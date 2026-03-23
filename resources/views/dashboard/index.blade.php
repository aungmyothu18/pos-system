@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@php
    $d = $dashboard;
    $fmtMoney = fn (float $v): string => number_format($v, 0, '.', ',');
    $pctClass = function (?float $p): string {
        if ($p === null) {
            return 'text-slate-400';
        }

        return $p >= 0 ? 'text-emerald-600' : 'text-rose-600';
    };
    $fmtTodayDelta = function (?float $p): string {
        if ($p === null) {
            return 'No comparison data';
        }
        $sign = $p > 0 ? '+' : '';

        return $sign . $p . '% from yesterday';
    };
    $fmtPeriodDelta = function (?float $p): string {
        if ($p === null) {
            return 'No comparison data';
        }
        $sign = $p > 0 ? '+' : '';

        return $sign . $p . '% vs previous period';
    };
@endphp

@section('content')
<div class="">
    <!-- Navbar -->
    <header class="sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 bg-white backdrop-blur border-b border-slate-200">
      <button id="sidebar-open" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Open menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
      <h1 class="text-lg font-semibold text-slate-900 truncate">အချက်အလက်များ</h1>
      <div class="flex items-center gap-2">
        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm">A</div>
      </div>
    </header>

    <main class="p-4 sm:p-6 space-y-6 bg-white">
      <!-- Summary cards -->
      <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 shadow-lg">
          <p class="text-slate-500 text-sm font-medium">Today Sales</p>
          <p id="dash-today-sales" class="text-2xl font-bold text-slate-900 mt-1">{{ $fmtMoney($d['today_sales']) }} Ks</p>
          <p id="dash-today-delta" class="text-xs mt-1 {{ $pctClass($d['today_sales_change_pct']) }}">{{ $fmtTodayDelta($d['today_sales_change_pct']) }}</p>
        </div>
        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 shadow-lg">
          <p class="text-slate-500 text-sm font-medium">Total Orders</p>
          <p id="dash-orders" class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($d['orders_count']) }}</p>
          <p class="text-xs mt-1"><span class="text-slate-400" id="dash-range-label">{{ $d['range_label'] }}</span><span class="text-slate-400"> · </span><span id="dash-orders-delta" class="{{ $pctClass($d['orders_change_pct']) }}">{{ $fmtPeriodDelta($d['orders_change_pct']) }}</span></p>
        </div>
        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 shadow-lg">
          <p class="text-slate-500 text-sm font-medium">စုစုပေါင်း ရတနာပစ္စည်းလက်ခံ</p>
          <p id="dash-jewelry" class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($d['jewelry_receives_count']) }}</p>
          <p class="text-xs mt-1"><span class="text-slate-400" id="dash-jewelry-meta">{{ $d['range_label'] }}</span><span class="text-slate-400"> · </span><span id="dash-jewelry-delta" class="{{ $pctClass($d['jewelry_change_pct']) }}">{{ $fmtPeriodDelta($d['jewelry_change_pct']) }}</span></p>
        </div>
        <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 shadow-lg">
          <p class="text-slate-500 text-sm font-medium">Revenue</p>
          <p id="dash-revenue" class="text-2xl font-bold text-slate-900 mt-1">{{ $fmtMoney($d['revenue']) }} Ks</p>
          <p class="text-xs mt-1"><span class="text-slate-400" id="dash-revenue-meta">{{ $d['range_label'] }}</span><span class="text-slate-400"> · </span><span id="dash-revenue-delta" class="{{ $pctClass($d['revenue_change_pct']) }}">{{ $fmtPeriodDelta($d['revenue_change_pct']) }}</span></p>
        </div>
      </section>
      <div class="mb-6 flex flex-wrap gap-2 items-center">
        <label class="text-slate-700 text-sm font-medium mr-2">Filter by:</label>
        <div class="flex flex-wrap gap-2">
          @foreach (['day' => 'Day', 'week' => 'Week', 'month' => 'Month', 'year' => 'Year'] as $key => $label)
            <button type="button"
              class="date-range-btn px-4 py-2 rounded-xl border font-medium transition {{ $d['range'] === $key ? 'bg-indigo-50 border-indigo-300 text-indigo-700 ring-2 ring-indigo-400' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
              data-range="{{ $key }}">
              {{ $label }}
            </button>
          @endforeach
        </div>
      </div>
      <div class="flex flex-col xl:flex-row gap-6">
        <div class="w-full xl:w-1/2 rounded-xl bg-slate-50 border border-slate-200 p-4 sm:p-6 shadow-lg mb-6 xl:mb-0">
          <h2 class="text-lg font-semibold text-slate-900 mb-4">Sales Overview</h2>
          <div class="h-64 rounded-lg bg-white border border-slate-200 p-2">
            <canvas id="dashboardLineChart"></canvas>
          </div>
        </div>

        <div class="w-full xl:w-1/2 rounded-xl bg-slate-50 border border-slate-200 p-4 sm:p-6 shadow-lg flex flex-col">
          <div class="mb-4">
            <h2 class="text-lg font-semibold text-slate-900">Most selling items</h2>
            <p class="text-xs text-slate-500 mt-1">By total units sold in the selected period</p>
          </div>
          <div class="w-full h-72 flex-1 min-h-[18rem]">
            <canvas id="dashboardBarChart"></canvas>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    (function () {
      const statsUrl = @json(route('dashboard.stats'));
      const initial = @json($d);
      let lineChart = null;
      let barChart = null;

      const barColors = ['#6366f1', '#34d399', '#f59e42', '#f43f5e', '#818cf8'];

      function fmtMoney(v) {
        return Number(v || 0).toLocaleString(undefined, { maximumFractionDigits: 0 }) + ' Ks';
      }

      function fmtInt(v) {
        return Number(v || 0).toLocaleString();
      }

      function pctClass(p) {
        if (p === null || p === undefined) return 'text-slate-400';
        return p >= 0 ? 'text-emerald-600' : 'text-rose-600';
      }

      function fmtTodayDelta(p) {
        if (p === null || p === undefined) return 'No comparison data';
        const sign = p > 0 ? '+' : '';
        return sign + p + '% from yesterday';
      }

      function fmtPeriodDelta(p) {
        if (p === null || p === undefined) return 'No comparison data';
        const sign = p > 0 ? '+' : '';
        return sign + p + '% vs previous period';
      }

      function applyDashboard(data) {
        document.getElementById('dash-today-sales').textContent = fmtMoney(data.today_sales);
        const todayDelta = document.getElementById('dash-today-delta');
        todayDelta.textContent = fmtTodayDelta(data.today_sales_change_pct);
        todayDelta.className = 'text-xs mt-1 ' + pctClass(data.today_sales_change_pct);

        document.getElementById('dash-orders').textContent = fmtInt(data.orders_count);
        document.getElementById('dash-range-label').textContent = data.range_label;
        const od = document.getElementById('dash-orders-delta');
        od.textContent = fmtPeriodDelta(data.orders_change_pct);
        od.className = pctClass(data.orders_change_pct);

        document.getElementById('dash-jewelry').textContent = fmtInt(data.jewelry_receives_count);
        document.getElementById('dash-jewelry-meta').textContent = data.range_label;
        const jd = document.getElementById('dash-jewelry-delta');
        jd.textContent = fmtPeriodDelta(data.jewelry_change_pct);
        jd.className = pctClass(data.jewelry_change_pct);

        document.getElementById('dash-revenue').textContent = fmtMoney(data.revenue);
        document.getElementById('dash-revenue-meta').textContent = data.range_label;
        const rd = document.getElementById('dash-revenue-delta');
        rd.textContent = fmtPeriodDelta(data.revenue_change_pct);
        rd.className = pctClass(data.revenue_change_pct);

        document.querySelectorAll('.date-range-btn').forEach(function (btn) {
          const active = btn.getAttribute('data-range') === data.range;
          btn.className = active
            ? 'date-range-btn px-4 py-2 rounded-xl border font-medium transition bg-indigo-50 border-indigo-300 text-indigo-700 ring-2 ring-indigo-400'
            : 'date-range-btn px-4 py-2 rounded-xl border font-medium transition bg-slate-50 border-slate-200 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600';
        });

        const tl = data.sales_timeline || { labels: [], values: [] };
        const tp = (data.top_products || []).slice(0, 5);

        if (window.Chart) {
          const lineCtx = document.getElementById('dashboardLineChart');
          if (lineCtx) {
            if (lineChart) lineChart.destroy();
            lineChart = new Chart(lineCtx.getContext('2d'), {
              type: 'line',
              data: {
                labels: tl.labels,
                datasets: [{
                  label: 'Sales (Ks)',
                  data: tl.values,
                  borderColor: '#4f46e5',
                  backgroundColor: 'rgba(79, 70, 229, 0.12)',
                  fill: true,
                  tension: 0.35,
                  pointRadius: 2,
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                  x: {
                    grid: { color: '#e5e7eb' },
                    ticks: { color: '#334155', maxRotation: 45, minRotation: 0 }
                  },
                  y: {
                    beginAtZero: true,
                    grid: { color: '#e5e7eb' },
                    ticks: { color: '#334155' }
                  }
                },
                plugins: { legend: { display: false } }
              }
            });
          }

          const barCtx = document.getElementById('dashboardBarChart');
          if (barCtx) {
            let labels = tp.map(function (r) { return r.product_name; });
            let values = tp.map(function (r) {
              var c = r.count;
              if (c === undefined || c === null) c = r.total;
              return Number(c) || 0;
            });
            if (!labels.length) {
              labels = ['No data'];
              values = [0];
            }
            if (barChart) barChart.destroy();
            barChart = new Chart(barCtx.getContext('2d'), {
              type: 'bar',
              data: {
                labels: labels,
                datasets: [{
                  label: 'Units sold',
                  data: values,
                  backgroundColor: labels.map(function (_, i) { return barColors[i % barColors.length]; }),
                  borderRadius: 6,
                }]
              },
              options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                  x: {
                    beginAtZero: true,
                    grid: { color: '#e5e7eb' },
                    ticks: {
                      color: '#334155',
                      font: { weight: '600' },
                      callback: function (v) {
                        return typeof v === 'number' && v % 1 === 0 ? v : Math.round(v);
                      }
                    }
                  },
                  y: {
                    grid: { display: false },
                    ticks: { color: '#334155', font: { weight: '600' } }
                  }
                },
                plugins: { legend: { display: false } }
              }
            });
          }
        }
      }

      document.addEventListener('DOMContentLoaded', function () {
        applyDashboard(initial);

        document.querySelectorAll('.date-range-btn').forEach(function (btn) {
          btn.addEventListener('click', function () {
            const range = btn.getAttribute('data-range');
            const urlObj = new URL(statsUrl, window.location.origin);
            urlObj.searchParams.set('range', range);
            const url = urlObj.toString();
            btn.disabled = true;
            fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
              .then(function (r) { return r.json(); })
              .then(function (data) {
                applyDashboard(data);
                if (window.history && window.history.replaceState) {
                  const u = new URL(window.location.href);
                  u.searchParams.set('range', range);
                  window.history.replaceState({}, '', u.pathname + u.search);
                }
              })
              .catch(function () { alert('Unable to load dashboard data.'); })
              .finally(function () { btn.disabled = false; });
          });
        });
      });
    })();
  </script>
@endsection

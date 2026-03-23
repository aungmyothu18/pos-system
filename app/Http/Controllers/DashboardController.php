<?php

namespace App\Http\Controllers;

use App\Models\JewelryReceive;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private const RANGES = ['day', 'week', 'month', 'year'];

    /** Number of products shown in the dashboard bar chart */
    private const TOP_PRODUCTS_LIMIT = 5;

    public function index(Request $request)
    {
        $range = $this->normalizeRange($request->query('range'));

        return view('dashboard.index', [
            'dashboard' => $this->buildDashboardPayload($range),
        ]);
    }

    public function stats(Request $request): JsonResponse
    {
        $range = $this->normalizeRange($request->query('range'));

        return response()->json($this->buildDashboardPayload($range));
    }

    private function normalizeRange(?string $range): string
    {
        $range = strtolower((string) $range);

        return in_array($range, self::RANGES, true) ? $range : 'week';
    }

    /**
     * @return array<string, mixed>
     */
    private function buildDashboardPayload(string $range): array
    {
        [$start, $end] = $this->currentBounds($range);
        [$prevStart, $prevEnd] = $this->previousBounds($range);

        $todaySales = (float) Transaction::query()
            ->where('type', 'Sale')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        $yesterdaySales = (float) Transaction::query()
            ->where('type', 'Sale')
            ->whereDate('created_at', today()->subDay())
            ->sum('total_amount');

        $todaySalesChangePct = $this->percentChange($yesterdaySales, $todaySales);

        $ordersCount = (int) Transaction::query()
            ->where('type', 'Sale')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $prevOrdersCount = (int) Transaction::query()
            ->where('type', 'Sale')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->count();

        $ordersChangePct = $this->percentChange((float) $prevOrdersCount, (float) $ordersCount);

        $jewelryReceivesCount = (int) JewelryReceive::query()
            ->whereBetween('receive_date', [$start->toDateString(), $end->toDateString()])
            ->count();

        $prevJewelryCount = (int) JewelryReceive::query()
            ->whereBetween('receive_date', [$prevStart->toDateString(), $prevEnd->toDateString()])
            ->count();

        $jewelryChangePct = $this->percentChange((float) $prevJewelryCount, (float) $jewelryReceivesCount);

        $revenue = (float) Transaction::query()
            ->where('type', 'Sale')
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_amount');

        $prevRevenue = (float) Transaction::query()
            ->where('type', 'Sale')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('total_amount');

        $revenueChangePct = $this->percentChange($prevRevenue, $revenue);

        $timeline = $this->salesTimeline($range, $start, $end);
        $topProducts = $this->topProductsBySellingCount($start, $end);

        return [
            'range' => $range,
            'range_label' => $this->rangeLabel($range),
            'today_sales' => $todaySales,
            'today_sales_change_pct' => $todaySalesChangePct,
            'orders_count' => $ordersCount,
            'orders_change_pct' => $ordersChangePct,
            'jewelry_receives_count' => $jewelryReceivesCount,
            'jewelry_change_pct' => $jewelryChangePct,
            'revenue' => $revenue,
            'revenue_change_pct' => $revenueChangePct,
            'sales_timeline' => $timeline,
            'top_products' => $topProducts,
        ];
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function currentBounds(string $range): array
    {
        $now = Carbon::now();

        return match ($range) {
            'day' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'month' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
        };
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function previousBounds(string $range): array
    {
        return match ($range) {
            'day' => [
                Carbon::now()->subDay()->startOfDay(),
                Carbon::now()->subDay()->endOfDay(),
            ],
            'week' => [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek(),
            ],
            'month' => [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth(),
            ],
            'year' => [
                Carbon::now()->subYear()->startOfYear(),
                Carbon::now()->subYear()->endOfYear(),
            ],
            default => [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek(),
            ],
        };
    }

    private function rangeLabel(string $range): string
    {
        return match ($range) {
            'day' => 'Today',
            'week' => 'This week',
            'month' => 'This month',
            'year' => 'This year',
            default => 'This week',
        };
    }

    private function percentChange(float $previous, float $current): ?float
    {
        if ($previous <= 0 && $current <= 0) {
            return null;
        }
        if ($previous <= 0) {
            return null;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * @return array{labels: list<string>, values: list<float>}
     */
    private function salesTimeline(string $range, Carbon $start, Carbon $end): array
    {
        $rows = Transaction::query()
            ->where('type', 'Sale')
            ->whereBetween('created_at', [$start, $end])
            ->get(['created_at', 'total_amount']);

        return match ($range) {
            'day' => $this->bucketByHour($rows, $start, $end),
            'year' => $this->bucketByMonth($rows, $start, $end),
            default => $this->bucketByDay($rows, $start, $end),
        };
    }

    /**
     * @param \Illuminate\Support\Collection<int, Transaction> $rows
     * @return array{labels: list<string>, values: list<float>}
     */
    private function bucketByHour($rows, Carbon $start, Carbon $end): array
    {
        $buckets = array_fill(0, 24, 0.0);
        foreach ($rows as $r) {
            $h = (int) $r->created_at->format('G');
            $buckets[$h] += (float) $r->total_amount;
        }
        $labels = [];
        $values = [];
        for ($h = 0; $h < 24; $h++) {
            $labels[] = sprintf('%02d:00', $h);
            $values[] = round($buckets[$h], 2);
        }

        return ['labels' => $labels, 'values' => $values];
    }

    /**
     * @param \Illuminate\Support\Collection<int, Transaction> $rows
     * @return array{labels: list<string>, values: list<float>}
     */
    private function bucketByDay($rows, Carbon $start, Carbon $end): array
    {
        $byDay = $rows->groupBy(fn ($r) => $r->created_at->toDateString());

        $labels = [];
        $values = [];
        for ($d = $start->copy()->startOfDay(); $d <= $end; $d->addDay()) {
            $key = $d->toDateString();
            $labels[] = $d->format('D j M');
            $values[] = round((float) $byDay->get($key, collect())->sum('total_amount'), 2);
        }

        return ['labels' => $labels, 'values' => $values];
    }

    /**
     * @param \Illuminate\Support\Collection<int, Transaction> $rows
     * @return array{labels: list<string>, values: list<float>}
     */
    private function bucketByMonth($rows, Carbon $start, Carbon $end): array
    {
        $byMonth = $rows->groupBy(fn ($r) => (int) $r->created_at->format('n'));

        $labels = [];
        $values = [];
        $endMonth = (int) $end->format('n');
        $year = (int) $end->format('Y');
        for ($m = 1; $m <= $endMonth; $m++) {
            $labels[] = Carbon::createFromDate($year, $m, 1)->format('M');
            $values[] = round((float) $byMonth->get($m, collect())->sum('total_amount'), 2);
        }

        return ['labels' => $labels, 'values' => $values];
    }

    /**
     * @return list<array{product_name: string, count: int}>
     */
    private function topProductsBySellingCount(Carbon $start, Carbon $end): array
    {
        $items = TransactionItem::query()
            ->select([
                'transaction_items.product_name',
                DB::raw('SUM(transaction_items.qty) as count'),
            ])
            ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->where('transactions.type', 'Sale')
            ->whereBetween('transactions.created_at', [$start, $end])
            ->groupBy('transaction_items.product_name')
            ->orderByDesc('count')
            ->limit(self::TOP_PRODUCTS_LIMIT)
            ->get();

        return $items->map(function ($row) {
            return [
                'product_name' => $row->product_name,
                'count' => (int) $row->count,
            ];
        })->values()->all();
    }
}

<?php

namespace App\Http\DAO;

use App\Models\JewelryReceive;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class JewelryReceiveDAO
{
    public function getReceivesPaginated(int $perPage, ?string $search = null, ?string $filter = null): LengthAwarePaginator
    {
        return JewelryReceive::query()
            ->withCount('items')
            ->when($search, function (Builder $q) use ($search) {
                $q->where(function (Builder $qq) use ($search) {
                    $qq->where('customer_name', 'like', '%' . $search . '%')
                        ->orWhere('customer_phone', 'like', '%' . $search . '%');
                });
            })
            ->when($filter, function (Builder $q) use ($filter) {
                $today = now()->startOfDay();

                if ($filter === 'today') {
                    $q->where('receive_date', now()->toDateString());
                } elseif ($filter === 'week') {
                    $q->where('receive_date', '>=', $today->copy()->startOfWeek()->toDateString());
                } elseif ($filter === 'month') {
                    $q->where('receive_date', '>=', $today->copy()->startOfMonth()->toDateString());
                }
            })
            ->orderByDesc('receive_date')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends([
                'search' => $search,
                'filter' => $filter,
            ]);
    }

    /**
     * @param array<int, array{
     *   type:string,
     *   kyat?:numeric|null,
     *   pae?:numeric|null,
     *   yway?:numeric|null,
     *   point?:numeric|null,
     *   color:string,
     *   price:numeric,
     *   remark?:string|null
     * }> $items
     */
    public function createReceive(string $customerName, string $customerPhone, array $items, ?string $overallNote = null): JewelryReceive
    {
        return DB::transaction(function () use ($customerName, $customerPhone, $items, $overallNote) {
            $totalItems = count($items);
            $totalValue = array_reduce($items, static function (float $sum, array $it): float {
                return $sum + (float) ($it['price'] ?? 0);
            }, 0.0);

            $receive = JewelryReceive::create([
                'receive_date' => now()->toDateString(),
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'overall_note' => $overallNote,
                'total_items' => $totalItems,
                'total_value' => $totalValue,
                'status' => 'received',
            ]);

            foreach ($items as $item) {
                $receive->items()->create([
                    'type' => (string) ($item['type'] ?? ''),
                    'kyat' => $item['kyat'] ?? null,
                    'pae' => $item['pae'] ?? null,
                    'yway' => $item['yway'] ?? null,
                    'point' => $item['point'] ?? null,
                    'color' => (string) ($item['color'] ?? ''),
                    'price' => (float) ($item['price'] ?? 0),
                    'remark' => $item['remark'] ?? null,
                ]);
            }

            return $receive->load('items');
        });
    }
}


<?php

namespace App\Http\Controllers;

use App\Http\DAO\JewelryReceiveDAO;
use App\Models\JewelryReceive;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JewelryReceiveExport;

class JewelryReceiveController extends Controller
{
    public function __construct(private readonly JewelryReceiveDAO $jewelryReceiveDao)
    {
    }

    public function index(Request $request)
    {
        $receives = $this->jewelryReceiveDao->getReceivesPaginated(
            perPage: 15,
            search: $request->input('search'),
            filter: $request->input('filter')
        );

        return view('jewelry-receive.index', compact('receives'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'overall_note' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.type' => ['required', 'string', 'max:100'],
            'items.*.kyat' => ['nullable', 'numeric', 'min:0'],
            'items.*.pae' => ['nullable', 'numeric', 'min:0'],
            'items.*.yway' => ['nullable', 'numeric', 'min:0'],
            'items.*.point' => ['nullable', 'numeric', 'min:0'],
            'items.*.color' => ['required', 'string', 'max:100'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.remark' => ['nullable', 'string', 'max:255'],
        ]);

        $this->jewelryReceiveDao->createReceive(
            customerName: $validated['customer_name'],
            customerPhone: $validated['customer_phone'],
            items: $validated['items'],
            overallNote: $validated['overall_note'] ?? null
        );

        return redirect()
            ->route('jewelry-receive.index')
            ->with('success', 'Jewelry receive saved successfully.');
    }

    public function show(int $id)
    {
        $receive = JewelryReceive::with('items')->findOrFail($id);
        return view('jewelry-receive.show', compact('receive'));
    }

    public function destroy(int $id)
    {
        $receive = JewelryReceive::findOrFail($id);
        $receive->delete();

        return redirect()
            ->route('jewelry-receive.index')
            ->with('success', 'Jewelry receive deleted successfully.');
    }

    public function export(Request $request): BinaryFileResponse
    {
        $search = $request->input('search');
        $filter = $request->input('filter');

        $query = JewelryReceive::query()
            ->with(['items'])
            ->withCount('items')
            ->orderByDesc('receive_date')
            ->orderByDesc('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', '%' . $search . '%')
                    ->orWhere('customer_phone', 'like', '%' . $search . '%');
            });
        }

        if ($filter === 'today') {
            $query->where('receive_date', now()->toDateString());
        } elseif ($filter === 'week') {
            $query->where('receive_date', '>=', now()->startOfWeek()->toDateString());
        } elseif ($filter === 'month') {
            $query->where('receive_date', '>=', now()->startOfMonth()->toDateString());
        }

        $receives = $query->get();

        $fileName = 'jewelry-receive-' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new JewelryReceiveExport($receives),
            $fileName
        );
    }
}


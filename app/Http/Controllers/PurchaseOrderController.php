<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    public function index(): View
    {
        $orders = PurchaseOrder::with('vendor', 'approver')->latest()->paginate(15);

        return view('purchase-orders.index', compact('orders'));
    }

    public function create(): View
    {
        return view('purchase-orders.form', [
            'order' => new PurchaseOrder(['status' => 'draft']),
            'vendors' => Vendor::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $order = DB::transaction(function () use ($data) {
            $order = PurchaseOrder::create([
                'vendor_id' => $data['vendor_id'],
                'status' => $data['status'],
                'payment_method' => $data['payment_method'] ?? null,
                'total_amount' => 0,
            ]);

            $this->saveItems($order, $data['items'] ?? []);

            return $order;
        });

        return redirect()->route('purchase-orders.show', $order)->with('status', 'Purchase order created.');
    }

    public function show(PurchaseOrder $purchaseOrder): View
    {
        $purchaseOrder->load('vendor', 'approver', 'items');

        return view('purchase-orders.show', ['order' => $purchaseOrder]);
    }

    public function edit(PurchaseOrder $purchaseOrder): View
    {
        $purchaseOrder->load('items');

        return view('purchase-orders.form', [
            'order' => $purchaseOrder,
            'vendors' => Vendor::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($purchaseOrder, $data) {
            $purchaseOrder->update([
                'vendor_id' => $data['vendor_id'],
                'status' => $data['status'],
                'payment_method' => $data['payment_method'] ?? null,
            ]);

            $purchaseOrder->items()->delete();
            $this->saveItems($purchaseOrder, $data['items'] ?? []);
        });

        return redirect()->route('purchase-orders.show', $purchaseOrder)->with('status', 'Purchase order updated.');
    }

    public function destroy(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $purchaseOrder->delete();

        return redirect()->route('purchase-orders.index')->with('status', 'Purchase order deleted.');
    }

    public function approve(Request $request, PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $purchaseOrder->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
        ]);

        return redirect()->route('purchase-orders.show', $purchaseOrder)->with('status', 'Purchase order approved.');
    }

    public function reject(Request $request, PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $purchaseOrder->update([
            'status' => 'rejected',
            'approved_by' => $request->user()->id,
        ]);

        return redirect()->route('purchase-orders.show', $purchaseOrder)->with('status', 'Purchase order rejected.');
    }

    private function saveItems(PurchaseOrder $order, array $items): void
    {
        $total = 0;

        foreach ($items as $item) {
            if (empty($item['item_name'])) {
                continue;
            }

            $qty = (float) ($item['quantity'] ?? 0);
            $unit = (float) ($item['unit_price'] ?? 0);
            $gst = (float) ($item['gst'] ?? 0);
            $lineBase = $qty * $unit;
            $lineTotal = $lineBase + ($lineBase * $gst / 100);

            $order->items()->create([
                'item_name' => $item['item_name'],
                'quantity' => $qty,
                'unit_price' => $unit,
                'gst' => $gst,
                'total' => $lineTotal,
            ]);

            $total += $lineTotal;
        }

        $order->update(['total_amount' => $total]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'status' => ['required', 'in:draft,pending,approved,rejected'],
            'payment_method' => ['nullable', 'in:cash,cheque,upi,bank_transfer'],
            'items' => ['array'],
            'items.*.item_name' => ['nullable', 'string', 'max:255'],
            'items.*.quantity' => ['nullable', 'numeric', 'min:0'],
            'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
            'items.*.gst' => ['nullable', 'numeric', 'min:0'],
        ]);
    }
}

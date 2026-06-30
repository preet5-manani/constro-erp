<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        $summary = [
            'total_bookings' => Booking::count(),
            'total_collected' => Payment::sum('amount'),
            'total_purchase' => PurchaseOrder::where('status', 'approved')->sum('total_amount'),
            'pending_purchase' => PurchaseOrder::where('status', 'pending')->sum('total_amount'),
        ];

        return view('reports.index', compact('summary'));
    }

    public function sales(): View
    {
        $bookings = Booking::with('customer', 'flat')->latest()->get();
        $payments = Payment::with('installment.booking.customer')->latest()->get();

        return view('reports.sales', compact('bookings', 'payments'));
    }

    public function purchase(): View
    {
        $orders = PurchaseOrder::with('vendor', 'approver')->latest()->get();

        return view('reports.purchase', compact('orders'));
    }

    public function revenue(): View
    {
        $monthly = Payment::selectRaw("to_char(paid_at, 'YYYY-MM') as month, sum(amount) as total")
            ->whereNotNull('paid_at')
            ->groupByRaw("to_char(paid_at, 'YYYY-MM')")
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return view('reports.revenue', compact('monthly'));
    }

    public function export(string $type): StreamedResponse
    {
        return match ($type) {
            'sales' => $this->stream('sales-report.csv', ['Booking #', 'Customer', 'Flat', 'Date', 'Token', 'Status'],
                Booking::with('customer', 'flat')->get()->map(fn ($b) => [
                    $b->id, $b->customer->name ?? '', $b->flat->flat_number ?? '',
                    optional($b->booking_date)->format('Y-m-d'), $b->token_amount, $b->status,
                ])),
            'purchase' => $this->stream('purchase-report.csv', ['PO #', 'Vendor', 'Status', 'Payment Method', 'Total'],
                PurchaseOrder::with('vendor')->get()->map(fn ($o) => [
                    $o->id, $o->vendor->name ?? '', $o->status, $o->payment_method, $o->total_amount,
                ])),
            default => abort(404),
        };
    }

    private function stream(string $filename, array $headings, $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headings, $rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $headings);
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}

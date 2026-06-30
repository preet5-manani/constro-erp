<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Flat;
use App\Models\Lead;
use App\Models\Project;
use App\Models\PurchaseOrder;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'projects' => Project::count(),
            'customers' => Customer::count(),
            'flats_sold' => Flat::where('status', 'sold')->count(),
            'pending_pos' => PurchaseOrder::where('status', 'pending')->count(),
            'active_leads' => Lead::whereNotIn('status', ['lost'])->count(),
            'bookings' => Booking::count(),
        ];

        $flatStatusCounts = Flat::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('dashboard', compact('stats', 'flatStatusCounts'));
    }
}

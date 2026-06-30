<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Installment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstallmentController extends Controller
{
    public function index(): View
    {
        $installments = Installment::with('booking.customer')->withCount('payments')->latest()->paginate(15);

        return view('installments.index', compact('installments'));
    }

    public function create(): View
    {
        return view('installments.form', ['installment' => new Installment(), 'bookings' => $this->bookingOptions()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Installment::create($this->validated($request));

        return redirect()->route('installments.index')->with('status', 'Installment created successfully.');
    }

    public function edit(Installment $installment): View
    {
        return view('installments.form', ['installment' => $installment, 'bookings' => $this->bookingOptions()]);
    }

    public function update(Request $request, Installment $installment): RedirectResponse
    {
        $installment->update($this->validated($request));

        return redirect()->route('installments.index')->with('status', 'Installment updated successfully.');
    }

    public function destroy(Installment $installment): RedirectResponse
    {
        $installment->delete();

        return redirect()->route('installments.index')->with('status', 'Installment deleted successfully.');
    }

    private function bookingOptions()
    {
        return Booking::with('customer')->latest()->get();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
            'status' => ['required', 'in:pending,paid,overdue'],
        ]);
    }
}

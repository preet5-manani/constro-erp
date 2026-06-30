<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Flat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with('customer', 'flat.floor.tower')->withCount('installments')->latest()->paginate(15);

        return view('bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        return view('bookings.form', $this->formData(new Booking()));
    }

    public function store(Request $request): RedirectResponse
    {
        Booking::create($this->validated($request));

        return redirect()->route('bookings.index')->with('status', 'Booking created successfully.');
    }

    public function show(Booking $booking): View
    {
        $booking->load('customer', 'flat.floor.tower', 'installments.payments');

        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking): View
    {
        return view('bookings.form', $this->formData($booking));
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $booking->update($this->validated($request));

        return redirect()->route('bookings.index')->with('status', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('bookings.index')->with('status', 'Booking deleted successfully.');
    }

    private function formData(Booking $booking): array
    {
        return [
            'booking' => $booking,
            'customers' => Customer::orderBy('name')->get(),
            'flats' => Flat::with('floor.tower')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'flat_id' => ['required', 'exists:flats,id'],
            'booking_date' => ['nullable', 'date'],
            'token_amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
        ]);
    }
}

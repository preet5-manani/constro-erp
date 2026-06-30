<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with('installment.booking.customer')->latest()->paginate(15);

        return view('payments.index', compact('payments'));
    }

    public function create(): View
    {
        return view('payments.form', ['payment' => new Payment(), 'installments' => $this->installmentOptions()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payment = Payment::create($this->validated($request));
        $this->maybeMarkInstallmentPaid($payment->installment);

        return redirect()->route('payments.index')->with('status', 'Payment recorded successfully.');
    }

    public function edit(Payment $payment): View
    {
        return view('payments.form', ['payment' => $payment, 'installments' => $this->installmentOptions()]);
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $payment->update($this->validated($request));
        $this->maybeMarkInstallmentPaid($payment->installment);

        return redirect()->route('payments.index')->with('status', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('status', 'Payment deleted successfully.');
    }

    private function maybeMarkInstallmentPaid(?Installment $installment): void
    {
        if (! $installment) {
            return;
        }

        $paid = $installment->payments()->sum('amount');

        if ($paid >= (float) $installment->amount && $installment->status !== 'paid') {
            $installment->update(['status' => 'paid']);
        }
    }

    private function installmentOptions()
    {
        return Installment::with('booking.customer')->latest()->get();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'installment_id' => ['required', 'exists:installments,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'method' => ['required', 'in:cash,cheque,upi,bank_transfer'],
            'transaction_ref' => ['nullable', 'string', 'max:255'],
            'paid_at' => ['nullable', 'date'],
        ]);
    }
}

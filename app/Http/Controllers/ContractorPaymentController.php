<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\ContractorPayment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractorPaymentController extends Controller
{
    public function index(): View
    {
        $contractorPayments = ContractorPayment::with('contractor')->latest('date')->paginate(15);

        return view('contractor-payments.index', compact('contractorPayments'));
    }

    public function create(): View
    {
        return view('contractor-payments.form', ['contractorPayment' => new ContractorPayment(), 'contractors' => Contractor::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        ContractorPayment::create($this->validated($request));

        return redirect()->route('contractor-payments.index')->with('status', 'Contractor payment recorded.');
    }

    public function edit(ContractorPayment $contractorPayment): View
    {
        return view('contractor-payments.form', ['contractorPayment' => $contractorPayment, 'contractors' => Contractor::orderBy('name')->get()]);
    }

    public function update(Request $request, ContractorPayment $contractorPayment): RedirectResponse
    {
        $contractorPayment->update($this->validated($request));

        return redirect()->route('contractor-payments.index')->with('status', 'Contractor payment updated.');
    }

    public function destroy(ContractorPayment $contractorPayment): RedirectResponse
    {
        $contractorPayment->delete();

        return redirect()->route('contractor-payments.index')->with('status', 'Contractor payment deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'contractor_id' => ['required', 'exists:contractors,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'date' => ['nullable', 'date'],
            'status' => ['required', 'string', 'max:50'],
        ]);
    }
}

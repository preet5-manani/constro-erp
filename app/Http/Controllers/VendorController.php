<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function index(): View
    {
        $vendors = Vendor::withCount('purchaseOrders')->latest()->paginate(15);

        return view('vendors.index', compact('vendors'));
    }

    public function create(): View
    {
        return view('vendors.form', ['vendor' => new Vendor()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Vendor::create($this->validated($request));

        return redirect()->route('vendors.index')->with('status', 'Vendor created successfully.');
    }

    public function edit(Vendor $vendor): View
    {
        return view('vendors.form', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        $vendor->update($this->validated($request));

        return redirect()->route('vendors.index')->with('status', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor): RedirectResponse
    {
        $vendor->delete();

        return redirect()->route('vendors.index')->with('status', 'Vendor deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'gst_number' => ['nullable', 'string', 'max:50'],
        ]);
    }
}

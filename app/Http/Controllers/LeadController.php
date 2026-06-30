<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(): View
    {
        $leads = Lead::with('customer', 'assignee')->withCount('siteVisits')->latest()->paginate(15);

        return view('leads.index', compact('leads'));
    }

    public function create(): View
    {
        return view('leads.form', $this->formData(new Lead()));
    }

    public function store(Request $request): RedirectResponse
    {
        Lead::create($this->validated($request));

        return redirect()->route('leads.index')->with('status', 'Lead created successfully.');
    }

    public function edit(Lead $lead): View
    {
        return view('leads.form', $this->formData($lead));
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $lead->update($this->validated($request));

        return redirect()->route('leads.index')->with('status', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()->route('leads.index')->with('status', 'Lead deleted successfully.');
    }

    private function formData(Lead $lead): array
    {
        return [
            'lead' => $lead,
            'customers' => Customer::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['nullable', 'exists:customers,id'],
            'source' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:new,contacted,visited,interested,lost'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);
    }
}

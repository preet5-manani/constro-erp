<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\SiteVisit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteVisitController extends Controller
{
    public function index(): View
    {
        $siteVisits = SiteVisit::with('lead.customer')->latest()->paginate(15);

        return view('site-visits.index', compact('siteVisits'));
    }

    public function create(): View
    {
        return view('site-visits.form', ['siteVisit' => new SiteVisit(), 'leads' => $this->leadOptions()]);
    }

    public function store(Request $request): RedirectResponse
    {
        SiteVisit::create($this->validated($request));

        return redirect()->route('site-visits.index')->with('status', 'Site visit recorded.');
    }

    public function edit(SiteVisit $siteVisit): View
    {
        return view('site-visits.form', ['siteVisit' => $siteVisit, 'leads' => $this->leadOptions()]);
    }

    public function update(Request $request, SiteVisit $siteVisit): RedirectResponse
    {
        $siteVisit->update($this->validated($request));

        return redirect()->route('site-visits.index')->with('status', 'Site visit updated.');
    }

    public function destroy(SiteVisit $siteVisit): RedirectResponse
    {
        $siteVisit->delete();

        return redirect()->route('site-visits.index')->with('status', 'Site visit deleted.');
    }

    private function leadOptions()
    {
        return Lead::with('customer')->latest()->get();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'lead_id' => ['required', 'exists:leads,id'],
            'visit_date' => ['nullable', 'date'],
            'feedback' => ['nullable', 'string'],
        ]);
    }
}

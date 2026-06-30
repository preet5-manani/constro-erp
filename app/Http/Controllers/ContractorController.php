<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractorController extends Controller
{
    public function index(): View
    {
        $contractors = Contractor::withCount('tasks', 'attendances')->latest()->paginate(15);

        return view('contractors.index', compact('contractors'));
    }

    public function create(): View
    {
        return view('contractors.form', ['contractor' => new Contractor()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Contractor::create($this->validated($request));

        return redirect()->route('contractors.index')->with('status', 'Contractor created successfully.');
    }

    public function edit(Contractor $contractor): View
    {
        return view('contractors.form', compact('contractor'));
    }

    public function update(Request $request, Contractor $contractor): RedirectResponse
    {
        $contractor->update($this->validated($request));

        return redirect()->route('contractors.index')->with('status', 'Contractor updated successfully.');
    }

    public function destroy(Contractor $contractor): RedirectResponse
    {
        $contractor->delete();

        return redirect()->route('contractors.index')->with('status', 'Contractor deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);
    }
}

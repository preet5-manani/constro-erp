<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\Floor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FlatController extends Controller
{
    public function index(): View
    {
        $flats = Flat::with('floor.tower.project')->latest()->paginate(15);

        return view('flats.index', compact('flats'));
    }

    public function create(): View
    {
        return view('flats.form', ['flat' => new Flat(), 'floors' => $this->floorOptions()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Flat::create($this->validated($request));

        return redirect()->route('flats.index')->with('status', 'Flat created successfully.');
    }

    public function edit(Flat $flat): View
    {
        return view('flats.form', ['flat' => $flat, 'floors' => $this->floorOptions()]);
    }

    public function update(Request $request, Flat $flat): RedirectResponse
    {
        $flat->update($this->validated($request));

        return redirect()->route('flats.index')->with('status', 'Flat updated successfully.');
    }

    public function destroy(Flat $flat): RedirectResponse
    {
        $flat->delete();

        return redirect()->route('flats.index')->with('status', 'Flat deleted successfully.');
    }

    private function floorOptions()
    {
        return Floor::with('tower.project')->get();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'floor_id' => ['required', 'exists:floors,id'],
            'flat_number' => ['required', 'string', 'max:255'],
            'area' => ['nullable', 'numeric', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,reserved,booked,sold'],
        ]);
    }
}

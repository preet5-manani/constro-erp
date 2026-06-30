<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Tower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FloorController extends Controller
{
    public function index(): View
    {
        $floors = Floor::with('tower.project')->withCount('flats')->latest()->paginate(15);

        return view('floors.index', compact('floors'));
    }

    public function create(): View
    {
        return view('floors.form', ['floor' => new Floor(), 'towers' => Tower::with('project')->orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Floor::create($this->validated($request));

        return redirect()->route('floors.index')->with('status', 'Floor created successfully.');
    }

    public function edit(Floor $floor): View
    {
        return view('floors.form', ['floor' => $floor, 'towers' => Tower::with('project')->orderBy('name')->get()]);
    }

    public function update(Request $request, Floor $floor): RedirectResponse
    {
        $floor->update($this->validated($request));

        return redirect()->route('floors.index')->with('status', 'Floor updated successfully.');
    }

    public function destroy(Floor $floor): RedirectResponse
    {
        $floor->delete();

        return redirect()->route('floors.index')->with('status', 'Floor deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'tower_id' => ['required', 'exists:towers,id'],
            'floor_number' => ['required', 'integer'],
        ]);
    }
}

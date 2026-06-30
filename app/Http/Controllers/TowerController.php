<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TowerController extends Controller
{
    public function index(): View
    {
        $towers = Tower::with('project')->withCount('floors')->latest()->paginate(15);

        return view('towers.index', compact('towers'));
    }

    public function create(): View
    {
        return view('towers.form', ['tower' => new Tower(), 'projects' => Project::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Tower::create($this->validated($request));

        return redirect()->route('towers.index')->with('status', 'Tower created successfully.');
    }

    public function show(Tower $tower): View
    {
        $tower->load(['project', 'floors' => fn ($q) => $q->withCount('flats')]);

        return view('towers.show', compact('tower'));
    }

    public function edit(Tower $tower): View
    {
        return view('towers.form', ['tower' => $tower, 'projects' => Project::orderBy('name')->get()]);
    }

    public function update(Request $request, Tower $tower): RedirectResponse
    {
        $tower->update($this->validated($request));

        return redirect()->route('towers.index')->with('status', 'Tower updated successfully.');
    }

    public function destroy(Tower $tower): RedirectResponse
    {
        $tower->delete();

        return redirect()->route('towers.index')->with('status', 'Tower deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);
    }
}

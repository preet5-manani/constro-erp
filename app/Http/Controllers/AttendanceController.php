<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Contractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        $attendances = Attendance::with('contractor')->latest('date')->paginate(15);

        return view('attendances.index', compact('attendances'));
    }

    public function create(): View
    {
        return view('attendances.form', ['attendance' => new Attendance(['date' => now()->toDateString()]), 'contractors' => Contractor::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Attendance::create($this->validated($request));

        return redirect()->route('attendances.index')->with('status', 'Attendance recorded.');
    }

    public function edit(Attendance $attendance): View
    {
        return view('attendances.form', ['attendance' => $attendance, 'contractors' => Contractor::orderBy('name')->get()]);
    }

    public function update(Request $request, Attendance $attendance): RedirectResponse
    {
        $attendance->update($this->validated($request, $attendance));

        return redirect()->route('attendances.index')->with('status', 'Attendance updated.');
    }

    public function destroy(Attendance $attendance): RedirectResponse
    {
        $attendance->delete();

        return redirect()->route('attendances.index')->with('status', 'Attendance deleted.');
    }

    private function validated(Request $request, ?Attendance $attendance = null): array
    {
        return $request->validate([
            'contractor_id' => ['required', 'exists:contractors,id'],
            'date' => [
                'required', 'date',
                Rule::unique('attendances')->where(fn ($q) => $q->where('contractor_id', $request->contractor_id))
                    ->ignore($attendance?->id),
            ],
            'status' => ['required', 'in:present,absent'],
        ]);
    }
}

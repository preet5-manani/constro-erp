<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\ContractorTask;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractorTaskController extends Controller
{
    public function index(): View
    {
        $contractorTasks = ContractorTask::with('contractor', 'task.project')->latest()->paginate(15);

        return view('contractor-tasks.index', compact('contractorTasks'));
    }

    public function create(): View
    {
        return view('contractor-tasks.form', $this->formData(new ContractorTask()));
    }

    public function store(Request $request): RedirectResponse
    {
        ContractorTask::create($this->validated($request));

        return redirect()->route('contractor-tasks.index')->with('status', 'Task assigned to contractor.');
    }

    public function edit(ContractorTask $contractorTask): View
    {
        return view('contractor-tasks.form', $this->formData($contractorTask));
    }

    public function update(Request $request, ContractorTask $contractorTask): RedirectResponse
    {
        $contractorTask->update($this->validated($request));

        return redirect()->route('contractor-tasks.index')->with('status', 'Contractor task updated.');
    }

    public function destroy(ContractorTask $contractorTask): RedirectResponse
    {
        $contractorTask->delete();

        return redirect()->route('contractor-tasks.index')->with('status', 'Contractor task deleted.');
    }

    private function formData(ContractorTask $contractorTask): array
    {
        return [
            'contractorTask' => $contractorTask,
            'contractors' => Contractor::orderBy('name')->get(),
            'tasks' => Task::with('project')->orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'contractor_id' => ['required', 'exists:contractors,id'],
            'task_id' => ['required', 'exists:tasks,id'],
            'status' => ['required', 'string', 'max:50'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);
    }
}

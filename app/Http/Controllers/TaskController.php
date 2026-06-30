<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $projectId = $request->integer('project_id') ?: null;

        $tasks = Task::with(['project', 'assignee', 'parent'])
            ->when($projectId, fn ($q) => $q->where('project_id', $projectId))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $projects = Project::orderBy('name')->get();

        return view('tasks.index', compact('tasks', 'projects', 'projectId'));
    }

    public function gantt(Request $request): View
    {
        $projects = Project::orderBy('name')->get();
        $projectId = $request->integer('project_id') ?: optional($projects->first())->id;

        $tasks = Task::with('dependencies')
            ->where('project_id', $projectId)
            ->orderBy('start_date')
            ->get();

        $ganttData = $tasks->map(fn (Task $task) => [
            'id' => (string) $task->id,
            'name' => $task->name,
            'start' => optional($task->start_date)->format('Y-m-d') ?? now()->format('Y-m-d'),
            'end' => optional($task->end_date)->format('Y-m-d') ?? now()->addDay()->format('Y-m-d'),
            'progress' => $task->progress,
            'dependencies' => $task->dependencies->pluck('depends_on_task_id')->implode(','),
        ])->values();

        return view('tasks.gantt', compact('projects', 'projectId', 'ganttData'));
    }

    public function create(): View
    {
        return view('tasks.form', $this->formData(new Task()));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $task = Task::create($data);
        $this->syncDependencies($task, $request);

        return redirect()->route('tasks.index')->with('status', 'Task created successfully.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.form', $this->formData($task));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $task->update($this->validated($request));
        $this->syncDependencies($task, $request);

        return redirect()->route('tasks.index')->with('status', 'Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('status', 'Task deleted successfully.');
    }

    private function formData(Task $task): array
    {
        return [
            'task' => $task,
            'projects' => Project::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
            'parentTasks' => Task::where('id', '!=', $task->id)->orderBy('name')->get(),
            'selectedDependencies' => $task->exists ? $task->dependencies->pluck('depends_on_task_id')->all() : [],
            'allTasks' => Task::where('id', '!=', $task->id)->orderBy('name')->get(),
        ];
    }

    private function syncDependencies(Task $task, Request $request): void
    {
        $task->dependencies()->delete();

        foreach (collect($request->input('dependencies', []))->filter() as $dependsOn) {
            if ((int) $dependsOn !== $task->id) {
                $task->dependencies()->create(['depends_on_task_id' => $dependsOn]);
            }
        }
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'parent_id' => ['nullable', 'exists:tasks,id'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:task,milestone'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'string', 'max:50'],
        ]);
    }
}

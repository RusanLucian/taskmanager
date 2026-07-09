<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', auth()->id());

        // Căutare după titlu
        if ($request->filled('search')) {
            $tasks->where('title', 'like', '%' . $request->search . '%');
        }

        // Filtrare după status
        if ($request->filled('status')) {
            $tasks->where('status', $request->status);
        }

        $tasks = $tasks->latest()->get();

        $totalTasks = Task::where('user_id', auth()->id())->count();
        $todoTasks = Task::where('user_id', auth()->id())
            ->where('status', 'todo')
            ->count();

        $inProgressTasks = Task::where('user_id', auth()->id())
            ->where('status', 'in_progress')
            ->count();

        $doneTasks = Task::where('user_id', auth()->id())
            ->where('status', 'done')
            ->count();

        return view('tasks.index', compact(
            'tasks',
            'totalTasks',
            'todoTasks',
            'inProgressTasks',
            'doneTasks'
        ));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task creat cu succes!');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task actualizat cu succes!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task șters cu succes!');
    }
}

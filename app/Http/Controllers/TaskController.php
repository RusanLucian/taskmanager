<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $tasks->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $tasks->where('status', $request->status);
        }

        $tasks = $tasks->latest()->get();

        $totalTasks = Task::where('user_id', Auth::id())->count();

        $todoTasks = Task::where('user_id', Auth::id())
            ->where('status', 'todo')
            ->count();

        $inProgressTasks = Task::where('user_id', Auth::id())
            ->where('status', 'in_progress')
            ->count();

        $doneTasks = Task::where('user_id', Auth::id())
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

    public function store(StoreTaskRequest $request)
    {
        Task::create([
            'user_id' => Auth::id(),
            ...$request->validated(),
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

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

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

@extends('layouts.app')

@section('title', 'Task-uri')

@section('content')

<section class="max-w-7xl mx-auto px-8 py-16">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-gray-500 text-sm">📋 Total Task-uri</p>
            <h2 class="text-3xl font-bold mt-2 text-gray-900">{{ $totalTasks }}</h2>
        </div>

        <div class="bg-red-50 rounded-xl shadow-sm border border-red-200 p-6">
            <p class="text-red-600 text-sm">🔴 Todo</p>
            <h2 class="text-3xl font-bold mt-2 text-gray-900">{{ $todoTasks }}</h2>
        </div>

        <div class="bg-yellow-50 rounded-xl shadow-sm border border-yellow-200 p-6">
            <p class="text-yellow-700 text-sm">🟡 În progres</p>
            <h2 class="text-3xl font-bold mt-2 text-gray-900">{{ $inProgressTasks }}</h2>
        </div>

        <div class="bg-green-50 rounded-xl shadow-sm border border-green-200 p-6">
            <p class="text-green-700 text-sm">🟢 Finalizate</p>
            <h2 class="text-3xl font-bold mt-2 text-gray-900">{{ $doneTasks }}</h2>
        </div>
    </div>

    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-bold mb-2 text-white">Task-urile mele</h1>
            <p class="text-gray-300">Aici vei vedea toate task-urile create.</p>
        </div>

        <a href="{{ route('tasks.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-semibold">
            + Adaugă task
        </a>
    </div>

    <form method="GET" action="{{ route('tasks.index') }}" class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="🔍 Caută task după titlu..."
                class="md:col-span-3 w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-5 py-3 shadow-sm"
            >

            <select
                name="status"
                class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-5 py-3 shadow-sm"
                onchange="this.form.submit()"
            >
                <option value="">Toate statusurile</option>
                <option value="todo" {{ request('status') == 'todo' ? 'selected' : '' }}>Todo</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>În progres</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Finalizate</option>
            </select>
        </div>
    </form>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($tasks->isEmpty())
        <div class="bg-white border border-gray-200 rounded-xl p-10 text-center shadow-sm">
            <h2 class="text-2xl font-semibold text-gray-900 mb-3">
                Nu ai niciun task momentan.
            </h2>

            <p class="text-gray-500">
                Apasă pe „Adaugă task” ca să creezi primul task.
            </p>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($tasks as $task)

                @php
                    $priorityClasses = match($task->priority) {
                        'high' => 'bg-red-100 text-red-700',
                        'medium' => 'bg-yellow-100 text-yellow-700',
                        'low' => 'bg-green-100 text-green-700',
                        default => 'bg-gray-100 text-gray-700',
                    };

                    $statusClasses = match($task->status) {
                        'todo' => 'bg-blue-100 text-blue-700',
                        'in_progress' => 'bg-orange-100 text-orange-700',
                        'done' => 'bg-green-100 text-green-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg transition duration-300">

                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $task->title }}
                            </h2>

                            <p class="text-gray-600 mt-3">
                                {{ $task->description }}
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                ✏️ Edit
                            </a>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                  onsubmit="return confirm('Sigur dorești să ștergi acest task?')">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-6 flex-wrap">

                        <span class="px-3 py-1 rounded-full {{ $priorityClasses }} text-sm">
                            @if($task->priority == 'high')
                                🔴 High
                            @elseif($task->priority == 'medium')
                                🟡 Medium
                            @else
                                🟢 Low
                            @endif
                        </span>

                        <span class="px-3 py-1 rounded-full {{ $statusClasses }} text-sm">
                            @if($task->status == 'todo')
                                🔵 Todo
                            @elseif($task->status == 'in_progress')
                                🟠 În progres
                            @else
                                🟢 Finalizat
                            @endif
                        </span>

                        @if($task->due_date)
                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm">
                                📅 {{ $task->due_date }}
                            </span>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</section>

@endsection

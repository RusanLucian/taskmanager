@extends('layouts.app')

@section('title', 'Editează Task')

@section('content')

<section class="max-w-3xl mx-auto px-8 py-16">

    <h1 class="text-4xl font-bold text-white mb-8">
        Editează task
    </h1>

    <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-6">

        @csrf
        @method('PUT')

        <div>
            <label class="block mb-2 text-gray-200 font-medium">
                Titlu
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title', $task->title) }}"
                class="w-full rounded-lg border border-gray-600 bg-gray-800 text-white placeholder-gray-400 p-3 focus:border-blue-500 focus:ring focus:ring-blue-500/20"
                required
            >
        </div>

        <div>
            <label class="block mb-2 text-gray-200 font-medium">
                Descriere
            </label>

            <textarea
                name="description"
                rows="5"
                class="w-full rounded-lg border border-gray-600 bg-gray-800 text-white placeholder-gray-400 p-3 focus:border-blue-500 focus:ring focus:ring-blue-500/20"
            >{{ old('description', $task->description) }}</textarea>
        </div>

        <div>
            <label class="block mb-2 text-gray-200 font-medium">
                Prioritate
            </label>

            <select
                name="priority"
                class="w-full rounded-lg border border-gray-600 bg-gray-800 text-white p-3 focus:border-blue-500 focus:ring focus:ring-blue-500/20"
            >
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div>
            <label class="block mb-2 text-gray-200 font-medium">
                Status
            </label>

            <select
                name="status"
                class="w-full rounded-lg border border-gray-600 bg-gray-800 text-white p-3 focus:border-blue-500 focus:ring focus:ring-blue-500/20"
            >
                <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>În progres</option>
                <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Finalizat</option>
            </select>
        </div>

        <div>
            <label class="block mb-2 text-gray-200 font-medium">
                Termen limită
            </label>

            <input
                type="date"
                name="due_date"
                value="{{ old('due_date', $task->due_date) }}"
                class="w-full rounded-lg border border-gray-600 bg-gray-800 text-white p-3 focus:border-blue-500 focus:ring focus:ring-blue-500/20"
            >
        </div>

        <div class="flex gap-4">

            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition"
            >
                💾 Salvează modificările
            </button>

            <a href="{{ route('tasks.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                ← Înapoi
            </a>

        </div>

    </form>

</section>

@endsection

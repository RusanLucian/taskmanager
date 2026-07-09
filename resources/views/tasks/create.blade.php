@extends('layouts.app')

@section('title', 'Adaugă Task')

@section('content')

<section class="max-w-3xl mx-auto px-8 py-16">

    <h1 class="text-4xl font-bold text-white mb-8">
        Adaugă un task nou
    </h1>

    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">

        @csrf

        <div>
            <label class="block mb-2 text-gray-200 font-medium">
                Titlu
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
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
            >{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block mb-2 text-gray-200 font-medium">
                Prioritate
            </label>

            <select
                name="priority"
                class="w-full rounded-lg border border-gray-600 bg-gray-800 text-white p-3 focus:border-blue-500 focus:ring focus:ring-blue-500/20"
            >
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
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
                <option value="todo">To Do</option>
                <option value="in_progress">În progres</option>
                <option value="done">Finalizat</option>
            </select>
        </div>

        <div>
            <label class="block mb-2 text-gray-200 font-medium">
                Termen limită
            </label>

            <input
                type="date"
                name="due_date"
                class="w-full rounded-lg border border-gray-600 bg-gray-800 text-white p-3 focus:border-blue-500 focus:ring focus:ring-blue-500/20"
            >
        </div>

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition"
        >
            Salvează task
        </button>

    </form>

</section>

@endsection

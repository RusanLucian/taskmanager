<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        $tasks = [
            ['title' => 'Finalizează documentația proiectului', 'description' => 'Actualizează README și adaugă capturi de ecran.', 'priority' => 'high', 'status' => 'done', 'due_date' => now()->subDays(2)],
            ['title' => 'Rezervă consultație stomatologică', 'description' => 'Sună și stabilește programarea.', 'priority' => 'medium', 'status' => 'todo', 'due_date' => now()->addDays(3)],
            ['title' => 'Plătește factura la internet', 'description' => 'Scadență la sfârșitul săptămânii.', 'priority' => 'high', 'status' => 'in_progress', 'due_date' => now()->addDay()],
            ['title' => 'Pregătește CV-ul', 'description' => 'Actualizează experiența și proiectele.', 'priority' => 'high', 'status' => 'done', 'due_date' => now()->subDay()],
            ['title' => 'Cumpără alimente', 'description' => 'Lapte, ouă, pâine, fructe.', 'priority' => 'low', 'status' => 'todo', 'due_date' => now()->addDays(5)],
            ['title' => 'Învață Laravel Policies', 'description' => 'Parcurge documentația oficială și implementează în proiect.', 'priority' => 'medium', 'status' => 'in_progress', 'due_date' => now()->addDays(4)],
            ['title' => 'Programează schimbul de ulei', 'description' => 'Service auto înainte de weekend.', 'priority' => 'medium', 'status' => 'todo', 'due_date' => now()->addDays(8)],
            ['title' => 'Trimite aplicații pentru internship', 'description' => 'Aplică la 5 companii.', 'priority' => 'high', 'status' => 'in_progress', 'due_date' => now()->addDays(2)],
            ['title' => 'Rezolvă exercițiile Laravel', 'description' => 'Finalizează capitolul despre Eloquent.', 'priority' => 'low', 'status' => 'done', 'due_date' => now()->subDays(4)],
        ];

        foreach ($tasks as $task) {
            Task::create(array_merge($task, ['user_id' => $user->id]));
        }
    }
}

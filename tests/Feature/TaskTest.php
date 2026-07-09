<?php

use App\Models\Task;
use App\Models\User;

it('authenticated user can create a task', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('tasks.store'), [
        'title' => 'Test Task',
        'description' => 'Test Description',
        'priority' => 'high',
        'status' => 'todo',
        'due_date' => now()->addDay()->format('Y-m-d'),
    ]);

    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'title' => 'Test Task',
        'user_id' => $user->id,
    ]);
});

it('authenticated user can update own task', function () {
    $user = User::factory()->create();

    $task = Task::create([
        'user_id' => $user->id,
        'title' => 'Old Title',
        'description' => 'Old Description',
        'priority' => 'low',
        'status' => 'todo',
        'due_date' => now(),
    ]);

    $response = $this->actingAs($user)->put(route('tasks.update', $task), [
        'title' => 'New Title',
        'description' => 'New Description',
        'priority' => 'high',
        'status' => 'done',
        'due_date' => now()->addDay()->format('Y-m-d'),
    ]);

    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'New Title',
    ]);
});

it('user cannot update another users task', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();

    $task = Task::create([
        'user_id' => $owner->id,
        'title' => 'Private Task',
        'description' => '',
        'priority' => 'medium',
        'status' => 'todo',
        'due_date' => now(),
    ]);

    $response = $this->actingAs($other)->put(route('tasks.update', $task), [
        'title' => 'Hacked',
        'description' => '',
        'priority' => 'high',
        'status' => 'done',
        'due_date' => now()->addDay()->format('Y-m-d'),
    ]);

    $response->assertForbidden();
});

it('authenticated user can delete own task', function () {
    $user = User::factory()->create();

    $task = Task::create([
        'user_id' => $user->id,
        'title' => 'Delete Me',
        'description' => '',
        'priority' => 'low',
        'status' => 'todo',
        'due_date' => now(),
    ]);

    $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});

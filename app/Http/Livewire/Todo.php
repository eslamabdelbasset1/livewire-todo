<?php
// app/Http/Livewire/Todo.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Todo as TodoModel;

class Todo extends Component
{
    public $todos;
    public $task = '';
    public $description = '';
    public $priority = 'medium';
    public $due_date = '';


    public $editMode = false;
    public $editId = null;
    public $editTask = '';

    public $editDescription = '';
    public $editPriority = 'medium';
    public $editDueDate = '';

    protected $rules = [
        'task' => 'required|min:3',
        'description' => 'nullable|string',
        'priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date|after_or_equal:today',
    ];

    public function mount()
    {
        $this->loadTodos();
    }

    public function loadTodos()
    {
        $this->todos = TodoModel::orderBy('completed')
            ->orderBy('due_date', 'asc')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->get();
    }

    public function addTodo()
    {
        $this->validate();


        TodoModel::create([
            'task' => $this->task,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'completed' => false
        ]);

        $this->reset(['task', 'description', 'priority', 'due_date']);
        $this->loadTodos();
        session()->flash('message', 'Todo added successfully.');
    }

    public function toggleCompletion($id)
    {
        $todo = TodoModel::find($id);
        $todo->completed = !$todo->completed;
        $todo->save();

        $this->loadTodos();
    }

    public function editTodo($id)
    {
        $todo = TodoModel::find($id);
        $this->editMode = true;
        $this->editId = $id;
        $this->editTask = $todo->task;
        $this->editDescription = $todo->description;
        $this->editPriority = $todo->priority;
        $this->editDueDate = $todo->due_date ? $todo->due_date->format('Y-m-d') : '';

    }

    public function updateTodo()
    {
        $this->validate([
            'editTask' => 'required|min:3',
            'editDescription' => 'nullable|string',
            'editPriority' => 'required|in:low,medium,high',
            'editDueDate' => 'nullable|date',
        ]);

        $todo = TodoModel::find($this->editId);
        $todo->task = $this->editTask;
        $todo->description = $this->editDescription;
        $todo->priority = $this->editPriority;
        $todo->due_date = $this->editDueDate;
        $todo->save();

        $this->cancelEdit();
        $this->loadTodos();
        session()->flash('message', 'Todo updated successfully.');
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->reset(['editId', 'editTask', 'editDescription', 'editPriority', 'editDueDate']);

    }

    public function deleteTodo($id)
    {
        TodoModel::destroy($id);
        $this->loadTodos();
        session()->flash('message', 'Todo deleted successfully.');
    }

    public function render()
    {
        return view('livewire.todo')
            ->layout('layouts.app');
    }
}

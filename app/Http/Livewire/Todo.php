<?php
// app/Http/Livewire/Todo.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Todo as TodoModel;

class Todo extends Component
{
    public $todos;
    public $task = '';
    public $editMode = false;
    public $editId = null;
    public $editTask = '';

    protected $rules = [
        'task' => 'required|min:3',
    ];

    public function mount()
    {
        $this->loadTodos();
    }

    public function loadTodos()
    {
        $this->todos = TodoModel::orderBy('created_at', 'desc')->get();
    }

    public function addTodo()
    {
        $this->validate();


        TodoModel::create([
            'task' => $this->task,
            'completed' => false
        ]);

        $this->task = '';
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
    }

    public function updateTodo()
    {
        $this->validate([
            'editTask' => 'required|min:3',
        ]);

        $todo = TodoModel::find($this->editId);
        $todo->task = $this->editTask;
        $todo->save();

        $this->cancelEdit();
        $this->loadTodos();
        session()->flash('message', 'Todo updated successfully.');
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->editId = null;
        $this->editTask = '';
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

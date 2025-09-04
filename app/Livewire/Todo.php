<?php

namespace App\Livewire;

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
        'task' => 'required|string|max:255|min:3',
    ];
    public function render()
    {
        return view('livewire.todo');
    }
}

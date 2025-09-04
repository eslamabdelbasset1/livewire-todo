<?php

use App\Http\Livewire\Todo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/todo', Todo::class);

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\Todo;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Manually register the Todo component
        Livewire::component('todo', Todo::class);
    }
}

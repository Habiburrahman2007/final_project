<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use App\Http\Middleware\CheckBanned;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor; 

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
        if (class_exists(\Livewire\Livewire::class)) {
        // agar Livewire mengaplikasikan CheckBanned pada setiap livewire request
        \Livewire\Livewire::addPersistentMiddleware([
            CheckBanned::class,
        ]);
    }
    }
}

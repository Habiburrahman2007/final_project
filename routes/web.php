<?php

use App\Livewire\Guess;
use App\Livewire\Profile;
use App\Livewire\Dashboard;
use App\Livewire\Statistic;
use App\Livewire\Auth\Login;
use App\Livewire\Categories;
use App\Livewire\EditArticle;
use App\Livewire\LandingPage;
use App\Livewire\UserControl;
use App\Livewire\Auth\Register;
use App\Livewire\CreateArticle;
use App\Livewire\DetailArticle;
use App\Livewire\DetailProfile;
use App\Livewire\Admin\Comments;
use App\Livewire\ArticleControl;
use App\Livewire\CreateCategory;
use App\Livewire\Profile\EditProfile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Guest\DetailArticle as GuestDetailArticle;
use App\Livewire\Guest\DetailProfile as GuestDetailProfile;
use App\Livewire\Guidelines;

Route::get('/', LandingPage::class)->name('landing-page');
Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::fallback(function () {
    return view('livewire.not-found');
});

Route::get('/guest', Guess::class)->name('guest');
Route::get('/detail-article-guest/{slug}', GuestDetailArticle::class)->name('detail-article-guest');
Route::get('/detail-profile-guest/{slug}', GuestDetailProfile::class)->name('detail-profile-guest');

Route::middleware(['auth', 'banned'])->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/guidelines', Guidelines::class)->name('guidelines');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile/edit', EditProfile::class)->name('profile.edit');
    Route::get('/create-article', CreateArticle::class)->name('create-article')->middleware('throttle:10,60'); // Max 10 articles per hour
    Route::get('/edit-article/{slug}', EditArticle::class)->name('edit-article');
    Route::get('/detail-profile/{slug}', DetailProfile::class)->name('detail-profile');
    Route::get('/detail-article/{slug}', DetailArticle::class)->name('detail-article');

    Route::prefix('admin')->middleware('is_admin')->group(function () {
        Route::get('/category', Categories::class)->name('category');
        Route::get('/create-category', CreateCategory::class)->name('create-category');
        Route::get('/statistic', Statistic::class)->name('statistic');
        Route::get('/blog-control', ArticleControl::class)->name('blog-control');
        Route::get('/user-control', UserControl::class)->name('user-control');
        Route::get('/comment-control', Comments::class)->name('comment-control');
    });
});

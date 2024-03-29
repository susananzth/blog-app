<?php

use App\Http\Livewire\Categories;
use App\Http\Livewire\Cities;
use App\Http\Livewire\Countries;
use App\Http\Livewire\Currencies;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\DocumentTypes;
use App\Http\Livewire\Posts;
use App\Http\Livewire\Profiles;
use App\Http\Livewire\Roles;
use App\Http\Livewire\States;
use App\Http\Livewire\Tags;
use App\Http\Livewire\Users;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profiles', Profiles::class)->name('profiles');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class    )->name('dashboard');
    Route::get('/category',  Categories::class   )->name('categories');
    Route::get('/city',      Cities::class       )->name('cities');
    Route::get('/country',   Countries::class    )->name('countries');
    Route::get('/currency',  Currencies::class   )->name('currencies');
    Route::get('/document',  DocumentTypes::class)->name('document_types');
    Route::get('/post',      Posts::class        )->name('posts');
    Route::get('/role',      Roles::class        )->name('roles');
    Route::get('/state',     States::class       )->name('states');
    Route::get('/tag',       Tags::class         )->name('tags');
    Route::get('/user',      Users::class        )->name('users');
});

require __DIR__.'/auth.php';

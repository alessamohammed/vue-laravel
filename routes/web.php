<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\API\HighlightController;
use App\Http\Controllers\API\TagController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/alltags', function () {
    return Inertia::render('Tags');
})->middleware(['auth', 'verified'])->name('alltags');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::group(['prefix' => 'highlight'],function () {
    Route::post('/add', [HighlightController::class,'add'])->name('highlight.add');
});
Route::get('/highlights', [HighlightController::class, 'index']);

// tags
// add tag page
Route::get('/addtag', function () {
    return Inertia::render('AddTag');
})->middleware(['auth', 'verified'])->name('addtag');
Route::get('/tags', [TagController::class, 'index']);
// tags group
Route::group(['prefix' => 'tag'],function () {
    Route::post('/add', [TagController::class,'add'])->name('tag.add');
    Route::post('/update/{id}', [TagController::class,'update'])->name('tag.update');
    Route::delete('/delete/{id}', [TagController::class,'delete'])->name('tag.delete');
});

require __DIR__.'/auth.php';

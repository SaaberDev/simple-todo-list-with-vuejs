<?php

use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\ProfileController;
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
})->name('home');

/*
|--------------------------------------------------------------------------
| Todo List Routes
|--------------------------------------------------------------------------
*/
Route::prefix('/my-todo-list')
    ->name('my_todo_list.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        // my todo list route
        Route::get('/', [ItemController::class, 'index'])->name('index');
        Route::post('/store', [ItemController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [ItemController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ItemController::class, 'destroy'])->name('destroy');
        Route::post('/mark-as-done/{id}', [ItemController::class, 'markAsDone'])->name('markAsDone');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

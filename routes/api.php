<?php

use App\Http\Controllers\Api\v1\Item\ItemApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/v1')->group(function () {
    Route::prefix('/my-todo-list')
        ->name('my_todo_list.')
        ->middleware(['auth:sanctum', 'verified'])
        ->group(function () {
            Route::get('/items', [ItemApiController::class, 'index'])->name('index');
            Route::post('/store', [ItemApiController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ItemApiController::class, 'edit'])->name('edit');
            Route::patch('/update/{id}', [ItemApiController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [ItemApiController::class, 'destroy'])->name('destroy');
            Route::post('/mark-as-done/{id}', [ItemApiController::class, 'markAsDone'])->name('mark_as_done');
        });
});

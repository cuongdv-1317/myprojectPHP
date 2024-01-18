<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::resource('/users', UserController::class);
Route::resource('/posts', PostController::class);
Route::resource('/comments', CommentController::class);

Route::get('/comments/post/{post}', [CommentController::class, 'showCommentPost'])->name('comments.showCommentPost');

Route::post('likes/user/{user}/post/{post}', [LikeController::class, 'like'])->name('likes.like');
Route::delete('likes/user/{user}/post/{post}', [LikeController::class, 'unlike'])->name('likes.unlike');

// Route::get('users', [UserController::class, 'index'])->name('users.index');
// Route::get('users/create', [UserController::class, 'create'])
//     ->name('users.create')
//     ->middleware([
//         'admin',
//     ]);
// Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
// Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
// Route::post('users', [UserController::class, 'store'])->name('users.store');
// Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
// Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

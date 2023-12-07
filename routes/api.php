<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowUserController;
use App\Http\Controllers\CommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Follow User
Route::controller(FollowUserController::class)->group(function () {
    Route::post('/profile/unfollow', 'destroy')->name('unfollow');
    Route::post('/profile/follow', 'create')->name('follow');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('/news/{id}/comment','store')->name('news.comments.store');
    Route::delete('/comment/{id_comment}','destroy')->name('news.comments.destroy');
    Route::patch('/comment/{id_comment}/edit','update')->name('news.comments.update');
});
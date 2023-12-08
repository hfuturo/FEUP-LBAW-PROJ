<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsItemController;
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

Route::controller(ReportController::class)->group(function () {
    Route::post('/profile/report', 'create_user');
    Route::delete('/delete_report', 'destroy');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/block_user','block');
    Route::delete('/delete_user','destroy');
});

Route::controller(NewsItemController::class)->group(function () {
    Route::delete('/delete_news_item','destroy_admin');
});

Route::controller(Comment::class)->group(function () {
    Route::delete('/delete_comment','destroy_admin');
});
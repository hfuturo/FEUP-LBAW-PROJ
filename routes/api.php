<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowUserController;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowTopicController;
use App\Http\Controllers\FollowTagController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\NotificationController;


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
    Route::post('/news/{id}/comment', 'store')->name('news.comments.store');
    Route::delete('/comment/{id_comment}', 'destroy')->name('news.comments.destroy');
});

Route::controller(ReportController::class)->group(function () {
    Route::post('/profile/report', 'create_user');
    Route::delete('/delete_report', 'destroy');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/block_user', 'block');
    Route::post('/unblock_user', 'unblock');
    Route::delete('/delete_user', 'destroy');
    Route::get('/fetch_pfp/{id}', 'fetch_pfp');
});

Route::controller(NewsItemController::class)->group(function () {
    Route::delete('/delete_news_item', 'destroy_admin');
});

Route::controller(Comment::class)->group(function () {
    Route::delete('/delete_comment', 'destroy_admin');
});

Route::controller(FollowTopicController::class)->group(function () {
    Route::post('/topic/unfollow', 'destroy')->name('unfollow');
    Route::post('/topic/follow', 'create')->name('follow');
});

Route::controller(FollowTagController::class)->group(function () {
    Route::post('/tag/unfollow', 'destroy')->name('unfollow');
    Route::post('/tag/follow', 'create')->name('follow');
});

Route::controller(VoteController::class)->group(function () {
    Route::post('/vote/update', 'update');
    Route::post('/vote/create', 'create');
    Route::delete('/vote/destroy', 'destroy');
});

Route::controller(NotificationController::class)->group(function () {
    Route::delete('/notification/destroy', 'destroy');
});

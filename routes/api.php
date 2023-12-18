<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowUserController;
use App\Http\Controllers\FollowOrganizationController;
use App\Http\Controllers\MembershipStatusController;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowTopicController;
use App\Http\Controllers\FollowTagController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BlockController;


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
    Route::patch('/comment/{id_comment}/edit', 'update')->name('news.comments.update');
    Route::delete('/delete_comment', 'destroy_admin');
});

Route::controller(ReportController::class)->group(function () {
    Route::post('/profile/report', 'create_user');
    Route::post('/content/report', 'create_content');
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

Route::controller(OrganizationController::class)->group(function () {
    Route::post('/organization/create', 'store')->name('create_org'); 
});

Route::controller(NotificationController::class)->group(function () {
    Route::delete('/notification/destroy', 'destroy');
});

Route::controller(BlockController::class)->group(function () {
    Route::post('/reject_appeal', 'reject_appeal');
});

Route::controller(FollowOrganizationController::class)->group(function () {
    Route::post('/organization/unfollow', 'destroy');
    Route::post('/organization/follow', 'create');
});

Route::controller(MembershipStatusController::class)->group(function () {
    Route::post('/organization/status/destroy', 'destroy');
    Route::post('/organization/status/create', 'create');
    Route::post('/organization/status/update', 'update');
    Route::post('/organization/manage/upgrade', 'upgrade');
    Route::post('/organization/manage/expel', 'expel');
    Route::post('/organization/manage/decline', 'decline');
    Route::post('/organization/manage/accept', 'accept');
});

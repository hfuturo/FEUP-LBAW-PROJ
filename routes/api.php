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
use App\Http\Controllers\FileController;
use App\Http\Controllers\TopicController;

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
    Route::post('/profile/unfollow', 'destroy')->name('unfollow_user');
    Route::post('/profile/follow', 'create')->name('follow_user');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('/news/{id}/comment', 'store')->name('news.comments.store')
        ->where('id', '[0-9]+');
    Route::delete('/comment/{id_comment}/delete', 'destroy')->name('news.comments.destroy')
        ->where('id_comment', '[0-9]+');
    Route::patch('/comment/{id_comment}/edit', 'update')->name('news.comments.update')
        ->where('id_comment', '[0-9]+');
    Route::delete('/delete_comment', 'destroy_admin')->middleware('admin');
});

Route::controller(ReportController::class)->group(function () {
    Route::post('/profile/report', 'create_user')->name('create_user_report');
    Route::post('/content/report', 'create_content');
    Route::delete('/delete_report', 'destroy')->middleware('moderator');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/block_user', 'block')->middleware('admin');
    Route::post('/upgrade_user', 'upgrade')->middleware('admin');
    Route::post('/unblock_user', 'unblock')->middleware('admin');
    Route::delete('/delete_user', 'destroy');
    Route::get('/fetch_pfp/{id}', 'fetch_pfp')->where('id', '[0-9]+');
    Route::patch('/moderator/revoke', 'revoke_moderator')->middleware('admin');
    Route::patch('/moderator/make', 'make_moderator')->middleware('admin');
});

Route::controller(NewsItemController::class)->group(function () {
    Route::delete('/delete_news_item', 'destroy_admin')->middleware('moderator');
});

Route::controller(FollowTopicController::class)->group(function () {
    Route::post('/topic/unfollow', 'destroy')->name('unfollow_topic');
    Route::post('/topic/follow', 'create')->name('follow_topic');
});

Route::controller(FollowTagController::class)->group(function () {
    Route::post('/tag/unfollow', 'destroy')->name('unfollow_tag');
    Route::post('/tag/follow', 'create')->name('follow_tag');
});

Route::controller(VoteController::class)->group(function () {
    Route::post('/vote/update', 'update');
    Route::post('/vote/create', 'create');
    Route::delete('/vote/destroy', 'destroy');
});

Route::controller(OrganizationController::class)->group(function () {
    Route::post('/organization/create', 'store')->name('create_org');
    Route::post('/organization/update', 'update');
    Route::post('/organization/delete_organization/{organization}', 'destroy')->name('delete_organization')
        ->where('organization', '[0-9]+');
});

Route::controller(NotificationController::class)->group(function () {
    Route::delete('/notification/destroy', 'destroy');
    Route::post('/notification/view', 'view');
});

Route::controller(BlockController::class)->group(function () {
    Route::post('/reject_appeal', 'reject_appeal')->middleware('admin');
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

Route::controller(FileController::class)->group(function () {
    Route::post('/file/delete', 'remove_pfp');
});

Route::controller(TopicController::class)->group(function () {
    Route::post('/topics/filter', 'filter');
});

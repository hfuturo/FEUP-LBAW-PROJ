<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsItemController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SuggestedTopicController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\BlockController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RecoverPasswordController;

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

// Home
Route::redirect('/', '/news');

// About Us
Route::view('/about_us', 'pages.about_us');
// Contact Us
Route::view('/contacts', 'pages.contacts');

Route::controller(BlockController::class)->group(function () {
    Route::view('/blocked', 'auth.block')->name('blocked')->middleware('authenticated');
    Route::post('/blocked', 'appeal_unblock')->name('appeal')->middleware('authenticated');
});

// News
Route::controller(NewsController::class)->group(function () {
    Route::get('/news', 'list_default_feed')->name('news');
    Route::get('/news/advanced_search', 'advanced_search')->name('advanced_search');
    Route::get('/news/recent_feed', 'recent_list')->name('recent_feed');
    Route::get('/news/follow_feed', 'follow_list')->name('follow_feed')->middleware('authenticated');
});

// API
Route::controller(ManageController::class)->group(function () {
    Route::post('/api/manage', 'search')->middleware('admin');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::view('/login', 'auth.login')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate')->middleware('guest');
    Route::get('/logout', 'logout')->name('logout')->middleware('authenticated');
});

// Recover Password
Route::controller(RecoverPasswordController::class)->group(function () {
    Route::get('/recover', 'show_recover_password_form')->name('recover_password');
    Route::post('/recover/verify_code', 'verify_code')->name('verify_code');
    Route::get('/recover/verify_code/{user}', 'verify_code_form')->name('verify_code_form')
        ->where('user', '[0-9]+');
});

Route::controller(RegisterController::class)->group(function () {
    Route::view('/register', 'auth.register')->name('register')->middleware('guest');
    Route::post('/register', 'register')->middleware('guest');
});

// News
Route::controller(NewsItemController::class)->group(function () {
    Route::post('/news/{id}', 'destroy')->name('destroy')
        ->where('id', '[0-9]+')->middleware('authenticated');
    Route::get('/news/create', 'create')->name('create_news')->middleware('authenticated');
    Route::post('/api/news/create', 'store')->name('create_news_api')->middleware('authenticated');
    Route::get('/news/{id}/edit', 'edit')->name('edit_news')
        ->where('id', '[0-9]+')->middleware('authenticated');
    Route::post('/api/news/{id}/edit', 'update')->name('edit_news_api')
        ->where('id', '[0-9]+')->middleware('authenticated');
    Route::get('/news/{id}', 'show')->name('news_page')
        ->where('id', '[0-9]+');
});

// Admin
Route::controller(ManageController::class)->group(function () {
    Route::get('/manage', 'show')->middleware('admin');
    Route::get('/manage_unblock_appeals', 'show_unblock_appeals')->name('unblock_appeals')->middleware('admin');
});

// Profile
Route::controller(UserController::class)->group(function () {
    Route::get('/profile/{user}', 'show')->name('profile')
        ->where('user', '[0-9]+')->middleware('authenticated');
    Route::post('/profile/{user}', 'update')->name('profile_update')
        ->where('user', '[0-9]+')->middleware('authenticated');
    Route::post('/profile/{user}/delete', 'delete')->name('delete_account')
        ->where('user', '[0-9]+')->middleware('authenticated');
    Route::post('/profile/{user}/block', 'block_perfil_button')->name('block')
        ->where('user', '[0-9]+')->middleware('admin');
    Route::post('/profile/{user}/unblock', 'unblock_perfil_button')->name('unblock')
        ->where('user', '[0-9]+')->middleware('admin');
});


Route::controller(SuggestedTopicController::class)->group(function () {
    Route::post('/topic_proposal', 'create')->name('topic_proposal')->middleware('authenticated');
    Route::post('/manage_topic/delete_suggested_topic', 'destroy')->name('delete_suggested_topic')->middleware('admin');
    Route::post('/manage_topic/accept_suggested_topic', 'accept')->name('accept_suggested_topic')->middleware('admin');
    Route::get('/manage_topic', 'show')->name('manage_topic')->middleware('admin');
});

Route::controller(ReportController::class)->group(function () {
    Route::get('/report_users', 'show_users')->name('user_reports')->middleware('admin');
    Route::get('/report_news', 'show_news')->name('news_reports')->middleware('moderator');
    Route::get('/report_comments', 'show_comments')->name('comments_reports')->middleware('moderator');
});

// email
Route::controller(MailController::class)->group(function () {
    Route::post('/send', 'send_recover_password_mail')->name('send_email');
});

Route::controller(TopicController::class)->group(function () {
    Route::get('/topic/{topic}', 'show')->name('topic')
        ->where('topic', '[0-9]+')->middleware('authenticated');
    Route::get('/moderators', 'moderators')->name('list_mods')->middleware('admin');
    Route::get('/topics', 'index')->name('show_topics')->middleware('authenticated');
});

Route::controller(TagController::class)->group(function () {
    Route::get('/tag/{tag}', 'show')->name('tag')
        ->where('tag', '[0-9]+')->middleware('authenticated');
});

// file
Route::controller(FileController::class)->group(function () {
    Route::post('/file/upload', 'upload')->middleware('authenticated');
});


Route::controller(OrganizationController::class)->group(function () {
    Route::get('/organization/{organization}', 'show')->name('show_org')
        ->where('organization', '[0-9]+')->middleware('authenticated');
    Route::get('/manage_organization/{organization}', 'show_manage')->name('show_manage_org')
        ->where('organization', '[0-9]+')->middleware('authenticated');
});


Route::controller(NotificationController::class)->group(function () {
    Route::get('/notification', 'show')->middleware('authenticated');
});

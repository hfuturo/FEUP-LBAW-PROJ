<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

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
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactUsController;
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
Route::redirect('/', '/login');

Route::controller(BlockController::class)->group(function () {
    Route::get('/blocked', 'blockPage')->name('blocked');
    Route::post('/blocked', 'appeal_unblock')->name('appeal');
});

// News
Route::controller(NewsController::class)->group(function () {
    Route::get('/news', 'list_default_feed')->name('news');
    Route::get('/news/advanced_search', 'advanced_search')->name('advanced_search');
    Route::get('/news/recent_feed', 'recent_list')->name('recent_feed');
    Route::get('/news/follow_feed', 'follow_list')->name('follow_feed');
});

// API
Route::controller(ManageController::class)->group(function () {
    Route::post('/api/manage', 'search');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

// Recover Password
Route::controller(RecoverPasswordController::class)->group(function () {
    Route::get('/recover', 'show_recover_password_form')->name('recover_password');
    Route::post('/recover/verify_code', 'verify_code')->name('verify_code');
    Route::get('/recover/verify_code/{user}', 'verify_code_form')->name('verify_code_form');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// News
Route::controller(NewsItemController::class)->group(function () {
    Route::post('/news/{id}', 'destroy')->name('destroy');
    Route::get('/news/create', 'create')->name('create_news');
    Route::post('/api/news/create', 'store')->name('create_news_api');
    Route::get('/news/{id}/edit', 'edit')->name('edit_news');
    Route::post('/api/news/{id}/edit', 'update')->name('edit_news_api');
    Route::get('/news/{id}', 'show')->name('news_page');
});

// Admin
Route::controller(ManageController::class)->group(function () {
    Route::get('/manage', 'show');
    Route::get('/manage_topic', 'show_suggested_topic')->name('manage_topic');
    Route::get('/manage_unblock_appeals', 'show_unblock_appeals')->name('unblock_appeals');
});

// Profile
Route::controller(UserController::class)->group(function () {
    Route::get('/profile/{user}', 'show')->name('profile');
    Route::post('/profile/{user}', 'update')->name('profile_update');
    Route::post('/profile/{user}/delete', 'delete')->name('delete_account');
    Route::post('/profile/{user}/block', 'block_perfil_button')->name('block');
    Route::post('/profile/{user}/unblock', 'unblock_perfil_button')->name('unblock');
});

// About Us
Route::controller(AboutUsController::class)->group(function () {
    Route::get('/about_us', 'show');
});


Route::controller(SuggestedTopicController::class)->group(function () {
    Route::post('/topic_proposal', 'create')->name('topic_proposal');
    Route::post('/manage_topic/delete_suggested_topic', 'destroy')->name('delete_suggested_topic');
    Route::post('/manage_topic/accept_suggested_topic', 'accept')->name('accept_suggested_topic');
});

// Contact Us
Route::controller(ContactUsController::class)->group(function () {
    Route::get('/contacts', 'show');
});

Route::controller(ReportController::class)->group(function () {
    Route::get('/report_users', 'show_users')->name('user_reports');
    Route::get('/report_news', 'show_news')->name('news_reports');
    Route::get('/report_comments', 'show_comments')->name('comments_reports');
});

// email
Route::controller(MailController::class)->group(function () {
    Route::post('/send', 'send_recover_password_mail')->name('send_email');
});

Route::controller(TopicController::class)->group(function () {
    Route::get('/topic/{topic}', 'show')->name('topic');
});

Route::controller(TagController::class)->group(function () {
    Route::get('/tag/{tag}', 'show')->name('tag');
});

// file
Route::controller(FileController::class)->group(function () {
    Route::post('/file/upload', 'upload');
});


Route::controller(OrganizationController::class)->group(function () {
    Route::get('organization/{organization}', 'show')->name('show_org');
    Route::get('manage_organization/{organization}', 'show_manage')->name('show_manage_org');
});


Route::controller(NotificationController::class)->group(function () {
    Route::get('/notification', 'show');
});

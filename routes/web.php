<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Follow_UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactUsController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

// News
Route::controller(NewsController::class)->group(function() {
    Route::get('/news', 'list_default_feed')->name('news');
});

// API
Route::controller(ManageController::class)->group(function() {
    Route::post('/api/manage', 'search');
});

Route::controller(NewsController::class)->group(function() {
    Route::get('/api/news/recent_feed', 'recent_list');
    Route::get('/api/news/follow_feed', 'follow_list');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Admin
Route::controller(ManageController::class)->group(function () {
    Route::get('/manage','show');
});

// Profile
Route::controller(UserController::class)->group(function () {
    Route::get('/profile/{user}', 'show')->name('profile');
    Route::post('/profile/{user}', 'update')->name('profile_update');
});

// About Us
Route::controller(AboutUsController::class)->group(function () {
    Route::get('/about_us', 'show');
});

// Follow User
Route::controller(Follow_UserController::class)->group(function () {
    Route::post('/profile/unfollow/{id_follower}/{id_following}', 'destroy')->name('unfollow');
    Route::post('/profile/follow/{id_follower}/{id_following}', 'create')->name('follow');
});

// Contact Us
Route::controller(ContactUsController::class)->group(function () {
    Route::get('/contacts', 'show');
});
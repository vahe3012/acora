<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Auth::routes();
//

Route::get('setlocale/{locale}', function ($locale) {
    if (in_array($locale, config('app.locales'))) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
});

Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('home');


Route::get('/admin', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//News
Route::get('/category-news/{slug?}', [App\Http\Controllers\Front\NewsController::class, 'news'])->name('category.news');
Route::get('/news/{news}', [App\Http\Controllers\Front\NewsController::class, 'single'])->name('news');
Route::any('/get-news/{slug?}', [App\Http\Controllers\Front\NewsController::class, 'getTable'])->name('get-news');

//Contact
Route::get('/contact-us', [App\Http\Controllers\Front\HomeController::class, 'contactUs'])->name('contact-us');
Route::post('/contact-us', [App\Http\Controllers\Front\HomeController::class, 'sendContactEmail'])->name('contact-send');

Route::get('/legislation', [App\Http\Controllers\Front\HomeController::class, 'legislation'])->name('legislation');

Route::get('/reports', [App\Http\Controllers\Front\HomeController::class, 'reports'])->name('reports');

Route::get('/digital-images', [App\Http\Controllers\Front\HomeController::class, 'digitalImages'])->name('digitalImages');

Route::get('/analyzes', [App\Http\Controllers\Front\HomeController::class, 'analyzes'])->name('analyzes');

Route::get('/about-us', [\App\Http\Controllers\Front\HomeController::class, 'aboutUs'])->name('about-us');

Route::get('/programs', [\App\Http\Controllers\Front\HomeController::class, 'programs'])->name('programs');

Route::get('/member/{member}', [\App\Http\Controllers\Front\HomeController::class, 'member'])->name('member');

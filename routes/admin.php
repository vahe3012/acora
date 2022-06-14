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

Route::group(['middleware' => ['auth']], function () {
    Route::name('admin.')->group(function () {

//    Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('home');

//    News
        Route::get('/news/draw', [\App\Http\Controllers\Admin\NewsController::class, 'draw'])->name('news.draw');
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);

//    Categories
        Route::get('/categories/draw', [\App\Http\Controllers\Admin\CategoryController::class, 'draw'])->name('categories.draw');
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);


//    Partners
        Route::get('/partners/draw', [\App\Http\Controllers\Admin\PartnerController::class, 'draw'])->name('partners.draw');
        Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class);

//    Reports
        Route::get('/reports/draw', [\App\Http\Controllers\Admin\ReportsController::class, 'draw'])->name('reports.draw');
        Route::resource('reports', \App\Http\Controllers\Admin\ReportsController::class);

//    Analyzes
        Route::get('/analyzes/draw', [\App\Http\Controllers\Admin\AnalyzesController::class, 'draw'])->name('analyzes.draw');
        Route::resource('analyzes', \App\Http\Controllers\Admin\AnalyzesController::class);

//    Digital Images
        Route::get('/digital-images/draw', [\App\Http\Controllers\Admin\DigitalImagesController::class, 'draw'])->name('digitalImages.draw');
        Route::post('/digital-images/sort', [\App\Http\Controllers\Admin\DigitalImagesController::class, 'sort'])->name('digitalImages.sort');
        Route::resource('digital-images', \App\Http\Controllers\Admin\DigitalImagesController::class);

//    laws
        Route::get('/laws/draw', [\App\Http\Controllers\Admin\LawController::class, 'draw'])->name('laws.draw');
        Route::resource('laws', \App\Http\Controllers\Admin\LawController::class);

//    Courses
        Route::get('/courses/draw', [\App\Http\Controllers\Admin\CourseController::class, 'draw'])->name('courses.draw');
        Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);

//    Programs
        Route::get('/programs/draw', [\App\Http\Controllers\Admin\ProgramController::class, 'draw'])->name('programs.draw');
        Route::resource('programs', \App\Http\Controllers\Admin\ProgramController::class);

//    Settings
        Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);

//    About us
        Route::get('/about-us', [\App\Http\Controllers\Admin\AboutController::class, 'index'])->name('about.index');
        Route::post('/about-us', [\App\Http\Controllers\Admin\AboutController::class, 'store'])->name('about.store');

//    Staff
        Route::get('/staff/draw', [\App\Http\Controllers\Admin\StaffController::class, 'draw'])->name('staff.draw');
        Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class);

//    MEDIA
        Route::post('/upload-file', [\App\Http\Controllers\Admin\MediaController::class, 'uploadFile'])->name('media.uploadFile');
        Route::post('/delete-file/{id}', [\App\Http\Controllers\Admin\MediaController::class, 'deleteFile'])->name('media.deleteFile');

//    ATTACHMENTS
        Route::resource('attachments', \App\Http\Controllers\Admin\AttachmentController::class);
    });
});


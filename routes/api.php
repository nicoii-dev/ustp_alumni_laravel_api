<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('forgot-password', 'ForgotPasswordController@forgotPassword')->middleware('guest')->name('password.email');
        Route::post('reset-password', 'ForgotPasswordController@resetPassword')->middleware('guest')->name('password.reset');
        Route::post('verify-email', 'AuthController@verifyEmail');
    });
    
    //for authenticated
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('logout', 'AuthController@logout');
            Route::post('verify-token', 'AuthController@verifyToken');
            Route::post('change-password', 'AuthController@changePassword');
        });

        Route::group(['prefix' => 'announcement'], function () {
            Route::get('/', 'AnnouncementController@index');
            Route::post('create', 'AnnouncementController@store');
            Route::post('view/{id}', 'AnnouncementController@show');
            Route::post('update/{id}', 'AnnouncementController@update');
            Route::delete('delete/{id}', 'AnnouncementController@destroy');
        });

        Route::group(['prefix' => 'post'], function () {
            Route::get('/', 'PostController@index');
            Route::post('create', 'PostController@store');
            Route::post('view/{id}', 'PostController@show');
            Route::post('update/{id}', 'PostController@update');
            Route::delete('delete/{id}', 'PostController@destroy');
            // Route::get('image/{filename}', 'PostController@showPostImage');
        });

        Route::group(['prefix' => 'comment'], function () {
            Route::get('/', 'CommentController@index');
            Route::post('create', 'CommentController@store');
            Route::post('view/{id}', 'CommentController@show');
            Route::post('update/{id}', 'CommentController@update');
            Route::delete('delete/{id}', 'CommentController@destroy');
        });

        Route::group(['prefix' => 'likes'], function () {
            Route::get('/', 'LikeController@index');
            Route::get('post/{id}', 'LikeController@showPostLikes');
            Route::post('like-post', 'LikeController@likePost');
            Route::post('unlike-post/{id}', 'LikeController@unLikePost');
        });

        Route::group(['prefix' => 'job-posting'], function () {
            Route::get('/', 'JobPostingController@index');
            Route::post('create', 'JobPostingController@store');
            Route::post('view/{id}', 'JobPostingController@show');
            Route::post('update/{id}', 'JobPostingController@update');
            Route::delete('delete/{id}', 'JobPostingController@destroy');
        });

        Route::group(['prefix' => 'course'], function () {
            Route::get('/', 'CourseController@index');
            Route::post('create', 'CourseController@store');
            Route::post('view/{id}', 'CourseController@show');
            Route::post('update/{id}', 'CourseController@update');
            Route::delete('delete/{id}', 'CourseController@destroy');
        });

        Route::group(['prefix' => 'employment'], function () {
            Route::get('/', 'EmploymentController@index');
            Route::post('create', 'EmploymentController@store');
            Route::post('view/{id}', 'EmploymentController@show');
            Route::post('update/{id}', 'EmploymentController@update');
            Route::delete('delete/{id}', 'EmploymentController@destroy');
        });

        Route::group(['prefix' => 'training'], function () {
            Route::get('/', 'TrainingController@index');
            Route::post('create', 'TrainingController@store');
            Route::post('view/{id}', 'TrainingController@show');
            Route::post('update/{id}', 'TrainingController@update');
            Route::delete('delete/{id}', 'TrainingController@destroy');
        });

        Route::group(['prefix' => 'alumni'], function () {
            Route::get('/', 'AlumniController@index');
            Route::post('import-csv', 'AlumniController@importCSV');
        });

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', 'DashboardController@index');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UserController@index');
            Route::post('create', 'UserController@store');
            Route::post('view/{id}', 'UserController@show');
            Route::post('update/{id}', 'UserController@update');
            Route::post('activate/{id}', 'UserController@activateUser');
            Route::post('deactivate/{id}', 'UserController@deactivateUser');
        });

        Route::group(['prefix' => 'lsi'], function () {
            Route::get('/', 'LsiController@index');
            Route::post('view/{id}', 'LsiController@show');
        });

        Route::group(['prefix' => 'qrcode'], function () {
            Route::post('view', 'QrDetailsController@show');
        });

    });

});
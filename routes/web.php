<?php

use UniSharp\LaravelFilemanager\Lfm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackCtrl\TagController;
use App\Http\Controllers\AuthCtrl\AuthController;
use App\Http\Controllers\BackCtrl\PostController;
use App\Http\Controllers\BackCtrl\UserController;
use App\Http\Controllers\FrontCtrl\BlogController;
use App\Http\Controllers\BackCtrl\CategoryController;
use App\Http\Controllers\BackCtrl\DashboardController;
use App\Http\Controllers\BackCtrl\NotificationController;
use App\Http\Controllers\FrontCtrl\CommentController;

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

Route::redirect('/', 'posts');
Route::prefix('posts')->controller(BlogController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{post:slug}', 'show');
    Route::prefix('comment')->middleware('auth')->group(function () {
        Route::post('store', 'storeComment');
        Route::post('store-reply', 'storeReply');
        Route::delete('{comment}/delete', 'deleteComment');
    });
});

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->middleware('guest');
    Route::post('register', 'register')->middleware('guest');
    Route::post('logout', 'logout')->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('main-menu/dashboard', DashboardController::class);
    Route::post('mark-notification', NotificationController::class);
});

Route::prefix('master-data')->middleware('auth')->group(function () {

    Route::prefix('categories')->controller(CategoryController::class)->group(function () {
        Route::get('/', 'index')->middleware('can:read category');
        Route::get('data-table', 'dataTable')->middleware('can:read category');
        Route::post('store', 'store')->middleware('can:create category');
        Route::prefix('{category:id}')->group(function () {
            Route::get('edit', 'edit')->middleware('can:update category');
            Route::put('update', 'update')->middleware('can:update category');
            Route::delete('destroy', 'destroy')->middleware('can:delete category');
        });
        Route::delete('destroy-all-selected', 'destroyAllSelected')->middleware('can:delete category');
    });

    Route::prefix('tags')->controller(TagController::class)->group(function () {
        Route::get('/', 'index')->middleware('can:read tag');
        Route::get('data-table', 'dataTable')->middleware('can:read tag');
        Route::post('store', 'store')->middleware('can:create tag');
        Route::prefix('{tag:id}')->group(function () {
            Route::get('edit', 'edit')->middleware('can:update tag');
            Route::put('update', 'update')->middleware('can:update tag');
            Route::delete('destroy', 'destroy')->middleware('can:delete tag');
        });
        Route::delete('destroy-all-selected', 'destroyAllSelected')->middleware('can:delete tag');
    });

    Route::prefix('posts')->controller(PostController::class)->group(function () {
        Route::get('/', 'index')->middleware('can:read post');
        Route::get('data-table', 'dataTable')->middleware('can:read post');
        Route::get('create', 'create')->middleware('can:create post');
        Route::post('store', 'store')->middleware('can:create post');
        Route::prefix('{post:slug}')->group(function () {
            Route::get('edit', 'edit')->middleware('can:update post');
            Route::put('update', 'update')->middleware('can:update post');
            Route::delete('destroy', 'destroy')->middleware('can:delete post');
        });
        Route::delete('destroy-all-selected', 'destroyAllSelected')->middleware('can:delete post');
    });
});

Route::prefix('management-users')->middleware('auth')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:read user');
    Route::get('data-table', 'dataTable')->middleware('can:read user');
    Route::post('store', 'store')->middleware('can:create user');
    Route::prefix('{user:id}')->group(function () {
        Route::patch('update-account-status', 'updateAccountStatus')->middleware('can:validate user');
        Route::get('edit', 'edit')->middleware('can:update user');
        Route::put('update', 'update')->middleware('can:update user');
        Route::delete('destroy', 'destroy')->middleware('can:delete user');
    });
    Route::delete('destroy-all-selected', 'destroyAllSelected')->middleware('can:delete user');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

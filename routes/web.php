<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\CategoryController;
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


Route::get('/', [FrontEndController::class, 'index'])->name('index');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/admin')->group(function(){
    //Admin Login
    Route::match(['get','post'],'/login',[AdminLoginController::class, 'adminLogin'])->name('adminlogin');
    Route::group(['middleware'=>'admin'], function(){
        //Admin Dashboard
        Route::get('/dashboard',[AdminLoginController::class, 'adminDashboard'])->name('admindashboard');
        //Admin Profile
        Route::get('/profile',[AdminLoginController::class, 'AdminProfile'])->name('profile');
        //Admin Profile Update
        Route::post('/profile/{id}',[AdminLoginController::class, 'ProfileUpdate'])->name('profileupdate');

        //Change PAssword
        Route::get('/change_password',[AdminLoginController::class, 'changePassword'])->name('change_password');
        Route::post('/check-password', [AdminLoginController::class,'checkUserPassword'])->name('checkUserPassword');

        //Category
        Route::get('/category/index', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/add', [CategoryController::class, 'categoryAdd'])->name('category.add');
        Route::post('/category/store', [CategoryController::class, 'categoryStore'])->name('category.store');
        Route::get('/category/edit/{id}', [CategoryController::class, 'Edit'])->name('category.edit');
        Route::post('/category/update/{id}', [CategoryController::class, 'Update'])->name('category.update');
        Route::get('/category-delete/{id}', [CategoryController::class, 'DeleteCategory'])->name('category.delete');
    });
    Route::get('admin/logout',[AdminLoginController::class,'AdminLogout'])->name('logout');
});

Route::get('/forget-password',[AdminLoginController::class, 'ForgetPassword'])->name('forgetpassword');

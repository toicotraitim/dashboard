<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MenuController;
use App\Http\Middleware\CheckUserMiddleware;
use App\Http\Middleware\CheckGuestMiddleware;

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
//User
Route::prefix("/admin")->middleware(CheckGuestMiddleware::class)->group(function() {
    Route::get("", AdminController::class);
    route::get("dashboard", [AdminController::class,"dashboard"])->name("admin.dashboard");
    route::get("/logout", [UserController::class,"logout"])->name("admin.logout");
    Route::resource("category-product",CategoryController::class);
    Route::resource("post-product",PostController::class);
    Route::resource("menu",MenuController::class);
    
    
});
//Guest
route::get("/admin/login", [UserController::class,"getLogin"])->name("admin.login")->middleware(CheckUserMiddleware::class);
route::post("/admin/login", [UserController::class,"postLogin"]);
<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/post', [BlogController::class, 'show'])->name('blog.show');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/course', [CourseController::class, 'show'])->name('courses.show');
Route::get('/shop', [StorefrontController::class, 'index'])->name('shop.index');
Route::get('/shop/list', [StorefrontController::class, 'listing'])->name('shop.list');
Route::get('/shop/item', [StorefrontController::class, 'product'])->name('shop.product');
Route::get('/item', [StorefrontController::class, 'product']);
Route::get('/herbs', [StorefrontController::class, 'herbs'])->name('shop.herbs');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'send'])->name('contacts.send');

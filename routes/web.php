<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Models\Brand;


/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //use for get all user
    // $users = User::all();


    //other method
    $users = DB::table('users')->get();
    return view('dashboard', compact('users'));
})->name('dashboard');

//category controller
//method by using name 

Route::get('/category/all', [CategoryController::class , 'AllCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class , 'AddCat'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class , 'Edit']);
Route::post('category/update/{id}', [CategoryController::class , 'Update']);

//trash list
Route::get('/softdelete/category/{id}', [CategoryController::class , 'SoftDelete']);
Route::get('/category/restore/{id}', [CategoryController::class , 'Restore']);
Route::get('/pdelete/category/{id}', [CategoryController::class , 'Pdelete']);

//for brand route
Route::get('/brand/all', [BrandController::class , 'AllBrand'])->name('all.brand');
Route::post('/brand/add', [BrandController::class , 'StoreBrand'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class , 'Edit']);
Route::post('brand/update/{id}', [BrandController::class , 'Update']);


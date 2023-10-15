<?php

use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
	use App\Http\Controllers\SectionsController;
	use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});
	Route::get('/home', function () {
		return view('home');
	})->middleware(['auth', 'verified'])->name('home');
	
	Route::get('/invoices', [InvoicesController::class,'index'])->name('invoices.index');
	
	
	
	Route::group([
		'middleware' => ['auth'],
		'controller'=>SectionsController::class,
		'prefix'=>'sections',
		'as'=>'sections.'
	],function (){
		Route::get('/', 'index')->name('index');
		Route::post('/store', 'store')->name('store');
		Route::patch('/update', 'update')->name('update');
		Route::delete('/destroy', 'destroy')->name('destroy');
		
	});





//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
	
//	Route::get('/{page}', [AdminController::class,'index']);
require __DIR__.'/auth.php';

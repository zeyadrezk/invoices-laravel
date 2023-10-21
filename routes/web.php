<?php

use App\Http\Controllers\InvoicesController;
	use App\Http\Controllers\InvoicesDetailsController;
	use App\Http\Controllers\ProductsController;
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
})->middleware('guest');

	Route::get('/home', function () {
		return view('home');
	})->middleware(['auth', 'verified'])
		->name('home');
	
//	Route::get('/invoices', [InvoicesController::class,'index'])->name('invoices.index')->middleware('auth');
	
	
	
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
	
	Route::group([
		'middleware' => ['auth'],
		'controller'=>ProductsController::class,
		'prefix'=>'products',
		'as'=>'products.'
	],function (){
		Route::get('/', 'index')->name('index');
		Route::post('/store', 'store')->name('store');
		Route::patch('/update', 'update')->name('update');
		Route::delete('/destroy', 'destroy')->name('destroy');
		
	});
Route::group([
		'middleware' => ['auth'],
		'controller'=>InvoicesController::class,
		'prefix'=>'invoices',
		'as'=>'invoices.'
	],function (){
		Route::get('/', 'index')->name('index');
		Route::get('/create', 'create')->name('create');
		Route::post('/store', 'store')->name('store');
		Route::patch('/update', 'update')->name('update');
		Route::delete('/destroy', 'destroy')->name('destroy');
		Route::get('/section/{id}', 'getproducts')->name('get-products');
		
	});
Route::group([
		'middleware' => ['auth'],
		'controller'=>InvoicesDetailsController::class,
		'prefix'=>'invoices',
		'as'=>'invoices.'
	],function (){
		Route::get('/details/{id}', 'edit')->name('details');
		Route::get('/View_file/{invoice_number}/{file_name}', 'open_file')->name('open.file');
		Route::get('/download/{invoice_number}/{file_name}', 'get_file')->name('get.file');
		Route::delete('/delete', 'destroy')->name('file.destroy');
		
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

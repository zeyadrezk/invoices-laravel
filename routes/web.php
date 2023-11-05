<?php

use App\Http\Controllers\InvoicesController;
	use App\Http\Controllers\InvoicesDetailsController;
	use App\Http\Controllers\ProductsController;
	use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
	use App\Http\Controllers\RoleController;
	use App\Http\Controllers\SectionsController;
	use App\Http\Controllers\UserController;
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
	
	
	//section routes
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
	
	//products routes
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
	
	
	//invoices routes
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
		Route::get('/edit/{id}', 'edit')->name('edit');
		Route::get('/section/{id}', 'getproducts')->name('get-products');
		Route::post('/restore', 'invoice_restore')->name('restore');
		
		Route::get('/print/php{id}', 'print_invoice')->name('print.invoice');
		Route::get('/excel_export', 'export')->name('excel.export');
		
		//status
		Route::get('/status_show/{id}', 'show')->name('status.show');
		Route::post('/status_update', 'status_update')->name('status.update');
		
		//show types of invoices
		Route::get('/paid', 'invoice_paid')->name('paid');
		Route::get('/unpaid', 'invoice_unpaid')->name('unpaid');
		Route::get('/partial', 'invoice_partial')->name('partial');
		Route::get('/archived_invoices', 'archived_invoices')->name('archived_invoices');
		
		//delete and archive
		Route::delete('/destroy', 'destroy')->name('destroy');
		Route::delete('/archive', 'invoice_archive')->name('archive');
	
});


		//details of invoices routes
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
		Route::post('/Attachments', 'store_attachment')->name('store.attachments');
		
	});
	
	
	Route::group(['middleware' => ['auth']], function() {
		
		Route::get('roles',[RoleController::class,'index'])->name('roles.index');
		Route::get('roles/create',[RoleController::class,'create'])->name('roles.create');
		Route::post('roles/store',[RoleController::class,'store'])->name('roles.store');
		Route::get('roles/edit/{id}',[RoleController::class,'edit'])->name('roles.edit');
		Route::patch('roles/update/{id}',[RoleController::class,'update'])->name('roles.update');
		Route::delete('roles/destroy/{id}',[RoleController::class,'destroy'])->name('roles.destroy');
		Route::get('roles/show/{id}',[RoleController::class,'show'])->name('roles.show');
		
		Route::get('users',[UserController::class,'index'])->name('users.index');
		Route::get('users/create',[UserController::class,'create'])->name('users.create');
		Route::post('users/store',[UserController::class,'store'])->name('users.store');
		Route::get('users/edit/{id}',[UserController::class,'edit'])->name('users.edit');
		Route::patch('users/update/{id}',[UserController::class,'update'])->name('users.update');
		Route::delete('users/destroy',[UserController::class,'destroy'])->name('users.destroy');
		
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

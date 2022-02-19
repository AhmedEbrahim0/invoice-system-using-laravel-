<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionRole;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\report\reportController;


Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('Role', 'PermissionRole');

Route::namespace("invoice")->group(function(){
    Route::resource('invoice', 'InvoicesController')->middleware('auth');
    Route::get("attachment/{folder_name}/{file_name}","InvoicesController@download")->name("download");
    Route::get("attach/show/{folder_name}/{file_name}","InvoicesController@showAttach")->name('show.attach');
    Route::get("attach/delete/{folder_name}/{file_name}/{id}","InvoicesController@deleteAttach")->name('attach.delete');
    Route::post("attach/add","InvoicesController@addAttach")->name('attach.add');
    Route::get("/copy","InvoicesController@copy");
    Route::get('/invoice/status/{id}',"InvoicesController@status")->name('invoice.status');
    Route::get('invoice/status/update/{id}',"InvoicesController@updateStatus")->name('invoice.status.update');
    Route::get('/invoice_paid',"InvoicesController@invoicePaid")->name("invoice.paid");
    Route::get('/invoice_non_paid',"InvoicesController@invoiceNonPaid")->name("invoice.non.paid");
    Route::get('/archive',"InvoicesController@archive")->name("invoice.archive");
    Route::get('/archive/update{id}',"InvoicesController@archive_update")->name("invoice.archive.update");
    Route::get("/invoice/print/{id}","InvoicesController@print")->name("invoice.print");
    Route::get("/export","InvoicesController@export")->name("export");
});

Route::namespace("sections")->group(function(){
Route::resource('section','SectionsController')->middleware('auth');
});

Route::namespace("product")->group(function(){
    Route::resource('product', 'ProductsController')->middleware('auth');
    Route::get("/ajax/{id}",'ProductsController@product');
});




Route::namespace("users")->group(function(){
    Route::resource('users', "UserController")->middleware("role:owner");
    Route::get("add_permission","UserController@add_permission")->middleware("role:owner")->name("add.permission");
    Route::get("/user_export","UserController@export")->name("user.export")->middleware("role:owner");
});

Route::namespace("report")->group(function(){

    Route::resource('reports', 'reportController');
    Route::post("reports","reportController@search")->name("search");
});




// this must be in the end
Route::get('/{page}', 'AdminController@index');





<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes([
    'verivy' => false,
    'reset' => false
]);

Route::middleware(['auth'])->group(function () {

    Route::middleware(['admin'])->group(function () {
        /**
         * Resource Barang
         */
        Route::post('/barang/get', 'BarangController@get')->name('barang.get');
        Route::post('/category/get', 'CategoryController@get')->name('category.get');
        Route::post('/member/get', 'MemberController@get')->name('member.get');

        /**
         * Stock
         */


        Route::prefix('/stock')->name('stock.')->group(function () {
            Route::get('/add', 'StockController@add')->name('add');
            Route::get('/remove', 'StockController@remove')->name('remove');

            Route::post('/create', 'StockController@create')->name('create');
            Route::delete('/destroy/{stock}', 'StockController@destroy')->name('destroy');
        });

        /**
         * Setting
         */

        Route::prefix('/setting')->name('setting.')->group(function () {
            Route::view('/', 'setting.index')->name('index');
            Route::put('/save', 'SettingController@save')->name('save');
        });

        /**
         * Laporan
         */

        Route::prefix('/laporan')->name('laporan.')->group(function () {
            Route::get('/', 'LaporanController@index')->name('index');
            Route::post('/download', 'LaporanController@download')->name('download');
        });

        /**
         * resource
         */
        Route::resource('/category', 'CategoryController')->except(['show', 'edit', 'create']);
        Route::resource('/member', 'MemberController')->except(['edit']);
        Route::resource('/user', 'Usercontroller')->except(['edit']);
    });

    Route::resource('/barang', 'BarangController')->except(['show', 'edit']);
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('/loan')->name('loan.')->group(function () {
        Route::patch('/return/{loan}', 'LoanController@return')->name('return');
        Route::patch('/extend/{loan}', 'LoanController@extend')->name('extend');
    });

    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::get('/index', 'ProfileController@index')->name('index');
        Route::put('/save', 'ProfileController@save')->name('save');
    });

    Route::post('register/save', 'ProfileController@simpan_register')->name('profile.simpanregister');

    Route::resource('/loan', 'LoanController')->except(['show', 'edit', 'update']);
});

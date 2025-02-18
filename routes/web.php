<?php

use App\Http\Controllers\AgenVoucherController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    // 'material' => MaterialController::class
]);
Route::group(["prefix" => "dataMaster"], function(){
    //master merek
    Route::get('merek', [MerekController::class, 'index'])->name('datamaster.merek');
    Route::get('merek/getData', [MerekController::class, 'getData'])->name('datamaster.merek.getdata');
    Route::get('merek/create', [MerekController::class, 'create'])->name('datamaster.merek.create');
    Route::post('merek/store', [MerekController::class, 'store'])->name('datamaster.merek.store');
    Route::get('merek/edit/{id}', [MerekController::class, 'edit'])->name('datamaster.merek.edit');
    Route::put('merek/update/{id}', [MerekController::class, 'update'])->name('datamaster.merek.update');
    Route::get('merek/destroy/{id}', [MerekController::class, 'destroy'])->name('datamaster.merek.destroy');
    //master satuan
    Route::get('satuan', [SatuanController::class, 'index'])->name('datamaster.satuan');
    Route::get('satuan/getData', [SatuanController::class, 'getData'])->name('datamaster.satuan.getdata');
    Route::get('satuan/create', [SatuanController::class, 'create'])->name('datamaster.satuan.create');
    Route::post('satuan/store', [SatuanController::class, 'store'])->name('datamaster.satuan.store');
    Route::get('satuan/edit/{id}', [SatuanController::class, 'edit'])->name('datamaster.satuan.edit');
    Route::put('satuan/update/{id}', [SatuanController::class, 'update'])->name('datamaster.satuan.update');
    Route::get('satuan/destroy/{id}', [SatuanController::class, 'destroy'])->name('datamaster.satuan.destroy');
});
Route::group(['prefix' => 'wilayah'], function(){
    Route::get('list', [WilayahController::class, 'list'])->name('wilayah.list');
    Route::get('getData', [WilayahController::class, 'getData'])->name('wilayah.getdata');
    Route::get('create', [WilayahController::class, 'create'])->name('wilayah.create');
    Route::post('store', [WilayahController::class, 'store'])->name('wilayah.store');
    Route::get('edit/{id}', [WilayahController::class, 'edit'])->name('wilayah.edit');
    Route::put('update/{id}', [WilayahController::class, 'update'])->name('wilayah.update');
    Route::get('destroy/{id}', [WilayahController::class, 'destroy'])->name('wilayah.destroy');
});
Route::group(['prefix' => 'cabang'], function(){
    Route::get('list', [CabangController::class, 'list'])->name('cabang.list');
    Route::get('getData', [CabangController::class, 'getData'])->name('cabang.getdata');
    Route::get('create', [CabangController::class, 'create'])->name('cabang.create');
    Route::post('store', [CabangController::class, 'store'])->name('cabang.store');
    Route::get('edit/{id}', [CabangController::class, 'edit'])->name('cabang.edit');
    Route::put('update/{id}', [CabangController::class, 'update'])->name('cabang.update');
    Route::get('destroy/{id}', [CabangController::class, 'destroy'])->name('cabang.destroy');
});
Route::group(["prefix" => "material"], function(){
    Route::get('create', [MaterialController::class, 'create'])->name('material.create');
    Route::post('store', [MaterialController::class, 'store'])->name('material.store');
    Route::get('edit/{id}', [MaterialController::class, 'edit'])->name('material.edit');
    Route::put('update/{id}', [MaterialController::class, 'update'])->name('material.update');
    Route::get('list', [MaterialController::class, 'index'])->name('material.index');
    Route::get('getData', [MaterialController::class, 'getData'])->name('material.getData');

    //control stok
    Route::get('kontrol', [MaterialController::class, 'kontrol'])->name('material.kontrol');
});

Route::group(["prefix" => "pembelian"], function(){
    //baru
    Route::get("/", [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('storeHead', [PembelianController::class, 'storeHead'])->name('pembelian.storeHead');
    Route::get('addDetail/{id}', [PembelianController::class, 'addDetail'])->name('pembelian.addDetail');
    Route::get('formAddItems/{nomor}', [PembelianController::class, 'addItems'])->name('pembelian.addItems');
    Route::post('storeItem', [PembelianController::class, 'storeItem'])->name('pembelian.storeItem');
    Route::get('getDataItems', [PembelianController::class, 'getDataItems'])->name('pembelian.getDataItems');
    Route::get('formEditItem/{id}', [PembelianController::class, 'editItem'])->name('pembelian.editItem');
    Route::put('updateItem/{id}', [PembelianController::class, 'updateItem'])->name('pembelian.updateItem');
    Route::get('destroyItem/{id}', [PembelianController::class, 'destroyItem'])->name('pembelian.destroyItem');
    Route::put('finishTrans/{id}', [PembelianController::class, 'finishTrans'])->name('pembelian.finishTrans');
    //daftar
    Route::get('list', [PembelianController::class, 'list'])->name('pembelian.list');
    Route::get('getData', [PembelianController::class, 'getData'])->name('pembelian.getData');
    Route::get('showDetail/{id}', [PembelianController::class, 'show'])->name('pembelian.show');
});

//akanet
Route::group(['prefix' => 'voucher'], function(){
    Route::get('list', [VoucherController::class, 'list'])->name('voucher.list');
    Route::get('getData', [VoucherController::class, 'getData'])->name('voucher.getdata');
    Route::get('create', [VoucherController::class, 'create'])->name('voucher.create');
    Route::post('store', [VoucherController::class, 'store'])->name('voucher.store');
    Route::get('edit/{id}', [VoucherController::class, 'edit'])->name('voucher.edit');
    Route::put('update/{id}', [VoucherController::class, 'update'])->name('voucher.update');
    Route::get('destroy/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');
});
Route::group(['prefix' => 'agen'], function(){
    Route::get('list', [AgenVoucherController::class, 'list'])->name('agen.list');
    Route::get('getData', [AgenVoucherController::class, 'getData'])->name('agen.getdata');
    Route::get('create', [AgenVoucherController::class, 'create'])->name('agen.create');
    Route::post('store', [AgenVoucherController::class, 'store'])->name('agen.store');
    Route::get('edit/{id}', [AgenVoucherController::class, 'edit'])->name('agen.edit');
    Route::put('update/{id}', [AgenVoucherController::class, 'update'])->name('agen.update');
    Route::get('destroy/{id}', [AgenVoucherController::class, 'destroy'])->name('agen.destroy');
});

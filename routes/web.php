<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Master\ComponentController;
use App\Http\Controllers\Master\StatusController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Ops\DistribusiController;
use App\Http\Controllers\Ops\IncDataController;
use App\Http\Controllers\Report\StokComponentController;
use App\Http\Controllers\Report\UseComponentController;
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




Route::get('/',[LoginController::class,'showLoginForm'])->name('login');

Auth::routes();

Route::middleware('auth:web')->group(function(){
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home/{type}',[App\Http\Controllers\HomeController::class,'get']);
    Route::get('/home/getrange/{per}/{segment?}/{info?}/{start?}/{end?}',[App\Http\Controllers\HomeController::class,'getrange']);


    Route::group(['prefix' => 'ops'],function(){

        Route::group(['prefix' => 'incomingdata'],function(){
            Route::get('formcreate',[IncDataController::class,'formCreate'])->name('ops.incdata.form');
            Route::get('listdata',[IncDataController::class,'listIncData'])->name('ops.incdata.list');
            Route::post('listdata',[IncDataController::class,'storeData'])->name('ops.incdata.storeData');
            Route::delete('listdata',[IncDataController::class,'destroyData'])->name('ops.incdata.destroyData');
            Route::get('getCurrentsts',[IncDataController::class,'getCurrentsts'])->name('getCurrentsts');
            Route::post('UpdateSts',[IncDataController::class,'UpdateSts'])->name('ops.incdata.UpdateSts');
            Route::get('detailMaster',[IncDataController::class,'detailMaster'])->name('ops.incdata.detailMaster');
        });

        Route::group(['prefix' => 'distribusi'], function(){
            Route::get('listdistribusi',[DistribusiController::class,'listdistribusi'])->name('ops.listdistribusi');
            Route::post('storeTtdKurir',[DistribusiController::class,'storeTtdKurir'])->name('ops.distribusi.storeTtdKurir');
            Route::get('print',[DistribusiController::class,'print'])->name('ops.distribusi.print');
        });
    });

    Route::group(['prefix' => 'master'], function(){
        Route::get('listcomponent',[ComponentController::class,'list'])->name('master.component.list');
        Route::post('listcomponent',[ComponentController::class,'storeComponent'])->name('master.component.store');
        Route::delete('listcomponent',[ComponentController::class,'destroyComponent'])->name('master.component.destroy');
        Route::post('putcomponent',[ComponentController::class,'putComponent'])->name('master.component.put');
        Route::get('getcomp',[ComponentController::class,'getByid'])->name('master.component.gebyid');

        Route::get('liststatus',[StatusController::class,'listStatus'])->name('master.status.list');
        Route::post('liststatus',[StatusController::class,'saveAll'])->name('master.status.store');
        Route::get('getstatus',[StatusController::class,'editByid'])->name('master.status.editByid');
        Route::post('savedit',[StatusController::class,'saveAllEdit'])->name('master.status.saveAllEdit');
        Route::delete('liststatus',[StatusController::class,'destroyStatus'])->name('master.status.destroy');

        Route::get('listuser',[UserController::class,'listuser'])->name('master.listuser.list');
        Route::post('listuser',[UserController::class,'storeUser'])->name('master.listuser.store');
        Route::delete('listuser',[UserController::class,'destroyUser'])->name('master.listuser.destroyUser');

    });

    Route::group(['prefix' => 'report'], function(){
        Route::get('listStok',[StokComponentController::class,'listStok'])->name('report.listStok');
        Route::get('listusecomp',[UseComponentController::class,'listusecomp'])->name('report.listusecomp');
    });

    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
});

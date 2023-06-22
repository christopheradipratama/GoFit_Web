<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\jadwalHarianController;
use App\Http\Controllers\bookingKelasController;
use App\Http\Controllers\bookingGymController;
use App\Http\Controllers\presensiInstrukturController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login", "App\Http\Controllers\loginController@login");

Route::group(['middleware' => 'auth:member-api,pegawai-api,instruktur-api'], function(){
    Route::post("logout", "App\Http\Controllers\loginController@logout");    
});

Route::post("gantiPassword", "App\Http\Controllers\loginController@gantiPassword");

Route::get("IndexJadwalHarian", "App\Http\Controllers\jadwalHarianController@index_mobile");
Route::get("IndexJadwalHarianInstruktur/{id}", "App\Http\Controllers\izinInstrukturController@index_jadwal_harian");
Route::get("IndexBookingGym/{id}", "App\Http\Controllers\bookingGymController@index_mobile");

Route::get("IndexIzinInstruktur/{id}", "App\Http\Controllers\izinInstrukturController@index_mobile");
Route::post("AddIzinInstruktur", "App\Http\Controllers\izinInstrukturController@store");

Route::post("bookingKelas", "App\Http\Controllers\bookingKelasController@store");
Route::get("IndexBookingKelas/{id}", "App\Http\Controllers\bookingKelasController@index_mobile");
Route::delete("cancelBookingKelas/{id}", "App\Http\Controllers\bookingKelasController@cancelBooking");
Route::get('instruktur_jadwal_presensi/{id}','App\Http\Controllers\bookingKelasController@index_mobile_presensi_jadwal');
Route::get('presensi_member/{id}','App\Http\Controllers\bookingKelasController@index_mobile_presensi_history');
Route::post('update_transaksi_presensi','App\Http\Controllers\bookingKelasController@update_transaksi');

Route::post("CreateBookingGym", "App\Http\Controllers\bookingGymController@store");
Route::delete("CancelBookingGym/{id}", "App\Http\Controllers\bookingGymController@batal_gym");

Route::post("CreatePresensiInstruktur", "App\Http\Controllers\presensiInstrukturController@store");
Route::get("IndexPresensiInstruktur", "App\Http\Controllers\presensiInstrukturController@index_mobile");

Route::get("dataMember/{id}", "App\Http\Controllers\memberController@getDataMember");
Route::get("dataInstruktur/{id}","App\Http\Controllers\instrukturController@getDataInstruktur");

Route::get("historyAktivitasInstruktur/{id}","App\Http\Controllers\instrukturController@getHistoryAktivitasInstruktur");






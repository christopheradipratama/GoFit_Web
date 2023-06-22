<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\memberController;
use App\Http\Controllers\instrukturController;
use App\Http\Controllers\izinInstrukturController;
use App\Http\Controllers\jadwalUmumController;
use App\Http\Controllers\jadwalHarianController;
use App\Http\Controllers\transaksiAktivasiController;
use App\Http\Controllers\transaksiDepositKelasController;
use App\Http\Controllers\transaksiDepositUangController;
use App\Http\Controllers\bookingKelasController;
use App\Http\Controllers\bookingGymController;
use App\Http\Controllers\laporanController;

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
Route::get("/", [loginController::class, "homePage"]);
Route::get("/loginPage", [loginController::class, "loginPage"]);

Route::post("/login", [loginController::class, "login"]);
Route::get("/logout", [loginController::class, "logout"]);

Route::get("/confirmEmail", [loginController::class, "confirmEmailPage"]);
Route::get("/confirmEmailProccess", [loginController::class, "confirmEmailProccess"]);
Route::get("/confirmPassword", [loginController::class, "confirmPasswordPage"]);
Route::post("/confirmPasswordProccess/{id}", [loginController::class, "confirmPasswordProccess"]);
Route::get("/dashboard", [dashboardController::class, "index"]);

//Route Member
Route::get("/member", [memberController::class, "index"]);
Route::get("/searchMember", [memberController::class, "search"]);
Route::get("/addMember", [memberController::class, "create"]);
Route::post("/storeMember", [memberController::class, "store"]);
Route::get("/editMember/{id}", [memberController::class, "edit"]);
Route::put("/updateMember/{id}", [memberController::class, "update"]);
Route::delete("/deleteMember/{id}", [memberController::class, "destroy"]);
Route::get("/resetPasswordMember/{id}", [memberController::class, "resetPassword"]);
Route::get("/cardMember/{id}", [memberController::class, "cardMember"]);

//Route Deactive Member
Route::get("/deactiveMember", [memberController::class, "deactiveIndex"]);
Route::get("/proccessDeactiveMemberAll", [memberController::class, "proccessDeactiveAll"]);
Route::get("/processDeactiveMember/{id}", [memberController::class, "processDeactive"]);

//Route Reset Class
Route::get("/resetClass", [memberController::class, "resetClassIndex"]);
Route::get("/proccessResetClass", [memberController::class, "proccessResetClass"]);

//Route Instruktur
Route::get("/instruktur", [instrukturController::class, "index"]);
Route::get("/searchInstruktur", [instrukturController::class, "search"]);
Route::get("/addInstruktur", [instrukturController::class, "create"]);
Route::post("/storeInstruktur", [instrukturController::class, "store"]);
Route::get("/editInstruktur/{id}", [instrukturController::class, "edit"]);
Route::put("/updateInstruktur/{id}", [instrukturController::class, "update"]);
Route::delete("/deleteInstruktur/{id}", [instrukturController::class, "destroy"]);

//Route Izin Instruktur
Route::get("/izinInstruktur", [izinInstrukturController::class, "index"]);
Route::get("/updateIzinInstruktur/{id}", [izinInstrukturController::class, "update"]);

//Route Reset Terlambat Instrukur
Route::get("/resetTerlambat", [instrukturController::class, "resetTerlambatIndex"]);
Route::get("/processResetTerlambat", [instrukturController::class, "processResetTerlambat"]);

//Route Jadwal Umum
Route::get("/jadwalUmum", [jadwalUmumController::class, "index"]);
Route::get("/addJadwalUmum", [jadwalUmumController::class, "create"]);
Route::post("/storeJadwalUmum", [jadwalUmumController::class, "store"]);
Route::get("/editJadwalUmum/{id}", [jadwalUmumController::class, "edit"]);
Route::put("/updateJadwalUmum/{id}", [jadwalUmumController::class, "update"]);
Route::delete("/deleteJadwalUmum/{id}", [jadwalUmumController::class, "destroy"]);

//Route Jadwal Harian
Route::get("/jadwalHarian", [jadwalHarianController::class, "index"]);
Route::get("/searchJadwalHarian", [jadwalHarianController::class, "search"]);
Route::get("/generateJadwalHarian", [jadwalHarianController::class, "generateJadwalHarian"]);
Route::post("/storeJadwalHarian", [jadwalHarianController::class, "store"]);
Route::get("/editJadwalHarian/{id}", [jadwalHarianController::class, "edit"]);
Route::put("/updateJadwalHarian/{id}", [jadwalHarianController::class, "update"]);
Route::delete("/deleteJadwalHarian/{id}", [jadwalHarianController::class, "destroy"]);

//Route Transaksi Aktivasi
Route::get("/transaksiAktivasi", [transaksiAktivasiController::class, "index"]);
Route::post("/addTransaksiAktivasi", [transaksiAktivasiController::class, "store"]);
Route::get("/strukTransaksiAktivasi/{id}", [transaksiAktivasiController::class, "cetakStruk"]);
Route::get("/konfirmasiTransaksiAktivasi", [transaksiAktivasiController::class, "indexTransaksiAktivasi"]);

//Route Transaksi Deposit Kelas
Route::get("/transaksiDepositKelas", [transaksiDepositKelasController::class, "index"]);
Route::post("/addTransaksiDepositKelas", [transaksiDepositKelasController::class, "create"]);
Route::get("/strukTransaksiDepositKelas/{id}", [transaksiDepositKelasController::class, "cetakStruk"]);
Route::get("/konfirmasiTransaksiDepositKelas", [transaksiDepositKelasController::class, "indexKonfirmasiDepositKelas"]);

//Route Transaksi Deposit Uang
Route::get("/transaksiDepositUang", [transaksiDepositUangController::class, "index"]);
Route::post("/addTransaksiDepositUang", [transaksiDepositUangController::class, "create"]);
Route::get("/strukTransaksiDepositUang/{id}", [transaksiDepositUangController::class, "cetakStruk"]);

//Route Presensi Booking Kelas
Route::get("/presensiBookingKelas", [bookingKelasController::class, "index"]);
Route::get("/strukBookingKelas/{id}", [bookingKelasController::class, "cetakStruk"]);

//Route Presensi Booking Gym
Route::get("/presensiBookingGym", [bookingGymController::class, "index"]);
Route::get("/konfirmasiGym/{id}", [bookingGymController::class, "konfirmasiGym"]);
Route::get("/strukBookingGym/{id}", [bookingGymController::class, "cetakStruk"]);

Route::get("/laporanPendapatan", [laporanController::class, "indexLaporanPendapatan"]);
Route::get("/laporanPendapatanProccess", [laporanController::class, "getLaporanPendapatan"]);

Route::get("/laporanKelas", [laporanController::class, "indexLaporanKelas"]);
Route::get("/laporanKelasProccess", [laporanController::class, "getLaporanKelas"]);

Route::get("/laporanGym", [laporanController::class, "indexLaporanGym"]);
Route::get("/laporanGymProccess", [laporanController::class, "getLaporanGym"]);

Route::get("/laporanInstruktur", [laporanController::class, "indexLaporanInstruktur"]);
Route::get("/laporanInstrukturProccess", [laporanController::class, "getLaporanInstruktur"]);


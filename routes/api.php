<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MahasiswaController;

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

Route::group(['prefix' => 'v1'], function () {
	
	// Mahasiswa
	Route::get('mahasiswa', [MahasiswaController::class, 'listMahasiswa']);
	Route::get('mahasiswa/{id}', [MahasiswaController::class, 'listMahasiswaById']);
	Route::post('mahasiswa/create', [MahasiswaController::class, 'insertMahasiswa']);
	Route::put('mahasiswa/update', [MahasiswaController::class, 'updateMahasiswa']);
	Route::delete('mahasiswa/delete', [MahasiswaController::class, 'deleteMahasiswa']);
});


<?php

use Illuminate\Support\Facades\Route;
use App\Models\User; // Import Model User
use Illuminate\Support\Facades\DB; // Import DB


use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ServiceController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // เรียกใช้ Model User ซึ่งต้อง Import ข้างบนด้วย
    $users = User::all();
    // $users = DB::table('users')->get(); // กรณีไม่มี model
    return view('dashboard', compact('users'));
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function (){ // การกำหนดหน้าที่ต้อง Login ก่อน ถึงจะเข้าถึงหน้าดังกล่าวได้ ***แบบกลุ่ม***

    // -------- Department --------- //
    Route::get('/department/all', [DepartmentController::class, 'index'])->name('department');
    Route::post('/department/add', [DepartmentController::class, 'store'])->name('addDepartment');
    Route::get('/department/edit/{id}', [DepartmentController::class, 'edit']);
    Route::post('/department/update/{id}', [DepartmentController::class, 'update']);

    Route::get('/department/softdelete/{id}', [DepartmentController::class, 'softdelete']);
    Route::get('/department/restore/{id}', [DepartmentController::class, 'restore']);
    Route::get('/department/forcedelete/{id}', [DepartmentController::class, 'forceDelete']);


    // ----------- Service ------------ //
    Route::get('/service/all', [ServiceController::class, 'index'])->name('service');
    Route::post('/service/add', [ServiceController::class, 'store'])->name('addService');
    Route::get('/service/edit/{id}', [ServiceController::class, 'edit']);
    Route::post('/service/update/{id}', [ServiceController::class, 'update']);
    Route::get('/service/delete/{id}', [ServiceController::class, 'delete']);
});



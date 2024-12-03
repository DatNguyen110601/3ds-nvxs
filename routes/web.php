<?php

use App\Models\User;
use App\Models\NhanVien;
use App\Models\DiemThang;
use App\Models\DanhSachTieuChi;
use App\Models\DiemTheoTieuChi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\DiemThangController;
use App\Http\Controllers\DuyetDiemThangController;
use App\Http\Controllers\DanhMucThangNamController;
use App\Http\Controllers\DanhSachTieuChiController;
use App\Http\Controllers\DiemTheoTieuChiController;
use App\Http\Controllers\NhanVienXuatSacController;
use App\Http\Controllers\ChamDiemNhanVienController;
use App\Http\Controllers\TieuChiTheoThangController;
use App\Http\Controllers\NhanVienTrongDMTNController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/', [HomeController::class])->name('home');
// });

Route::middleware('auth:sanctum')->group(function(){
// Route::get('/', [DanhMucThangNamController::class, 'home'])->name('home');
    Route::get('/', [HomeController::class, '__invoke'])->name('home');

Route::prefix('/danh-muc-thang-nam')->as('danh-muc-thang-nam.')->group(function() {
    Route::get('/', [DanhMucThangNamController::class, 'index'])->name('index');
    Route::get('/show/{danhMucThangNam}', [DanhMucThangNamController::class, 'show'])->name('show');
    Route::get('/create', [DanhMucThangNamController::class, 'create'])->name('create');
    Route::post('/create/store', [DanhMucThangNamController::class, 'store'])->name('store');
    Route::get('/edit/{danhMucThangNam}', [DanhMucThangNamController::class, 'edit'])->name('edit');
    Route::put('/edit/{danhMucThangNam}/update', [DanhMucThangNamController::class, 'update'])->name('update');
    Route::delete('/{danhMucThangNam}/delete', [DanhMucThangNamController::class, 'destroy'])->name('delete');
// // xem chi tiết điểm nhân viên theo tháng
    Route::get('/show/{danhMucThangNam}/nhan-vien/{nhanVien}/', [DanhMucThangNamController::class, 'xemDiemNhanVienThang'])->name('xem-diem-nhan-vien-thang');
// xuất file excel
    Route::get('/danh-muc-thang-nam/{danhMucThangNam}/xuat-file-excel', [DanhMucThangNamController::class, 'exportExcel'])->name('exportExcel');

});

Route::prefix('/nhan-vien')->as('nhan-vien.')->group(function() {
    Route::get('/', [NhanVienController::class, 'index'])->name('index');
    Route::get('/show/{danhSachNhanVien}', [NhanVienController::class, 'show'])->name('show');
    // Route::get('/create', [NhanVienController::class, 'create'])->name('create');
    // Route::post('/create/store', [NhanVienController::class, 'store'])->name('store');
    Route::get('/edit/{danhSachNhanVien}', [NhanVienController::class, 'edit'])->name('edit');
    Route::put('/edit/{danhSachNhanVien}/update', [NhanVienController::class, 'update'])->name('update');

});

Route::prefix('/tieu-chi-nhan-vien')->as('tieu-chi-nhan-vien.')->group(function() {
    Route::get('/', [DanhSachTieuChiController::class, 'index'])->name('index');
    Route::get('/create', [DanhSachTieuChiController::class, 'create'])->name('create');
    Route::post('/store', [DanhSachTieuChiController::class, 'store'])->name('store');
    Route::get('/edit/{danhSachTieuChi}', [DanhSachTieuChiController::class, 'edit'])->name('edit');
    Route::put('/edit/{danhSachTieuChi}/update', [DanhSachTieuChiController::class, 'update'])->name('update');
    Route::delete('/{danhSachTieuChi}/delete', [DanhSachTieuChiController::class, 'destroy'])->name('delete');


});

// //ds tiêu chí tháng
Route::prefix('/tieu-chi-theo-thang')->as('tieu-chi-theo-thang.')->group(function() {
    Route::get('/', [TieuChiTheoThangController::class, 'index'])->name('index');
    Route::get('/{danhMucThangNam}/show', [TieuChiTheoThangController::class, 'show'])->name('show');
    Route::get('/create', [TieuChiTheoThangController::class, 'create'])->name('create');
    Route::post('/store', [TieuChiTheoThangController::class, 'store'])->name('store');
    Route::get('/edit/{danhMucThangNam}', [TieuChiTheoThangController::class, 'edit'])->name('edit');
    Route::put('/edit/{danhMucThangNam}/update', [TieuChiTheoThangController::class, 'update'])->name('update');

    Route::delete('/delete/tieu-chi-thang/{id_thang_nam}/tieu-chi/{id_tieu_chi}', [TieuChiTheoThangController::class, 'destroy'])->name('delete');
    // thêm tiêu chí theo tháng, có thể khác nhân viên
    Route::get('{danhMucThangNam}/create', [TieuChiTheoThangController::class, 'themTieuChiThang'])->name('them-tieu-chi-thang');
    Route::get('{danhMucThangNam}/edit/nam-thang/{id_thang_nam}/tieu-chi/{id_tieu_chi}', [TieuChiTheoThangController::class, 'suaTieuChiThang'])->name('sua-tieu-chi-thang');
    Route::put('{danhMucThangNam}/edit/nam-thang/{id_thang_nam}/tieu-chi/{id_tieu_chi}/update', [TieuChiTheoThangController::class, 'updateTieuChiThang'])->name('update-tieu-chi-thang');



});

Route::get('/diem-theo-tieu-chi', [DiemTheoTieuChiController::class, 'index'])->name('diem-theo-tieu-chi.index');
Route::get('/danh-muc-thang-nam/{danhMucThangNam}/nhan-vien/{nhanVien}/{diemThang}/diem-theo-tieu-chi/create', [DiemTheoTieuChiController::class, 'create'])->name('diem-theo-tieu-chi.create');
Route::post('/danh-muc-thang-nam/{danhMucThangNam}/nhan-vien/{nhanVien}/{diemThang}/diem-theo-tieu-chi/store', [DiemTheoTieuChiController::class, 'store'])->name('diem-theo-tieu-chi.store');


// //chấm điểm nhân viên
Route::get('/danh-muc-thang-nam/{danhMucThangNam}/nhan-vien/{nhanVien}/cham-diem', [ChamDiemNhanVienController::class, 'create'])->name('cham-diem-nhan-vien.create');
Route::post('/danh-muc-thang-nam/{danhMucThangNam}/nhan-vien/{nhanVien}/diem-theo-tieu-chi/store/{diemThang}', [ChamDiemNhanVienController::class, 'store'])->name('cham-diem-nhan-vien.store');
Route::get('/danh-muc-thang-nam/{danhMucThangNam}/nhan-vien/{nhanVien}/sua-diem', [ChamDiemNhanVienController::class, 'edit'])->name('cham-diem-nhan-vien.edit');


// nhân viên-> điểm tháng
Route::prefix('/diem-thang')->as('diem-thang.')->group(function() {
    Route::get('/', [DiemThangController::class, 'index'])->name('index');
    Route::get('/{diemThang}/nhan-vien/{nhanVien}', [DiemThangController::class, 'show'])->name('show');
});
Route::get('/danh-muc-thang-nam/{danhMucThangNam}/duyet-tat-ca', [DuyetDiemThangController::class, 'duyetDiemThangAll'])->name('duyet.duyetDiemThangAll');
Route::get('/danh-muc-thang-nam/{danhMucThangNam}/nhan-vien/{nhanVien}/duyet', [DuyetDiemThangController::class, 'duyetDiemThang'])->name('duyet.duyetDiemThang');

//nhân viên xuất sắc
Route::prefix('/nhan-vien-xuat-sac')->as('nhan-vien-xuat-sac.')->group(function() {
    Route::get('/nhan-vien-xuat-sac', [NhanVienXuatSacController::class, 'index'])->name('index');

});


//thêm nhân viên vào tháng
Route::prefix('')->as('nhan-vien-trong-dmtn.')->group(function() {
    Route::get('/danh-muc-thang-nam/{danhMucThangNam}/nhan-vien/create', [NhanVienTrongDMTNController::class, 'create'])->name('create');
    Route::post('/danh-muc-thang-nam/{danhMucThangNam}/nhan-vien/store', [NhanVienTrongDMTNController::class, 'store'])->name('store');
    Route::delete('/danh-muc-thang-nam/{danhMucThangNam}/diem-thang/{diemThang}/delete', [NhanVienTrongDMTNController::class, 'destroy'])->name('delete');

});



});


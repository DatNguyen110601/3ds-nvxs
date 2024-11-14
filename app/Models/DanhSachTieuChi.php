<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhSachTieuChi extends Model
{
    use HasFactory;
    public $table = 'nvxs___danh_sach_tieu_chis';
    public $fillable = ['ten_tieu_chi', 'diem_toi_da', 'diem_toi_thieu','he_so','trang_thai'];
    public $timestamps = false;


    const TT_HOAT_DONG = 1;
    const TT_TAT = 0;

    public static $dsTrangThai = [
        self::TT_HOAT_DONG => 'Hoạt động',
        self::TT_TAT => 'Tắt'
    ];
}

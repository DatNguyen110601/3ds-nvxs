<?php

namespace App\Models;

use App\Models\DiemTheoTieuChi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    /**
     * Get all of the comments for the DanhSachTieuChi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diemTheoTieuChi(): HasMany
    {
        return $this->hasMany(DiemTheoTieuChi::class, 'id_tieu_chi', 'id');
    }
}

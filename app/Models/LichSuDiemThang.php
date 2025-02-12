<?php

namespace App\Models;

use App\Models\User;
use App\Models\LichSuDiemTheoTieuChi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LichSuDiemThang extends Model
{
    use HasFactory;

    public $table = 'nvxs___lich_su_diem_thangs';
    public $fillable = ['id_thang_nam','id_nhan_vien','id_nguoi_cham','tong_diem'];



    public function nhanVien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_nhan_vien', 'id');
    }

    public function nguoiCham(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_nguoi_cham', 'id');
    }

    public function lsDiemTheoTieuChi(): HasMany
    {
        return $this->hasMany(LichSuDiemTheoTieuChi::class, 'id_diem_nv_thang', 'id');
    }

}

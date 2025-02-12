<?php

namespace App\Models;

use App\Models\DiemThang;
use App\Models\LichSuDiemThang;
use App\Models\TieuChiTheoThang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DanhMucThangNam extends Model
{
    use HasFactory;
    public $table = 'nvxs___danh_muc_thang_nams';
    public $timestamps = false;
    public $fillable = [
        'thang', 'nam'
    ];

    /**
     * Get all of the comments for the DanhMucThangNam
     *
     * @return HasMany
     */
    public function dsTieuChiThang(): HasMany
    {
        return $this->hasMany(TieuChiTheoThang::class, 'id_thang_nam', 'id');
    }

    /**
     * Get all of the comments for the DanhMucThangNam
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diemThang(): HasMany
    {
        return $this->hasMany(DiemThang::class, 'id_thang_nam', 'id');
    }

    public function lichSuDiemThang(): HasMany
    {
        return $this->hasMany(LichSuDiemThang::class, 'id_thang_nam', 'id');
    }

}

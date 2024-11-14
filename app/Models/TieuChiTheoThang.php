<?php

namespace App\Models;

use App\Models\DanhMucThangNam;
use App\Models\DanhSachTieuChi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TieuChiTheoThang extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $table = 'nvxs___tieu_chi_theo_thangs';
    protected $primaryKey = ['id_thang_nam', 'id_tieu_chi'];

    public $fillable = ['id_thang_nam','id_tieu_chi'];
    public $timestamps = false;


    /**
     * Get the user that owns the TieuChiTheoThang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenTieuChi(): BelongsTo
    {
        return $this->belongsTo(DanhSachTieuChi::class, 'id_tieu_chi', 'id');
    }

    /**
     * Get the user that owns the TieuChiTheoThang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function danhMucThangNam(): BelongsTo
    {
        return $this->belongsTo(DanhMucThangNam::class, 'id_thang_nam', 'id');
    }

}

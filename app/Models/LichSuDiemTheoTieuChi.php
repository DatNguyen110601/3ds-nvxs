<?php

namespace App\Models;

use App\Models\DanhSachTieuChi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LichSuDiemTheoTieuChi extends Model
{
    use HasFactory;
    public $table = 'nvxs___lich_su_diem_theo_tieu_chis';
    public $fillable = ['id_tieu_chi','id_diem_nv_thang','diem','ly_do'];
    public $timestamps = false;


    public function tenTieuChi(): BelongsTo
    {
        return $this->belongsTo(DanhSachTieuChi::class, 'id_tieu_chi', 'id');
    }
}

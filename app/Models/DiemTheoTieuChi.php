<?php

namespace App\Models;

use App\Models\DanhSachTieuChi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiemTheoTieuChi extends Model
{
    use HasFactory;
    public $table = 'nvxs___diem_theo_tieu_chis';
    public $fillable = ['id_tieu_chi', 'id_nguoi_cham', 'id_diem_nv_thang', 'diem', 'duyet'];
    public $timestamps = false;



    /**
     * Get the user that owns the DiemTheoTieuChi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenTieuChi(): BelongsTo
    {
        return $this->belongsTo(DanhSachTieuChi::class, 'id_tieu_chi', 'id');
    }
    static protected function booted() {
        parent::booted();
        static::creating(function ($diemTheoTieuChi) {
            $diemTheoTieuChi->id_nguoi_cham = 1;
            $diemTheoTieuChi->diem = 0;
            $diemTheoTieuChi->duyet = false;

        });

    }
}

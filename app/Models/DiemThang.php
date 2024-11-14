<?php

namespace App\Models;

use App\Models\User;
use App\Models\NhanVien;
use App\Models\DanhMucThangNam;
use App\Models\DiemTheoTieuChi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiemThang extends Model
{
    use HasFactory;
    public $table = 'nvxs___diem_thangs';
    public $fillable = ['id_thang_nam', 'id_nhan_vien', 'tong_diem'];
    public $timestamps = false;

    /**
     * Get the user that owns the DiemThang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nhanVien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_nhan_vien', 'id');
    }

    /**
     * Get all of the comments for the DiemThang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diemTheoTieuChi(): HasMany
    {
        return $this->hasMany(DiemTheoTieuChi::class, 'id_diem_nv_thang', 'id');
    }

    /**
     * Get the user that owns the DiemThang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function danhMucThangNam(): BelongsTo
    {
        return $this->belongsTo(DanhMucThangNam::class, 'id_thang_nam', 'id');
    }



    static protected function booted() {
        parent::booted();
        static::creating(function ($diemThang) {
            $diemThang->tong_diem = 0;
        });

        static::updating(function ($diemThang) {
            $diemTheoTieuChi = $diemThang->diemTheoTieuChi;
            $tongDiem = 0;
            if(count($diemTheoTieuChi) != 0){
                foreach($diemTheoTieuChi as $diem){

                    $tongDiem += (float) $diem->diem * (float) $diem->tenTieuChi->he_so;
                }
            };
            $diemThang->tong_diem = $tongDiem;
            // $thue = (float) $gioHang->thue / 100;
            // $gioHang->tong_gia_tien = round($gioHang->tong_gia_san_pham * (1 + $thue));
        });
    }


}

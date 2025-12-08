<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ViTri extends Model
{
    use HasFactory;
    protected $table = 'tochuc___vi_tri';
    protected $fillable = [
        'ten_vi_tri',
        'id_vi_tri_quan_ly',
        'phong_ban',
        'id_phong_ban',
        'noi_lam_viec',
        'muc_dich',
        'id_user',
        'trang_thai',
        'stroke',
        'huong_dan_cong_viec',
    ];

    public const TT_KHOA = 1;
    public const TT_MO_KHOA = 0;

    protected static function booted()
    {
        static::creating(function ($viTri) {
            if ($viTri->id_user == 0) {
                $viTri->id_user = null;
            }
            // $viTri->save();
        });

        static::updating(function ($viTri) {
            if ($viTri->id_user == 0) {
                $viTri->id_user = null;
            }
            // $viTri->save();
        });
    }

    public function capQuanLy()
    {
        return $this->belongsTo(Vitri::class, 'id_vi_tri_quan_ly', 'id');
    }

    /**
     * Get the user that owns the ViTri
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function capDuoi()
    {
        return $this->hasMany(Vitri::class, 'id_vi_tri_quan_ly', 'id')->orderBy('stt_cap_bac');
    }

    public function phongBan(): BelongsTo
    {
        return $this->belongsTo(PhongBan::class, 'id_phong_ban');
    }
}

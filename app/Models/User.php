<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\ViTri;
use App\Models\PhongBan;
use App\Models\DiemThang;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    CONST EMPLOYEE = 1;
    CONST PUBLIC_USER = 2;

    CONST STATUS_ACTIVE = 1;
    CONST STATUS_BANNED = 0;

    CONST ID_USER_CO_QUYEN = [573];
    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diemThang(): HasMany
    {
        return $this->hasMany(DiemThang::class, 'id_nhan_vien', 'id');
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viTri(): HasMany
    {
        return $this->hasMany(ViTri::class, 'id_user', 'id');
    }



    //
    public function userThuocPhongBan()
    {
        return $this->belongsToMany(PhongBan::class,'tochuc___user_thuoc_phong_bans','id_user','id_phong_ban');
    }

    public function isViTri($viTriKiemTra)
    {
        $viTriUser = $this->viTri->first();
        $listIDCapDuoi = $this->listIdCapDuoi($viTriUser);
        return  $listIDCapDuoi;
    }

    public function dsViTri($viTriKiemTra)
    {
        $viTriUser = $this->viTri->first();
        // Danh sách có cả chính nó
        $listIDCapDuoi = $this->listIdCapDuoi($viTriUser);
        // Loại bỏ chính vị trí user
        $listIDCapDuoi = array_values(array_filter($listIDCapDuoi, fn($id) => $id != $viTriUser->id));
        // Nếu sau khi loại mà trống -> trả về rỗng
        if (empty($listIDCapDuoi)) {
            return [];
        }

        return $listIDCapDuoi;
    }

    // public function dsViTri($viTriKiemTra)
    //     {
    //         $viTriUser = $this->viTri->first();
    //         // dd($viTriUser);
    //         $listIDCapDuoi = $this->listIdCapDuoi($viTriUser);
    //         return $listIDCapDuoi;
    //     }


    public function isCapTren($viTriKiemTra)
    {
        $viTriUser = $this->viTri;
        $listIDCapDuoi = $this->listIdCapDuoi($viTriUser);
        unset($listIDCapDuoi[0]);
        return in_array($viTriKiemTra->id, $listIDCapDuoi);

    }

    public function listIdCapDuoi($viTri)
    {
        $listID = [$viTri->id];
        if($viTri->capDuoi->isNotEmpty()){
            foreach ($viTri->capDuoi as $capDuoi) {
                // Gọi đệ quy để lấy danh sách ID cấp dưới của viTri
                $listID = array_merge($listID, $this->listIdCapDuoi($capDuoi));

            }
        }

       return $listID;
    }



    public function quyenHr()
{
    return in_array($this->id, self::ID_USER_CO_QUYEN);
}
}

<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhongBan extends Model
{
    use HasFactory;
    protected $table = "tochuc___phong_ban";
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'stt'
    ];

    public function userThuocPhongBan()
    {
        return $this->belongsToMany(User::class,'tochuc___user_thuoc_phong_bans','id_phong_ban','id_user');
    }
}

<?php

// namespace App\Models;

// use App\Models\User;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

// class NhanVien extends Model
// {
//     use HasFactory;
//     public $table= 'users';
//     public $timestamps = false;
//     public $fillable = [
//         'user_id', 'ho_ten'
//     ];

//     /**
//      * Get the user that owns the NhanVien
//      *
//      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//      */
//     public function user(): BelongsTo
//     {
//         return $this->belongsTo(User::class, 'user_id', 'id');
//     }
// }

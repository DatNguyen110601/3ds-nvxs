<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSlack extends Model
{
    use HasFactory;
    public $table = 'nvxs___test_slacks';
    public $fillable = ['ho_ten','email', 'ngay_sinh', 'so_dien_thoai', 'json_data'];
    
}

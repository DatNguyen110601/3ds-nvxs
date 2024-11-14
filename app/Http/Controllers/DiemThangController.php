<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DiemThang;
use Illuminate\Http\Request;

class DiemThangController extends Controller
{

    public function index(){
        return view('diem-thang.index');
    }

    public function show(DiemThang $diemThang, User $nhanVien){
        $danhMucThangNam = $diemThang->danhMucThangNam;

        return view('diem-thang.show',['danhMucThangNam' => $danhMucThangNam,
                                        'nhanVien' => $nhanVien,
                                        'diemThang' => $diemThang
                                    ]);
    }
}

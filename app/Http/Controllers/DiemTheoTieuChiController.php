<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\DiemThang;
use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;
use App\Traits\DiemThangTraits;

class DiemTheoTieuChiController extends Controller
{
    use DiemThangTraits;
    //
    public function index(){
        $dsNhanVien = NhanVien::all();
        return view('diem-theo-tieu-chi.index', ['dsNhanVien' => $dsNhanVien]);
    }

    public function create(DanhMucThangNam $danhMucThangNam, NhanVien $nhanVien, DiemThang $diemThang){

        $tieuChiTheoThang = $danhMucThangNam->dsTieuChiThang;

        return view('diem-theo-tieu-chi.create', ['danhMucThangNam' => $danhMucThangNam,
                                                'nhanVien' =>$nhanVien,
                                                'diemThang' =>$diemThang,
                                                'tieuChiTheoThang' => $tieuChiTheoThang]);
    }
    public function store(Request $request, DanhMucThangNam $danhMucThangNam, NhanVien $nhanVien, DiemThang $diemThang){
        // dd($diemThang);
        $inputs = $request->input('inputs');
        // dd($inputs);
        $diemTheoTieuChi = $diemThang->diemTheoTieuChi;
        // dd($diemTheoTieuChi);
        foreach($inputs as $key => $value){
            $timDiemThang = $diemTheoTieuChi->where('id_tieu_chi', $key)->first();
            $timDiemThang->update([
                'diem' => $value,
            ]);
        }

        $this->tinhTongDiem($diemThang);

        return redirect()->route('danh-muc-thang-nam.show',[
            'danhMucThangNam' => $danhMucThangNam,
            'diemThang' => $diemThang,

         ])->with('status', "Chấm điểm nhân viên {$nhanVien->ho_ten} thành công!");
    }
}

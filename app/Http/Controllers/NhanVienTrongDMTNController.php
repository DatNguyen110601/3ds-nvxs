<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DiemThang;
use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;
use App\Traits\DiemThangTraits;

class NhanVienTrongDMTNController extends Controller
{
    use DiemThangTraits;

    // thêm nhân viên

    public function create(DanhMucThangNam $danhMucThangNam){

        $dsTieuChi = $danhMucThangNam->dsTieuChiThang;
        // dd($dsTieuChi);
        $diemThang = $danhMucThangNam->diemThang;

        // Lấy danh sách id_nhan_vien từ diemThang
        $idNhanVienDaCo = $diemThang->pluck('id_nhan_vien')->toArray();

        // Lấy danh sách nhân viên mà không có trong $idNhanVienDaCo
        $dsNhanVien = User::where('status', User::STATUS_ACTIVE)->where('type', User::EMPLOYEE)
                        ->whereNotIn('id', $idNhanVienDaCo)
                        ->get();


        return view('nhan-vien-trong-dmtn.create',[
            'danhMucThangNam' => $danhMucThangNam,
            'dsTieuChi' =>$dsTieuChi,
            'dsNhanVien' => $dsNhanVien,
            'diemThang' => $diemThang
        ]);
    }

    public function store(Request $request,DanhMucThangNam $danhMucThangNam){
        $validated = $request->validate([
            'id_thang_nam' => 'required',
            'check_tieu_chi' => 'required|array',
            'nhan-vien' => 'required|array'
        ]);

        //Điểm tháng
        if($request['nhan-vien']){
            $jobNhanVien = $this->themDiemThang($validated['nhan-vien'], $validated['id_thang_nam'],$validated['check_tieu_chi']);
            $diemThang = $danhMucThangNam->diemThang;
            return redirect()->route('danh-muc-thang-nam.show', [
                                    'danhMucThangNam' => $danhMucThangNam,
                                    'diemThang' => $diemThang,

                                    ])->with('status', 'Thêm nhân viên thành công!');
        }

    }

    public function destroy(DanhMucThangNam $danhMucThangNam, DiemThang $diemThang){
        // dd($diemThang->diemTheoTieuChi);
        foreach($diemThang->diemTheoTieuChi as $diemTieuChi){
            $diemTieuChi->delete();
        };
        $diemThang->delete();

        $dsDiemThang = $danhMucThangNam->diemThang;
        return redirect()->route('danh-muc-thang-nam.show', [
            'danhMucThangNam' => $danhMucThangNam,
            'diemThang' => $dsDiemThang,

            ])->with('status', 'Xoá nhân viên thành công!');

    }
}

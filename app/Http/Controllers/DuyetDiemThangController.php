<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DanhMucThangNamExport;

class DuyetDiemThangController extends Controller
{
    public function duyetDiemThangAll(DanhMucThangNam $danhMucThangNam){
        $diemThang = $danhMucThangNam->diemThang;
        // dd($diemThang);
        foreach($diemThang as $diem){
            foreach($diem->diemTheoTieuChi as $tieuChi){
                $tieuChi->update(['duyet' => true]);

            }
        }
        return redirect()->route('danh-muc-thang-nam.show', ['danhMucThangNam' => $danhMucThangNam])
                                            ->with('status', 'Duyệt thành công!');
    }

    public function duyetDiemThang(DanhMucThangNam $danhMucThangNam, User $nhanVien){
        $diemThang = $danhMucThangNam->diemThang->where('id_nhan_vien', $nhanVien->id)->first();
        // dd($diemThang);
        foreach($diemThang->diemTheoTieuChi as $tieuChi){

            $tieuChi->update(['duyet' => true]);
        }
        return redirect()->route('danh-muc-thang-nam.show', ['danhMucThangNam' => $danhMucThangNam])
                                            ->with('status', "Duyệt điểm {$diemThang->nhanVien->name} thành công!");
    }

    public function removeDuyetDiemThang(DanhMucThangNam $danhMucThangNam, User $nhanVien){
        $diemThang = $danhMucThangNam->diemThang->where('id_nhan_vien', $nhanVien->id)->first();
        // dd($diemThang);
        foreach($diemThang->diemTheoTieuChi as $tieuChi){

            $tieuChi->update(['duyet' => false]);
        }
        return redirect()->route('danh-muc-thang-nam.show', ['danhMucThangNam' => $danhMucThangNam])
                                            ->with('status', "Hủy duyệt điểm {$diemThang->nhanVien->name} thành công!");
    }
}

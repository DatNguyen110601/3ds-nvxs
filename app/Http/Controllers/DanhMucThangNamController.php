<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NhanVien;
use App\Models\DiemThang;
use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DanhMucThangNamExport;

class DanhMucThangNamController extends Controller
{
    public function index(){
        $danhMucThangNam = DanhMucThangNam::all();
        return view('danh-muc-thang-nam.index', ['danhMucThangNam'=> $danhMucThangNam]);
    }

    public function create(){
        return view('danh-muc-thang-nam.create');

    }

    public function store(Request $request){


        $validated = $request->validate([
            'thang' => 'required',
            'nam' => 'required',
        ]);
        DanhMucThangNam::create($validated);
        return redirect()->route('danh-muc-thang-nam.index')->with('status', 'Thêm thành công!');

    }

    public function edit(DanhMucThangNam $danhMucThangNam){

        return view('danh-muc-thang-nam.edit', ['danhMucThangNam'=> $danhMucThangNam]);

    }

    public function update(Request $request, DanhMucThangNam $danhMucThangNam){

        $validated = $request->validate([
            'thang' => 'required',
            'nam' => 'required',
        ]);
        $danhMucThangNam->update($validated);

        return redirect()->route('danh-muc-thang-nam.index')->with('status', 'Sửa thành công!');

    }


    public function show(DanhMucThangNam $danhMucThangNam){
        $diemThang = $danhMucThangNam->diemThang;

        return view('danh-muc-thang-nam.show', [
            'danhMucThangNam' => $danhMucThangNam,
            'diemThang' => $diemThang,

         ]);

    }

    public function destroy(DanhMucThangNam $danhMucThangNam){
        if(count($danhMucThangNam->diemThang)==0){
            $danhMucThangNam->delete();
            return redirect()->route('danh-muc-thang-nam.index')->with('status', 'Xóa thành công!');

        }else{
            return redirect()->route('danh-muc-thang-nam.index')->with('error', 'Xóa thất bại!');
        };

    }


    //xem chi tiết điểm nhân viên theo tháng

    public function xemDiemNhanVienThang(DanhMucThangNam $danhMucThangNam, User $nhanVien){

        $diemThangs = $danhMucThangNam->diemThang;
        $diemThang = $diemThangs->where('id_nhan_vien', $nhanVien->id)->first();

        return view('danh-muc-thang-nam.nhan-vien-thang', ['danhMucThangNam' => $danhMucThangNam,
                                                            'nhanVien' => $nhanVien,
                                                            'diemThang' => $diemThang
                                                        ]);
    }

    //xuất file excel

    public function exportExcel(DanhMucThangNam $danhMucThangNam){
        return Excel::download(new DanhMucThangNamExport($danhMucThangNam), "nvxs_thang{$danhMucThangNam->thang}_nam{$danhMucThangNam->nam}.xlsx");

    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhSachTieuChi;

class DanhSachTieuChiController extends Controller
{
    //
    public function index(){
        $dsTieuChi = DanhSachTieuChi::all();
        return view('tieu-chi-nhan-vien.index',['dsTieuChi' => $dsTieuChi]);
    }

    public function create(){
        return view('tieu-chi-nhan-vien.create');
    }

    public function __validate($request){
        $validated = $request->validate([
            "ten_tieu_chi" => 'required',
            "diem_toi_da" => 'required',
            "diem_toi_thieu" => 'required',
            "he_so" => 'required',
            "trang_thai" => 'nullable',
            "mo_ta" => 'nullable'
        ],[
            "ten_tieu_chi" => 'Nhập tên tiêu chí',
            "diem_toi_da" => 'Nhập điểm tối đa',
            "diem_toi_thieu" => 'Nhập điểm tối thiểu',
            "he_so" => 'Nhập hệ số',
        ]);
        return $validated;
    }

    public function store(Request $request){

        $validated = $this->__validate($request);

        $createTieuChi = DanhSachTieuChi::create($validated);
        if($createTieuChi){
            return redirect()->route('tieu-chi-nhan-vien.index')->with('status', 'Thêm tiêu chí thành công!');
        }
        else{
            return redirect()->route('tieu-chi-nhan-vien.index')->with('error', 'Thêm tiêu chí thất bại!');
        }
    }

    public function edit( DanhSachTieuChi $danhSachTieuChi){
        // dd($danhSachTieuChi);
        return view('tieu-chi-nhan-vien.edit', ['danhSachTieuChi' => $danhSachTieuChi]);
    }

    public function update(Request $request, DanhSachTieuChi $danhSachTieuChi){

        $validated = $this->__validate($request);

        $danhSachTieuChi->update($validated);
        return redirect()->route('tieu-chi-nhan-vien.index')->with('status', 'Sửa tiêu chí thành công!');
    }

    public function destroy(DanhSachTieuChi $danhSachTieuChi){
        $dsTieuChi = DanhSachTieuChi::all();
        $diemTheoTieuChi = $danhSachTieuChi->diemTheoTieuChi;
        if(count($diemTheoTieuChi) == 0){

            $danhSachTieuChi->delete();
            return redirect()->route('tieu-chi-nhan-vien.index',['dsTieuChi' => $dsTieuChi])
                            ->with('status', 'Xóa tiêu chí thành công!');
        }
        else{
            return redirect()->route('tieu-chi-nhan-vien.index',['dsTieuChi' => $dsTieuChi])
                            ->with('error', 'Xóa thất bại! tiêu chí đã được áp dụng!');
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NhanVien;
use App\Models\DiemThang;
use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;
use App\Traits\DiemThangTraits;

class ChamDiemNhanVienController extends Controller
{
    use DiemThangTraits;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(DanhMucThangNam $danhMucThangNam, User $nhanVien){
        $diemThang = $danhMucThangNam->diemThang->where('id_nhan_vien' , $nhanVien->id)->first();
        $diemTheoTieuChi = $diemThang->diemTheoTieuChi;

        $tieuChiTheoThang = $danhMucThangNam->dsTieuChiThang;

        return view('cham-diem-nhan-vien.create', ['danhMucThangNam' => $danhMucThangNam,
                                                'nhanVien' =>$nhanVien,
                                                'diemThang' => $diemThang,
                                                'diemTheoTieuChi' => $diemTheoTieuChi]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DanhMucThangNam $danhMucThangNam, User $nhanVien, DiemThang $diemThang){
        // dd($diemThang);
        // dd($request->all());
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

         ])->with('status', "Chấm điểm nhân viên {$nhanVien->name} thành công!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DanhMucThangNam $danhMucThangNam, User $nhanVien)
    {
        $diemThang = $danhMucThangNam->diemThang->where('id_nhan_vien' , $nhanVien->id)->first();
        $diemTheoTieuChi = $diemThang->diemTheoTieuChi;

        $tieuChiTheoThang = $danhMucThangNam->dsTieuChiThang;

        return view('cham-diem-nhan-vien.edit', ['danhMucThangNam' => $danhMucThangNam,
                                                'nhanVien' =>$nhanVien,
                                                'diemThang' => $diemThang,
                                                'diemTheoTieuChi' => $diemTheoTieuChi]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DanhMucThangNam $danhMucThangNam, User $nhanVien, DiemThang $diemThang)
    {
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

         ])->with('status', "Sửa điểm nhân viên {$nhanVien->ho_ten} thành công!");
    }

    /**
     * Remove the specified resource from storage.
     */

}

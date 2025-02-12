<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NhanVien;
use App\Models\DiemThang;
use Illuminate\Http\Request;
use App\Models\LichSuChamDiem;
use App\Models\DanhMucThangNam;
use App\Models\LichSuDiemThang;
use App\Traits\DiemThangTraits;
use Illuminate\Support\Facades\Auth;
use App\Models\LichSuDiemTheoTieuChi;

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
        // dd($diemThang);
        $user = Auth::user();

        $inputs = $request->input('inputs');

        $diemTheoTieuChi = $diemThang->diemTheoTieuChi;
        // dd($diemTheoTieuChi);
        foreach($inputs as $key => $value){
            $timDiemThang = $diemTheoTieuChi->where('id_tieu_chi', $key)->first();
            $timDiemThang->update([
                'diem' => $value,
            ]);
        }

        $tongDiem = $this->tinhTongDiem($diemThang);


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

        // $diemThang = $danhMucThangNam->diemThang->where('id_nhan_vien' , $nhanVien->id)->first();
        // $diemTheoTieuChi = $diemThang->diemTheoTieuChi;

        // $tieuChiTheoThang = $danhMucThangNam->dsTieuChiThang;

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

        $lichSu = $danhMucThangNam->lichSuDiemThang;

        if ($lichSu->count() > 2) {
            // Lấy 2 bản ghi mới nhất
            $toKeep = $lichSu->sortByDesc('created_at')->take(2)->pluck('id');

            // Xóa tất cả trừ 2 bản ghi mới nhất
            $danhMucThangNam->lichSuDiemThang()
                ->whereNotIn('id', $toKeep)
                ->delete();
        }
        $user = Auth::user();

        $inputs = $request->input('inputs');
        $inputsLyDo = $request->input('input-ly-do');
        // dd($inputs);

        // dd($inputsLyDo["1"]);
        $diemTheoTieuChi = $diemThang->diemTheoTieuChi;
        // dd($diemTheoTieuChi);
        foreach($inputs as $key => $value){

            if($value != null){
                $timDiemThang = $diemTheoTieuChi->where('id_tieu_chi', $key)->first();
                $timDiemThang->update([
                    'diem' => $value,
                ]);
            }

        }

        $tongDiem =$this->tinhTongDiem($diemThang);

        // lịch sử
        if($tongDiem){

            $lichSuDiemThang = LichSuDiemThang::create([
                'id_thang_nam' =>$diemThang->id_thang_nam,
                'id_nhan_vien' => $nhanVien->id,
                'id_nguoi_cham' => $user->id,
                'tong_diem' => $tongDiem
            ]);

            if($lichSuDiemThang){
                foreach($diemTheoTieuChi as $diem){
                    $lichSuDiemTheoTieuChi = LichSuDiemTheoTieuChi::create([
                        'id_tieu_chi'=> $diem->id_tieu_chi,
                        'id_diem_nv_thang'=> $lichSuDiemThang->id,
                        'diem'=> $diem->diem,
                        'ly_do'=> $inputsLyDo[$diem->id_tieu_chi]
                    ]);
                }
            }
        }

        return redirect()->route('danh-muc-thang-nam.show',[
            'danhMucThangNam' => $danhMucThangNam,
            'diemThang' => $diemThang,

         ])->with('status', "Sửa điểm nhân viên {$nhanVien->ho_ten} thành công!");
    }

    /**
     * Remove the specified resource from storage.
     */

}

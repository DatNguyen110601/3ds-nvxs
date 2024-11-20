<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ViTri;
use App\Models\NhanVien;
use App\Models\DiemThang;
// use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;
use App\Models\DanhSachTieuChi;
use App\Traits\DiemThangTraits;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DanhMucThangNamExport;

class DanhMucThangNamController extends Controller
{
    use DiemThangTraits;


    public function home(Request $request){
        $nam = $request->input('year', date('Y'));
        $thang = $request->input('month', date('n'));

        $danhMucThangNam = DanhMucThangNam::where('nam', $nam)->where('thang', $thang)->first();
        $diemThang = null;
        if($danhMucThangNam){
            $diemThang = $danhMucThangNam->diemThang;
        }




        return view('danh-muc-thang-nam.home', [
            'danhMucThangNam' => $danhMucThangNam,
            'diemThang' => $diemThang,
            'nam' => $nam,
            'thang' => $thang

         ]);
    }

    public function index(){
        $danhMucThangNam = DanhMucThangNam::all();
        return view('danh-muc-thang-nam.index', ['danhMucThangNam'=> $danhMucThangNam]);
    }

    public function create(){
        return view('danh-muc-thang-nam.create');

    }

    public function store(Request $request){

        $validated = $request->validate([
            'nam' => 'required',
        ]);

        $danhMucThangNam = DanhMucThangNam::where('nam', $validated['nam'])->first();
        if(!$danhMucThangNam){
            foreach(range(1, 12) as $thang){
                DanhMucThangNam::create([
                    'nam' => $validated['nam'],
                    'thang' => $thang
                ]

                );
            };
            return redirect()->route('danh-muc-thang-nam.index')->with('status', 'Thêm thành công!');
        }
        return redirect()->route('danh-muc-thang-nam.index')->with('error', 'Thêm thất bại! Danh mục năm đã được tạo trước đó!');

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

        return Excel::download(new DanhMucThangNamExport($danhMucThangNam->id), "nvxs_thang{$danhMucThangNam->thang}_nam{$danhMucThangNam->nam}.xlsx");

    }

    // public function exportExcel(DanhMucThangNam $danhMucThangNam){
    //     $idDanhMucThangNam = $danhMucThangNam->id;
    //     // Truy vấn dữ liệu từ cơ sở dữ liệu
    //     $data = DB::table('users')
    //         ->join('nvxs___diem_thangs', 'users.id', '=', 'nvxs___diem_thangs.id_nhan_vien')
    //         ->join('nvxs___diem_theo_tieu_chis', 'nvxs___diem_thangs.id', '=', 'nvxs___diem_theo_tieu_chis.id_diem_nv_thang')
    //         ->join('nvxs___tieu_chi_theo_thangs', 'nvxs___diem_theo_tieu_chis.id_tieu_chi', '=', 'nvxs___tieu_chi_theo_thangs.id_tieu_chi')
    //         ->join('nvxs___danh_muc_thang_nams', 'nvxs___tieu_chi_theo_thangs.id_thang_nam', '=', 'nvxs___danh_muc_thang_nams.id')
    //         ->where('nvxs___danh_muc_thang_nams.id', $idDanhMucThangNam)
    //         ->select(
    //             'users.name',
    //             'nvxs___tieu_chi_theo_thangs.id_tieu_chi',
    //             'nvxs___diem_theo_tieu_chis.diem',
    //             'nvxs___diem_thangs.tong_diem'
    //         )
    //         ->get();

    //     // Định dạng dữ liệu để xuất Excel
    //     $excelData = [];
    //     $stt = 1;
    //     foreach ($data as $row) {
    //         $excelData[] = [
    //             'STT' => $stt++,
    //             'Tên nhân viên' => $row->name,
    //             'Tiêu chí ' . $row->id_tieu_chi => $row->diem,
    //             'Tổng điểm' => $row->tong_diem,
    //         ];
    //     }

    //     // Xuất file Excel
    //     return \Maatwebsite\Excel\Excel::create('Diem_Thang_Nam', function ($excel) use ($excelData) {
    //         $excel->sheet('Sheet1', function ($sheet) use ($excelData) {
    //             $sheet->fromArray($excelData);
    //         });
    //     })->download('xlsx');
    // }


}

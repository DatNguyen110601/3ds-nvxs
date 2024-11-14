<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NhanVien;
use App\Jobs\DiemThangJob;
use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;
use App\Models\DanhSachTieuChi;
use App\Traits\DiemThangTraits;
use App\Jobs\DiemTheoTieuChiJob;
use App\Models\TieuChiTheoThang;

class TieuChiTheoThangController extends Controller
{
    use DiemThangTraits;
    //
    public function index(){

        $danhMucThangNam = DanhMucThangNam::all();

        return view('tieu-chi-theo-thang.index',
            ['danhMucThangNam'=> $danhMucThangNam,
            // 'dsTieuChiTheoThang' => $dsTieuChiTheoThang
            ]);
    }
    public function show(DanhMucThangNam $danhMucThangNam){
        // dd($danhMucThangNam);
        $tieuChiTheoThang = $danhMucThangNam->dsTieuChiThang;

        return view('tieu-chi-theo-thang.show', ['danhMucThangNam' =>$danhMucThangNam,
                                                'tieuChiTheoThang' =>$tieuChiTheoThang]);
    }

    public function create(Request $request){
        $danhMucThangNam = DanhMucThangNam::all();
        $dsTieuChi = DanhSachTieuChi::all();
        $dsNhanVien = User::all();
        return view('tieu-chi-theo-thang.create',['danhMucThangNam' => $danhMucThangNam,
                                                    'dsTieuChi' => $dsTieuChi,
                                                    'dsNhanVien' => $dsNhanVien
    ]);
    }

    public function store(Request $request){

        $validated = $request->validate([
            'id_thang_nam' => 'required',
            'check_tieu_chi' => 'required|array'
        ]);
        foreach($validated['check_tieu_chi'] as $tieuChi){
            $tieuChiTheoThang = TieuChiTheoThang::where('id_thang_nam', $validated['id_thang_nam'])
                                                ->where('id_tieu_chi', $tieuChi)->first();

            if($tieuChiTheoThang == null){
                $createTieuChiTheoThang = TieuChiTheoThang::create([
                    'id_thang_nam' => $validated['id_thang_nam'],
                    'id_tieu_chi' => $tieuChi
                ]);
            }
        }
        //Điểm tháng
        if(!empty($request->tat_ca_nhan_vien)){
            // $arrayNhanVien = [];
            $arrayNhanVien = User::pluck('id')->toArray();

            $jobNhanVien = $this->themDiemThang($arrayNhanVien, $validated['id_thang_nam'], $validated['check_tieu_chi']);

        }else{

            $jobNhanVien = $this->themDiemThang($request['nhan-vien'], $validated['id_thang_nam'],$validated['check_tieu_chi']);

        };


        // foreach($validated['check_tieu_chi'] as $tieuChi){
        //     $tieuChiTheoThang = TieuChiTheoThang::where('id_thang_nam', $validated['id_thang_nam'])
        //                                         ->where('id_tieu_chi', $tieuChi)->first();

        //     if($tieuChiTheoThang == null){
        //         $createTieuChiTheoThang = TieuChiTheoThang::create([
        //             'id_thang_nam' => $validated['id_thang_nam'],
        //             'id_tieu_chi' => $tieuChi
        //         ]);

        //         if($createTieuChiTheoThang){
        //             if(!empty($request->tat_ca_nhan_vien)){
        //                 // $arrayNhanVien = [];
        //                 $arrayNhanVien = User::pluck('id')->toArray();

        //                 $jobNhanVien = $this->themDiemThang($arrayNhanVien, $createTieuChiTheoThang->id_thang_nam, $tieuChi);

        //             }else{

        //                 $jobNhanVien = $this->themDiemThang($request['nhan-vien'], $createTieuChiTheoThang->id_thang_nam, $tieuChi);

        //             };
        //         }
        //     }


        // };

        return redirect()->route('tieu-chi-theo-thang.index')
                        ->with('status', "Thêm tiêu chí {$createTieuChiTheoThang->thang}");

    }



    public function edit(DanhMucThangNam $danhMucThangNam){
        $dsTieuChiThang = $danhMucThangNam->dsTieuChiThang;
        $diemThang = $danhMucThangNam->diemThang;

        $dsTieuChi = DanhSachTieuChi::all();
        $dsNhanVien = User::all();
        return view('tieu-chi-theo-thang.edit',['danhMucThangNam' => $danhMucThangNam,
                                                    'dsTieuChi' => $dsTieuChi,
                                                    'dsNhanVien' => $dsNhanVien,
                                                    'dsTieuChiThang' => $dsTieuChiThang,
                                                    'diemThang' => $diemThang

        ]);
    }

    public function update(Request $request, DanhMucThangNam $danhMucThangNam){

        $validated = $request->validate([
            'id_thang_nam' => 'required',
            'check_tieu_chi' => 'required|array'
        ]);
        foreach($danhMucThangNam->dsTieuChiThang as $tieuChiThang){

            $deleteTieuChi = $tieuChiThang->delete();
        }
        dd($tieuChiThang);
        foreach($validated['check_tieu_chi'] as $tieuChi){
            $tieuChiTheoThang = TieuChiTheoThang::where('id_thang_nam', $validated['id_thang_nam'])
                                                ->where('id_tieu_chi', $tieuChi)->first();

            if($tieuChiTheoThang == null){
                $createTieuChiTheoThang = TieuChiTheoThang::create([
                    'id_thang_nam' => $validated['id_thang_nam'],
                    'id_tieu_chi' => $tieuChi
                ]);
            }
        }
        //Điểm tháng
        if(!empty($request->tat_ca_nhan_vien)){
            // $arrayNhanVien = [];
            $arrayNhanVien = User::pluck('id')->toArray();

            $jobNhanVien = $this->themDiemThang($arrayNhanVien, $validated['id_thang_nam'], $validated['check_tieu_chi']);

        }else{

            $jobNhanVien = $this->themDiemThang($request['nhan-vien'], $validated['id_thang_nam'],$validated['check_tieu_chi']);

        };
        return redirect()->route('tieu-chi-theo-thang.index')
                        ->with('status', "Sửa tiêu chí {$createTieuChiTheoThang->thang}");
    }


    public function destroy($id_thang_nam, $id_tieu_chi){
         // Find the `TieuChi` entry based on both `id_thang_nam` and `id_tieu_chi`.
    $tieuChi = TieuChiTheoThang::where('id_thang_nam', $id_thang_nam)
        ->where('id_tieu_chi', $id_tieu_chi);
        // dd($tieuChi->first()->id_tieu_chi);
    if ($tieuChi) {
        $danhMucThangNam = $tieuChi->first()->danhMucThangNam;
        $diemThang = $danhMucThangNam->diemThang;

        $idTieuChi = $tieuChi->first()->id_tieu_chi;

        foreach($diemThang as $diem){
            //lọc bảng DiemTheoTieuChi
            foreach($diem->diemTheoTieuChi as $diemTheoTieuChi){
                //so sánh id_tieu_chi bảng DiemTheoTieuChi với TieuChiTheoThang

                if($diemTheoTieuChi->id_tieu_chi == $idTieuChi){
                    $diemTheoTieuChi->delete();
                }
            }
        }
        $tieuChi->delete();


        return back()->with('status', 'Xóa tiêu chí thành công!');
    }
    return back()->with('error', 'Xóa tiêu chí thất bại!');
    }


    public function themTieuChiThang(DanhMucThangNam $danhMucThangNam){
        $dsTieuChi = DanhSachTieuChi::all();
        $dsTieuChiThang = $danhMucThangNam->dsTieuChiThang->pluck('id_tieu_chi');

        $filteredTieuChi = $dsTieuChi->whereNotIn('id', $dsTieuChiThang);

        // dd($filteredTieuChi);
        // dd($danhMucThangNam->dsTieuChiThang);
        $dsTieuChi = DanhSachTieuChi::all();
        $dsNhanVien = User::all();
        return view('tieu-chi-theo-thang.them-tieu-chi-thang', ['danhMucThangNam' => $danhMucThangNam,
                                                                'filteredTieuChi' => $filteredTieuChi,
                                                                'dsNhanVien' => $dsNhanVien
                                                        ]);
    }

    public function suaTieuChiThang(DanhMucThangNam $danhMucThangNam, $id_thang_nam, $id_tieu_chi){


        $tieuChiTheoThang = TieuChiTheoThang::where('id_thang_nam', $id_thang_nam)
                                            ->where('id_tieu_chi', $id_tieu_chi)->first();

        $dsNhanVien = User::all();
        $diemThang = $danhMucThangNam->diemThang;
        // dd($tieuChiTheoThang);
        return view('tieu-chi-theo-thang.sua-tieu-chi-thang', ['danhMucThangNam' => $danhMucThangNam,
                                                                'tieuChiTheoThang' => $tieuChiTheoThang,
                                                                'dsNhanVien' => $dsNhanVien,
                                                                'diemThang' =>$diemThang
                                                        ]);

    }

    public function updateTieuChiThang(Request $request ,DanhMucThangNam $danhMucThangNam, $id_thang_nam, $id_tieu_chi){

        $validated = $request->validate([
            'id_thang_nam' => 'required',
            'check_tieu_chi' => 'required|array'
        ]);
        // dd($request->check_tieu_chi);
        $diemThang= $danhMucThangNam->diemThang;
        foreach($diemThang as $diem){
            $diemTheoTieuChi = $diem->diemTheoTieuChi->where('id_tieu_chi', $id_tieu_chi)->first();
            if ($diemTheoTieuChi !== null) {
                $diemTheoTieuChi->delete();
            }

        }

        if(!empty($request->tat_ca_nhan_vien)){
            // $arrayNhanVien = [];
            $arrayNhanVien = User::pluck('id')->toArray();

            $jobNhanVien = $this->themDiemThang($arrayNhanVien, $validated['id_thang_nam'], $validated['check_tieu_chi']);

        }else{

            $jobNhanVien = $this->themDiemThang($request['nhan-vien'], $validated['id_thang_nam'],$validated['check_tieu_chi']);

        };

        return redirect()->route('tieu-chi-theo-thang.show', ['danhMucThangNam'=>$danhMucThangNam])
                        ->with('status', "Cập nhật tiêu chí thành công!");

    }

}

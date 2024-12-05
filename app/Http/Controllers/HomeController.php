<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DiemThang;
use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    // public function __invoke(Request $request)
    // {

    //     $nam = $request->input('year', date('Y'));
    //     $thang = $request->input('month', date('n'));


    //     if($nam == null && $thang == null){
    //         $danhMucThangNam = DanhMucThangNam::all();

    //             return view('danh-muc-thang-nam.home', [
    //                 'danhMucThangNam' => $danhMucThangNam,
    //                 'nam' => $nam,
    //                 'thang' => $thang
    //             ]);

    //     }
    //     elseif($nam !=null && $thang == null){

    //         $danhMucThangNam = DanhMucThangNam::where('nam', $nam)->get();
    //         // dd($danhMucThangNam);
    //             return view('danh-muc-thang-nam.home', [
    //                 'danhMucThangNam' => $danhMucThangNam,
    //                 'nam' => $nam,
    //                 'thang' => $thang
    //             ]);

    //     }
    //     elseif($nam == null && $thang !=null){

    //         $danhMucThangNam = DanhMucThangNam::where('thang', $thang)->get();

    //             return view('danh-muc-thang-nam.home', [
    //                 'danhMucThangNam' => $danhMucThangNam,
    //                 'nam' => $nam,
    //                 'thang' => $thang
    //             ]);

    //     }
    //     else{
    //         $danhMucThangNam = DanhMucThangNam::where('nam', $nam)->where('thang', $thang)->get();

    //         return view('danh-muc-thang-nam.home', [
    //             'danhMucThangNam' => $danhMucThangNam,
    //             'nam' => $nam,
    //             'thang' => $thang
    //             ]);
    //     }

    // }

    public function __invoke(Request $request)
    {

        $nam = $request->input('year', date('Y'));
        $thang = $request->input('month', date('n'));
        $idNhanVien = $request->input('id_nhan_vien');
        $idNhanVien = $idNhanVien == "0" ? null : $idNhanVien;
        $danhMucThangNam = DanhMucThangNam::all();
        // $nam = 2024;
        // $thang = null;
        // $idNhanVien = "1";
        // $query = DiemThang::with(['danhMucThangNam', 'nhanVien']);
        // ->where('id_nhan_vien', $idNhanVien);
        if($idNhanVien == null){
            $query = DiemThang::with(['danhMucThangNam', 'nhanVien']);
        }
        else{
            $query = DiemThang::with(['danhMucThangNam', 'nhanVien'])
            ->where('id_nhan_vien', $idNhanVien);

        }


        // Xử lý các trường hợp
        if ($nam == null && $thang == null) {
            // Không lọc theo năm và tháng
            $data = $query->get();

        } elseif ($nam != null && $thang == null) {
            // Lọc theo năm nhưng không theo tháng
            $query->whereRelation('danhMucThangNam', function ($q) use ($nam) {
                $q->where('nam', $nam);
            });
            $data = $query->get();
        } elseif ($nam == null && $thang != null) {
            // Lọc theo tháng nhưng không theo năm
            $query->whereRelation('danhMucThangNam', function ($q) use ($thang) {
                $q->where('thang', $thang);
            });
            $data = $query->get();
        } else {
            // Lọc theo cả năm và tháng
            $query->whereRelation('danhMucThangNam', function ($q) use ($nam, $thang) {
                $q->where('nam', $nam)->where('thang', $thang);
            });
            $data = $query->get();
        }


        $data = $data->groupBy(function ($diemThang) {
            return $diemThang->danhMucThangNam->id;
        });

        // Lọc lại cấu trúc nếu cần thêm các thuộc tính
        $data = $data->map(function ($diemThangs, $idDanhMucThangNam) {
            return [
                'idDanhMucThangNam' => $idDanhMucThangNam,
                'diemThangs' => $diemThangs->map(function ($diemThang) {
                    return [
                        'diemThang' => $diemThang
                    ];
                }),
            ];
        });


        // foreach($data as $dt){

        //     foreach($dt['diemThangs'] as $key => $diemT){

        //         dd($diemT);
        //     }

        // }

        // Kiểm tra dữ liệu
        // dd($data->get());


        // Định dạng dữ liệu
        // $data = $data->map(function ($diemThang) {
        //     return [
        //         'diemThang' => $diemThang,
        //     ];
        // });
        // dd($data);
        $dsNhanVien = User::where('status', User::STATUS_ACTIVE)->where('type', User::EMPLOYEE)->get();
        $whereDsNhanVien = $dsNhanVien->where('id', $idNhanVien);
        // dd($whereDsNhanVien);
        return view('danh-muc-thang-nam.home1', [

                        'nam' => $nam,
                        'thang' => $thang,
                        'idNhanVien' =>$idNhanVien,
                        'datas' => $data,
                        'danhMucThangNam' => $danhMucThangNam,
                        'dsNhanVien' => $dsNhanVien
                        ]);

    }

}

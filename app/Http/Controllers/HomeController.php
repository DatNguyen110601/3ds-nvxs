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

    /*
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
                        */







    // public function __invoke(Request $request)
    // {
    //     // dd($request->all());
    //     $nam = $request->input('year', date('Y'));
    //     $thang = $request->input('month', date('n'));
    //     $idNhanVien = $request->input('id_nhan_vien');
    //     $idNhanVien = $idNhanVien == "0" ? null : $idNhanVien;
    //     $danhMucThangNam = DanhMucThangNam::all();

    //     if($idNhanVien == null){
    //         $query = DiemThang::with(['danhMucThangNam', 'nhanVien']);
    //     }
    //     else{
    //         $query = DiemThang::with(['danhMucThangNam', 'nhanVien'])
    //         ->where('id_nhan_vien', $idNhanVien);

    //     }


    //     // Xử lý các trường hợp
    //     if ($nam == null && $thang == null) {
    //         // Không lọc theo năm và tháng
    //         $data = $query->get();

    //     } elseif ($nam != null && $thang == null) {
    //         // Lọc theo năm nhưng không theo tháng
    //         $query->whereRelation('danhMucThangNam', function ($q) use ($nam) {
    //             $q->where('nam', $nam);
    //         });
    //         $data = $query->get();
    //     } elseif ($nam == null && $thang != null) {
    //         // Lọc theo tháng nhưng không theo năm
    //         $query->whereRelation('danhMucThangNam', function ($q) use ($thang) {
    //             $q->where('thang', $thang);
    //         });
    //         $data = $query->get();
    //     } else {
    //         // Lọc theo cả năm và tháng
    //         $query->whereRelation('danhMucThangNam', function ($q) use ($nam, $thang) {
    //             $q->where('nam', $nam)->where('thang', $thang);
    //         });
    //         $data = $query->get();
    //     }


    //     $data = $data->groupBy(function ($diemThang) {
    //         return $diemThang->danhMucThangNam->id;
    //     });

    //     // Lọc lại cấu trúc nếu cần thêm các thuộc tính
    //     $data = $data->map(function ($diemThangs, $idDanhMucThangNam) {
    //         return [
    //             'idDanhMucThangNam' => $idDanhMucThangNam,
    //             'diemThangs' => $diemThangs->map(function ($diemThang) {
    //                 return [
    //                     'diemThang' => $diemThang
    //                 ];
    //             }),
    //         ];
    //     });


    //     $dsNhanVien = User::where('status', User::STATUS_ACTIVE)->where('type', User::EMPLOYEE)->get();
    //     $whereDsNhanVien = $dsNhanVien->where('id', $idNhanVien);
    //     // dd($whereDsNhanVien);
    //     // dd($dsNhanVien);
    //     return view('danh-muc-thang-nam.home1', [

    //                     'nam' => $nam,
    //                     'thang' => $thang,
    //                     'idNhanVien' =>$idNhanVien,
    //                     'datas' => $data,
    //                     'danhMucThangNam' => $danhMucThangNam,
    //                     'dsNhanVien' => $dsNhanVien

    //                     ]);

    // }





    public function __invoke(Request $request)
{
    $nam = $request->input('year', date('Y'));
    $thang = $request->input('month', date('n'));
    $phongBan = $request->input('phong_ban'); // phòng ban gửi từ form (string)

    // Lấy DS nhân viên active
    $dsNhanVien = User::where('status', User::STATUS_ACTIVE)
        ->where('type', User::EMPLOYEE)
        ->with('viTri')
        ->get();

    // ==== 1. Lọc NHÂN VIÊN THEO PHÒNG BAN ====

    $user = auth()->user();
    $phongBanUser = $user->viTri->first()->phong_ban ?? null;

    // Nếu chưa chọn phòng ban → mặc định phòng ban của user
    if (!$phongBan || $phongBan === "0") {
        $phongBan = $phongBanUser;
    }
    if ($phongBan && $phongBan !== "0") {
        // Lấy ra danh sách ID nhân viên trong phòng ban đó
        $listIdNhanVien = $dsNhanVien->filter(function ($nv) use ($phongBan) {
            return $nv->viTri->first() && $nv->viTri->first()->phong_ban == $phongBan;
        })->pluck('id')->toArray();
    } else {
        $listIdNhanVien = $dsNhanVien->pluck('id')->toArray();
    }

    // ==== 2. Query DiemThang theo danh sách nhân viên ====
    $query = DiemThang::with(['danhMucThangNam', 'nhanVien'])
                ->whereIn('id_nhan_vien', $listIdNhanVien);

    // ==== 3. Lọc theo năm / tháng ====
    if ($nam != null && $thang != null) {
        $query->whereRelation('danhMucThangNam', function ($q) use ($nam, $thang) {
            $q->where('nam', $nam)->where('thang', $thang);
        });
    } elseif ($nam != null) {
        $query->whereRelation('danhMucThangNam', function ($q) use ($nam) {
            $q->where('nam', $nam);
        });
    } elseif ($thang != null) {
        $query->whereRelation('danhMucThangNam', function ($q) use ($thang) {
            $q->where('thang', $thang);
        });
    }

    $data = $query->get();

    // ==== 4. Group theo idDanhMucThangNam ====
    $data = $data->groupBy(fn($item) => $item->danhMucThangNam->id);

    $data = $data->map(function ($group, $idDanhMucThangNam) {
        return [
            'idDanhMucThangNam' => $idDanhMucThangNam,
            'diemThangs' => $group->map(fn($d) => ['diemThang' => $d]),
        ];
    });

    // ==== 5. Lấy danh sách phòng ban duy nhất ====
    $dsPhongBan = $dsNhanVien->pluck('viTri')->flatten()->pluck('phong_ban')->unique();

    return view('danh-muc-thang-nam.home1', [
        'nam' => $nam,
        'thang' => $thang,
        'phongBan' => $phongBan,
        'datas' => $data,
        'danhMucThangNam' => DanhMucThangNam::all(),
        'dsNhanVien' => $dsNhanVien,
        'dsPhongBan' => $dsPhongBan,
    ]);
}



}




<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;

class NhanVienXuatSacController extends Controller
{


    public function index(Request $request){
        $year = $request->input('year', date('Y')); // Lấy năm từ request, mặc định là năm hiện tại

        // dd($year);
        // Lấy danh sách nhân viên kèm điểm theo tháng
        $dsNhanVien = User::where('status', User::STATUS_ACTIVE)->where('type', User::EMPLOYEE)->get();

        $data = $dsNhanVien->map(function ($nhanVien) use ($year) {
            // Khởi tạo dữ liệu nhân viên
            $monthlyPoints = array_fill(1, 12, 0); // Điểm từ tháng 1 đến 12
            $totalPoints = 0;

            // Tính điểm theo tháng
            foreach ($nhanVien->diemThang as $diemThang) {
                if ($diemThang->danhMucThangnam->nam == $year) {
                    $month = $diemThang->danhMucThangnam->thang;
                    $monthlyPoints[$month] = $diemThang->tong_diem;
                    $totalPoints += $diemThang->tong_diem;
                }
            }

            return[
                'nhanVien' => $nhanVien,
                'nhan_vien' => $nhanVien->name,
                'tong_diem' => $totalPoints,
                'diem_thang' => $monthlyPoints,
            ];
        });
        $data = $data->sortByDesc('tong_diem');
        
        // Lấy điểm cao nhất (top 1) và điểm thứ hai (top 2)
        $top1 = $data->first(); // Người có điểm cao nhất

        if($top1['tong_diem'] == 0){
            $data = null;
            return view('nhan-vien-xuat-sac.index', [
                'data' => $data,
                'year' => $year,
            ]);
        };
        $top2 = $data->skip(1)->first(); // Người có điểm cao thứ 2
        $top3 = $data->skip(2)->first(); // Người có điểm cao thứ 3

        // Kiểm tra nếu điểm top 1 và top 2 cách quá xa so với top 3
        if ($top1['tong_diem'] - $top3['tong_diem'] > 10) { // Thay 10 bằng giá trị cách biệt bạn cho là quá xa
            // Nếu cách biệt quá xa, chỉ lấy top 1 và top 2
            $data = $data->take(2);
        } else {
            // Nếu không, lấy tất cả nhân viên có điểm bằng hoặc cao hơn điểm của top 3
            $maxPoint = $top3['tong_diem'];
            $data = $data->filter(function ($item) use ($maxPoint) {
                return $item['tong_diem'] >= $maxPoint;
            });
        }

            return view('nhan-vien-xuat-sac.index', [
                'data' => $data,
                'year' => $year,
            ]);
        }



    // public function index(){

    //         $danhMucThangNam = DanhMucThangNam::all();
    //         $top3TongDiems = [];

    //         foreach ($danhMucThangNam as $danhMuc) {
    //             // Group 'diemThang' records by 'tong_diem' and sort them in descending order
    //             $groupedTongDiems = $danhMuc->diemThang
    //                                          ->groupBy('tong_diem')
    //                                          ->sortByDesc(function ($group, $tongDiem) {
    //                                              return $tongDiem;
    //                                          });

    //             // Collect the top groups until we reach the top 3 positions
    //             $topGroups = [];
    //             foreach ($groupedTongDiems as $tongDiem => $group) {
    //                 $topGroups[$tongDiem] = $group;
    //                 if (count($topGroups) >= 3) break; // Stop once we have the top 3 positions
    //             }

    //             // Store the result in an array with the danhMuc identifier as key
    //             $top3TongDiems[$danhMuc->id] = $topGroups;
    //         }

    //         return view('nhan-vien-xuat-sac.index', [
    //             'danhMucThangNam' =>$danhMucThangNam,
    //             'top3TongDiems' => $top3TongDiems,
    //         ]);
    //     }








    //     // $danhMucThangNam = DanhMucThangNam::all();
    //     $danhMucThangNam = DanhMucThangNam::all()->groupBy('nam');

    //     $top3TongDiems = [];
    //     $totalTongDiemByNam = [];

    // foreach ($danhMucThangNam as $danhMuc) {


    //         $nam = $danhMuc->nam;
    //         // $totalTongDiemByNam[$nam] = ($totalTongDiemByNam[$nam] ?? 0) + $danhMuc->diemThang->sum('tong_diem');


    //         $groupedTongDiems = $danhMuc->diemThang
    //             ->groupBy('tong_diem')
    //             ->sortByDesc(function ($group, $tongDiem) {
    //                 return $tongDiem;
    //             });

    //         // Get the top 3 groups of 'tong_diem'
    //         $topGroups = [];
    //         foreach ($groupedTongDiems as $tongDiem => $group) {
    //             $topGroups[$tongDiem] = $group;
    //             if (count($topGroups) >= 3) break;
    //         }

    //         $top3TongDiems[$danhMuc->thang] = $topGroups;

    // }

    // dd($top3TongDiems);

    // return view('nhan-vien-xuat-sac.index', [
    //     'top3TongDiems' => $top3TongDiems,
    //     'totalTongDiemByNam' => $totalTongDiemByNam,
    // ]);
// }


}

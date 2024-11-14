<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;

class NhanVienXuatSacController extends Controller
{
    public function index(){

            $danhMucThangNam = DanhMucThangNam::all();
            $top3TongDiems = [];

            foreach ($danhMucThangNam as $danhMuc) {
                // Group 'diemThang' records by 'tong_diem' and sort them in descending order
                $groupedTongDiems = $danhMuc->diemThang
                                             ->groupBy('tong_diem')
                                             ->sortByDesc(function ($group, $tongDiem) {
                                                 return $tongDiem;
                                             });

                // Collect the top groups until we reach the top 3 positions
                $topGroups = [];
                foreach ($groupedTongDiems as $tongDiem => $group) {
                    $topGroups[$tongDiem] = $group;
                    if (count($topGroups) >= 3) break; // Stop once we have the top 3 positions
                }

                // Store the result in an array with the danhMuc identifier as key
                $top3TongDiems[$danhMuc->id] = $topGroups;
            }

            return view('nhan-vien-xuat-sac.index', [
                'danhMucThangNam' =>$danhMucThangNam,
                'top3TongDiems' => $top3TongDiems,
            ]);
        }







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

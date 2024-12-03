<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucThangNam;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $nam = $request->input('year', date('Y'));
        $thang = $request->input('month', date('n'));


        if($nam == null && $thang == null){
            $danhMucThangNam = DanhMucThangNam::all();

                return view('danh-muc-thang-nam.home', [
                    'danhMucThangNam' => $danhMucThangNam,
                    'nam' => $nam,
                    'thang' => $thang
                ]);

        }
        elseif($nam !=null && $thang == null){

            $danhMucThangNam = DanhMucThangNam::where('nam', $nam)->get();
            // dd($danhMucThangNam);
                return view('danh-muc-thang-nam.home', [
                    'danhMucThangNam' => $danhMucThangNam,
                    'nam' => $nam,
                    'thang' => $thang
                ]);

        }
        elseif($nam == null && $thang !=null){

            $danhMucThangNam = DanhMucThangNam::where('thang', $thang)->get();

                return view('danh-muc-thang-nam.home', [
                    'danhMucThangNam' => $danhMucThangNam,
                    'nam' => $nam,
                    'thang' => $thang
                ]);

        }
        else{
            $danhMucThangNam = DanhMucThangNam::where('nam', $nam)->where('thang', $thang)->get();

            return view('danh-muc-thang-nam.home', [
                'danhMucThangNam' => $danhMucThangNam,
                'nam' => $nam,
                'thang' => $thang
                ]);
        }

    }

}

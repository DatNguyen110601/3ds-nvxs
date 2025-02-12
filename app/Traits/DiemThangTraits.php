<?php
namespace App\Traits;

use App\Models\DiemThang;
use App\Models\DiemTheoTieuChi;
use App\Jobs\DiemTheoTieuChiJob;
use App\Models\TieuChiTheoThang;
use Illuminate\Support\Facades\Log;

trait DiemThangTraits {

    public function themDiemThang($arrayNhanVien ,$idThangNam, $arrayTieuChi){


        foreach($arrayNhanVien as $idNhanVien){
            $timDiemThang = DiemThang::where('id_thang_nam' , $idThangNam)
                                        ->where('id_nhan_vien', $idNhanVien)->first();

            if($timDiemThang == null){
                $createDiemThang = DiemThang::create([
                    'id_thang_nam' => $idThangNam,
                    'id_nhan_vien' => $idNhanVien
                ]);

                $createDiemTheoTieuChi = DiemTheoTieuChiJob::dispatch( $idThangNam, $createDiemThang, $arrayTieuChi);
            }
            else{
                // dd($timDiemThang);

                $createDiemTheoTieuChi = DiemTheoTieuChiJob::dispatch( $idThangNam, $timDiemThang, $arrayTieuChi);

            }

        }
    }

    public function tinhTongDiem($diemThang){
        $diemTheoTieuChi = $diemThang->diemTheoTieuChi;
        // dd($diemTheoTieuChi);
        // Sum all values in the $diemTheoTieuChi array
        $tongDiem = 0;
        foreach($diemTheoTieuChi as $diem){
            $tongDiem += (float) $diem->diem * (float) $diem->tenTieuChi->he_so;
        }
        $diemThang->update(['tong_diem' => $tongDiem]);
        return $tongDiem;
    }

    public function updateDiemThang($diemThang){

    }

}

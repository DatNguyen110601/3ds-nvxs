<?php

namespace App\Jobs;

use App\Models\DiemThang;
use Illuminate\Bus\Queueable;
use App\Models\DiemTheoTieuChi;
use App\Models\TieuChiTheoThang;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DiemTheoTieuChiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $idThangNam;
    public $createDiemThang;
    public $arrayTieuChi;
    /**
     * Create a new job instance.
     */
    public function __construct($idThangNam, DiemThang $createDiemThang, $arrayTieuChi)
    {

        $this->idThangNam = $idThangNam;
        $this->createDiemThang = $createDiemThang;
        $this->arrayTieuChi = $arrayTieuChi;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $tieuChiTheoThang = DiemTheoTieuChi::where('id_diem_nv_thang', $this->createDiemThang->id)->get();

        foreach($this->arrayTieuChi as $tieuChi){

            $exists = $tieuChiTheoThang->contains('id_tieu_chi', $tieuChi);
            // dd($exists);
            if (!$exists) {
                // dd($tieuChi);
                $createDiemTheoTieuChi = DiemTheoTieuChi::create([
                    'id_tieu_chi' => $tieuChi,
                    'id_diem_nv_thang' => $this->createDiemThang->id
                ]);
            }
        }



        // $tieuChiTheoThang = TieuChiTheoThang::where('id_thang_nam', $this->idThangNam)->get();

        // foreach($tieuChiTheoThang as $tieuChi){
        //     $createDiemTheoTieuChi = DiemTheoTieuChi::create([
        //         'id_tieu_chi' => $tieuChi->id_tieu_chi,
        //         'id_diem_nv_thang' => $this->createDiemThang->id
        //     ]);
        // }

    }
}

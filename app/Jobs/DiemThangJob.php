<?php

namespace App\Jobs;

use App\Models\NhanVien;
use App\Models\DiemThang;
use Illuminate\Bus\Queueable;
use App\Models\DiemTheoTieuChi;
use App\Jobs\DiemTheoTieuChiJob;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DiemThangJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $arrayNhanVien;
    public $idThangNam;
    /**
     * Create a new job instance.
     */
    public function __construct($arrayNhanVien, $idThangNam)
    {
        $this->arrayNhanVien = $arrayNhanVien;
        $this->idThangNam = $idThangNam;
    }
    public $uniqueFor = 30;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->arrayNhanVien as $idNhanVien){
            $createDiemThang = DiemThang::create([
                'id_thang_nam' => $this->idThangNam,
                'id_nhan_vien' => $idNhanVien
            ]);
            
            if($createDiemThang){
                $createDiemTheoTieuChiThang = DiemTheoTieuChiJob::dispatch($createDiemThang->id);
            }
        }
    }
}

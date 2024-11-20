<?php

namespace App\Exports;

use App\Models\DanhMucThangNam;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class DanhMucThangNamExport implements  FromView
{

    protected $idDanhMucThangNam;

    public function __construct($idDanhMucThangNam){
        $this->idDanhMucThangNam = $idDanhMucThangNam;
    }
    public function view(): View
    {
        $thangData = DB::table('nvxs___danh_muc_thang_nams')->where('id', $this->idDanhMucThangNam)->first();

        $data = DB::table('users')
            ->join('nvxs___diem_thangs', function ($join) {
                $join->on('users.id', '=', 'nvxs___diem_thangs.id_nhan_vien')
                    ->where('nvxs___diem_thangs.id_thang_nam', '=', $this->idDanhMucThangNam);
            })

            ->join('nvxs___diem_theo_tieu_chis', 'nvxs___diem_thangs.id', '=', 'nvxs___diem_theo_tieu_chis.id_diem_nv_thang')
            ->join('nvxs___tieu_chi_theo_thangs', 'nvxs___diem_theo_tieu_chis.id_tieu_chi', '=', 'nvxs___tieu_chi_theo_thangs.id_tieu_chi')
            ->join('nvxs___danh_sach_tieu_chis', 'nvxs___tieu_chi_theo_thangs.id_tieu_chi', '=', 'nvxs___danh_sach_tieu_chis.id')
            ->where('nvxs___tieu_chi_theo_thangs.id_thang_nam', $this->idDanhMucThangNam)

            ->select(
                'users.name',
                'nvxs___diem_thangs.tong_diem',
                'nvxs___tieu_chi_theo_thangs.id_tieu_chi',
                'nvxs___danh_sach_tieu_chis.ten_tieu_chi',

                'nvxs___diem_theo_tieu_chis.diem'
            )
            ->get()
            ->groupBy('name');

        return view('exports.diem_thang', [
            'data' => $data,
            'thang' => $thangData->thang,
            'nam' => $thangData->nam,
        ]);
    }
    }







    // protected $danhMucThangNam;
    // protected $index;
    // public function __construct($danhMucThangNam)
    // {
    //     $this->danhMucThangNam = $danhMucThangNam;
    // }

    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     $this->index = 1;
    //     return $this->danhMucThangNam->diemThang;
    // }

    // public function headings() :array{
    //     $headings = [
    //         'Stt',
    //         'Tên Nhân Viên',
    //         'Tổng điểm'

    //     ];
    //     foreach ($this->danhMucThangNam->dsTieuChiThang as $tieuChi) {
    //         $headings[] = $tieuChi->tenTieuChi->ten_tieu_chi; // Replace `name` with the actual property name
    //     }
    //     return $headings;
    // }
    // public function map($diem): array {
    //         return[
    //             $this->index++,
    //             $diem->nhanVien->name,
    //             $diem->tong_diem
    //         ];

    // }

    //
//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 // Set title
//                 $title = "NHÂN VIÊN XUẤT SẮC THÁNG {$this->danhMucThangNam->thang} NĂM {$this->danhMucThangNam->nam}";
//                 $event->sheet->mergeCells('A1:H1'); // Merge cells for the title
//                 $event->sheet->setCellValue('A1', $title); // Set the title text
//                 $event->sheet->getStyle('A1')->applyFromArray([
//                     'font'      => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FF0000']], // Bold font, size 11
//                     'alignment' => [
//                         'horizontal' => Alignment::HORIZONTAL_CENTER ,
//                         'vertical' => Alignment::VERTICAL_CENTER,
//                         'wrapText' => true
//                     ], // Center-align text
//                     'fill'      => [
//                         'fillType'   => Fill::FILL_SOLID,
//                     ],
//                 ]);

//                 // Set column headings
//                 $headings = $this->headings();
//                 foreach ($headings as $index => $heading) {
//                     $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
//                     $event->sheet->setCellValue($column . '2', $heading);
//                 }

//                 $event->sheet->getStyle('A2:H2')->applyFromArray([
//                     'font'      => ['bold' => true], // Make font bold
//                     'alignment' => [
//                         'horizontal' => Alignment::HORIZONTAL_CENTER, // Center-align text horizontally
//                         'vertical' => Alignment::VERTICAL_CENTER, // Middle-align text vertically
//                         'wrapText' => true
//                     ],
//                     'fill'      => [
//                         'fillType'   => Fill::FILL_SOLID,
//                         'startColor' => ['rgb' => '93ccea'] // Set background color
//                     ],
//                 ]);

//                 // Set content starting from row 3
//                 $row = 3;
//                 foreach ($this->collection() as $user) {
//                     $rowData = $this->map($user);
//                     foreach ($rowData as $index => $value) {
//                         $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
//                         $event->sheet->setCellValue($column . $row, $value);
//                     }
//                     $row++;
//                 }

//                 // Set height for the headings row
//                 $event->sheet->getRowDimension(2)->setRowHeight(50);
//                 $event->sheet->getColumnDimension('A')->setWidth(20);
//                 $event->sheet->getColumnDimension('B')->setWidth(20);
//                 $event->sheet->getColumnDimension('C')->setWidth(20);
//                 $event->sheet->getColumnDimension('D')->setWidth(20);
//                 $event->sheet->getColumnDimension('E')->setWidth(20);
//                 $event->sheet->getColumnDimension('F')->setWidth(20);
//                 $event->sheet->getColumnDimension('G')->setWidth(20);
//                 $event->sheet->getColumnDimension('H')->setWidth(20);


//                 // Apply borders to all cells
//                 $lastRow = $event->sheet->getDelegate(2)->getHighestRow();
//                 $lastColumn = $event->sheet->getDelegate()->getHighestColumn();
//                 $cellRange = 'A2:' . $lastColumn . $lastRow;
//                 $event->sheet->getStyle($cellRange)->applyFromArray([
//                     'borders' => [
//                         'allBorders' => [
//                             'borderStyle' => Border::BORDER_THIN, // Add thin border around cells
//                             'color' => ['rgb' => '000000'], // Border color
//                         ],
//                     ],
//                     'alignment' => [
//                         'horizontal' => Alignment::HORIZONTAL_CENTER, // Center-align text horizontally
//                         'vertical' => Alignment::VERTICAL_CENTER, // Middle-align text vertically
//                     ],
//                 ]);
//             },
//         ];
//     }

// }

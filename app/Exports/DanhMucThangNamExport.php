<?php

namespace App\Exports;

use App\Models\DanhMucThangNam;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;

class DanhMucThangNamExport implements FromCollection,WithHeadings,WithMapping,WithEvents
{
    protected $danhMucThangNam;

    public function __construct($danhMucThangNam)
    {
        $this->danhMucThangNam = $danhMucThangNam;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->danhMucThangNam->diemThang;
    }

    public function headings() :array{
        return [
            'Tên Nhân Viên',
            'Tổng điểm'

        ];
    }
    public function map($diem): array {
            return[
                $diem->nhanVien->name,
                $diem->tong_diem
            ];

    }

    //
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Set title
                $title = "NHÂN VIÊN XUẤT SẮC THÁNG {$this->danhMucThangNam->thang} NĂM {$this->danhMucThangNam->nam}";
                $event->sheet->mergeCells('A1:H1'); // Merge cells for the title
                $event->sheet->setCellValue('A1', $title); // Set the title text
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FF0000']], // Bold font, size 11
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER ,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ], // Center-align text
                    'fill'      => [
                        'fillType'   => Fill::FILL_SOLID,
                    ],
                ]);

                // Set column headings
                $headings = $this->headings();
                foreach ($headings as $index => $heading) {
                    $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
                    $event->sheet->setCellValue($column . '2', $heading);
                }

                $event->sheet->getStyle('A2:H2')->applyFromArray([
                    'font'      => ['bold' => true], // Make font bold
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER, // Center-align text horizontally
                        'vertical' => Alignment::VERTICAL_CENTER, // Middle-align text vertically
                        'wrapText' => true
                    ],
                    'fill'      => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '93ccea'] // Set background color
                    ],
                ]);

                // Set content starting from row 3
                $row = 3;
                foreach ($this->collection() as $user) {
                    $rowData = $this->map($user);
                    foreach ($rowData as $index => $value) {
                        $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
                        $event->sheet->setCellValue($column . $row, $value);
                    }
                    $row++;
                }

                // Set height for the headings row
                $event->sheet->getRowDimension(2)->setRowHeight(50);
                $event->sheet->getColumnDimension('A')->setWidth(20);
                $event->sheet->getColumnDimension('B')->setWidth(20);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(20);
                $event->sheet->getColumnDimension('E')->setWidth(20);
                $event->sheet->getColumnDimension('F')->setWidth(20);
                $event->sheet->getColumnDimension('G')->setWidth(20);
                $event->sheet->getColumnDimension('H')->setWidth(20);


                // Apply borders to all cells
                $lastRow = $event->sheet->getDelegate(2)->getHighestRow();
                $lastColumn = $event->sheet->getDelegate()->getHighestColumn();
                $cellRange = 'A2:' . $lastColumn . $lastRow;
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN, // Add thin border around cells
                            'color' => ['rgb' => '000000'], // Border color
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER, // Center-align text horizontally
                        'vertical' => Alignment::VERTICAL_CENTER, // Middle-align text vertically
                    ],
                ]);
            },
        ];
    }

}

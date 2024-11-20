<?php
$list = [

    route('diem-thang.index') => "Điểm tháng",
    route('nhan-vien.show', ['danhSachNhanVien' => $nhanVien]) => "{$nhanVien->name}",
    '#' => "năm {$danhMucThangNam->nam}/ tháng {$danhMucThangNam->thang}",
    '##' => "Điểm"
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

    <div class=" d-flex justify-content-between mb-3 mt-4">
        <legend class="legend">Điểm tháng {{$danhMucThangNam->thang}}, nhân viên {{$nhanVien->name}}</legend>
        
    </div>

    @if (session('status'))
        <div class="alert alert-success">
        {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
        </div>
    @endif
    <div class="table-responsive">

        <table class="table  table-bordered">
            <thead class="table-light">
                <tr>

                    <th scope="col">Nhân Viên</th>
                    <th scope="col">Tiêu chí</th>
                    <th scope="col">Điểm</th>
                    <th scope="col">Hành động</th>

                </tr>
            </thead>

            @if(!empty($diemThang))
            <tbody class="text-center">

                <tr>

                    <td>{{$diemThang->nhanVien->name}}</td>
                    <td style="padding: 0px;">
                        <table class="table" style="margin: 0px;">
                            @foreach ($diemThang->diemTheoTieuChi as $diem)
                            <tr><td>{{$diem->tenTieuChi->ten_tieu_chi}}</td></tr>

                            @endforeach
                        </table>
                    </td>

                    <td style="padding: 0px;" >
                        <table class="table" style="margin: 0px;">
                            @foreach ($diemThang->diemTheoTieuChi as $diem)
                            <tr><td>{{$diem->diem}}</td></tr>

                            @endforeach
                        </table>
                    </td>

                    <td>
                        {{-- <a href="">

                            <span class="material-symbols-outlined fs-3"  style="color: #0d6efd;">
                                contrast_square
                            </span>

                        </a> --}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Tổng điểm: {{$diemThang->tong_diem}}</strong></td>
                </tr>
            </tbody>
        @endif

        </table>
    </div>

</x-layout>

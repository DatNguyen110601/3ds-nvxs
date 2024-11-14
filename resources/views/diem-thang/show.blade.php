<?php
$list = [

    route('diem-thang.index') => "Điểm tháng",
    route('nhan-vien.show', ['danhSachNhanVien' => $nhanVien]) => "{$nhanVien->name}",
    '#' => "năm {$danhMucThangNam->nam}/ tháng {$danhMucThangNam->thang}",
    '##' => "Điểm"
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Điểm tháng {{$danhMucThangNam->thang}}, nhân viên {{$nhanVien->name}}</legend>
        <div class="mb-2">
            <a href="{{route('danh-muc-thang-nam.create')}}" class="btn btn-primary">
                <span class="material-symbols-outlined" >
                    add_task
                </span>
                Thêm</a>
        </div>
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
    <div>

        <table class="table ">
            <head>
                <tr>

                    <th scope="col">Nhân Viên</th>
                    <th scope="col">Tiêu chí</th>
                    <th scope="col">Điểm</th>
                    <th scope="col">Hành động</th>

                </tr>
            </head>

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

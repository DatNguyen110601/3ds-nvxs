<?php
$list = [
    route('home') =>'Trang chủ',
    route('danh-muc-thang-nam.index')=>'Danh mục tháng năm',
    route('danh-muc-thang-nam.show', ['danhMucThangNam' => $danhMucThangNam,
                                    'diemThang' => $diemThang,])
                                    => "Nhân viên tháng {$danhMucThangNam->thang}",
    '#' => "{$nhanVien->name}"
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>



    <div class=" d-flex justify-content-between mb-3 mt-4">
        <legend class="legend">Tiêu chí nhân viên tháng {{$danhMucThangNam->thang}} , {{$nhanVien->name}}</legend>
        {{-- <div class="mb-2">
            <a href="{{route('danh-muc-thang-nam.create')}}" class="btn btn-primary">
                <span class="material-symbols-outlined" >
                    add_task
                </span>
                Thêm</a>
        </div> --}}
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

            <table class="table " style="border: 1px solid #000">
                <head>
                    <tr>

                        <th scope="col">Nhân Viên</th>
                        <th scope="col">Tiêu chí</th>
                        <th scope="col">Điểm</th>
                        <th>Người chấm</th>
                        <th scope="col">Cập nhật</th>

                    </tr>
                </head>
                @foreach ($lichSuDiemThang as $index => $lsDiemThang)
                @if(!empty($diemThang))
                <tbody class="text-center">

                    <tr>

                        @if ($index == count($lichSuDiemThang) - 1)
                            <td>{{$lsDiemThang->nhanVien->name}}</td>
                           
                        @else
                            <td></td>

                        @endif
                        {{-- <td>{{$lsDiemThang->nhanVien->name}}</td> --}}
                        <td style="padding: 0px;">
                            <table class="table" style="margin: 0px;">
                                @foreach ($lsDiemThang->lsDiemTheoTieuChi as $diem)
                                <tr><td>{{$diem->tenTieuChi->ten_tieu_chi}}</td></tr>

                                @endforeach
                            </table>
                        </td>

                        <td style="padding: 0px;" >
                            <table class="table" style="margin: 0px;">
                                @foreach ($lsDiemThang->lsDiemTheoTieuChi as $diem)

                                <tr><td class="text-center" title="{{ $diem->ly_do }}">{{$diem->diem}}</td></tr>


                                @endforeach
                            </table>
                        </td>
                        <td>
                            {{ $lsDiemThang->nguoiCham->name }}
                        </td>
                        <td>
                            {{ $lsDiemThang->created_at->format('H:i:s d-m-Y') }}

                        </td>

                    </tr>
                    <tr>
                        <td colspan="5"><strong>Tổng điểm: {{$lsDiemThang->tong_diem}}</strong></td>
                    </tr>
                </tbody>
                @endif
                @endforeach
            </table>





        <?php /*

        @foreach ($lichSuDiemThang as $lsDiemThang)

            <table class="table ">
                <head>
                    <tr>

                        <th scope="col">Nhân Viên</th>
                        <th scope="col">Tiêu chí</th>
                        <th scope="col">Điểm</th>
                        <th scope="col">Cập nhật</th>

                    </tr>
                </head>

                @if(!empty($diemThang))
                <tbody class="text-center">

                    <tr>
                        <td>{{$lsDiemThang->nhanVien->name}}</td>
                        <td style="padding: 0px;">
                            <table class="table" style="margin: 0px;">
                                @foreach ($lsDiemThang->lsDiemTheoTieuChi as $diem)
                                <tr><td>{{$diem->tenTieuChi->ten_tieu_chi}}</td></tr>

                                @endforeach
                            </table>
                        </td>

                        <td style="padding: 0px;" >
                            <table class="table" style="margin: 0px;">
                                @foreach ($lsDiemThang->lsDiemTheoTieuChi as $diem)
                                <tr><td>{{$diem->diem}}</td></tr>

                                @endforeach
                            </table>
                        </td>

                        <td>
                            {{ $lsDiemThang->created_at->format('H:i:s d-m-Y') }}

                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"><strong>Tổng điểm: {{$lsDiemThang->tong_diem}}</strong></td>
                    </tr>
                </tbody>
                @endif

            </table>

        @endforeach

        */?>


        <?php /*
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
                            @can('add_edit_diem')
                                <a href="{{route('cham-diem-nhan-vien.create',
                                [
                                    'danhMucThangNam' =>$danhMucThangNam,
                                    'nhanVien' => $nhanVien,

                                ])}}" title="Chấm điểm">

                                <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;">
                                        border_color
                                </span>

                                </a>
                            @endcan
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"><strong>Tổng điểm: {{$diemThang->tong_diem}}</strong></td>
                    </tr>
                </tbody>
            @endif

            </table>
        */ ?>

    </div>

</x-layout>

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

    <div class=" d-flex justify-content-between  mb-3 mt-4">
        <legend class="legend">Tiêu chí nhân viên tháng {{$danhMucThangNam->thang}} , {{$nhanVien->name}}</legend>
        {{-- <div class="mb-2">
            <a href="{{route('danh-muc-thang-nam.create')}}" class="btn btn-primary">
                <span class="material-symbols-outlined" >
                    add_task
                </span>
                Thêm</a>
        </div> --}}

        <div class="d-flex">
            @can('duyet_diem')
                <div class="mb-2 mr-2">
                @if ($diemThang->diemTheoTieuChi->every(fn($duyet) => $duyet->duyet == 1))

                                <a href="{{route('duyet.removeDuyetDiemThang', ['danhMucThangNam' => $danhMucThangNam,
                                    'nhanVien' =>$nhanVien])}}" title="Bỏ duyệt"
                                    onclick="return confirm('Bạn có chắc chắn muốn BỎ DUYỆT?');"
                                    class="btn btn-success"
                                    style="width:160px;"
                                    >

                                    <span class="material-symbols-outlined" style="color: #bbb">
                                        task_alt
                                    </span>
                                    Hủy Duyệt
                                </a>

                    @else
                        <a href="{{route('duyet.duyetDiemThang', ['danhMucThangNam' => $danhMucThangNam,
                            'nhanVien' =>$nhanVien])}}" title="Duyệt"
                            onclick="return confirm('Bạn có chắc chắn muốn DUYỆT?');"
                            class="btn btn-success"
                            style="width:160px"
                            >
                            <span class="material-symbols-outlined" style="color: #bbb">
                            task_alt
                            </span>
                            Duyệt
                        </a>

                @endif


                </div>
            @endcan

            @can('add_edit_diem')

                @if ($diemThang->tong_diem == 0)
                    <div class="mb-2 mr-2">
                        <a href="{{route('cham-diem-nhan-vien.create',
                        [
                            'danhMucThangNam' =>$danhMucThangNam,
                            'nhanVien' => $diemThang->nhanVien,

                        ])}}" title="Chấm điểm"
                                    class="btn btn-info"

                        style="width:160px;"


                        >
                        <span class="material-symbols-outlined" >
                            border_color
                        </span>
                        Chấm điểm
                    </a>
                    </div>

                @else
                    <div class="mb-2 mr-2">
                        <a href="{{route('cham-diem-nhan-vien.edit',
                            [
                                'danhMucThangNam' =>$danhMucThangNam,
                                'nhanVien' => $diemThang->nhanVien,

                            ])}}" title="Chấm điểm"
                            style="width:160px;"
                            class="btn btn-info"
                            >
                            <span class="material-symbols-outlined">
                                border_color
                            </span>
                            Sửa điểm
                        </a>
                    </div>
                @endif

                @endcan
                <div class="mb-2 mr-2">
                    <a href="{{route('danh-muc-thang-nam.xem-lich-su',
                                    [
                                        'danhMucThangNam' =>$danhMucThangNam,
                                        'nhanVien' => $nhanVien,

                                    ])}}"
                                    class="btn btn-warning"
                                    style="width:160px;"
                                    title="Xem lịch sử">
                                    <span class="material-symbols-outlined">
                                        history
                                    </span>
                                Xem lịch sử

                    </a>
                </div>
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
                        <?php /*
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
                        */?>

                        {{-- @can('add_edit_diem')

                        @if ($diemThang->tong_diem == 0)

                            <a href="{{route('cham-diem-nhan-vien.create',
                            [
                                'danhMucThangNam' =>$danhMucThangNam,
                                'nhanVien' => $diemThang->nhanVien,

                            ])}}" title="Chấm điểm"
                            style="{{ $diemThang->diemTheoTieuChi->every(fn($duyet) => $duyet->duyet == 0) ? '' : 'pointer-events: none; opacity: 0.5;' }}"
                            >
                            <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;">
                                border_color
                            </span>

                            </a>
                        @else
                            <a href="{{route('cham-diem-nhan-vien.edit',
                            [
                                'danhMucThangNam' =>$danhMucThangNam,
                                'nhanVien' => $diemThang->nhanVien,

                            ])}}" title="Chấm điểm"
                            style="{{ $diemThang->diemTheoTieuChi->every(fn($duyet) => $duyet->duyet == 0) ? '' : 'pointer-events: none; opacity: 0.5;' }}"
                            >

                            <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;">
                                border_color
                            </span>

                            </a>
                        @endif

                        @endcan

                        <a href="{{route('danh-muc-thang-nam.xem-lich-su',
                                        [
                                            'danhMucThangNam' =>$danhMucThangNam,
                                            'nhanVien' => $nhanVien,

                                        ])}}" title="Xem lịch sử">

                                        <span class="material-symbols-outlined fs-3">
                                            history
                                        </span>

                        </a>
                    </td> --}}
                </tr>
                <tr>
                    <td colspan="4"><strong>Tổng điểm: {{$diemThang->tong_diem}}</strong></td>
                </tr>
            </tbody>
        @endif

        </table>
    </div>

</x-layout>

<?php
$list = [
    route('danh-muc-thang-nam.index')=>'Danh mục tháng năm',
    '#' => "Nhân viên tháng {$danhMucThangNam->thang}"
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Tiêu chí nhân viên tháng {{$danhMucThangNam->thang}}</legend>

        @can('duyet_diem')
        <div class="mb-2">
            <a href="{{route('duyet.duyetDiemThangAll', ['danhMucThangNam' => $danhMucThangNam])}}" class="btn btn-primary" title="Duyệt">
                <span class="material-symbols-outlined" >
                    browse
                </span>
                Duyệt</a>
        </div>
        @endcan

        @can('export_excel')
        <div class="mb-2 ml-2">

            <a href="" class="btn btn-primary" title="Tải file excel">
                <span class="material-symbols-outlined" >
                    download
                </span>
                </a>

        </div>
        @endcan

        @can('add_danh_muc_thang_nam')
        <div class="mb-2 ml-2">
            <a href="{{route('danh-muc-thang-nam.create')}}" class="btn btn-primary">
                <span class="material-symbols-outlined" >
                    add_task
                </span>
                Thêm</a>

        </div>
        @endcan

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
                    <th scope="col">STT</th>
                    <th scope="col">Tên Nhân Viên</th>
                    <th scope="col">Tổng điểm</th>
                    <th scope="col">Duyệt</th>
                    <th scope="col">Hành động</th>
                </tr>
            </head>


            @if(!empty($diemThang))
            <tbody class="text-center">
            @foreach ($diemThang as $key=>$value)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$value->nhanVien->name}}</td>
                    <td>{{$value->tong_diem}}</td>
                        @if ($value->duyet == 1)
                        <td>Đã duyệt</td>
                        @else
                        <td>Chưa duyệt</td>
                        @endif
                    <td>
                        <a href="{{route('danh-muc-thang-nam.xem-diem-nhan-vien-thang',
                            ['danhMucThangNam' =>$danhMucThangNam,
                            'nhanVien' => $value->nhanVien,
                            ]
                            )}}" title="Xem" >
                            <span class="material-symbols-outlined fs-3">
                                table_eye
                            </span>
                        </a>
                        @can('add_edit_diem')
                        <a href="{{route('cham-diem-nhan-vien.create',
                        [
                            'danhMucThangNam' =>$danhMucThangNam,
                            'nhanVien' => $value->nhanVien,

                        ])}}" title="Chấm điểm">

                        <span class="material-symbols-outlined fs-3"  style="color: #0d6efd;">
                            contrast_square
                        </span>

                        </a>

                        <a href="{{route('cham-diem-nhan-vien.edit',
                        [
                            'danhMucThangNam' =>$danhMucThangNam,
                            'nhanVien' => $value->nhanVien,

                        ])}}" title="Sửa" >
                            <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;">
                                border_color
                            </span>
                        </a>
                        @endcan

                        @can('duyet_diem')
                        <a href="{{route('duyet.duyetDiemThang', ['danhMucThangNam' => $danhMucThangNam,
                            'nhanVien' =>$value->nhanVien])}}" title="Xem" >
                            <span class="material-symbols-outlined fs-3">
                            browse
                            </span>
                        </a>
                        @endcan

                    </td>
                </tr>
            @endforeach
            </tbody>
        @endif

        </table>
    </div>

</x-layout>

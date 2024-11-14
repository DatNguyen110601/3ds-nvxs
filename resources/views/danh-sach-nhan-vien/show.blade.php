<?php
$list = [

    route('nhan-vien.index')=>'Danh sách nhân viên',
    '#' => "{$danhSachNhanVien->name}"
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>

<div>
    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Nhân viên {{$danhSachNhanVien->name}}</legend>
       
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

    <div class="">
        <table class="table">
            <thead>
                <tr>

                    <th>Năm</th>
                    <th>Tháng</th>
                    <th>Tổng điểm</th>
                    <th>Hành động</th>

                </tr>
            </thead>
            <tbody class="text-center">

                @foreach ($diemThang as $diem)
                <tr>
                    <td>{{$diem->danhMucThangNam->nam}}</td>
                    <td>{{$diem->danhMucThangNam->thang}}</td>
                    <td>{{$diem->tong_diem}}</td>
                    <td>
                        <a href="{{route('diem-thang.show', ['nhanVien' =>$danhSachNhanVien,
                                                            'diemThang' => $diem])}}" title="Xem" >
                            <span class="material-symbols-outlined fs-3">
                                table_eye
                            </span>
                        </a>
                        <a href="" title=Sửa>
                            <span class="material-symbols-outlined fs-3"  style="color: #0dcaf0;">
                                border_color
                            </span>
                        </a>
                        <a href="" title="Xóa">
                            <span class="material-symbols-outlined fs-3 " style="color: red;" title="Xóa">
                                delete
                            </span>
                        </a>
                    </td>
                </tr>
                @endforeach


            </tbody>
        </table>
    </div>

</div>
</x-layout>

<?php
$list = [
    '#'=>'Danh sách nhân viên',
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>

<div>
    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Danh sách nhân viên</legend>

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
                    <th>Stt</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($danhSachNhanVien as $key =>$nhanVien)
                    <tr>
                        <td>{{$key +1}}</td>
                        <td><a href="{{route('nhan-vien.show', $nhanVien)}}">{{$nhanVien->name}}</a></td>
                        <td>{{$nhanVien->email}}</td>

                        <td>

                            <a href="{{route('nhan-vien.show', $nhanVien)}}" >
                                <span class="material-symbols-outlined fs-3" title="Xem">
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

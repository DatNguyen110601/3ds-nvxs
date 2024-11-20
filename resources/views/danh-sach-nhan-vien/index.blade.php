<?php
$list = [
    '#'=>'Danh sách nhân viên',
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>

<div>
    <div class=" d-flex justify-content-between mb-3 mt-4">
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

    <div class="table-responsive">

        <table class="table  table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Stt</th>
                    <th>Họ tên</th>
                    <th>Phòng ban</th>
                    <th>Email</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($danhSachNhanVien as $key =>$nhanVien)
                    <tr>
                        <td>{{$key +1}}</td>
                        <td><a href="{{route('nhan-vien.show', $nhanVien)}}">{{$nhanVien->name}} <br>
                            <span style="color: #565555; font-size:13px;">
                                @foreach ($nhanVien->viTri as $item)
                                    ({{$item->ten_vi_tri}})
                                @endforeach
                            </span></a></td>
                            <td>
                                @foreach ($nhanVien->viTri as $item)
                                    {{$item->phong_ban}}
                                @endforeach
                            </td>
                        <td>{{$nhanVien->email}}</td>

                        <td>

                            <a href="{{route('nhan-vien.show', $nhanVien)}}" >
                                <span class="material-symbols-outlined fs-3" title="Xem">
                                    table_eye
                                </span>
                                </a>

                            {{-- <a href="" title=Sửa>
                                <span class="material-symbols-outlined fs-3"  style="color: #0dcaf0;">
                                    border_color
                                </span>
                            </a>
                            <a href="" title="Xóa">
                                <span class="material-symbols-outlined fs-3 " style="color: red;" title="Xóa">
                                    delete
                                </span>
                            </a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</x-layout>

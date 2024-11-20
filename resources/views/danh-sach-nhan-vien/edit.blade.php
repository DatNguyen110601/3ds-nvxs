<?php
$list = [
    route('nhan-vien.index') =>'Danh mục nhân viên',
    '#' => 'Sửa nhân viên'
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>

<div class=" d-flex justify-content-between mb-3 mt-4">
    <legend class="legend">Sửa nhân viên {{$danhSachNhanVien->ho_ten}}</legend>
</div>
    <div class="col-6">
    <form action="{{route('nhan-vien.store')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="" class="form-lable">Họ tên</label>
            <input type="text" name="ho_ten" id="ho_ten" value="{{$danhSachNhanVien->ho_ten}}" class="form-control"/>
        </div>
        <div  class="mb-3">
            <label for="" class="form-lable">Email</label>
            <input type="text" name="email" id="email" value="{{$danhSachNhanVien->user->email}}" class="form-control"/>
        </div>
        <div  class="mb-3">
            <label for="" class="form-lable">Mật khẩu</label>
            <input type="text" name="mat_khau" id="mat_khau" class="form-control"/>
        </div>
        <input type="submit" value="Thêm mới"/>

    </form>
</div>
</x-layout>

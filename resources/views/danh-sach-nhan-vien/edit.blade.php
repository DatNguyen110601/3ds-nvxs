<?php
$list = [
    route('home') =>'Trang chủ',
    route('nhan-vien.index') =>'Danh mục nhân viên',
    '#' => 'Sửa nhân viên'
];
?>
<style>
    .btn-primary{
        background: #0a58ca !important;
    }
</style>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>

<div class=" d-flex justify-content-between mb-3 mt-4">
    <legend class="legend">Sửa nhân viên {{$danhSachNhanVien->ho_ten}}</legend>
</div>
    <div class="col-6">
    <form action="{{route('nhan-vien.update', ['danhSachNhanVien' =>$danhSachNhanVien])}}" method="post">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="" class="form-lable">Họ tên</label>
            <input type="text" name="name" id="name" value="{{$danhSachNhanVien->name}}" class="form-control"/>
        </div>
        <div  class="mb-3">
            <label for="" class="form-lable">Email</label>
            <input type="text" name="email" id="email" value="{{$danhSachNhanVien->email}}" class="form-control"/>
        </div>
        <div  class="mb-3">
            <label for="" class="form-lable">Mật khẩu</label>
            <input type="text" name="mat_khau" id="mat_khau" class="form-control"/>
        </div>
        <input type="submit" class="btn btn-primary" value="Cập nhật"/>

    </form>
</div>
</x-layout>

<?php
$list = [
    route('nhan-vien.index') =>'Danh mục nhân viên',
    '#' => 'Thêm nhân viên'
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb" style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

<div class=" d-flex justify-content-between mb-2">
    <legend class="legend">Thêm nhân viên</legend>
</div>
    <div class="col-6">
    <form action="{{route('nhan-vien.store')}}" method="post">
        @csrf
        <div class="input-group mb-3">
            <span for="ho_ten" class="input-group-text">Họ tên</span>
            <input type="text" name="ho_ten" id="ho_ten" class="form-control"/>

        </div>

        <div class="input-group mb-3">
            <span for="ho_ten" class="input-group-text">Email</span>
            <input type="email" name="email" id="email"  class="form-control"/>
        </div>

        <div class="input-group mb-3">
            <span for="mat_khau" class="input-group-text">Mật khẩu</span>
            <input type="text" name="mat_khau" id="mat_khau"  class="form-control"/>

        </div>

        <input type="submit" value="Thêm mới"/>

    </form>
</div>
</x-layout>

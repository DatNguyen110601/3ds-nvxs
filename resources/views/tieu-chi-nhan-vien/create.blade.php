<?php
$list = [
    route('tieu-chi-nhan-vien.index') =>'Danh sách tiêu chí',
    '#' => 'Thêm tiêu chí'
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb" style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>
    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Thêm tiêu chí</legend>
    </div>

<div class="col-6">
    <form action="{{route('tieu-chi-nhan-vien.store')}}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <span for=""  class="input-group-text">Tên tiêu chí</span>
            <input type="text" name="ten_tieu_chi" class="form-control"/>
        </div>
        <div class="input-group mb-3">
            <span for="" class="input-group-text">Điểm tối đa</span>
            <input type="number" name="diem_toi_da" class="form-control"/>
        </div>
        <div class="input-group mb-3">
            <span for="" class="input-group-text">Điểm tối thiểu</span>
            <input type="number" name="diem_toi_thieu" class="form-control"/>
        </div>
        <div class="input-group mb-3">
            <span for="" class="input-group-text">Hệ số</span>
            <input type="text" name="he_so" class="form-control"/>
        </div>
        <div class="input-group mb-3">
            <span for="" class="input-group-text">Hoạt động</span>

            <select name="trang_thai" id="trang_thai" class="form-control">
                <option value="1">Hoạt động</option>
                <option value="0">Tắt</option>
            </select>

        </div>
        <input type="submit" value="Thêm" />
    </form>
</div>
</x-layout>

<?php
$list = [
    route('home') =>'Trang chủ',
    route('danh-muc-thang-nam.index') =>'Danh mục tháng năm',
    '#' => "Sửa danh mục tháng {$danhMucThangNam->thang} năm {$danhMucThangNam->nam}"
];
?>
<style>
    .btn-primary{
        background: #0a58ca !important;
    }
</style>
<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb" style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

<div  class="col-6">


    <div class="form-wrapper">
        <legend class="legend mb-4">Sửa danh mục tháng năm</legend>


    <form action="{{route('danh-muc-thang-nam.update',$danhMucThangNam)}}" method="POST">
        @method('PUT')
        @csrf
        <div class="mb-4">
            <label for="nam" class="form-label">Chọn năm</label>
            <select name="nam" id="nam" class="form-control">

                @foreach (range(2023, 2040) as $nam)
                    @if (old('nam', $danhMucThangNam->nam == $nam))
                        <option value="{{$nam}}" selected>{{$nam}}</option>
                    @else
                        <option value="{{$nam}}">{{$nam}}</option>
                @endif
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="nam" class="form-label">Chọn tháng</label>

            <select name="thang" id="thang" class="form-control">

                @foreach (range(1, 12) as $thang)
                @if(old('thang', $danhMucThangNam->thang == $thang))
                    <option value="{{$thang}}" selected>{{$thang}}</option>
                @else
                    <option value="{{$thang}}">{{$thang}}</option>
                @endif
                @endforeach
            </select>
        </div>

        <input type="submit" class="btn btn-primary" value="Cập nhật"/>
    </form>
    </div>
</div>
</x-layout>

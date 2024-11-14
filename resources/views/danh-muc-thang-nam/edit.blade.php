<?php
$list = [
    route('danh-muc-thang-nam.index') =>'Danh mục tháng năm',
    '#' => "Sửa danh mục tháng {$danhMucThangNam->thang} năm {$danhMucThangNam->nam}"
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb" style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

<div  class="col-6">
    <form action="{{route('danh-muc-thang-nam.update',$danhMucThangNam)}}" method="POST">
        @method('PUT')
        @csrf
        <div class="input-group mb-3">
            <span for="nam" class="input-group-text">Chọn năm</span>
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

        <div class="input-group mb-3">
            <span for="thang" class="input-group-text">Chọn tháng</span>
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
        <button type="button" class="bg-current text-red-600 ">

        </button>
        <input type="submit" value="Cập nhật"/>
    </form>
</div>
</x-layout>

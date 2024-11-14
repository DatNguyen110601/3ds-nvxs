<?php
$list = [
    route('danh-muc-thang-nam.index') =>'Danh mục tháng năm',
    '#' => 'Thêm danh mục tháng năm'
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb"   style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>


<div class="col-6">
    {{-- <legend class="legend">Danh mục tháng năm</legend> --}}
    <form action="{{route('danh-muc-thang-nam.store')}}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <span for="nam" class="input-group-text">Chọn năm</span>
            <select class="form-control" name="nam" id="nam">

                @foreach (range(2023, 2040) as $nam)
                    <option value="{{$nam}}">{{$nam}}</option>
                @endforeach
            </select>
        </div>

        <div class="input-group mb-3">
            <span for="thang" class="input-group-text">Chọn tháng</span>

            <select name="thang" id="thang" class="form-control">

                @foreach (range(1, 12) as $thang)
                    <option value="{{$thang}}">Tháng {{$thang}}</option>
                @endforeach
            </select>
        </div>
        <input type="submit" class="bg-sky-500/100" value="Thêm"/>
    </form>
</div>
</x-layout>

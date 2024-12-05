<?php
$list = [
    route('home') =>'Trang chủ',
    route('danh-muc-thang-nam.index') =>'Danh mục tháng năm',
    '#' => 'Thêm danh mục tháng năm'
];
?>

<style>
    .btn-primary{
        background: #0a58ca !important;
    }
</style>
<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"   style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

    <div class="col-6">
        <div class="">
            <div class="form-wrapper">
                <legend class="legend mb-4">Thêm danh mục tháng năm</legend>

                <form action="{{route('danh-muc-thang-nam.store')}}" method="POST" id="yearForm" novalidate>
                    @csrf
                    <div class="mb-4">
                        <label for="nam" class="form-label">Năm</label>
                        <select class="form-control" name="nam" id="yearSelect" required >
                            <option value="" selected disabled>Chọn năm</option>
                        </select>
                        <div class="invalid-feedback" id="yearError" role="alert">
                            Hãy chọn năm!
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>


    {{-- <form action="{{route('danh-muc-thang-nam.store')}}" method="POST">
        @csrf
        <div class="form-container">
            <div class="form-group">
                <label for="nam">Chọn năm</label>
                <select id="nam" class="form-control" name="nam"  id="nam">

                    @foreach (range(2023, 2040) as $nam)
                        <option value="{{$nam}}">{{$nam}}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" class="bg-sky-500/100" value="Thêm"/>


        </div>
    </form> --}}



    {{-- <legend class="legend">Danh mục tháng năm</legend> --}}
    {{-- <form action="{{route('danh-muc-thang-nam.store')}}" method="POST">
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
    </form> --}}





@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const yearSelect = document.getElementById("yearSelect");
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i <= currentYear + 20; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            yearSelect.appendChild(option);
        }

        document.getElementById("yearForm").addEventListener("submit", (event) => {
            if (!yearSelect.value) {
                event.preventDefault();
                yearSelect.classList.add("is-invalid");
            }
        });
    });
</script>

@endpush
</x-layout>

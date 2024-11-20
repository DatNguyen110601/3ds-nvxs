<?php
$list = [
    route('tieu-chi-nhan-vien.index') =>'Danh sách tiêu chí',
    '#' => 'Thêm tiêu chí'
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
    <div class=" d-flex justify-content-between mb-3 mt-4">
        <legend class="legend">Thêm tiêu chí</legend>
    </div>

<div class="col-6">

    <div class="container">
        <form action="{{route('tieu-chi-nhan-vien.store')}}" method="POST" id="formTieuChi">
            @csrf
            <div class="form-group mb-3">
                <label for="" >Tên tiêu chí</label>
                <input type="text" name="ten_tieu_chi" value="{{old('ten_tieu_chi')}}" class="form-control" placeholder="Tên tiêu chí"/>
            </div>
            @error('ten_tieu_chi')
                <p style="color: red;">
                    {{ $message }}
                </p>
            @enderror
            <div class="form-group mb-3">
                <label for="" >Điểm tối thiểu</label>
                <input type="number" name="diem_toi_thieu" id="diem_toi_thieu" value="{{old('diem_toi_thieu')}}" class="form-control" placeholder="Điểm tối thiểu"/>
                <div class="invalid-feedback" id="yearError" role="alert">
                    Điểm tối đa phải lớn hơn điểm tối thiểu!
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="" >Điểm tối đa</label>
                <input type="number" name="diem_toi_da" id="diem_toi_da"  value="{{old('diem_toi_da')}}"  class="form-control" placeholder="Điểm tối đa"/>

            </div>

            <div class="form-group mb-3">
                <label for="" >Hệ số</label>
                <input type="text" name="he_so" class="form-control"  value="{{old('he_so')}}"  placeholder="Hệ số"/>
            </div>
            <div class="form-group mb-3">
                <label for="">Hoạt động</label>

                <select name="trang_thai" id="trang_thai" class="form-control">
                    <option value="1">Hoạt động</option>
                    <option value="0">Tắt</option>
                </select>

            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </div>

</div>

@push('scripts')
    <script>
        document.getElementById("formTieuChi").addEventListener("submit", (event) => {
            const diemToiThieu = document.getElementById("diem_toi_thieu");
            const diemToiDa = document.getElementById("diem_toi_da");

            if (diemToiThieu.value > diemToiDa.value) {
                event.preventDefault();
                diemToiThieu.classList.add("is-invalid");
            }
        });
    </script>
@endpush
</x-layout>

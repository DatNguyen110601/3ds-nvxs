<?php
$list = [
    route('danh-muc-thang-nam.index')=>'Danh mục tháng năm',
    route('danh-muc-thang-nam.show', [
        'danhMucThangNam' =>$danhMucThangNam,
        'diemThang' => $diemThang]) => "Nhân viên tháng {$danhMucThangNam->thang}",
        '#' => "Chấm điểm nhân viên {$nhanVien->ho_ten}"
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>
    <div class=" d-flex justify-content-between mb-3 mt-4">
        <legend class="legend">Chấm điểm nhân viên {{$nhanVien->ho_ten}}</legend>
    </div>


        <form action="{{route('diem-theo-tieu-chi.store', ['danhMucThangNam' =>$danhMucThangNam, 'nhanVien' =>$nhanVien, 'diemThang' => $diemThang])}}" method="POST">
            @csrf
        {{-- <div class="mt-10 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-6"> --}}
            <div class="col-6">
            @if (!empty($tieuChiTheoThang))
                @foreach ($tieuChiTheoThang as $tieuChi)
                <div class="row">
                    <div class="col-6 input-group mb-3">
                        <span for="first-name" class="input-group-text">{{$tieuChi->tenTieuChi->ten_tieu_chi}}</span>

                            <input type="number" name="inputs[{{$tieuChi->id_tieu_chi}}]" id="input-{{$tieuChi->id}}"
                            min="{{$tieuChi->tenTieuChi->diem_toi_thieu}}" max="{{$tieuChi->tenTieuChi->diem_toi_da}}"class="form-control"/>
                        {{-- <input type="number" name="{{$tieuChi->id}}" id="" autocomplete="given-name" class="block w-1/2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"> --}}

                    </div>
                </div>


                @endforeach

            @endif

                <input type="submit" value="Thêm"/>
        </div>
        </form>

@push('script')


@endpush
</x-layout>

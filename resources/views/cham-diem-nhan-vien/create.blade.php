<?php
$list = [
    route('danh-muc-thang-nam.index')=>'Danh mục tháng năm',
    route('danh-muc-thang-nam.show', [
        'danhMucThangNam' =>$danhMucThangNam]) => "Nhân viên tháng {$danhMucThangNam->thang}",
        '#' => "Chấm điểm nhân viên {$nhanVien->name}"
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
    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Chấm điểm nhân viên {{$nhanVien->name}}</legend>
    </div>

    <div class="container mt-3">
        <form action="{{route('cham-diem-nhan-vien.store', ['danhMucThangNam' =>$danhMucThangNam, 'nhanVien' =>$nhanVien, 'diemThang' =>$diemThang])}}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tiêu chí</th>
                            <th>Thang điểm</th>
                            <th>Điểm đạt được</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($diemTheoTieuChi))
                        @foreach ($diemTheoTieuChi as $tieuChi)
                            <tr class="text-center">
                                <td>{{$tieuChi->tenTieuChi->ten_tieu_chi}}</td>
                                {{-- <td><input type="number" name="thang_diem[]" class="form-control" placeholder="Thang điểm" required></td> --}}
                                <td>
                                    {{$tieuChi->tenTieuChi->diem_toi_thieu}} - {{$tieuChi->tenTieuChi->diem_toi_da}}
                                </td>
                                {{-- <td><input type="number" name="diem_dat_duoc[]" class="form-control" placeholder="Điểm đạt được" required></td> --}}
                                <td>
                                    <input type="number" name="inputs[{{$tieuChi->id_tieu_chi}}]" id="input-{{$tieuChi->id}}" placeholder="Điểm đạt được"
                                    min="{{$tieuChi->tenTieuChi->diem_toi_thieu}}" max="{{$tieuChi->tenTieuChi->diem_toi_da}}"class="form-control" required/>

                                </td>
                            </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Lưu đánh giá</button>
            </div>
        </form>
    </div>





<?php /*

        <form action="{{route('cham-diem-nhan-vien.store', ['danhMucThangNam' =>$danhMucThangNam, 'nhanVien' =>$nhanVien, 'diemThang' =>$diemThang])}}" method="POST">
            @csrf
        {{-- <div class="mt-10 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-6"> --}}
            <div class="col-6">
            @if (!empty($diemTheoTieuChi))
                @foreach ($diemTheoTieuChi as $tieuChi)
                <div class="row">
                    <div class="col-6 input-group mb-3">
                        <span for="first-name" class="input-group-text">{{$tieuChi->tenTieuChi->ten_tieu_chi}}</span>

                            <input type="number" name="inputs[{{$tieuChi->id_tieu_chi}}]" id="input-{{$tieuChi->id}}"
                            min="{{$tieuChi->tenTieuChi->diem_toi_thieu}}" max="{{$tieuChi->tenTieuChi->diem_toi_da}}"class="form-control" required/>
                        {{-- <input type="number" name="{{$tieuChi->id}}" id="" autocomplete="given-name" class="block w-1/2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"> --}}

                    </div>
                </div>


                @endforeach

            @endif

                <input type="submit" value="Thêm"/>
        </div>
        </form>
 */?>
@push('script')


@endpush
</x-layout>

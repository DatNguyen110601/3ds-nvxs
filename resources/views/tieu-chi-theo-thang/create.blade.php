<?php
$list = [
    route('home') =>'Trang chủ',
    route('tieu-chi-theo-thang.index')=>'Danh sách tiêu chí theo tháng',
    '#' => 'Thêm tiêu chí tháng'
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
        <legend class="legend">Thêm tiêu chí tháng</legend>
    </div>
    <div class="col-6">
        <form action="{{route('tieu-chi-theo-thang.store')}}" method="POST">
            @csrf

            <div class="mb-3">
                <select name="id_thang_nam" id="id_thang_nam" class="form-control">
                    @foreach ($danhMucThangNam as $danhMuc)
                    @if (count($danhMuc->dsTieuChiThang) == 0)
                        <option value="{{$danhMuc->id}}">Năm {{$danhMuc->nam}} Tháng {{$danhMuc->thang}}</option>
                    @endif
                    @endforeach

                </select>
            </div>

            <div class="col-12">
                <table class="table  table-bordered mt-5">
                    <thead class="table-light">
                        <tr>

                            <th class="w-20">
                                <input class="form-check-input" name="toggleChon[]" type="checkbox" onchange="toggleChonCheckBox()" id="flexCheckDefault">
                            </th>

                            <th>STT</th>
                            <th>Tên tiêu chí</th>
                            <th>Điểm tối thiểu</th>
                            <th>Điểm tối đa</th>
                            <th>Hệ số</th>
                            {{-- <th>Trạng thái</th> --}}

                        </tr>
                    </thead>
                    <tbody class="text-center">

                        @foreach ($dsTieuChi as $key => $tieuChi)
                        <tr>
                            <td class="text-center">
                                <input class="form-check-input" name="check_tieu_chi[]" type="checkbox" value="{{$tieuChi->id}}" id="flexCheckDefault">
                            </td>
                            <td>{{$key +1}}</td>
                            <td>{{$tieuChi->ten_tieu_chi}}</td>
                            <td>{{$tieuChi->diem_toi_thieu}}</td>
                            <td>{{$tieuChi->diem_toi_da}}</td>
                            <td>{{$tieuChi->he_so}}</td>
                            {{-- <td>{{$tieuChi->trang_thai}}</td> --}}

                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="mb-3">
                <label for="nhan-vien" >Chọn nhân viên</label>
                <select name="nhan-vien[]" id="nhan-vien" multiple>
                    @foreach ($dsNhanVien as $nhanVien)
                        <option value="{{$nhanVien->id}}">@foreach ($nhanVien->viTri as $viTri)
                           {{$viTri->phong_ban}}
                        @endforeach - {{$nhanVien->name}} </option>
                    @endforeach
                </select>


                <?php /* $arrIDOldNhom = old('id_nhom') == null ? [] : old('id_nhom'); */ ?>

            </div>
            <div  class="input-group mb-3">
                <input type="checkbox" name="tat_ca_nhan_vien" checked class="form-check-input"/>
                <span class="ms-1"> Tất cả nhân viên</span>
            </div>

            <input type="submit" class="btn btn-primary" value="Thêm"/>
        </form>
    </div>

@push('scripts')


<script type="text/javascript">
    $("#nhan-vien").selectize({
        valueField: 'id',
        labelField: 'text',
        searchField: 'text'
    });

</script>
<script>
    let toggleChon = 0;

    function toggleChonCheckBox() {
        if (toggleChon == 0) {
            selects();
            toggleChon = 1;
        } else {
            deSelect();
            toggleChon = 0;
        }
    }

    function selects() {
        var ele = document.getElementsByName('check_tieu_chi[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = true;
        }
    }

    function deSelect() {
        var ele = document.getElementsByName('check_tieu_chi[]');
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = false;
        }
    }
</script>
@endpush
    </x-layout>


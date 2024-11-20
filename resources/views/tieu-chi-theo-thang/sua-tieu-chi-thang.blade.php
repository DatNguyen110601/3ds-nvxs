<?php
$list = [
    route('tieu-chi-theo-thang.index')=>'Danh sách tiêu chí theo tháng',
    route('tieu-chi-theo-thang.show', ['danhMucThangNam' => $danhMucThangNam])
     => "Tiêu chí năm {$danhMucThangNam->nam}/ tháng {$danhMucThangNam->thang}",
    '#' => 'Sửa tiêu chí'
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
        <legend class="legend">Sửa tiêu chí tháng {{$danhMucThangNam->thang}} (năm {{$danhMucThangNam->nam}})</legend>
    </div>
    <div class="col-6">
        <form action="{{route('tieu-chi-theo-thang.update-tieu-chi-thang', ['danhMucThangNam' =>$danhMucThangNam,
                                                            'id_thang_nam'=> $tieuChiTheoThang->id_thang_nam ,
                                                            'id_tieu_chi'=> $tieuChiTheoThang->id_tieu_chi,
                                                            ])}}" method="POST">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <select name="id_thang_nam" id="id_thang_nam" class="form-control">
                        <option value="{{$danhMucThangNam->id}}">Năm {{$danhMucThangNam->nam}} Tháng {{$danhMucThangNam->thang}}</option>
                </select>
            </div>

            <div class="table-responsive">

                <table class="table  table-bordered">
                    <thead class="table-light">
                        <tr>

                            <th class="w-20">
                                <input class="form-check-input" name="toggleChon[]" type="checkbox" onchange="toggleChonCheckBox()" id="flexCheckDefault">
                            </th>


                            <th>Tên tiêu chí</th>
                            <th>Điểm tối đa</th>
                            <th>Điểm tối thiểu</th>
                            <th>Hệ số</th>
                            {{-- <th>Trạng thái</th> --}}

                        </tr>
                    </thead>
                    <tbody class="text-center">


                        <tr>
                            <td class="text-center">
                                <input class="form-check-input" name="check_tieu_chi[]" type="checkbox" value="{{$tieuChiTheoThang->id_tieu_chi}}" id="flexCheckDefault" checked>
                            </td>

                            <td>{{$tieuChiTheoThang->tenTieuChi->ten_tieu_chi}}</td>
                            <td>{{$tieuChiTheoThang->tenTieuChi->diem_toi_da}}</td>
                            <td>{{$tieuChiTheoThang->tenTieuChi->diem_toi_thieu}}</td>
                            <td>{{$tieuChiTheoThang->tenTieuChi->he_so}}</td>
                            {{-- <td>{{$tieuChiTheoThang->tenTieuChi->trang_thai}}</td> --}}

                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="mb-3">
                <label for="nhan-vien" >Chọn nhân viên</label>
                <select name="nhan-vien[]" id="nhan-vien" multiple>
                    @foreach ($dsNhanVien as $nhanVien)

                    <?php
                        $isChecked = $diemThang->contains(function ($diem) use ($nhanVien, $tieuChiTheoThang){
                            $tieuChi = $diem->diemTheoTieuChi->where('id_tieu_chi', $tieuChiTheoThang->id_tieu_chi);

                            if ($tieuChi) {
                                return $tieuChi->isNotEmpty() && $nhanVien->id == $diem->id_nhan_vien;
                            }

                        });
                    ?>

                        <option value="{{$nhanVien->id}}" {{ $isChecked ? 'selected' : '' }}>
                            @foreach ($nhanVien->viTri as $viTri)
                            {{$viTri->phong_ban}}
                            @endforeach - {{$nhanVien->name}}
                        </option>
                    @endforeach
                </select>


                <?php /* $arrIDOldNhom = old('id_nhom') == null ? [] : old('id_nhom'); */ ?>

            </div>
            <div  class="input-group mb-3">
                <input type="checkbox" name="tat_ca_nhan_vien" class="form-check-input"/>
                <span class="ms-1"> Tất cả nhân viên</span>
            </div>

            <input type="submit" class="btn btn-primary" value="Cập nhật"/>
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


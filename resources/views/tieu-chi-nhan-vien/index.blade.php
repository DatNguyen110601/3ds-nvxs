
<?php
$list = [
    route('home') =>'Trang chủ',
    '#'=>'Danh sách tiêu chí',
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>


<div>
    <div class=" d-flex justify-content-between mb-3 mt-4">
        <legend class="legend">Danh sách tiêu chí</legend>
        <div>
            @can('add_danh_sach_tieu_chi')
                <a href="{{route('tieu-chi-nhan-vien.create')}}" class="btn btn-primary">
                    <span class="material-symbols-outlined" >
                        add_task
                    </span>
                    Thêm</a>
            @endcan
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
        {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
        </div>
    @endif
    <div class="table-responsive">

        <table class="table  table-bordered">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th style="min-width:200px;">Tên tiêu chí</th>
                    <th style="width:500px;">Mô tả</th>
                    <th>Điểm tối thiểu</th>
                    <th>Điểm tối đa</th>
                    <th>Hệ số</th>
                    <th>Trạng thái</th>
                    <th>Hoạt động</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @if (count($dsTieuChi)!=0)
                    @foreach ($dsTieuChi as $key => $tieuChi)

                    <tr>
                        <td>{{$key +1}}</td>
                        <td>{{$tieuChi->ten_tieu_chi}}</td>
                        <td>{{$tieuChi->mo_ta}}</td>

                        <td>{{$tieuChi->diem_toi_thieu}}</td>
                        <td>{{$tieuChi->diem_toi_da}}</td>
                        <td>{{$tieuChi->he_so}}</td>
                        {{-- <td>{{$tieuChi::$dsTrangThai[$tieuChi->trang_thai]}}</td> --}}
                        <td>
                            @if ($tieuChi->trang_thai == 1)
                                <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;" title="Hoạt động">
                                    toggle_on
                                </span>
                            @else
                            <span class="material-symbols-outlined fs-3" title="Tắt">
                                toggle_off
                            </span>
                            @endif

                        </td>
                        <td>
                            @can('edit_danh_sach_tieu_chi')
                                <a href="{{route('tieu-chi-nhan-vien.edit', $tieuChi)}}">
                                    <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;" title="Sửa">
                                        border_color
                                    </span>
                                </a>
                            @endcan
                            @can('delete_danh_sach_tieu_chi')
                                <?php

                                $url = route('tieu-chi-nhan-vien.delete', ['danhSachTieuChi' => $tieuChi]);

                                ?>
                                <button type="button" onclick="xoaTieuChi('{{$url}}')">
                                    <span class="material-symbols-outlined fs-3 " style="color: red;" title="Xóa">
                                        delete
                                    </span>
                                </button>
                            @endcan

                    </td>
                    </tr>
                    @endforeach

                @else
                <tr>
                    <td colspan="7"  style="background:darkgray;">Chưa có tiêu chí nào</td>
                </tr>
                @endif

            </tbody>


        </table>
    </div>
</div>


<form action="" method="POST" class="col-6" id="frm_xoa_thong_tin">
    @method('DELETE')
    @csrf
</form>

@push('scripts')
    <script type="text/javascript">
    function xoaTieuChi(url){
        if (!confirm(`Xóa tiêu chí này khỏi danh sách?`)) {
            return false;
        }

        const formXoa = document.getElementById('frm_xoa_thong_tin');
        formXoa.action = url;
        formXoa.submit();
    }
    </script>
@endpush
</x-layout>


<?php
$list = [
    route('home') =>'Trang chủ',
    route('tieu-chi-theo-thang.index')=>'Danh sách tiêu chí theo tháng',
    '#' => "Tiêu chí năm {$danhMucThangNam->nam}/ tháng {$danhMucThangNam->thang}"
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>

    <div>
        <div class=" d-flex justify-content-between mb-3 mt-4">
            <legend class="legend">Tiêu chí tháng {{$danhMucThangNam->thang}}</legend>
            <div class="mb-2">

                @can('add_tieu_chi_theo_thang')

                    <a href="{{route('tieu-chi-theo-thang.them-tieu-chi-thang', ['danhMucThangNam' => $danhMucThangNam])}}" class="btn btn-primary">
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
                        <th>Tên tiêu chí</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($tieuChiTheoThang) != 0)
                        @foreach ($tieuChiTheoThang  as $key =>$tieuChi)

                        <tr>
                            <td>{{$key +1}}</td>
                            <td>{{$tieuChi->tenTieuChi->ten_tieu_chi}}</td>
                            <td>
                                @can('edit_tieu_chi_theo_thang')
                                    <a href="{{route('tieu-chi-theo-thang.sua-tieu-chi-thang', ['danhMucThangNam' =>$danhMucThangNam,
                                        'id_thang_nam'=> $tieuChi->id_thang_nam ,
                                        'id_tieu_chi'=> $tieuChi->id_tieu_chi,
                                        ])}}">
                                    <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;" title="Sửa">
                                    border_color
                                    </span>
                                    </a>
                                @endcan

                                @can('delete_tieu_chi_theo_thang')
                                    <?php

                                        $url = route('tieu-chi-theo-thang.delete', ['id_thang_nam' => $tieuChi->id_thang_nam, 'id_tieu_chi' => $tieuChi->id_tieu_chi]);

                                    ?>
                                    <button type="button" onclick="xoaTieuChi('{{$url}}')">
                                        <span class="material-symbols-outlined fs-3 " style="color: red;" title="Xóa">
                                            delete
                                        </span>
                                    </button>
                                @endcan

                                    {{-- <a href="" title="Xóa">
                                        <span class="material-symbols-outlined fs-3 " style="color: red;" title="Xóa">
                                            delete
                                        </span>
                                    </a> --}}
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" style="background: darkgray">Không có tiêu chí nào</td>
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
        if (!confirm(`Xóa tiêu chí này?`)) {
            return false;
        }

        const formXoa = document.getElementById('frm_xoa_thong_tin');
        formXoa.action = url;
        formXoa.submit();
    }
    </script>
@endpush
</x-layout>

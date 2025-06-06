<?php
$list = [
    route('home') =>'Trang chủ',
    route('danh-muc-thang-nam.index')=>'Danh mục tháng năm',
    '#' => "Nhân viên năm {$danhMucThangNam->nam}/ tháng {$danhMucThangNam->thang}"
];
?>


<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

    <div class=" d-flex justify-content-between mb-3 mt-4">
        <legend class="legend">Tiêu chí nhân viên tháng {{$danhMucThangNam->thang}}</legend>

        <div class="mb-2 mr-2">

            <a href="{{route('danh-muc-thang-nam.bieuDoDanhMucThangNam', ['danhMucThangNam' => $danhMucThangNam])}}"
                style="width:120px;" class="btn btn-warning" title="Biểu đồ">
                <span class="material-symbols-outlined" >
                    bar_chart
                </span>
                Biểu đồ</a>

        </div>
        @can('duyet_diem')
        <div class="mb-2">
            <a href="{{route('duyet.duyetDiemThangAll', ['danhMucThangNam' => $danhMucThangNam])}}" class="btn btn-success" title="Duyệt">
                <span class="material-symbols-outlined">
                    task_alt
                </span>
                Duyệt</a>
        </div>
        @endcan

        @can('export_excel')
        <div class="mb-2 ml-2">

            <a href="{{route('danh-muc-thang-nam.exportExcel', ['danhMucThangNam' => $danhMucThangNam])}}"
                style="width:160px;" class="btn btn-info" title="Tải file excel">
                <span class="material-symbols-outlined" >
                    download
                </span>
                Tải file excel</a>

        </div>
        @endcan

        @can('add_danh_muc_thang_nam')
        <div class="mb-2 ml-2">
            <a href="{{route('nhan-vien-trong-dmtn.create', ['danhMucThangNam' =>$danhMucThangNam])}}" class="btn btn-primary">
                <span class="material-symbols-outlined" >
                    add_task
                </span>
                Thêm</a>

        </div>
        @endcan

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
                    <th scope="col">STT</th>
                    <th scope="col">Tên Nhân Viên</th>
                    <th>Phòng Ban</th>
                    <th scope="col">Tổng điểm</th>
                    <th scope="col">Duyệt</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>


            @if(count($diemThang)!=0)

                <tbody class="text-center">
                @foreach ($diemThang as $key=>$value)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$value->nhanVien->name}}<br>
                            <span style="color: #565555; font-size:13px;">
                                @foreach ($value->nhanVien->viTri as $item)
                                    ({{$item->ten_vi_tri}})
                                @endforeach
                            </span>
                        </td>

                            <td>
                                @foreach ($value->nhanVien->viTri as $item)
                                    {{$item->phong_ban}}
                                @endforeach
                            </td>

                        <td>
                            @if ($value->tong_diem ==0)
                                <span style="color: #333333;">Chưa chấm</span>
                            @else
                                {{$value->tong_diem}}
                            @endif
                        </td>

                        @if ($value->diemTheoTieuChi->every(fn($duyet) => $duyet->duyet == 1))
                            <td>
                                <span class="material-symbols-outlined fs-3" style="color: #198754">
                                    check
                                </span>
                            </td>
                        @else
                            <td>
                                <span class="material-symbols-outlined fs-3" >
                                    more_horiz
                                </span>
                            </td>
                        @endif
                        <td>
                            <a href="{{route('danh-muc-thang-nam.xem-diem-nhan-vien-thang',
                                ['danhMucThangNam' =>$danhMucThangNam,
                                'nhanVien' => $value->nhanVien,
                                ]
                                )}}" title="Xem" >
                                <span class="material-symbols-outlined fs-3">
                                    table_eye
                                </span>
                            </a>

                            <?php /*
                            @can('add_edit_diem')
                            <a href="{{route('cham-diem-nhan-vien.create',
                            [
                                'danhMucThangNam' =>$danhMucThangNam,
                                'nhanVien' => $value->nhanVien,

                            ])}}" title="Chấm điểm">

                            <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;">
                                border_color
                            </span>

                            </a>
                            @endcan

                            */?>
                            @can('add_edit_diem')

                                    @if ($value->tong_diem == 0)

                                        <a href="{{route('cham-diem-nhan-vien.create',
                                        [
                                            'danhMucThangNam' =>$danhMucThangNam,
                                            'nhanVien' => $value->nhanVien,

                                        ])}}" title="Chấm điểm"
                                        style="{{ $value->diemTheoTieuChi->every(fn($duyet) => $duyet->duyet == 0) ? '' : 'pointer-events: none; opacity: 0.5;' }}"
                                        >
                                        <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;">
                                            border_color
                                        </span>

                                        </a>
                                    @else
                                        <a href="{{route('cham-diem-nhan-vien.edit',
                                        [
                                            'danhMucThangNam' =>$danhMucThangNam,
                                            'nhanVien' => $value->nhanVien,

                                        ])}}" title="Chấm điểm"
                                        style="{{ $value->diemTheoTieuChi->every(fn($duyet) => $duyet->duyet == 0) ? '' : 'pointer-events: none; opacity: 0.5;' }}"
                                        >

                                        <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;">
                                            border_color
                                        </span>

                                        </a>
                                    @endif

                            @endcan

                            @can('duyet_diem')
                            @if ($value->diemTheoTieuChi->every(fn($duyet) => $duyet->duyet == 1))
                                <a href="{{route('duyet.removeDuyetDiemThang', ['danhMucThangNam' => $danhMucThangNam,
                                    'nhanVien' =>$value->nhanVien])}}" title="Bỏ duyệt"
                                    onclick="return confirmAction(event, 'Bạn có chắc chắn muốn BỎ DUYỆT?')">
                                    <span class="material-symbols-outlined fs-3" style="color: #bbb">
                                        task_alt
                                    </span>
                                </a>


                            @else
                                <a href="{{route('duyet.duyetDiemThang', ['danhMucThangNam' => $danhMucThangNam,
                                    'nhanVien' =>$value->nhanVien])}}" title="Duyệt"
                                    onclick="return confirmAction(event, 'Bạn có chắc chắn muốn DUYỆT?')">
                                    <span class="material-symbols-outlined fs-3" style="color: #198754">
                                    task_alt
                                    </span>
                                </a>
                            @endif

                            @endcan
                            @can('delete_nhan_vien_trong_dmtn')
                                <?php
                                $urlXoa = route('nhan-vien-trong-dmtn.delete', ['danhMucThangNam'=> $danhMucThangNam,
                                                                                'diemThang' => $value]);
                                ?>
                                <button type="button" class=" text-red-600 " onclick="xoaThongTin('{{$urlXoa}}')">
                                    <span class="material-symbols-outlined fs-3">
                                        delete
                                    </span>
                                </button>

                            @endcan

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center"  style="background:darkgray;">Chưa có thông tin tiêu chí nhân viên</td>
                </tr>
                </tbody>
            @endif

        </table>
    </div>

    <form action="" method="POST" class="col-6" id="frm_xoa_thong_tin">
        @method('DELETE')
        @csrf
    </form>

@push('scripts')
    <script type="text/javascript">
        function xoaThongTin(url) {

            if (!confirm(`Bạn muốn xóa nhân viên này?`)) {
                return false;
            }

            const formXoa = document.getElementById('frm_xoa_thong_tin');
            formXoa.action = url;
            formXoa.submit();
        }
    </script>
@endpush
</x-layout>

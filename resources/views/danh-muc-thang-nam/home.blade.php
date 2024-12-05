<?php
$list = [
    '/' => "Trang chủ",

];
?>
<style>
    .btn-info{
        background: #31d2f2 !important;
    }
    .alert-message {
    background-color: #ffdddd;
    color: #d9534f;
    border: 1px solid #d9534f;
    border-radius: 5px;
    padding: 15px 15px;
    margin-top: 30px;
    text-align: center;
}

</style>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

    <div>
        <form action="" method="GET" class="mb-3">
            <div class="d-flex">
                <div class="row g-3">
                    <div class="col-auto">
                        <input type="number" name="year" value="{{ $nam }}" class="form-control" placeholder="Nhập năm">
                    </div>
                    <div class="col-auto">
                        <input type="number" name="month" value="{{ $thang }}" class="form-control" placeholder="Nhập tháng">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-info">Tìm</button>
                    </div>
                </div>
            </div>

        </form>

    </div>



    @php
        $hasDiemThang = false; // Biến kiểm tra nếu có bất kỳ danh mục nào có diemThang khác 0
    @endphp
    @foreach ($danhMucThangNam as $danhMuc)
    @if (count($danhMuc->diemThang) !=0)

    @php
        $hasDiemThang = true;
    @endphp

        <div class=" d-flex justify-content-between mb-3 mt-4">

            <legend class="legend">Tiêu chí nhân viên tháng @if ($danhMuc!= null )
                {{$danhMuc->thang}}

                @endif
            </legend>

            @if ($danhMuc!= null)
            {{-- @can('duyet_diem') --}}

                <div class="mb-2">
                    <a href="{{route('duyet.duyetDiemThangAll', ['danhMucThangNam' => $danhMuc])}}" class="btn btn-success" title="Duyệt">
                        <span class="material-symbols-outlined">
                            task_alt
                        </span>
                        Duyệt</a>
                </div>

            {{-- @endcan --}}

            {{-- @can('export_excel') --}}
            <div class="mb-2 ml-2">

                <a href="{{route('danh-muc-thang-nam.exportExcel', ['danhMucThangNam' => $danhMuc])}}" class="btn btn-info" title="Tải file excel"
                    style="width:160px;">
                    <span class="material-symbols-outlined" >
                        download
                    </span>
                    Tải file excel</a>

            </div>
            {{-- @endcan --}}

            {{-- @can('add_danh_muc_thang_nam') --}}
            <div class="mb-2 ml-2">
                <a href="{{route('nhan-vien-trong-dmtn.create', ['danhMucThangNam' =>$danhMuc])}}" class="btn btn-primary">
                    <span class="material-symbols-outlined" >
                        add_task
                    </span>
                    Thêm</a>

            </div>
            {{-- @endcan --}}


            @endif
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
                        <th scope="col">Phòng ban</th>
                        <th scope="col">Tổng điểm</th>
                        <th scope="col">Duyệt</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>


                @if(!empty($danhMuc->diemThang))
                <tbody class="text-center">
                @foreach ($danhMuc->diemThang as $key=>$value)
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
                        <td>{{$value->tong_diem}}</td>
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
                                ['danhMucThangNam' =>$danhMuc,
                                'nhanVien' => $value->nhanVien,
                                ]
                                )}}" title="Xem" >
                                <span class="material-symbols-outlined fs-3">
                                    table_eye
                                </span>
                            </a>
                            @can('add_edit_diem')
                            <a href="{{route('cham-diem-nhan-vien.create',
                            [
                                'danhMucThangNam' =>$danhMuc,
                                'nhanVien' => $value->nhanVien,

                            ])}}" title="Chấm điểm">

                            <span class="material-symbols-outlined fs-3"  style="color: #0d6efd;">
                                contrast_square
                            </span>

                            </a>


                            @endcan

                            @can('duyet_diem')
                            @if ($value->diemTheoTieuChi->every(fn($duyet) => $duyet->duyet == 1))

                                    <span class="material-symbols-outlined fs-3" style="color: #bbb">
                                    task_alt
                                    </span>

                            @else
                                <a href="{{route('duyet.duyetDiemThang', ['danhMucThangNam' => $danhMuc,
                                    'nhanVien' =>$value->nhanVien])}}" title="Duyệt" >
                                    <span class="material-symbols-outlined fs-3" style="color: #198754">
                                    task_alt
                                    </span>
                                </a>
                            @endif

                            @endcan
                            @can('delete_nhan_vien_trong_dmtn')
                                <?php
                                        $urlXoa = route('nhan-vien-trong-dmtn.delete', ['danhMucThangNam'=> $danhMuc,
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
                </tbody>
            @endif

            </table>
        </div>

    @endif
    @endforeach

    @if (!$hasDiemThang)
        <div class=" alert-message">

            Không tìm thấy tiêu chí nhân viên
        </div>
    @endif

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

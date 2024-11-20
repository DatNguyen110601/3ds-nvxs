<?php
$list = [
    '#'=>'Danh mục tháng năm',
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

    <div class=" d-flex justify-content-between mb-3 mt-4">
        <legend class="legend font-normal">Danh mục tháng năm</legend>
        @can('add_danh_muc_thang_nam')
        <div>
            <a href="{{route('danh-muc-thang-nam.create')}}" class="btn btn-primary">
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
        <table class="table table-bordered">
            <thead class="table-light" >
                <tr>
                    <th scope="col">Stt</th>
                    <th scope="col">Năm</th>
                    <th scope="col">Tháng</th>
                    <th scope="col">Tiêu chí</th>
                    <th scope="col">Hành động</th>

                </tr>
            </thead>


            @if(!empty($danhMucThangNam))
            <tbody>
                @foreach ($danhMucThangNam as $key=>$danhMuc)

                    <tr class="text-center">
                        <td>{{$key+1}}</td>
                        <td>{{$danhMuc->nam}}</td>
                        <td><a href="{{route('danh-muc-thang-nam.show', $danhMuc)}}">{{$danhMuc->thang}}</a></td>
                        <td><a href="{{route('tieu-chi-theo-thang.show', $danhMuc)}}">{{count($danhMuc->dsTieuChiThang)}}</a></td>
                        <td>

                                <a href="{{route('danh-muc-thang-nam.show', $danhMuc)}}" title="Xem" >
                                    <span class="material-symbols-outlined fs-3">
                                        table_eye
                                    </span>
                                </a>

                            @can('edit_danh_muc_thang_nam')
                            <a href="{{route('danh-muc-thang-nam.edit', $danhMuc)}}" title="Sửa" >
                                <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;">
                                    border_color
                                </span>
                            </a>

                            <?php
                                $urlXoa = route('danh-muc-thang-nam.delete', ['danhMucThangNam'=> $danhMuc]);
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

<form action="" method="POST" class="col-6" id="frm_xoa_thong_tin">
    @method('DELETE')
    @csrf
</form>

@push('scripts')
<script type="text/javascript">
    function xoaThongTin(url) {

        if (!confirm(`Xóa thông tin này?`)) {
            return false;
        }

        const formXoa = document.getElementById('frm_xoa_thong_tin');
        formXoa.action = url;
        formXoa.submit();
    }
</script>

@endpush
</x-layout>

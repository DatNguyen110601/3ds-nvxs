
<?php
$list = [
    route('home') =>'Trang chủ',
    '#'=>'Danh sách tiêu chí theo tháng',
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>

    <div>
        <div class=" d-flex justify-content-between mb-3 mt-4">
            <legend class="legend">Danh sách tiêu chí theo tháng</legend>
            <div>
                @can('add_tieu_chi_theo_thang')
                <a href="{{route('tieu-chi-theo-thang.create')}}" class="btn btn-primary">
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
                        <th>Năm</th>
                        <th>Tháng</th>
                        <th>Tổng tiêu chí</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($danhMucThangNam as $key =>$danhMuc)
                    @if (count($danhMuc->dsTieuChiThang) != 0)
                    <tr>
                        <td>{{$key +1}}</td>
                        <td>{{$danhMuc->nam}}</td>
                        <td><a href="{{route('tieu-chi-theo-thang.show', $danhMuc)}}"><span>{{$danhMuc->thang}}</span></a></td>
                        <td>{{count($danhMuc->dsTieuChiThang)}}</td>
                        <td><a href="{{route('tieu-chi-theo-thang.show', $danhMuc)}}" >
                            <span class="material-symbols-outlined fs-3" title="Xem">
                                table_eye
                            </span>
                            </a>

                            {{-- <a href="{{route('tieu-chi-theo-thang.edit',['danhMucThangNam' =>$danhMuc])}}">
                                <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;" title="Sửa">
                                    border_color
                                </span>
                            </a> --}}

                            {{-- <a href="" title="Xóa">
                                <span class="material-symbols-outlined fs-3 " style="color: red;" title="Xóa">
                                    delete
                                </span>
                            </a> --}}

                        </td>
                    </tr>
                    @endif

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</x-layout>


<?php
$list = [
    '#'=>'Danh sách tiêu chí',
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>


<div>
    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Danh sách tiêu chí</legend>
        <div>

            <a href="{{route('tieu-chi-nhan-vien.create')}}" class="btn btn-primary">
                <span class="material-symbols-outlined" >
                    add_task
                </span>
                Thêm</a>
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
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên tiêu chí</th>
                    <th>Điểm tối đa</th>
                    <th>Điểm tối thiểu</th>
                    <th>Hệ số</th>
                    <th>Trạng thái</th>
                    <th>Hoạt động</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @foreach ($dsTieuChi as $key => $tieuChi)

                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$tieuChi->ten_tieu_chi}}</td>
                    <td>{{$tieuChi->diem_toi_da}}</td>
                    <td>{{$tieuChi->diem_toi_thieu}}</td>
                    <td>{{$tieuChi->he_so}}</td>
                    <td>{{$tieuChi::$dsTrangThai[$tieuChi->trang_thai]}}</td>
                    <td>
                        <a href="{{route('tieu-chi-nhan-vien.edit', $tieuChi)}}">
                            <span class="material-symbols-outlined fs-3" style="color: #0dcaf0;" title="Sửa">
                                border_color
                            </span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>


        </table>
    </div>
</div>
</x-layout>

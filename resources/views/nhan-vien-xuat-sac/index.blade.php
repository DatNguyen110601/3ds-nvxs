<?php
$list = [
    '#'=>'Nhân viên xuất sắc',
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>

    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Nhân viên xuất sắc</legend>

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
            <head style="color: #bcbccb; font-weight: 100;">
                <tr>
                    <th scope="col">Năm</th>
                    <th scope="col">Nhân viên xuất sắc</th>
                    <th scope="col">Hành động</th>

                </tr>
            </head>


            @if(!empty($top3TongDiems))
            <tbody>
                @foreach ($top3TongDiems as $danhMucId => $topGroups)

                    <tr class="text-center">
                        <?php $thangNam =  $danhMucThangNam->where('id',$danhMucId)->first() ?>
                        <td>Tháng {{ $thangNam->thang }} Năm {{ $thangNam->nam }}</td>

                        <td style="padding: 0px;" >

                                    @foreach ($topGroups as $tongDiem => $group)
                                    {{-- <li>Tong Diem: {{ $tongDiem }} - Số người: {{ count($group) }}</li> --}}
                                        <table class="table" style="margin: 0px;">

                                                    @foreach ($group as $diem)
                                                    @if ($diem->tong_diem != 0)
                                                    <tr>
                                                        <td>{{$diem->nhanVien->name}}</td>
                                                        <td>
                                                            {{ $diem->tong_diem }}
                                                            </td>
                                                    </tr>
                                                    @endif


                                                    @endforeach

                                        </table>

                                    @endforeach

                        </td>
                        {{-- <td><a href="{{route('danh-muc-thang-nam.show', $danhMuc)}}">{{$danhMuc->thang}}</a></td> --}}
                        {{-- <td><a href="{{route('tieu-chi-theo-thang.show', $danhMuc)}}">{{count($danhMuc->dsTieuChiThang)}}</a></td> --}}
                        <td>



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

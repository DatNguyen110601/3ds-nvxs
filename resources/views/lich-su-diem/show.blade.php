<?php
$list = [
    route('home') =>'Trang chủ',
    route('danh-muc-thang-nam.index')=>'Danh mục tháng năm',
    route('danh-muc-thang-nam.show', ['danhMucThangNam' => $danhMucThangNam,
                                    'diemThang' => $diemThang,])
                                    => "Nhân viên tháng {$danhMucThangNam->thang}",
    route('danh-muc-thang-nam.xem-diem-nhan-vien-thang', ['danhMucThangNam' => $danhMucThangNam,
                                'nhanVien' => $nhanVien,])
                                => "{$nhanVien->name}",

    '#' => "Lịch sử"
];
?>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
    </div>



    <div class=" d-flex justify-content-between mb-3 mt-4">
        <legend class="legend">Tiêu chí nhân viên tháng {{$danhMucThangNam->thang}} , {{$nhanVien->name}}</legend>
        {{-- <div class="mb-2">
            <a href="{{route('danh-muc-thang-nam.create')}}" class="btn btn-primary">
                <span class="material-symbols-outlined" >
                    add_task
                </span>
                Thêm</a>
        </div> --}}
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
    <div>
        @if ($lichSuDiemThang->isNotEmpty())
        <table class="table" style="border: 1px solid #000">

    @php
        // Lịch sử đầu tiên
        $firstLs = $lichSuDiemThang->first();
        // Danh sách tiêu chí
        $listTieuChi = $firstLs->lsDiemTheoTieuChi ?? collect();
    @endphp

    <thead>
        <tr>
            <th scope="col">Tiêu chí</th>

            {{-- Hiển thị ngày + Người chấm đúng 1 lần --}}
            @foreach ($lichSuDiemThang as $ls)
                <th scope="col" class="text-center">
                    {{ $ls->created_at->format('d-m-Y (H:i)') }} <br>
                    <small>Người chấm: {{ $ls->nguoiCham->name }}</small>
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody class="text-center">

        {{-- Chỉ duyệt tiêu chí 1 lần --}}
        @foreach ($listTieuChi as $index => $tc)
            <tr>
                <td>{{ $tc->tenTieuChi->ten_tieu_chi }}</td>

                {{-- Chỉ hiển thị điểm --}}
                @foreach ($lichSuDiemThang as $ls)
                    @php
                        $diem = $ls->lsDiemTheoTieuChi[$index];
                    @endphp

                    <td title="{{ $diem->ly_do ?? '-' }}">
                        {{ $diem->diem }}
                    </td>
                @endforeach
            </tr>
        @endforeach

        {{-- Tổng điểm của mỗi lịch sử --}}
        <tr class="bg-gray-200 font-bold">
            <td>Tổng điểm</td>
            @foreach ($lichSuDiemThang as $ls)
                <td>{{ $ls->tong_diem }}</td>
            @endforeach
        </tr>

    </tbody>
</table>
        @elseif ($lichSuDiemThang->isEmpty())
            <p class='text-danger p-3'>Không có dữ liệu lịch sử.</p>

            @endif


<?php /*
            <table class="table" style="border: 1px solid #000">

            @php
                // Lịch sử đầu tiên
                $firstLs = $lichSuDiemThang->first();
                // Danh sách tiêu chí
                $listTieuChi = $firstLs->lsDiemTheoTieuChi ?? collect();
            @endphp

            <thead>
                <tr>
                    <th scope="col">Tiêu chí</th>

                    {{-- Hiển thị ngày + Người chấm đúng 1 lần --}}
                    @foreach ($lichSuDiemThang as $ls)
                        <th scope="col" class="text-center">
                            {{ $ls->created_at->format('d-m-Y (H:i)') }} <br>
                            <small>Người chấm: {{ $ls->nguoiCham->name }}</small>
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="text-center">

                {{-- Chỉ duyệt tiêu chí 1 lần --}}
                @foreach ($listTieuChi as $index => $tc)
                    <tr>
                        <td>{{ $tc->tenTieuChi->ten_tieu_chi }}</td>

                        {{-- Chỉ hiển thị điểm --}}
                        @foreach ($lichSuDiemThang as $ls)
                            @php
                                $diem = $ls->lsDiemTheoTieuChi[$index];
                            @endphp

                            <td title="{{ $diem->ly_do ?? '-' }}">
                                {{ $diem->diem }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach

                {{-- Tổng điểm của mỗi lịch sử --}}
                <tr class="bg-gray-200 font-bold">
                    <td>Tổng điểm</td>
                    @foreach ($lichSuDiemThang as $ls)
                        <td>{{ $ls->tong_diem }}</td>
                    @endforeach
                </tr>

            </tbody>
        </table>
*/?>

<?php /*
            <table class="table " style="border: 1px solid #000">
                <head>
                    <tr>

                        <th scope="col">Nhân Viên</th>
                        <th scope="col">Tiêu chí</th>
                        <th scope="col">Điểm</th>
                        <th>Người chấm</th>
                        <th scope="col">Cập nhật</th>

                    </tr>
                </head>
                @foreach ($lichSuDiemThang as $index => $lsDiemThang)
                @if(!empty($diemThang))
                <tbody class="text-center">

                    <tr>

                        @if ($index == count($lichSuDiemThang) - 1)
                            <td>{{$lsDiemThang->nhanVien->name}}</td>

                        @else
                            <td></td>

                        @endif
                        {{-- <td>{{$lsDiemThang->nhanVien->name}}</td> --}}
                        <td style="padding: 0px;">
                            <table class="table" style="margin: 0px;">
                                @foreach ($lsDiemThang->lsDiemTheoTieuChi as $diem)
                                <tr><td>{{$diem->tenTieuChi->ten_tieu_chi}}</td></tr>

                                @endforeach
                            </table>
                        </td>

                        <td style="padding: 0px;" >
                            <table class="table" style="margin: 0px;">
                                @foreach ($lsDiemThang->lsDiemTheoTieuChi as $diem)

                                <tr><td class="text-center" title="{{ $diem->ly_do }}">{{$diem->diem}}</td></tr>


                                @endforeach
                            </table>
                        </td>
                        <td>
                            {{ $lsDiemThang->nguoiCham->name }}
                        </td>
                        <td>
                            {{ $lsDiemThang->created_at->format('H:i:s d-m-Y') }}

                        </td>

                    </tr>
                    <tr>
                        <td colspan="5"><strong>Tổng điểm: {{$lsDiemThang->tong_diem}}</strong></td>
                    </tr>
                </tbody>
                @endif
                @endforeach
            </table>
*/?>




        <?php /*

        @foreach ($lichSuDiemThang as $lsDiemThang)

            <table class="table ">
                <head>
                    <tr>

                        <th scope="col">Nhân Viên</th>
                        <th scope="col">Tiêu chí</th>
                        <th scope="col">Điểm</th>
                        <th scope="col">Cập nhật</th>

                    </tr>
                </head>

                @if(!empty($diemThang))
                <tbody class="text-center">

                    <tr>
                        <td>{{$lsDiemThang->nhanVien->name}}</td>
                        <td style="padding: 0px;">
                            <table class="table" style="margin: 0px;">
                                @foreach ($lsDiemThang->lsDiemTheoTieuChi as $diem)
                                <tr><td>{{$diem->tenTieuChi->ten_tieu_chi}}</td></tr>

                                @endforeach
                            </table>
                        </td>

                        <td style="padding: 0px;" >
                            <table class="table" style="margin: 0px;">
                                @foreach ($lsDiemThang->lsDiemTheoTieuChi as $diem)
                                <tr><td>{{$diem->diem}}</td></tr>

                                @endforeach
                            </table>
                        </td>

                        <td>
                            {{ $lsDiemThang->created_at->format('H:i:s d-m-Y') }}

                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"><strong>Tổng điểm: {{$lsDiemThang->tong_diem}}</strong></td>
                    </tr>
                </tbody>
                @endif

            </table>

        @endforeach

        */?>




    </div>

</x-layout>

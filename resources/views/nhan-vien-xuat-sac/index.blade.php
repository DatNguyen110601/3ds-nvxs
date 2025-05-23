<?php
$list = [
    route('home') =>'Trang chủ',
    '#'=>'Nhân viên xuất sắc',
];
?>
<style>
    .btn-info{
        background: #31d2f2 !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<x-layout>
    <div class="flex items-center justify-between border-b py-2  breadcrumb"  style="border-block-color: red;">
        <x-breadcrumb :list='$list' />
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


    <div class="container">
        <legend class="legend text-center mb-4">Danh sách nhân viên xuất sắc - Năm {{ $year }}</legend>

        <form action="" method="GET" class="mb-3">
            <div class="d-flex justify-content-end">
                <div class="row g-3">
                    <div class="col-auto">
                        <input type="number" name="year" value="{{ $year }}" class="form-control" placeholder="Nhập năm">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-info">Tìm</button>
                    </div>
                </div>
            </div>

        </form>

        <div class="table-responsive">
            <table class="table table-bordered text-center table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Stt</th>
                        <th>Nhân viên</th>
                        <th>Tổng điểm</th>
                        @for ($i = 1; $i <= 12; $i++)
                            <th>Tháng {{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    <tr></tr>
                    <?php $key = 1; ?>
                    @if ($data!= null)
                    @foreach ($data as $item)

                    <tr>
                        <td>{{$key++}}</td>

                        <td>
                            <a href="{{route('nhan-vien.show', ['danhSachNhanVien' => $item['nhanVien']])}}">
                                {{ $item['nhan_vien'] }} <br>
                                <span style="color: #565555; font-size:13px">
                                    @foreach ($item['nhanVien']->viTri as $viTri)
                                        ({{$viTri->ten_vi_tri}})
                                    @endforeach
                                </span>
                            </a>

                        </td>
                        <td>{{ $item['tong_diem'] }}</td>
                        @for ($i = 1; $i <= 12; $i++)
                            <td>{{ $item['diem_thang'][$i] }}</td>
                        @endfor
                    </tr>

                    @endforeach
                    @else
                    <td colspan="15" style="background:darkgray;">Chưa có nhân viên xuất sắc</td>
                    @endif

                </tbody>
            </table>
        </div>


        {{-- biểu đồ --}}
        {{-- <div class=" d-flex w-full">
            <div class="bg-white w-full mt-8">
                <h2 class="text-xl font-bold text-center mb-4">Biểu đồ thống kê</h2>
                <canvas id="myChart"></canvas>
            </div>
        </div> --}}
        {{--  --}}

        <div class=" d-flex w-full">
            <div class="bg-white w-full mt-8">
                <h2 class="text-xl font-bold text-center mb-4">Biểu đồ thống kê</h2>
                <canvas id="stackedChart" width="1200" height="600"></canvas>

            </div>
        </div>
    </div>


<?php /*

    <div class="table-responsive">
        <table class="table  table-bordered">
            <thead class="table-light">
                <tr>
                    <th scope="col">Năm</th>
                    <th scope="col">Nhân viên xuất sắc</th>
                    <th scope="col">Hành động</th>

                </tr>
            </thead>


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
    */ ?>

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



    const rawDataObject = @json($data); // từ Laravel truyền qua

    const rawData = Object.values(rawDataObject);
    // Lấy tên nhân viên cho trục X
    const labels = rawData.map(item => item.nhan_vien);

    // Duyệt theo từng tháng để tạo datasets
    const datasets = [];

    for (let month = 1; month <= 12; month++) {
        const dataForMonth = rawData.map(item => item.diem_thang[month] ?? 0);

        datasets.push({
            label: `Tháng ${month}`,
            data: dataForMonth,
            backgroundColor: getColor(month),
            stack: 'stack1'
        });
    }

    const config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Biểu đồ cột chồng - Tổng điểm các tháng theo nhân viên'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    stacked: true,
                    title: {
                        display: true,
                        text: 'Nhân viên'
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    max: 100,

                    title: {
                        display: true,
                        text: 'Tổng điểm'
                    }
                }
            }
        }
    };

    new Chart(document.getElementById('stackedChart'), config);

    // Hàm chọn màu theo tháng
    function getColor(month) {
        const colors = [
            '#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236',
            '#166a8f', '#00a950', '#58595b', '#8549ba', '#e0ac69',
            '#b83c6f', '#7bdcb5'
        ];
        return colors[(month - 1) % colors.length];
    }
</script>

@endpush
</x-layout>

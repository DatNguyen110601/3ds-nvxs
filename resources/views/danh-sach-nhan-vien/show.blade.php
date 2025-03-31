<?php
$list = [
    route('home') =>'Trang chủ',
    route('nhan-vien.index')=>'Danh sách nhân viên',
    // '#' => "{$danhSachNhanVien->name}"
    '#' => isset($danhSachNhanVien) ? $danhSachNhanVien->name : 'Nhân viên'
];


// Khởi tạo mảng 12 tháng với tổng điểm mặc định là 0
$tongDiemMap = array_fill_keys(range(1, 12), 0);

// Lặp qua $diemThang và cập nhật tổng điểm cho tháng tương ứng
foreach ($diemThang as $diem) {
    $tongDiemMap[$diem->danhMucThangNam->thang] = $diem->tong_diem;
}

$thangLabels = array_keys($tongDiemMap);
$tongDiemValues = array_values($tongDiemMap);

?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>

<div>
    <div class=" d-flex justify-content-between mb-3 mt-4">
        <legend class="legend">Nhân viên {{$danhSachNhanVien->name}}</legend>

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

                    <th>Năm</th>
                    <th>Tháng</th>
                    <th>Tổng điểm</th>
                    <th>Hành động</th>

                </tr>
            </thead>
            <tbody class="text-center">

            @if(count($diemThang)!=0)
                @foreach ($diemThang as $diem)
                    <tr>
                        <td>{{$diem->danhMucThangNam->nam}}</td>
                        <td>{{$diem->danhMucThangNam->thang}}</td>

                        <td>
                            @if ($diem->tong_diem == 0)
                                Chưa chấm
                            @else
                                {{$diem->tong_diem}}
                            @endif
                        </td>

                        <td>
                            <a href="{{route('diem-thang.show', ['nhanVien' =>$danhSachNhanVien,
                                                                'diemThang' => $diem])}}" title="Xem" >
                                <span class="material-symbols-outlined fs-3">
                                    table_eye
                                </span>
                            </a>
                            {{-- <a href="" title=Sửa>
                                <span class="material-symbols-outlined fs-3"  style="color: #0dcaf0;">
                                    border_color
                                </span>
                            </a>
                            <a href="" title="Xóa">
                                <span class="material-symbols-outlined fs-3 " style="color: red;" title="Xóa">
                                    delete
                                </span>
                            </a> --}}
                        </td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="4"  style="background:darkgray;">Chưa có thông tin</td>
            </tr>
            @endif

            </tbody>
        </table>



    </div>
    <div class=" d-flex w-full">
        <div class="bg-white w-full mt-8">
            <h2 class="text-xl font-bold text-center mb-4">Biểu đồ thống kê</h2>
            <canvas id="stackedBarChart"></canvas>
        </div>
    </div>



</div>

@push('scripts')
<script type="text/javascript">
        const rawData = @json($data); // Laravel đẩy biến từ controller ra Blade

const labels = rawData.map(item => `Tháng ${item.thang}`);

// Tìm tất cả tiêu chí duy nhất
const tieuChiSet = new Set();
rawData.forEach(item => {
    item.chi_tiet_tieu_chi.forEach(chiTiet => {
        if (chiTiet.tieu_chi) {
            tieuChiSet.add(chiTiet.tieu_chi);
        }
    });
});
const tieuChiList = Array.from(tieuChiSet);

// Tạo datasets theo từng tiêu chí
const datasets = tieuChiList.map(tieuChi => {
    return {
        label: tieuChi,
        data: rawData.map(item => {
            const found = item.chi_tiet_tieu_chi.find(tc => tc.tieu_chi === tieuChi);
            return found ? found.diem : 0;
        }),
        backgroundColor: getRandomColor(),
        stack: 'stack1'
    };
});

const ctx = document.getElementById('stackedBarChart').getContext('2d');
new Chart(ctx, {
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
                // text: 'Biểu đồ điểm theo tiêu chí của từng nhân viên'
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            x: {
                stacked: true
            },
            y: {
                max:100,
                stacked: true,
                beginAtZero: true
            }
        }
    }
});

// Hàm tạo màu ngẫu nhiên
function getRandomColor() {
    const r = Math.floor(Math.random() * 200);
    const g = Math.floor(Math.random() * 200);
    const b = Math.floor(Math.random() * 200);
    return `rgba(${r}, ${g}, ${b}, 0.7)`;
}
</script>
@endpush
</x-layout>

<?php
$list = [
    route('home') =>'Trang chủ',
    route('danh-muc-thang-nam.index')=>'Danh mục tháng năm',
    route('danh-muc-thang-nam.show', ['danhMucThangNam' => $danhMucThangNam]) => "Nhân viên năm {$danhMucThangNam->nam}/ tháng {$danhMucThangNam->thang}",
    '#' => "Biểu đồ"
];
?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;">
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



    <div class=" d-flex w-full">
        <div class="bg-white w-full mt-8">
            <h2 class="text-xl font-bold text-center mb-4">Biểu đồ thống kê</h2>
            <canvas id="stackedBarChart" width="1200" height="600"></canvas>

        </div>
    </div>



@push('scripts')
<script type="text/javascript">
        const rawData = @json($data); // Laravel đẩy biến từ controller ra Blade

const labels = rawData.map(item => item.nhan_vien);

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
                text: 'Biểu đồ điểm của từng nhân viên'
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

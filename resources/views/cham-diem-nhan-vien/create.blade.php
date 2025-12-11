<?php
$list = [
    route('home') =>'Trang chủ',
    route('danh-muc-thang-nam.index')=>'Danh mục tháng năm',
    route('danh-muc-thang-nam.show', [
        'danhMucThangNam' =>$danhMucThangNam]) => "Nhân viên tháng {$danhMucThangNam->thang}",
        '#' => "Chấm điểm nhân viên {$nhanVien->name}"
];
?>


<style>
    .btn-primary{
        background: #0a58ca !important;
    }
</style>

<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>
    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Chấm điểm nhân viên {{$nhanVien->name}}</legend>
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

    <div class="container mt-3">
        <form action="{{route('cham-diem-nhan-vien.store', ['danhMucThangNam' =>$danhMucThangNam, 'nhanVien' =>$nhanVien, 'diemThang' =>$diemThang])}}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tiêu chí</th>
                            <th>Thang điểm</th>
                            <th>Điểm đạt được</th>
                            <th>Hành động</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($diemTheoTieuChi))
                        @foreach ($diemTheoTieuChi as $tieuChi)
                            <tr class="text-center">
                                <td>{{$tieuChi->tenTieuChi->ten_tieu_chi}}</td>
                                {{-- <td><input type="number" name="thang_diem[]" class="form-control" placeholder="Thang điểm" required></td> --}}
                                <td>
                                    {{$tieuChi->tenTieuChi->diem_toi_thieu}} - {{$tieuChi->tenTieuChi->diem_toi_da}}
                                </td>


                            <td>
                                @php
                                   // Chọn ký tự phân tách, ví dụ dấu |
                                    $separator = '#';
                                    $moTaArray = explode($separator, $tieuChi->tenTieuChi->mo_ta);

                                    // Tách mô tả theo xuống dòng
                                    // $moTaArray = preg_split("/\r\n|\n|\r/", $tieuChi->tenTieuChi->mo_ta);
                                @endphp

                                <div class="d-flex justify-content-center gap-2">
                                    @for ($i = 1; $i <= $tieuChi->tenTieuChi->diem_toi_da; $i++)
                                        @php
                                            // Lấy mô tả cho từng điểm (nếu có)
                                            $moTa = $moTaArray[$i - 1] ?? $tieuChi->tenTieuChi->mo_ta;
                                        @endphp

                                        <input type="radio"
                                            class="btn-check"
                                            name="inputs[{{ $tieuChi->id_tieu_chi }}]"
                                            id="radio-{{ $tieuChi->id_tieu_chi }}-{{ $i }}"
                                            value="{{ $i }}"
                                            >

                                        <label class="btn btn-outline-primary btn-sm"
                                            for="radio-{{ $tieuChi->id_tieu_chi }}-{{ $i }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="bottom"
                                            title="{{ $moTa }}">
                                            {{ $i }}
                                        </label>
                                    @endfor
                                </div>
                            </td>

                            <td>
    @if ($tieuChi->tenTieuChi->ten_tieu_chi === 'Todolist(1)')

        <button
            type="button"
            class="btn btn-warning btn-sm btn-call-api"
            data-id-nhan-vien="{{ $nhanVien->id }}"
            data-thang="{{ $danhMucThangNam->thang }}"
            data-nam="{{ $danhMucThangNam->nam }}"
            data-id-tieu-chi="{{ $tieuChi->id_tieu_chi }}"
        >
            Todolist(1)
        </button>

        <span class="badge bg-danger mt-2 d-none api-result"></span>

    @else
        <span class="text-muted">—</span>
    @endif
</td>


                                {{-- <td><input type="number" name="diem_dat_duoc[]" class="form-control" placeholder="Điểm đạt được" required></td> --}}
                                {{-- <td>
                                    <input type="number" name="inputs[{{$tieuChi->id_tieu_chi}}]" id="input-{{$tieuChi->id}}" placeholder="Điểm đạt được"
                                    min="{{$tieuChi->tenTieuChi->diem_toi_thieu}}" max="{{$tieuChi->tenTieuChi->diem_toi_da}}"class="form-control" required/>

                                </td> --}}
                            </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Lưu đánh giá</button>
            </div>
        </form>
    </div>





<?php /*

        <form action="{{route('cham-diem-nhan-vien.store', ['danhMucThangNam' =>$danhMucThangNam, 'nhanVien' =>$nhanVien, 'diemThang' =>$diemThang])}}" method="POST">
            @csrf
        {{-- <div class="mt-10 grid grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-6"> --}}
            <div class="col-6">
            @if (!empty($diemTheoTieuChi))
                @foreach ($diemTheoTieuChi as $tieuChi)
                <div class="row">
                    <div class="col-6 input-group mb-3">
                        <span for="first-name" class="input-group-text">{{$tieuChi->tenTieuChi->ten_tieu_chi}}</span>

                            <input type="number" name="inputs[{{$tieuChi->id_tieu_chi}}]" id="input-{{$tieuChi->id}}"
                            min="{{$tieuChi->tenTieuChi->diem_toi_thieu}}" max="{{$tieuChi->tenTieuChi->diem_toi_da}}"class="form-control" required/>
                        {{-- <input type="number" name="{{$tieuChi->id}}" id="" autocomplete="given-name" class="block w-1/2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"> --}}

                    </div>
                </div>


                @endforeach

            @endif

                <input type="submit" value="Thêm"/>
        </div>
        </form>
 */?>
@push('scripts')

<script>
document.addEventListener("DOMContentLoaded", function() {

    document.addEventListener("click", function(e) {

        if (e.target.classList.contains("btn-call-api")) {

            let btn = e.target;
            let idNhanVien = btn.dataset.idNhanVien;
            let thang = btn.dataset.thang;
            let nam = btn.dataset.nam;
            let idTieuChi = btn.dataset.idTieuChi;

            function getDaysInMonth(month, year) {
                return new Date(year, month, 0).getDate();
            }

            // === LẤY NGÀY HIỆN TẠI ===
            let today = new Date();
            let thangHienTai = today.getMonth() + 1;
            let namHienTai = today.getFullYear();
            let ngayHienTai = today.getDate();
            // === XÁC ĐỊNH NGÀY KẾT THÚC ===
            let ngayKetThuc;

            if (thang == thangHienTai && nam == namHienTai) {
                // Nếu là tháng năm hiện tại → lấy tới ngày hôm nay
                ngayKetThuc = `${String(ngayHienTai).padStart(2, '0')}-${String(thang).padStart(2, '0')}-${nam}`;
            } else {
                // Nếu tháng/năm khác → lấy ngày cuối tháng
                let soNgayCuoi = getDaysInMonth(thang, nam);
                ngayKetThuc = `${String(soNgayCuoi).padStart(2, '0')}-${String(thang).padStart(2, '0')}-${nam}`;
            }

            let soNgayCuoi = getDaysInMonth(thang, nam);
            // Tạo chuỗi ngày dạng DD-MM-YYYY
            let ngayBatDau = `01-${String(thang).padStart(2, '0')}-${nam}`;
            // let ngayKetThuc = `${String(soNgayCuoi).padStart(2, '0')}-${String(thang).padStart(2, '0')}-${nam}`;

            // Tự tạo ngày
            // let ngayBatDau = `01-${thang}-${nam}`;
            // let ngayKetThuc = `${soNgayCuoi}-${thang}-${nam}`;

            let apiUrl = `https://todo.3ds.vn/api/task-theo-thang?id_nhan_vien=${idNhanVien}&ngay_bat_dau=${ngayBatDau}&ngay_ket_thuc=${ngayKetThuc}`;
            console.log(apiUrl);
            btn.innerHTML = "Đang lấy...";

            fetch(apiUrl)
                .then(res => res.json())
                .then(data => {
                    let soNgay = data?.so_ngay_khong_task ?? 0;

                    // ⭐ QUY TẮC ĐIỂM
                    let diem = 1;
                    if (soNgay === 0) diem = 5;
                    else if (soNgay === 1) diem = 4;
                    else if (soNgay === 3) diem = 3;
                    else if (soNgay === 4) diem = 2;
                    else if (soNgay > 5) diem = 1;

                    // ⭐ AUTO CHECK RADIO
                    let radioId = `radio-${idTieuChi}-${diem}`;
                    let radio = document.getElementById(radioId);

                    if (radio) {
                        radio.checked = true;
                    }

                    // ⭐ HIỆN KẾT QUẢ BÊN CẠNH NÚT
                    let span = btn.parentElement.querySelector(".api-result");
                    span.textContent = `Không task: ${soNgay} ngày (Điểm: ${diem})`;
                    span.classList.remove("d-none");

                    btn.innerHTML = "Todolist(1)";
                })
                .catch(err => {
                    console.error(err);
                    alert("Không thể gọi API!");
                    btn.innerHTML = "Todolist(1)";
                });

        }
    });

});
</script>
    {{-- Kích hoạt tooltip của Bootstrap --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

@endpush
</x-layout>

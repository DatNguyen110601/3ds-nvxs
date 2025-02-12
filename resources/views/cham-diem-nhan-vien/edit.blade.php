<?php
$list = [
    route('home') =>'Trang chủ',
    route('danh-muc-thang-nam.index')=>'Danh mục tháng năm',
    route('danh-muc-thang-nam.show', [
        'danhMucThangNam' =>$danhMucThangNam]) => "Nhân viên tháng {$danhMucThangNam->thang}",
        '#' => "Sửa điểm nhân viên {$nhanVien->name}"
];
?>

<style>
    .btn-primary{
        background: #0a58ca !important;
    }

    #submit.enabled {
    background-color: green;
    cursor: pointer;
    }
    #submit:disabled {
        background-color: gray;
        cursor: not-allowed;
    }
</style>


<x-layout>
    <div class="flex items-center justify-between border-b py-2 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>
    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Chấm điểm nhân viên {{$nhanVien->name}}</legend>
    </div>

    <div class="container mt-3">
        <form action="{{route('cham-diem-nhan-vien.update', ['danhMucThangNam' =>$danhMucThangNam, 'nhanVien' =>$nhanVien, 'diemThang' =>$diemThang])}}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Tiêu chí</th>
                            <th>Thang điểm</th>
                            <th>Điểm</th>
                            <th>Điểm đạt được</th>
                            <th>Lý do</th>

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
                                {{-- <td><input type="number" name="diem_dat_duoc[]" class="form-control" placeholder="Điểm đạt được" required></td> --}}
                                <td>{{$tieuChi->diem}}</td>


                                <td>
                                    <input type="number"  name="inputs[{{$tieuChi->id_tieu_chi}}]" id="inputs-{{$tieuChi->id}}"
                                    min="{{$tieuChi->tenTieuChi->diem_toi_thieu}}" max="{{$tieuChi->tenTieuChi->diem_toi_da}}"class="form-control input-field" placeholder="Điểm đạt được"/>

                                </td>
                                <td>
                                    <input type="text" name="input-ly-do[{{$tieuChi->id_tieu_chi}}]" id="input-ly-do-{{$tieuChi->id}}" placeholder="Lý do"
                                   class="form-control"/>
                                </td>
                            </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <button type="submit" id="submit" class="btn btn-primary">Lưu đánh giá</button>
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

// document.addEventListener('DOMContentLoaded', () => {
//     const inputFields = document.querySelectorAll('.input-field'); // Tất cả ô input "Điểm đạt được"
//     const reasonFields = document.querySelectorAll('[id^="input-ly-do-"]'); // Tất cả ô input "Lý do"
//     const submitButton = document.getElementById('submit'); // Nút submit

//     // Hàm kiểm tra tất cả ô input
//     function validateInputs() {
//         let allValid = true;

//         // Kiểm tra các ô "Điểm đạt được"
//         inputFields.forEach(input => {
//             const value = parseFloat(input.value); // Giá trị của input
//             const min = parseFloat(input.min); // Giá trị tối thiểu
//             const max = parseFloat(input.max); // Giá trị tối đa

//             if (isNaN(value) || value < min || value > max) {
//                 allValid = false; // Nếu không hợp lệ
//             }
//         });

//         // Kiểm tra các ô "Lý do"
//         reasonFields.forEach(reason => {
//             if (reason.value.trim() === "") {
//                 allValid = false; // Nếu "Lý do" rỗng
//             }
//         });

//         // Bật/tắt nút Submit
//         submitButton.disabled = !allValid;
//         if (allValid) {
//             submitButton.classList.add('enabled');
//         } else {
//             submitButton.classList.remove('enabled');
//         }
//     }

//     // Lắng nghe sự kiện 'input' cho tất cả các trường
//     inputFields.forEach(input => {
//         input.addEventListener('input', validateInputs);
//     });

//     reasonFields.forEach(reason => {
//         reason.addEventListener('input', validateInputs);
//     });
// });
//




document.addEventListener('DOMContentLoaded', () => {
    const inputFields = document.querySelectorAll('.input-field'); // Tất cả ô input "Điểm đạt được"
    const reasonFields = document.querySelectorAll('[id^="inputs-"]'); // Tất cả ô input "Lý do"
    const submitButton = document.getElementById('submit'); // Nút submit

    // Hàm kiểm tra tính hợp lệ
    function validateInputs() {
        let allCleared = false;

        // Kiểm tra các ô "Điểm đạt được"
        inputFields.forEach(input => {
            const value = input.value.trim(); // Giá trị của input
            if (value !== "") {
                allCleared = true; // Nếu có giá trị, không được bật nút
            }
        });

        // Kiểm tra các ô "Lý do"
        reasonFields.forEach(reason => {
            if (reason.value.trim() !== "") {
                allCleared = true; // Nếu có giá trị, không được bật nút
            }
        });

        // Bật/tắt nút Submit
        submitButton.disabled = !allCleared;
        if (allCleared) {
            submitButton.classList.add('enabled'); // Thêm lớp khi nút có thể nhấn
        } else {
            submitButton.classList.remove('enabled'); // Xóa lớp khi nút không thể nhấn
        }
    }

    // Lắng nghe sự kiện 'input' cho tất cả các trường
    inputFields.forEach(input => {
        input.addEventListener('input', validateInputs);
    });

    reasonFields.forEach(reason => {
        reason.addEventListener('input', validateInputs);
    });

    // Kiểm tra lần đầu khi trang tải
    validateInputs();
});



//////
    document.querySelectorAll('input[name^="inputs"]').forEach(input => {
            input.addEventListener('input', function () {
                const id = this.getAttribute('id').split('-')[1];
                const inputLyDo = document.getElementById(`input-ly-do-${id}`);

                if (this.value.trim() !== "") {
                    inputLyDo.setAttribute('required', 'required');
                } else {
                    inputLyDo.removeAttribute('required');
                    // Xóa thông báo lỗi nếu tồn tại
                    const errorSpan = document.querySelector(`#error-ly-do-${id}`);
                    if (errorSpan) errorSpan.remove();
                }
            });
        });

        document.querySelectorAll('input[name^="input-ly-do"]').forEach(input => {
            input.addEventListener('invalid', function (e) {
                e.preventDefault(); // Ngăn thông báo mặc định của trình duyệt
                const id = this.getAttribute('id').split('-')[3];

                // Xóa thông báo lỗi cũ nếu có
                let errorSpan = document.querySelector(`#error-ly-do-${id}`);
                if (!errorSpan) {
                    errorSpan = document.createElement('span');
                    errorSpan.id = `error-ly-do-${id}`;
                    errorSpan.style.color = 'red';
                    errorSpan.textContent = 'Bạn cần nhập lý do.';
                    this.parentElement.appendChild(errorSpan);
                }
            });

            input.addEventListener('input', function () {
                const id = this.getAttribute('id').split('-')[3];
                const errorSpan = document.querySelector(`#error-ly-do-${id}`);
                if (this.value.trim() !== "" && errorSpan) {
                    errorSpan.remove();
                }
            });
        });


// document.querySelectorAll('input[name^="inputs"]').forEach(input => {
//     input.addEventListener('input', function () {
//         // Lấy id của ô "Lý do" tương ứng
//         const id = this.getAttribute('id').split('-')[1];
//         const inputLyDo = document.getElementById(`input-ly-do-${id}`);

//         // Kiểm tra nếu có nhập giá trị thì thêm 'required', nếu xóa giá trị thì bỏ 'required'
//         if (this.value.trim() !== "") {
//             inputLyDo.setAttribute('required', 'required');
//         } else {
//             inputLyDo.removeAttribute('required');
//         }
//     });
// });
</script>


@endpush
</x-layout>

<?php /*
<x-layout>
    <div class="flex items-center justify-between border-b p-4 breadcrumb"  style="border-block-color: red;" >
        <x-breadcrumb :list='$list' />
    </div>
    <div class=" d-flex justify-content-between mb-2">
        <legend class="legend">Sửa điểm nhân viên {{$nhanVien->name}}</legend>
    </div>


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
                            min="{{$tieuChi->tenTieuChi->diem_toi_thieu}}" max="{{$tieuChi->tenTieuChi->diem_toi_da}}" value="{{$tieuChi->diem}}" class="form-control" required/>
                        {{-- <input type="number" name="{{$tieuChi->id}}" id="" autocomplete="given-name" class="block w-1/2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"> --}}

                    </div>
                </div>


                @endforeach

            @endif

                <input type="submit" value="Cập nhật"/>
        </div>
        </form>

@push('script')


@endpush
</x-layout>

*/ ?>

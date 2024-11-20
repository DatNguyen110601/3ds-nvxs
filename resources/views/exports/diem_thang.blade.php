
<div class="table-responsive">
    <table style="border: 2px solid black; border-collapse: collapse;">
        <thead class="table-primary">
            <!-- Tiêu đề chính -->
            <tr>
                <th colspan="{{ count($data->first()) + 2 }}" style="text-align: center; font-weight: bold; font-size: 18px;">
                    NHÂN VIÊN XUẤT SẮC THÁNG {{ $thang }} NĂM {{ $nam }}
                </th>
            </tr>
            <!-- Đầu mục cột -->
            <tr style="height:100px">
                <th style="text-align: center; font-weight: bold; width: 50px; height:50px;  font-size: 16px;  border: 2px solid black;">Stt</th>

                <th style="text-align: center; font-weight: bold; width: 200px; height:50px;  font-size: 16px;  border: 2px solid black;">Tên Nhân Viên</th>
                <th style="text-align: center; font-weight: bold;  width: 200px; height:50px;  font-size: 16px;  border: 2px solid black;">Tổng Điểm</th>
                @foreach($data->first()->groupBy('ten_tieu_chi') as $tieuChi)
                    <th style="text-align: center; font-weight: bold;  width: 200px; height:50px;  font-size: 16px;  border: 2px solid black;" >{{ $tieuChi->first()->ten_tieu_chi }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <?php $key = 0; ?>
            @foreach($data as $index => $nhanVien)

                <tr class="border: 2px solid black;">
                    <td style="text-align: center; font-size: 14px; height:30px;  border: 2px solid black;">{{ ++$key }}</td>

                    <!-- Tên nhân viên -->
                    <td style="text-align: center; font-size: 14px; height:30px;  border: 2px solid black;">{{ $nhanVien->first()->name }}</td>
                    <!-- Tổng điểm -->
                    <td style="text-align: center; font-size: 14px; height:30px;  border: 2px solid black;">{{ $nhanVien->first()->tong_diem }}</td>
                    <!-- Điểm theo từng tiêu chí -->
                    @foreach($nhanVien->groupBy('id_tieu_chi') as $tieuChi)
                    <td style="text-align: center; font-size: 14px; height:30px;  border: 2px solid black;">{{ $tieuChi->first()->diem }}</td>
                    @endforeach


                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên nhân viên</th>
            <th>Tiêu chí</th>
            <th>Điểm</th>
            <th>Tổng điểm</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $row)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $row->ho_ten }}</td>
                <td>{{ $row->id_tieu_chi }}</td>
                <td>{{ $row->diem }}</td>
                <td>{{ $row->tong_diem }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

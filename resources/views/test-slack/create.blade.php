<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Thông Tin Khách Hàng</title>
</head>
<body>
    <h2>Form Đăng Ký Thông Tin</h2>
    <form action= "{{ route('slack.guiForm') }}" method="POST">
        @csrf
        <label for="ho_ten">Họ và tên:</label><br>
        <input type="text" id="ho_ten" name="ho_ten" required><br><br>

        <label for="ngay_sinh">Ngày sinh:</label><br>
        <input type="date" id="ngay_sinh" name="ngay_sinh" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="so_dien_thoai">Số điện thoại:</label><br>
        <input type="tel" id="so_dien_thoai" name="so_dien_thoai" required><br><br>

        <button type="submit">Gửi Slack</button>
    </form>
</body>
</html>

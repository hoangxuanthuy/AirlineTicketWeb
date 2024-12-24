<?php
require_once 'config.php';

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $LopHoc = $_POST['LopHoc'];
    $DiaChi = $_POST['DiaChi'];
    $DiemTrungBinh = $_POST['DiemTrungBinh'];

    $sql = "INSERT INTO SinhVien (HoTen, GioiTinh, NgaySinh, LopHoc, DiaChi, DiemTrungBinh) 
            VALUES ('$HoTen', '$GioiTinh', '$NgaySinh', '$LopHoc', '$DiaChi', '$DiemTrungBinh')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Thêm sinh viên thành công!</p>";
    } else {
        echo "<p style='color: red;'>Lỗi: " . $conn->error . "</p>";
    }
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
</head>
<body>
    <h1>Thêm Sinh Viên</h1>
    <form method="POST" action="">
        <label for="HoTen">Họ Tên:</label>
        <input type="text" name="HoTen" required><br><br>

        <label for="GioiTinh">Giới Tính:</label>
        <select name="GioiTinh" required>
            <option value="Nam">Nam</option>
            <option value="Nu">Nữ</option>
        </select><br><br>

        <label for="NgaySinh">Ngày Sinh:</label>
        <input type="date" name="NgaySinh" required><br><br>

        <label for="LopHoc">Lớp Học:</label>
        <input type="text" name="LopHoc" required><br><br>

        <label for="DiaChi">Địa Chỉ:</label>
        <input type="text" name="DiaChi" required><br><br>

        <label for="DiemTrungBinh">Điểm Trung Bình:</label>
        <input type="number" name="DiemTrungBinh" step="0.01" required><br><br>

        <button type="submit">Thêm Sinh Viên</button>
    </form>
    <br>
    <a href="index.php">Quay lại danh sách sinh viên</a>
</body>
</html>
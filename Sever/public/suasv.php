<?php
// Import file cấu hình
require_once 'config.php';

// Kiểm tra nếu có tham số id trong URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn để lấy thông tin sinh viên
    $sql = "SELECT * FROM SinhVien WHERE MaSinhVien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra nếu sinh viên tồn tại
    if ($result->num_rows > 0) {
        $sinhvien = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy sinh viên!";
        exit();
    }
}

// Xử lý khi form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $hoten = $_POST['hoten'];
    $gioitinh = $_POST['gioitinh'];
    $ngaysinh = $_POST['ngaysinh'];
    $lophoc = $_POST['lophoc'];
    $diachi = $_POST['diachi'];
    $diemtrungbinh = $_POST['diemtrungbinh'];

    // Câu lệnh SQL để cập nhật thông tin sinh viên
    $sql = "UPDATE SinhVien SET HoTen = ?, GioiTinh = ?, NgaySinh = ?, LopHoc = ?, DiaChi = ?, DiemTrungBinh = ? WHERE MaSinhVien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $hoten, $gioitinh, $ngaysinh, $lophoc, $diachi, $diemtrungbinh, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href = 'index.php';</script>";
    } else {
        echo "Cập nhật thất bại!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa Sinh Viên</title>
</head>
<body>
<h2>Sửa Thông Tin Sinh Viên</h2>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $sinhvien['MaSinhVien']; ?>">
    <label>Họ Tên:</label><br>
    <input type="text" name="hoten" value="<?php echo $sinhvien['HoTen']; ?>"><br>
    <label>Giới Tính:</label><br>
    <input type="text" name="gioitinh" value="<?php echo $sinhvien['GioiTinh']; ?>"><br>
    <label>Ngày Sinh:</label><br>
    <input type="date" name="ngaysinh" value="<?php echo $sinhvien['NgaySinh']; ?>"><br>
    <label>Lớp Học:</label><br>
    <input type="text" name="lophoc" value="<?php echo $sinhvien['LopHoc']; ?>"><br>
    <label>Địa Chỉ:</label><br>
    <input type="text" name="diachi" value="<?php echo $sinhvien['DiaChi']; ?>"><br>
    <label>Điểm Trung Bình:</label><br>
    <input type="text" name="diemtrungbinh" value="<?php echo $sinhvien['DiemTrungBinh']; ?>"><br><br>
    <input type="submit" value="Lưu Thay Đổi">
</form>
<a href="index.php">Quay lại danh sách</a>
</body>
</html>

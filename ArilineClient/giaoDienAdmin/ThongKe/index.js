const menuBtn = document.querySelector('.menu-btn');
    const sidebar = document.querySelector('.sidebar');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });


    // Lấy phần tử canvas
    const ctx = document.getElementById('statChart').getContext('2d');

    // Dữ liệu và cấu hình biểu đồ
    const chart = new Chart(ctx, {
        type: 'bar', // Loại biểu đồ (cột)
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'], // Nhãn (x-axis)
            datasets: [{
                label: 'Doanh thu (VND)', // Tiêu đề
                data: [12000000, 15000000, 18000000, 13000000, 17000000, 19000000], // Dữ liệu
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)', // Màu cột
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)', // Màu viền
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Biểu đồ tự động điều chỉnh theo kích thước
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tháng'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Doanh thu (VND)'
                    },
                    beginAtZero: true
                }
            }
        }
    });

    // Kiểm tra trạng thái đăng nhập
    const isLoggedIn = localStorage.getItem("isLoggedIn");

    // Nếu chưa đăng nhập, chuyển về trang Login
    if (!isLoggedIn) {
        alert("Vui lòng đăng nhập trước!");
        window.location.href = "Login.html";
    }

    function logout() {
        // Cảnh báo xác nhận trước khi đăng xuất
        const confirmation = window.confirm("Bạn có chắc chắn muốn đăng xuất?");
        
        if (confirmation) {
            // Nếu người dùng chọn OK, quay lại trang đăng nhập
            localStorage.removeItem("isLoggedIn");
            window.location.href = "login.html";  // Chuyển về trang login
        } else {
            // Nếu người dùng chọn Cancel, không làm gì
            console.log("Đăng xuất đã bị hủy");
        }
    }


    function XuatbaoCao() {
            
        const monthSelect = document.getElementById('month');
        const yearSelect = document.getElementById('year');

            const month = monthSelect.value; // Lấy giá trị của tháng
            const year = yearSelect.value; // Lấy giá trị của năm

            if (!year) {
                // Nếu cả tháng và năm đều chưa chọn
                alert("Bạn phải chọn năm!");
            } else if (!month) {
                // Chỉ chọn tháng, đi tới BaoCaoThang.html
                localStorage.setItem('year', year); // Lưu tháng vào localStorage
                window.location.href = 'BaoCaoNam.html';
            } else if (month && year) {
                // Chọn cả tháng và năm, đi tới BaoCaoNam.html
                localStorage.setItem('month', month); // Lưu tháng vào localStorage
                localStorage.setItem('year', year); // Lưu năm vào localStorage
                window.location.href = 'BaoCaoThang.html';
            } 
       

    }
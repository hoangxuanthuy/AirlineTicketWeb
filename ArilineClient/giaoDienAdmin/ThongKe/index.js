// Biến toàn cục để lưu token
let authToken = null;

// Lấy token từ localStorage khi trang được tải
document.addEventListener('DOMContentLoaded', function () {
    authToken = localStorage.getItem('auth_token');
    const isLoggedIn = localStorage.getItem('isLoggedIn');

    if (!authToken || !isLoggedIn) {
        alert('Vui lòng đăng nhập trước!');
        window.location.href = "../login.php";
    } else {
        console.log('Token:', authToken); // Kiểm tra token được truyền vào
        // Ẩn biểu đồ khi chưa chọn năm
    }
});

// Toggle Sidebar
const menuBtn = document.querySelector('.menu-btn');
const sidebar = document.querySelector('.sidebar');
menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

// Đăng xuất
function logout() {
    const confirmation = window.confirm("Bạn có chắc chắn muốn đăng xuất?");
    if (confirmation) {
        localStorage.removeItem("isLoggedIn");
        localStorage.removeItem("auth_token");
        window.location.href = "../login.php";
    }
}

// Khởi tạo biểu đồ
const ctx = document.getElementById('statChart').getContext('2d');
let chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [], // Nhãn cột (tháng)
        datasets: [{
            label: 'Doanh thu (VND)', // Tiêu đề
            data: [], // Dữ liệu
            backgroundColor: 'rgba(54, 162, 235, 0.6)', // Màu cột
            borderColor: 'rgba(54, 162, 235, 1)', // Màu viền
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
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

// Hàm tải dữ liệu doanh thu
function loadRevenue(month, year) {
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    let url = `http://172.20.10.4:8000/api/revenue/monthly?year=${year}`;
    if (month) {
        url += `&month=${month}`;
    }

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
        .then(response => {
            if (!response.ok) throw new Error(`Lỗi khi tải dữ liệu doanh thu: ${response.status}`);
            return response.json();
        })
        .then(data => {
            const labels = data.details.map(item => `Tháng ${item.month}`);
            const revenues = data.details.map(item => item.revenue);

            // Hiển thị biểu đồ nếu dữ liệu tồn tại
            if (data.details.length > 0) {
                document.getElementById('statChart').style.display = 'block';
                chart.data.labels = labels;
                chart.data.datasets[0].data = revenues;
                chart.update();
            } else {
                alert('Không có dữ liệu doanh thu cho khoảng thời gian này.');
                document.getElementById('statChart').style.display = 'none';
            }

            // Hiển thị tổng doanh thu
            const totalRevenueElement = document.getElementById('total-revenue');
            totalRevenueElement.textContent = new Intl.NumberFormat("vi-VN").format(data.revenue || 0);
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu doanh thu:', error);
            alert('Không thể tải dữ liệu doanh thu. Vui lòng thử lại!');
        });
}

// Gắn sự kiện khi thay đổi tháng và năm
document.getElementById('month').addEventListener('change', () => {
    const selectedMonth = document.getElementById('month').value;
    const selectedYear = document.getElementById('year').value;

    if (!selectedYear) {
        alert('Vui lòng chọn năm trước!');
        document.getElementById('month').value = ""; // Reset tháng nếu chưa chọn năm
        return;
    }

    loadRevenue(selectedMonth, selectedYear);
});

document.getElementById('year').addEventListener('change', () => {
    const selectedMonth = document.getElementById('month').value;
    const selectedYear = document.getElementById('year').value;

    if (selectedYear) {
        loadRevenue(selectedMonth, selectedYear);
    } else {
        alert('Vui lòng chọn năm!');
    }
});
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
            window.location.href = 'BaoCaoNam.php';
        } else if (month && year) {
            // Chọn cả tháng và năm, đi tới BaoCaoNam.html
            localStorage.setItem('month', month); // Lưu tháng vào localStorage
            localStorage.setItem('year', year); // Lưu năm vào localStorage
            window.location.href = 'BaoCaoThang.php';
        } 
   

}
// Biến toàn cục để lưu token
let authToken = null;

// Lấy token từ localStorage khi trang được tải
document.addEventListener('DOMContentLoaded', function () {
    authToken = localStorage.getItem('auth_token');
    const isLoggedIn = localStorage.getItem('isLoggedIn');

    if (!authToken || isLoggedIn !== "true") {
        alert('Vui lòng đăng nhập trước!');
        window.location.href = "../login.php";
    } else {
        console.log('Token:', authToken);
    }
});

// Đăng xuất
function logout() {
    const confirmation = window.confirm("Bạn có chắc chắn muốn đăng xuất?");
    if (confirmation) {
        localStorage.removeItem("auth_token");
        localStorage.removeItem("isLoggedIn");
        alert("Bạn đã đăng xuất thành công!");
        window.location.href = "../login.php";
    }
}

// Khởi tạo biểu đồ cột
const ctxBar = document.getElementById('statChart').getContext('2d');
let barChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: [],
        datasets: []
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
                    text: 'Chuyến bay (Flight ID)'
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

// Khởi tạo biểu đồ hình tròn
const ctxPie = document.getElementById('pieChart').getContext('2d');
let pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        let value = context.raw || 0;
                        return `${context.label}: ${new Intl.NumberFormat('vi-VN').format(value)} VND`;
                    }
                }
            }
        }
    }
});
function loadRevenue(month, year) {
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    let url;

    // Xác định API cần gọi
    if (month) {
        url = `http://172.20.10.4:8000/api/revenue/monthly?year=${year}&month=${month}`;
    } else {
        url = `http://172.20.10.4:8000/api/revenue/yearly?year=${year}`;
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
            if (month) {
                const labels = data.map(item => `Flight ID: ${item.flight_id}`);
                const revenues = data.map(item => item.revenue);

                updateBarChart(labels, revenues, `Doanh thu theo chuyến bay (Tháng ${month}/${year})`);
                updatePieChart(labels, revenues);
            } else {
                const labels = data.map(item => `Tháng ${item.month}`);
                const revenues = data.map(item => item.total_revenue);

                updateBarChart(labels, revenues, `Tổng doanh thu (Năm ${year})`);
                updatePieChart(labels, revenues);
            }

            const totalRevenue = data.reduce((acc, item) => acc + (item.revenue || item.total_revenue || 0), 0);
            document.getElementById('total-revenue').textContent = new Intl.NumberFormat("vi-VN").format(totalRevenue);
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu doanh thu:', error);
            alert('Không thể tải dữ liệu doanh thu. Vui lòng thử lại!');
        });
}



// Hàm cập nhật biểu đồ cột
function updateBarChart(labels, data, labelText) {
    barChart.data.labels = labels;
    barChart.data.datasets = [{
        label: labelText,
        data: data,
        backgroundColor: 'rgba(75, 192, 192, 0.6)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    }];
    barChart.update();
}

// Hàm cập nhật biểu đồ hình tròn
function updatePieChart(labels, data) {
    pieChart.data.labels = labels;
    pieChart.data.datasets[0].data = data;
    pieChart.update();
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

    loadRevenue(selectedMonth, selectedYear);
});

// Hàm xuất báo cáo
function XuatbaoCao() {
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;

    if (!year) {
        alert("Vui lòng chọn năm để xuất báo cáo!");
        return;
    }

    if (month) {
        // Lưu dữ liệu tháng và năm vào localStorage để sử dụng trong BaoCaoThang.php
        localStorage.setItem('month', month);
        localStorage.setItem('year', year);
        window.location.href = 'BaoCaoThang.php';
    } else {
        // Lưu dữ liệu năm vào localStorage để sử dụng trong BaoCaoNam.php
        localStorage.setItem('year', year);
        window.location.href = 'BaoCaoNam.php';
    }
}

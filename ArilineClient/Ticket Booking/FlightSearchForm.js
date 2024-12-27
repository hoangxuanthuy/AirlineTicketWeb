const checkboxes = document.querySelectorAll("#customer"); // Chọn tất cả checkbox có cùng id "customer"

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            if (checkbox.checked) {
                // Bỏ chọn tất cả các checkbox khác
                checkboxes.forEach((cb) => {
                    if (cb !== checkbox) {
                        cb.checked = false;
                    }
                });
            }
        });
    });

const serverIp = 'localhost';
const serverPort = 8001;

let adults = 1;
let children = 0;

window.airportsCache = {};

let bookingInfo = sessionStorage.getItem('bookingInfo');

document.addEventListener('DOMContentLoaded', () => {
    bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo'));
    loadAirports();
    loadSeatClasses();
    updateUserAccountInfo();
    updatePassengerDisplay();
    if (bookingInfo) {
        document.getElementById('roundTrip').checked = bookingInfo.roundTrip;
        document.getElementById('departure-date').value = bookingInfo.departureDate || '';
        document.getElementById('return-date').value = bookingInfo.returnDate || '';
    }
});

async function fetchAirportName(airportId) {   
    airportId = parseInt(airportId);
    return airportsCache[airportId] || "Unknown Airport";
}

function loadAirports(currentPage = 1) {
    console.log('Loading airports...');
    let authToken = sessionStorage.getItem('auth_token');
    console.log(authToken);
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    const url = `http://${serverIp}:${serverPort}/api/airports`;

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        console.log(response);
        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
        return response.json();
    })
    .then(data => {
        bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo'));
        console.log('====================' + bookingInfo);
        const fromSelect = document.getElementById('from-airport');
        fromSelect.innerHTML = ''; // Clear existing options
        data.forEach(airport => {
            const option = document.createElement('option');
            option.value = airport.airport_id;
            option.textContent = `${airport.airport_name} - (${airport.address})`;
            fromSelect.appendChild(option);
            airportsCache[airport.airport_id] = airport.airport_name;
        });
        if (bookingInfo && bookingInfo.fromAirport) {
            console.log(bookingInfo.fromAirport + "================");
            fromSelect.value = bookingInfo.fromAirport || data[0].airport_id;
        }

        const toSelect = document.getElementById('to-airport');
        toSelect.innerHTML = ''; // Clear existing options
        data.forEach(airport => {
            const option = document.createElement('option');
            option.value = airport.airport_id;
            option.textContent = `${airport.airport_name} - (${airport.address})`;
            toSelect.appendChild(option);
        });
        if (bookingInfo && bookingInfo.toAirport) {
            toSelect.value = bookingInfo.toAirport || data[0].airport_id;
        }

        // Save airports data to local storage
        localStorage.setItem('airportsCache', JSON.stringify(airportsCache));
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu Sân bay:', error);
        alert('Không thể tải dữ liệu Sân bay. Vui lòng thử lại!');
    });
    return airportsCache;
}

function getAirportNameById(airportId) {
    const airportsCache = JSON.parse(localStorage.getItem('airportsCache')) || {};
    return airportsCache[airportId] || "Unknown Airport";
}

function loadSeatClasses() {
    let authToken = sessionStorage.getItem('auth_token');
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    const url = `http://${serverIp}:${serverPort}/api/seatclass`;

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${authToken}`
        }
    })
    .then(response => {
        console.log(response);
        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);
        return response.json();
    })
    .then(data => {
        const seatClassSelect = document.getElementById('seat-class');
        seatClassSelect.innerHTML = ''; // Clear existing options
        data.forEach(seatClass => {
            const option = document.createElement('option');
            option.value = seatClass.seat_class_id;
            option.textContent = seatClass.seat_class_name;
            seatClassSelect.appendChild(option);
        });
        bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo'));
        if (bookingInfo && bookingInfo.seatClass) {
            seatClassSelect.value = parseInt(bookingInfo.seatClass) || data[0].seat_class_id;
        }
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu Hạng ghế:', error);
        alert('Không thể tải dữ liệu Hạng ghế. Vui lòng thử lại!');
    });
}

function updatePassengerDisplay() {
   // document.getElementById('adults-count').textContent = adults;
  //  document.getElementById('children-count').textContent = children;
    //document.querySelector('.main-text').textContent = `${adults} người lớn, ${children} trẻ em`;
}

document.querySelectorAll('.increment').forEach(button => {
    button.addEventListener('click', () => {
        const type = button.getAttribute('data-type');
        if (type === 'adults') {
            adults += 1;
        } else if (type === 'children') {
            children += 1;
        }
        updatePassengerDisplay();
    });
});

document.querySelectorAll('.decrement').forEach(button => {
    button.addEventListener('click', () => {
        const type = button.getAttribute('data-type');
        if (type === 'adults' && adults > 1) {
            adults -= 1;
        } else if (type === 'children' && children > 0) {
            children -= 1;
        }
        updatePassengerDisplay();
    });
});

document.getElementById('button1').addEventListener('click', () => {
    //create object to save to local storage and pass to next page
    let bookingInfo = {
        fromAirport: document.getElementById('from-airport').value,
        toAirport: document.getElementById('to-airport').value,
        departureDate: document.getElementById('departure-date').value,
        returnDate: document.getElementById('return-date').value,
        seatClass: document.getElementById('seat-class').value,
        adults: adults,
        children: children,
        roundTrip : document.getElementById('roundTrip').checked
    }
    sessionStorage.setItem('bookingInfo', JSON.stringify(bookingInfo));
    window.location.href = "../Ticket Booking/bookticket/index.html";
});

function updateUserAccountInfo() {
    const loggedInUser = sessionStorage.getItem("username");
    const userRole = sessionStorage.getItem("role");

    if (loggedInUser) {
        const userAccount = document.getElementById("user-account");
        const accountMenu = document.getElementById("account-menu");

        userAccount.textContent = loggedInUser;

        if (userRole === "employee") {
            accountMenu.innerHTML = `
                <li><a href="../TCN_NhanVien/Taikhoan.html">Tài khoản</a></li>
                <li><a href="../TCN_NhanVien/Phieudat.html">Xử lý phiếu đặt</a></li>
                <li><a href="../TCN_NhanVien/Xulyve.html">Xử lý vé</a></li>
                <li><a href="../TCN_NhanVien/Xulytt.html">Xử lý thông tin KH</a></li>
                <li><a href="#" id="logout-link">Đăng xuất</a></li>
            `;
        } else if (userRole === "director") {
            accountMenu.innerHTML = `
                <li><a href="http://127.0.0.1:5502/ArilineClient/TCN/TCN_Lichsu.html">Tài khoản</a></li>
                <li><a href="#">Quản lý báo cáo</a></li>
                <li><a href="#">Xem thống kê</a></li>
                <li><a href="#">Quản lý nhân viên</a></li>
                <li><a href="#" id="logout-link">Đăng xuất</a></li>
            `;
        } else {
            accountMenu.innerHTML = `
                <li><a href="http://127.0.0.1:5502/ArilineClient/TCN/TCN_Lichsu.html">Tài khoản</a></li>
                <li><a href="#" id="logout-link">Đăng xuất</a></li>
            `;
        }

        document.getElementById("logout-link").addEventListener("click", (e) => {
            e.preventDefault();
            sessionStorage.removeItem("username");
            sessionStorage.removeItem("role");
            location.reload();
        });
    }
} 



document.querySelectorAll('.increment').forEach(button => {
    button.addEventListener('click', () => {
        const type = button.getAttribute('data-type');
        if (type === 'adults') {
            adults += 1;
        } else if (type === 'children') {
            children += 1;
        }
        updatePassengerDisplay();
    });
});

document.querySelectorAll('.decrement').forEach(button => {
    button.addEventListener('click', () => {
        const type = button.getAttribute('data-type');
        if (type === 'adults' && adults > 1) {
            adults -= 1;
        } else if (type === 'children' && children > 0) {
            children -= 1;
        }
        updatePassengerDisplay();
    });
});

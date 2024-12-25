
const serverIp = 'localhost';
const serverPort = 8001;
// Function to fetch airports from the server and populate the dropdown
function loadAirports(currentPage = 1) {
    console.log('Loading airports...');
    let authToken = sessionStorage.getItem('auth_token');
    console.log(authToken);
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    // Load theo mã sân bay
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
        console.log(data);
        const fromSelect = document.getElementById('from-airport');
        fromSelect.innerHTML = ''; // Clear existing options
        data.forEach(airport => {
            const option = document.createElement('option');
            option.value = airport.airport_id;
            option.textContent = `${airport.airport_name} (${airport.address})`;
            fromSelect.appendChild(option);
        });

        const toSelect = document.getElementById('to-airport');
        toSelect.innerHTML = ''; // Clear existing options
        data.forEach(airport => {
            const option = document.createElement('option');
            option.value = airport.airport_id;
            option.textContent = `${airport.airport_name} (${airport.address})`;
            toSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu Sân bay:', error);
        alert('Không thể tải dữ liệu Sân bay. Vui lòng thử lại!');
    });
}

function loadSeatClasses() {
    console.log('Loading seat classes...');
    let authToken = sessionStorage.getItem('auth_token');
    if (!authToken) {
        alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
        window.location.href = "../login.php";
        return;
    }

    const url = `http://${serverIp}:${serverPort}/api/seats`;

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
        console.log(data);
        const seatClassSelect = document.getElementById('seat-class');
        seatClassSelect.innerHTML = ''; // Clear existing options
        data.forEach(seatClass => {
            const option = document.createElement('option');
            option.value = seatClass.seat_class_id;
            option.textContent = seatClass.seat_class_name;
            seatClassSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu Hạng ghế:', error);
        alert('Không thể tải dữ liệu Hạng ghế. Vui lòng thử lại!');
    });
}

let adults = 1;
let children = 0;

function updatePassengerDisplay() {
    document.getElementById('adults-count').textContent = adults;
    document.getElementById('children-count').textContent = children;
    document.querySelector('.main-text').textContent = `${adults} người lớn, ${children} trẻ em`;
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

// Initialize display on load
updatePassengerDisplay();

document.addEventListener('DOMContentLoaded', () => {
    loadAirports();
    loadSeatClasses();
});

document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const fromAirport = document.getElementById('from-airport').value;
    const toAirport = document.getElementById('to-airport').value;
    const departureDate = document.getElementById('departure-date').value;
    const returnDate = document.getElementById('return-date').value;
    const seatClass = document.getElementById('seat-class').value;
    const adults = document.getElementById('adults-count').textContent;
    const children = document.getElementById('children-count').textContent;
    
    // Construct URL with updated directory name
    const bookingUrl = `../TicketBooking/bookticket/index.html?from=${fromAirport}&to=${toAirport}&departure=${departureDate}&return=${returnDate}&class=${seatClass}&adults=${adults}&children=${children}`;
    
    // Redirect to booking page
    window.location.href = bookingUrl;
});
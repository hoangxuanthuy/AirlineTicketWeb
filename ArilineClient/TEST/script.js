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

      
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu Sân bay:', error);
        alert('Không thể tải dữ liệu Sân bay. Vui lòng thử lại!');
    });
}

document.addEventListener('DOMContentLoaded', loadAirports);

const serverIp = 'localhost';
const serverPort = 8001;

// Pagination Logic
const flightsPerPage = 10;
let currentPage = 1;
let totalPages = 0;

const flightCardsContainer = document.querySelector('.flight-list');
const prevBtn = document.querySelector(".prev-btn");
const nextBtn = document.querySelector(".next-btn");
const pageInfo = document.querySelector(".page-info");

let bookingInfo = sessionStorage.getItem('bookingInfo');

function showPage(page) {
    const flightCards = document.querySelectorAll(".flight-card");
    flightCards.forEach((card, index) => {
        card.style.display = (index >= (page - 1) * flightsPerPage && index < page * flightsPerPage) ? "grid" : "none";
    });
    pageInfo.textContent = `Page ${page} of ${totalPages}`;
    prevBtn.disabled = page === 1;
    nextBtn.disabled = page === totalPages;
}

prevBtn.addEventListener("click", () => {
    if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
    }
});

nextBtn.addEventListener("click", () => {
    if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
    }
});

async function fetchAllFlights() {
    try {
        const authToken = sessionStorage.getItem('auth_token');
        if (!authToken) {
            alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
            window.location.href = "../login.php";
            return;
        }
        const response = await fetch(`http://${serverIp}:${serverPort}/api/flights`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const flights = await response.json();
        flightCardsContainer.innerHTML = ''; // Clear existing flight cards

        for (const flight of flights) {
            console.log("departure_airport_id", flight.departure_airport_id);
            const departureAirport = await fetchAirportName(flight.departure_airport_id);
            const arrivalAirport = await fetchAirportName(flight.arrival_airport_id);

            const flightCard = document.createElement('div');
            flightCard.classList.add('flight-card');
            flightCard.innerHTML = `
                <div class="airline-info">
                    <div class="airline-name">
                        <img src="path/to/airlineLogo.png" alt="Airline Logo">
                        Airline Name
                    </div>
                    <div class="seats-left">
                        <img src="path/to/seatsIcon.png" width="16" height="16" alt="">
                        Seats Left
                    </div>
                </div>
                <div class="flight-times">
                    <div class="time-group">
                        <div class="time">${new Date(flight.departure_date_time).toLocaleTimeString()}</div>
                        <div class="airport">Departure: ${departureAirport}</div>
                    </div>
                    <div class="duration">
                        <div>${flight.flight_time}</div>
                        <div>Non-stop</div>
                    </div>
                    <div class="time-group">
                        <div class="time">${new Date(flight.departure_date_time).toLocaleTimeString()}</div>
                        <div class="airport">Arrival: ${arrivalAirport}</div>
                    </div>
                </div>
                <div class="price">
                    <div class="amount">${flight.unit_price} VND</div>
                    <div class="per-person">/khách</div>
                </div>
                <button class="select-button" id="select-flight-${flight.flight_id}">Chọn</button>
            `;
            flightCardsContainer.appendChild(flightCard);

            document.getElementById(`select-flight-${flight.flight_id}`).addEventListener("click", () => {
                if (!sessionStorage.getItem("username")) {
                    alert("Vui lòng đăng nhập trước khi chọn chuyến bay.");
                    window.location.href = "../../Sign In/index.html";
                } else {
                    let bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo')) || {};
                    bookingInfo.flightId = flight.flight_id;                  
                    bookingInfo.departureDateTime = flight.departure_date_time;
                    bookingInfo.unitPrice = flight.unit_price;

                    sessionStorage.setItem('bookingInfo', JSON.stringify(bookingInfo));
                    
                    window.location.href = "../information/index.html";
                }
            });
        }

        totalPages = Math.ceil(flights.length / flightsPerPage);
        showPage(currentPage);
    } catch (error) {
        console.error("Error fetching flights:", error);
    }
}

let airportsCache = {};

async function fetchAllAirports() {
    try {
        const authToken = sessionStorage.getItem('auth_token');
        const response = await fetch(`http://${serverIp}:${serverPort}/api/airports`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const airports = await response.json();
        console.log("Airports:", airports);
        airports.forEach(airport => {
            airportsCache[airport.airport_id] = airport.airport_name;
        });
        console.log("Airports cache:", airportsCache);
    } catch (error) {
        console.error("Error fetching airports:", error);
    }
}

async function fetchAirportName(airportId) {
    return airportsCache[airportId] || "Unknown Airport";
}

document.addEventListener("DOMContentLoaded", async () => {
    await fetchAllAirports();
    await fetchAllFlights();
    updateUserAccountInfo();
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

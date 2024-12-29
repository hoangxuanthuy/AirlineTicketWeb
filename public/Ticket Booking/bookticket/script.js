
// Pagination Logic
const flightsPerPage = 10;
let currentPage = 1;
let totalPages = 0;

const flightCardsContainer = document.querySelector('.flight-list');
const prevBtn = document.querySelector(".prev-btn");
const nextBtn = document.querySelector(".next-btn");
const pageInfo = document.querySelector(".page-info");

let info = JSON.parse(sessionStorage.getItem('bookingInfo'));
let arrival_airport_id = info.toAirport;
let departure_airport_id = info.fromAirport;

// Get airline filter checkboxes
const airlineCheckboxes = document.querySelectorAll('.filter-group input[type="checkbox"]');

// Add event listeners to checkboxes
airlineCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        currentPage = 1;
        showPage(currentPage);
    });
});

// Select stopover checkboxes
const stopoverCheckboxes = document.querySelectorAll('.filter-group input[type="checkbox"][name="stopover"]');

// Add event listeners to stopover checkboxes
stopoverCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        currentPage = 1;
        showPage(currentPage);
    });
});

// Function to get selected airlines
function getSelectedAirlines() {
    const selected = [];
    airlineCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selected.push(checkbox.value);
        }
    });
    return selected;
}

// Function to get selected stopovers
function getSelectedStopovers() {
    const selected = [];
    stopoverCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selected.push('direct'); // Only 'direct' is relevant
        }
    });
    return selected;
}

function showPage(page) {
    const flightCards = document.querySelectorAll(".flight-card");
    const selectedAirlines = getSelectedAirlines();
    const selectedStopovers = getSelectedStopovers();

    // Hide all flight cards if 'Bay thẳng' is unchecked
    if (!selectedStopovers.includes('direct')) {
        flightCards.forEach(card => {
            card.style.display = "none";
        });
        pageInfo.textContent = `Page 0 of 0`;
        prevBtn.disabled = true;
        nextBtn.disabled = true;
        return;
    }

    flightCards.forEach((card, index) => {
        const airline = card.getAttribute('data-airline');
        const stopover = card.getAttribute('data-stopover'); // 'direct'
        const airlineMatch = selectedAirlines.length === 0 || selectedAirlines.includes(airline);
        let stopoverMatch = selectedStopovers.length === 0 || selectedStopovers.includes(stopover);

        const display = (airlineMatch && stopoverMatch && index >= (page - 1) * flightsPerPage && index < page * flightsPerPage) ? "grid" : "none";
        card.style.display = display;
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




document.addEventListener("DOMContentLoaded", async () => {
  

    await fetchAllFlights();
});

async function fetchAllFlights() {
    try {
        const authToken = sessionStorage.getItem('auth_token');
        if (!authToken) {
            alert("Phiên làm việc hết hạn. Vui lòng đăng nhập lại!");
            window.location.href = "../../Sign In/index.php";
            return;
        }
        const response = await fetch(`http://${serverIp}:${serverPort}/api/getflights`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const flights = await response.json();
        
        // Filter flights based on arrival and departure airport IDs
        const filteredFlights = flights.filter(flight => 
            flight.departure_airport_id == departure_airport_id && 
            flight.arrival_airport_id == arrival_airport_id
        );
        flightCardsContainer.innerHTML = ''; // Clear existing flight cards

        const airlineNames = ["VietNamAirline", "Bamboo Airways", "VietJet Air", "Vietravel Airlines"];

        // Function to get image path based on airline name
        function getAirlineImagePath(airlineName) {
            const imagePaths = {
                "VietNamAirline": "img/vietnam-airline-logo.jpg",
                "Bamboo Airways": "img/logo-bamboo-airways-inkythuatso-13-16-29-54.jpg",
                "VietJet Air": "img/VietJet_Air-Logo.wine.png",
                "Vietravel Airlines": "img/OIP.jpg"
            };
            return imagePaths[airlineName] || "../../images/default.png";
        }

        for (const flight of filteredFlights) {
            const departureAirport =getAirportAddress(flight.departure_airport_id);
            const arrivalAirport = getAirportAddress(flight.arrival_airport_id);
            // Determine if the flight is direct based on flight data
            const isDirect = true; // All flights are direct
            const stopoverText = "direct"; // Set stopover text to 'direct'

            const flightCard = document.createElement('div');
            flightCard.classList.add('flight-card');
            
            const airlineName = airlineNames[Math.floor(Math.random() * airlineNames.length)];
            
            flightCard.setAttribute('data-airline', airlineName); // Add data attribute
            flightCard.setAttribute('data-stopover', 'direct'); // Ensure data-stopover is 'direct'

            flightCard.innerHTML = `
                            <div class="airline-info">
                                <div class="airline-name">
                                    <img src="${getAirlineImagePath(airlineName)}" alt="Airline Logo" style="width: 150px; height: auto;">
                                    
                                </div>
                                
                            </div>
                            <div class="flight-times">
                                <div class="time-group">
                                    <div class="time">${new Date(flight.departure_date_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div>
                                    <div class="airport">${departureAirport}</div>
                                </div>
                                <div class="duration">
                                    <div>${flight.flight_time}</div>
                                    <div>${isDirect ? 'Bay thẳng' : '1+ điểm dừng'}</div>
                                </div>
                                <div class="time-group">
                                    <div class="time">${calculateArrivalTime(flight.departure_date_time, flight.flight_time)}</div>
                                    <div class="airport"> ${arrivalAirport}</div>
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
                    window.location.href = "../../Sign In/index.php";
                } else {
                    let bookingInfo = JSON.parse(sessionStorage.getItem('bookingInfo')) || {};
                    bookingInfo.flightId = flight.flight_id;                  
                    bookingInfo.departureDateTime = flight.departure_date_time;
                    bookingInfo.unitPrice = flight.unit_price;

                    sessionStorage.setItem('bookingInfo', JSON.stringify(bookingInfo));
                    
                    window.location.href = "../information/index.php";
                }
            });
        }

        totalPages = Math.ceil(filteredFlights.length / flightsPerPage);
        showPage(currentPage);
    } catch (error) {
        console.error("Error fetching flights:", error);
    }
}

function calculateArrivalTime(departureDateTime, flightTime) {
    const departure = new Date(departureDateTime);
    const [hours, minutes] = flightTime.split('h').map(part => parseInt(part));
    departure.setHours(departure.getHours() + hours);
    departure.setMinutes(departure.getMinutes() + (minutes || 0));
    return departure.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

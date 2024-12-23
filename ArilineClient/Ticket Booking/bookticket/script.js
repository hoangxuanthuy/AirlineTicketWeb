// Gắn sự kiện click cho từng nút theo ID
document.getElementById("select-flight-1").addEventListener("click", function () {
    window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/information/index.html";
});

document.getElementById("select-flight-2").addEventListener("click", function () {
    window.location.href = "/TCN/TCN.html?flight=2";
});

// Removed DOMContentLoaded wrapper
const dropdown = document.querySelector(".dropdown-toggle");
const dropdownMenu = document.querySelector(".dropdown-menu");

dropdown.addEventListener("click", (e) => {
    e.preventDefault();
    // Toggle dropdown menu
    dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
});

// Đóng menu khi click bên ngoài
document.addEventListener("click", (e) => {
    if (!dropdown.contains(e.target)) {
        dropdownMenu.style.display = "none";
    }
});

// document.querySelector('.menu-toggle').addEventListener('click', () => {
//     document.querySelector('.nav-menu').classList.toggle('show');
// });

// Pagination Logic
const flightCards = document.querySelectorAll(".flight-card");
const prevBtn = document.querySelector(".prev-btn");
const nextBtn = document.querySelector(".next-btn");
const pageInfo = document.querySelector(".page-info");
const flightsPerPage = 10;
let currentPage = 1;
const totalPages = Math.ceil(flightCards.length / flightsPerPage);

function showPage(page) {
    flightCards.forEach((card, index) => {
        if (index >= (page - 1) * flightsPerPage && index < page * flightsPerPage) {
            card.style.display = "grid";
        } else {
            card.style.display = "none";
        }
    });
    pageInfo.textContent = `Page ${page} of ${totalPages}`;
    prevBtn.disabled = page === 1;
    nextBtn.disabled = page === totalPages;
}

prevBtn.addEventListener("click", () => {
    console.log("Previous button clicked");
    if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
    }
});

nextBtn.addEventListener("click", () => {
    console.log("Next button clicked");
    if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
    }
});

showPage(currentPage);

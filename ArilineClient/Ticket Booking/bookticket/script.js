// Gắn sự kiện click cho từng nút theo ID
document.getElementById("select-flight-1").addEventListener("click", function () {
    window.location.href = "http://127.0.0.1:5501/ArilineClient/Ticket%20Booking/information/index.html";
});

document.getElementById("select-flight-2").addEventListener("click", function () {
    window.location.href = "/TCN/TCN.html?flight=2";
});

document.addEventListener("DOMContentLoaded", () => {
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
});

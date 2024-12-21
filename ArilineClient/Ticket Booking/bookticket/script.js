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

    // Pagination Logic
    const flightCards = document.querySelectorAll('.flight-card');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const pageInfo = document.querySelector('.page-info');

    let currentPage = 1;
    const flightsPerPage = 7;
    const totalPages = Math.ceil(flightCards.length / flightsPerPage);

    function showPage(page) {
        flightCards.forEach((card, index) => {
            card.style.display = (index >= (page - 1) * flightsPerPage && index < page * flightsPerPage) ? 'grid' : 'none';
        });
        pageInfo.textContent = `Page ${page} of ${totalPages}`;
        prevBtn.disabled = page === 1;
        nextBtn.disabled = page === totalPages;
    }

    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });

    // Initialize pagination
    showPage(currentPage);
});

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

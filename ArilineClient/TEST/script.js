// script.js

// Lắng nghe sự kiện nhấp chuột trên các liên kết
document.getElementById("home-link").addEventListener("click", function () {
    window.location.href = "/index.html"; // Đường dẫn đến trang chủ
});

document.getElementById("journey-info-link").addEventListener("click", function () {
    window.location.href = "/Ticket Booking//TCN.html"; // Đường dẫn đến trang thông tin hành trình
});

document.getElementById("signin-link").addEventListener("click", function () {
    window.location.href = "/Sign In/index.html"; // Đường dẫn đến trang đăng nhập
});

document.getElementById("signup-link").addEventListener("click", function () {
    window.location.href = "/Sign Up/index.html"; // Đường dẫn đến trang đăng ký
});


document.querySelector('.dropdown-toggle').addEventListener('click', function () {
    const menu = document.querySelector('.dropdown-menu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.banner-slide');
    const prevButton = document.querySelector('.banner-prev');
    const nextButton = document.querySelector('.banner-next');
    const dotsContainer = document.querySelector('.banner-dots');
    let currentSlide = 0;

    // Create dots
    slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('banner-dot');
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.banner-dot');

    function showSlide(n) {
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function goToSlide(n) {
        showSlide(n);
    }

    prevButton.addEventListener('click', prevSlide);
    nextButton.addEventListener('click', nextSlide);

    // Auto-advance slides every 5 seconds
    setInterval(nextSlide, 5000);

    // Show the first slide
    showSlide(0);
});

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Booking</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <header class="header">
        <div class="header-content">
            <img src="img/Logo.png" alt="JO4 Airlines" class="logo">
            <nav class="nav-menu">
                <a href="../TEST/index.php" id="home-link">Trang chủ</a>
                <a href="#" id="journey-info-link">Thông tin hành trình</a>
                <a href="#">Liên hệ</a>

                <!-- Dropdown Tài khoản -->
                <div class="dropdown" id="account-dropdown">
                    <a href="#" class="dropdown-toggle" id="user-account">Tài khoản</a>
                    <ul class="dropdown-menu" id="account-menu">
                        <li><a href="../Sign In/index.php" id="signin-link">Đăng nhập</a></li>
                        <li><a href="../Sign Up/index.php" id="signup-link">Đăng ký</a></li>
                    </ul>
                </div>

            </nav>
        </div>
    </header>
    <main>
        <section class="banner-section">
            <div class="banner-container">
                <div class="banner-slide">
                    <img src="img/1.png" alt="Banner 1">
                </div>
                <div class="banner-slide">
                    <img src="img/2.png" alt="Banner 2">
                </div>
                <div class="banner-slide">
                    <img src="img/5.png" alt="Banner 3">
                </div>
                <button class="banner-prev">&lt;</button>
                <button class="banner-next">&gt;</button>
                <div class="banner-dots"></div>
            </div>
        </section>
        <!-- Main Content -->
        <main class="main-content">
            <!-- Flight Search Form -->
            <div class="search-box">
                <div class="search-grid">
                    <!-- From -->
                    <div class="search-item">
                        <label>Từ</label>
                        <div class="input-with-icon">
                            <i style="margin-top: 15px;" class="fas fa-plane-departure"></i>
                            <div class="input-content">
                                <!-- Replace static text with a dropdown -->
                                <select id="from-airport">
                                    <option>Loading airports...</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- To -->
                    <div class="search-item">
                        <label>Đến</label>
                        <div class="input-with-icon">
                            <i style="margin-top: 15px;" class="fas fa-plane-arrival"></i>
                            <div class="input-content">
                                <select id="to-airport">
                                    <option>Loading airports...</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Passengers -->
                    <div class="search-item">
                        <label>Chọn hành khách</label>
                        <div class="input-with-icon">
                            <i style="margin-top: 15px;" class="fas fa-users"></i>
                            <div class="input-content">
                                <div class="passenger-controls">
                                    <div class="passenger-type">
                                        <span style="display: block; width: 90px;">Người lớn</span>
                                        <!-- <button type="button" class="decrement" data-type="adults">−</button>
                                        <span id="adults-count">1</span>
                                        <button type="button" class="increment" data-type="adults">+</button> -->
                                        <input type="checkbox" id="customer" checked>
                                    </div>
                                    <div class="passenger-type">
                                        <span style="display: block; width: 90px;">Trẻ em</span>
                                        <!-- <button type="button" class="decrement" data-type="children">−</button>
                                        <span id="children-count">0</span>
                                        <button type="button" class="increment" data-type="children">+</button> -->
                                        <input type="checkbox" id="customer">
                                    </div>
                                </div>
                                <div class="main-text"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Departure Date -->
                    <div class="search-item">
                        <label>Ngày đi</label>
                        <div class="input-with-icon">
                            <i style="margin-top: 15px;" class="far fa-calendar"></i>
                            <div class="input-content">
                                <input type="date" id="departure-date" value="2024-09-27">
                            </div>
                        </div>
                    </div>

                    <!-- Return Date -->
                    <div class="search-item">
                        <!-- <label>Ngày khứ hồi</label> -->
                        <div class="checkbox-group">
                            <input style="margin-bottom: 10px;" type="checkbox" id="roundTrip">
                            <label for="roundTrip">Khứ hồi</label>
                        </div>
                        <div class="input-with-icon" id="khuhoi" style="display: none;">
                            <i style="margin-top: 15px;" class="far fa-calendar"></i>
                            <div class="input-content">
                                <input type="date" id="return-date" value="2024-09-29">

                            </div>
                        </div>
                    </div>

                    <!-- Seat Class -->
                    <div class="search-item">
                        <label>Hạng ghế</label>
                        <div class="input-with-icon">
                            <i style="margin-top: 15px;" class="fas fa-chair"></i>
                            <div class="input-content">
                                <select id="seat-class">
                                    <option>Loading seat classes...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="search-btn" id="button2">
                    <i class="fas fa-search"></i>
                    Tìm kiếm
                </button>
            </div>



            <section class="destinations">
                <h2>KHÁM PHÁ ĐIỂM ĐẾN</h2>
                <div class="destinations-grid">
                    <div class="destination-card">
                        <img src="img/tokyo.jpg" alt="Tokyo">
                        <div class="destination-info">
                            <h3>Tokyo - Thủ đô hiện đại và truyền thống</h3>
                        </div>
                    </div>
                    <div class="destination-card">
                        <img src="img/hội an.jpg" alt="Hội An">
                        <div class="destination-info">
                            <h3>Hội An - Thành phố cổ </h3>
                        </div>
                    </div>
                    <div class="destination-card">
                        <img src="img/dalt.jpg" alt="Đà Lạt">
                        <div class="destination-info">
                            <h3>Đà Lạt - Một Paris thu nhỏ</h3>
                        </div>
                    </div>
                </div>
            </section>

            <section class="promotions">
                <h2>ƯU ĐÃI</h2>
                <div class="promo-grid">
                    <div class="promo-card"></div>
                    <div class="promo-card"></div>
                    <div class="promo-card"></div>
                    <div class="promo-card"></div>
                </div>
            </section>

            <section class="payment-partners">
                <div class="payment-partners">
                    <h2>Đối Tác Thanh Toán</h2>
                    <p>Chúng tôi hợp tác với các đối tác thanh toán đáng tin cậy để đảm bảo giao dịch của bạn được xử lý
                        an toàn và nhanh chóng.</p>
                    <div class="partners-grid">
                        <div class="partner-item">
                            <img src="img/vcb.webp" alt="Partner 1">
                        </div>
                        <div class="partner-item">
                            <img src="img/agrib.jpg" alt="Partner 2">
                        </div>
                        <div class="partner-item">
                            <img src="img/bidv.jpg" alt="Partner 3">
                        </div>
                        <div class="partner-item">
                            <img src="img/mb.jpg" alt="Partner 4">
                        </div>
                        <div class="partner-item">
                            <img src="img/onepay.png" alt="Partner 5">
                        </div>
                        <div class="partner-item">
                            <img src="img/Techcombank_logo.png" alt="Partner 6">
                        </div>
                        <div class="partner-item">
                            <img src="img/ocb.png" alt="Partner 7">
                        </div>
                        <div class="partner-item">
                            <img src="img/vp.jpg" alt="Partner 8">
                        </div>
                        <div class="partner-item">
                            <img src="img/acb.svg" alt="Partner 9">
                        </div>
                        <div class="partner-item">
                            <img src="img/lienviet.png" alt="Partner 10">
                        </div>
                        <div class="partner-item">
                            <img src="img/Logo-ZaloPay-2s.webp" alt="Partner 11">
                        </div>
                        <div class="partner-item">
                            <img src="img/vib.png" alt="Partner 12">
                        </div>
                        <div class="partner-item">
                            <img src="img/viettin.jpg" alt="Partner 13">
                        </div>
                        <div class="partner-item">
                            <img src="img/donga.jpg" alt="Partner 14">
                        </div>
                        <div class="partner-item">
                            <img src="img/sacom.jpg" alt="Partner 15">
                        </div>
                        <div class="partner-item">
                            <img src="img/tp.jpg" alt="Partner 16">
                        </div>
                    </div>
                </div>

            </section>

            <!-- Phần "Tại sao nên đặt vé" -->
            <section class="why-book">
                <h2>Tại sao nên đặt vé với chúng tôi?</h2>
                <div class="reasons-grid">
                    <div class="reason-item">
                        <i class="fa fa-check-circle reason-icon"></i>
                        <h3>Tiết kiệm thời gian</h3>
                        <p>Quá trình đặt vé nhanh chóng và dễ dàng, giúp bạn tiết kiệm thời gian cho những chuyến đi của
                            mình.</p>
                    </div>
                    <div class="reason-item">
                        <i class="fa fa-credit-card reason-icon"></i>
                        <h3>An toàn và bảo mật</h3>
                        <p>Chúng tôi cung cấp hệ thống thanh toán an toàn, bảo mật tuyệt đối với mọi giao dịch của bạn.
                        </p>
                    </div>
                    <div class="reason-item">
                        <i class="fa fa-globe reason-icon"></i>
                        <h3>Đi khắp nơi</h3>
                        <p>Hệ thống của chúng tôi hỗ trợ đặt vé cho nhiều điểm đến quốc tế và trong nước.</p>
                    </div>
                    <div class="reason-item">
                        <i class="fa fa-star reason-icon"></i>
                        <h3>Đánh giá từ khách hàng</h3>
                        <p>Có hàng nghìn đánh giá tích cực từ khách hàng, đảm bảo bạn sẽ có một trải nghiệm tuyệt vời.
                        </p>
                    </div>
                </div>
            </section>

            <footer class="footer">
                <div class="footer-content">
                    <div class="footer-logo">
                        <img src="img/Logo.png" alt="JO4 Travel">
                        <p>Your number one travel agency</p>
                    </div>
                    <div class="footer-links">
                        <div class="footer-column">
                            <h3>JO4 Airlines</h3>
                            <ul>
                                <li><a href="#">Giới thiệu công ty</a></li>
                                <li><a href="#">Đặt bay</a></li>
                                <li><a href="#">Đối tác</a></li>
                                <li><a href="#">Thông tin truyền thông</a></li>
                                <li><a href="#">Trách nhiệm xã hội</a></li>
                                <li><a href="#">Quan hệ cổ đông</a></li>
                                <li><a href="#">Về chúng tôi</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h3>Pháp lý</h3>
                            <ul>
                                <li><a href="#">Các điều kiện & điều khoản</a></li>
                                <li><a href="#">Điều lệ vận chuyển</a></li>
                                <li><a href="#">Điều khoản sử dụng cookies</a></li>
                                <li><a href="#">Bảo mật thông tin</a></li>
                                <li><a href="#">Quy chế hoạt động sàn TMDT</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h3>Hỗ trợ</h3>
                            <ul>
                                <li><a href="#">Góp ý dịch vụ</a></li>
                                <li><a href="#">Trung tâm trợ giúp</a></li>
                                <li><a href="#">Chính sách bảo vệ hành khách</a></li>
                                <li><a href="#">Ứng dụng di động</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h3>Liên hệ</h3>
                            <ul>
                                <li><a href="#">Giới thiệu công ty</a></li>
                                <li><a href="#">Đặt bay</a></li>
                                <li><a href="#">Đối tác</a></li>
                                <li><a href="#">Thông tin truyền thông</a></li>
                                <li><a href="#">Trách nhiệm xã hội</a></li>
                                <li><a href="#">Quan hệ cổ đông</a></li>
                                <li><a href="#">Về chúng tôi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </main>

        <script src="../Sign In/script.js" type="module"></script>
        <script>
            const username = sessionStorage.getItem('username');
            if (username) {
                document.getElementById('user-account').textContent = username;
            }

            // Retrieve and display selected flight data
            const selectedFlight = JSON.parse(sessionStorage.getItem("selectedFlight"));
            if (selectedFlight) {
                console.log(selectedFlight);
                document.getElementById("departure-date").textContent = selectedFlight.departure_time; // Updated property
                document.getElementById("departure-airport").textContent = selectedFlight.departure_airport;
                document.getElementById("departure-time").textContent = selectedFlight.departure_time;
                document.getElementById("departure-arrival-time").textContent = selectedFlight.arrival_time;
            }


            document.addEventListener("DOMContentLoaded", () => {
                const roundTripCheckbox = document.getElementById("roundTrip");
                const inputWithIcon = document.querySelector("#khuhoi");

                // Kiểm tra trạng thái checkbox khi người dùng thay đổi
                roundTripCheckbox.addEventListener("change", () => {
                    if (roundTripCheckbox.checked) {
                        inputWithIcon.style.display = "flex"; // Hiển thị div khi checkbox được chọn
                    } else {
                        inputWithIcon.style.display = "none"; // Ẩn div khi checkbox không được chọn
                    }
                });
            });


        </script>
        <script src="../Ticket Booking/FlightSearchForm.js" type="module"></script>
        <script src="script.js" type="module"></script>
</body>
</body>

</html>
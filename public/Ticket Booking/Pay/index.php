<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media (max-width: 600px) {
            .search-grid {
                display: block;
            }

            .search-item {
                margin-bottom: 10px;
            }

            .payment-container {
                display: flex;
                flex-direction: column;
            }

            .payment-summary,
            .price-details {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <img src="img/Logo.png" alt="JO4 Airlines" class="logo">
            <nav class="nav-menu">
                <a href="../../TEST/index.php">Trang chủ</a>
                <a href="#">Thông tin hành trình</a>
                <a href="#">Liên hệ</a>
                <!-- Dropdown Tài khoản -->
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" id="user-account">Tài khoản</a>
                    <ul class="dropdown-menu" id="account-menu">
                        <li><a href="../../Sign In/index.php">Đăng nhập</a></li>
                        <li><a href="../../Sign Up/index.php">Đăng ký</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

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
                                    <input  type="checkbox" id="customer" checked>
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
            <button type="button" class="search-btn" id="button1">
                <i class="fas fa-search"></i>
                Tìm kiếm
            </button>
        </div>

        <!-- ... (rest of the HTML remains the same) ... -->



        <!-- Progress Bar -->
        <div class="progress-bar">
            <a href="#" class="progress-step ">
                <span class="step-icon"><i class="fas fa-info-circle"></i></span>
                <span class="step-text">Điền thông tin</span>
            </a>
            <a href="#" class="progress-step">
                <span class="step-icon"><i class="fas fa-chair"></i></span>
                <span class="step-text">Chọn chỗ ngồi</span>
            </a>
            <a href="#" class="progress-step">
                <span class="step-icon"><i class="fas fa-check-circle"></i></span>
                <span class="step-text">Xem lại</span>
            </a>
            <a href="#" class="progress-step active">
                <span class="step-icon"><i class="fas fa-credit-card"></i></span>
                <span class="step-text">Thanh toán</span>
            </a>
        </div>
        <div class="payment-container">
            <div class="payment-summary">
                <div class="summary-item">
                    <label>Tổng tiền:</label>
                    <span class="amount">2.960.000VND</span>
                </div>

                <div class="summary-item">
                    <label>Mã khuyến mãi:</label>
                    <input type="text" id="promoCode" placeholder="Nhập mã khuyến mãi">
                </div>

                <div class="summary-item final-amount">
                    <label>Thành tiền:</label>
                    <span class="amount">2.960.000VND</span>
                </div>

                <button class="zalopay-button">
                    <img src="zalopay-icon.png" alt="ZaloPay" class="zalopay-icon">
                    <span>Thanh toán với ZaloPay</span>
                </button>
            </div>

            <div class="price-details">
                <h2>Giá bạn trả</h2>
                <div class="price-list">
                    <div class="price-item">
                        <div class="trip-info">
                            <div class="date" id="departure-date-1">27-09-2024</div>
                            <div id="departure-airport-2" class="departure-airport-2">TP HCM - Đà Nẵng</div>
                        </div>
                        <div class="price">1.240.000 VND</div>
                    </div>

                    <!-- <div class="price-item">
                        <div class="trip-info">
                            <div class="date">29-09-2024</div>
                            <div class="route">Đà Nẵng - TP HCM</div>
                        </div>
                        <div class="price">1.240.000 VND</div>
                    </div> -->

                    <div class="price-item">
                        <div class="trip-info">
                            <div id ="cccc" class="route">Hành lý tới Đà Nẵng</div>
                        </div>
                        <div class="price">240.000 VND</div>
                    </div>

                    <div id="toast">
                        
                    </div>

                    <!-- <div class="price-item">
                        <div class="trip-info">
                            <div class="route">Hành lý tới TP HCM</div>
                        </div>
                        <div class="price">240.000 VND</div>
                    </div> -->
                </div>
            </div>
        </div>
    </main>

    <script src="../FlightSearchForm.js"></script>
    <script src="script.js"></script>
    <script>
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
</body>

</html>
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 21, 2024 lúc 03:07 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qwerty`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `citizen_id` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`account_id`, `email`, `password`, `account_name`, `citizen_id`, `phone`) VALUES
(1, 'john.doe@example.com', 'password123', 'John Doe', 'A123456789', '555-1234'),
(2, 'jane.smith@example.com', 'password456', 'Jane Smith', 'B987654321', '555-5678');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `airline`
--

CREATE TABLE `airline` (
  `airline_id` bigint(20) UNSIGNED NOT NULL,
  `airline_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `airline`
--

INSERT INTO `airline` (`airline_id`, `airline_name`) VALUES
(1, 'Delta Airlines'),
(2, 'United Airlines');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `airport`
--

CREATE TABLE `airport` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `airport_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `airport`
--

INSERT INTO `airport` (`id`, `airport_name`, `address`) VALUES
(1, 'JFK International', 'New York, NY'),
(2, 'LAX International', 'Los Angeles, CA');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking`
--

CREATE TABLE `booking` (
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `seat_id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `luggage_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `booking_issuance_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `booking`
--

INSERT INTO `booking` (`booking_id`, `seat_id`, `flight_id`, `client_id`, `luggage_id`, `promotion_id`, `status`, `booking_issuance_date`) VALUES
(1, 1, 1, 1, 1, 1, 'Confirmed', '2024-11-20'),
(2, 2, 2, 2, 2, 2, 'Pending', '2024-11-21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `client`
--

CREATE TABLE `client` (
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `citizen_id` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `birth_day` date NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `client`
--

INSERT INTO `client` (`client_id`, `client_name`, `citizen_id`, `phone`, `gender`, `birth_day`, `country`) VALUES
(1, 'John Doe', 'A123456789', '555-1234', 'Male', '1985-06-15', 'USA'),
(2, 'Jane Smith', 'B987654321', '555-5678', 'Female', '1990-12-01', 'Canada');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flight`
--

CREATE TABLE `flight` (
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `plane_id` bigint(20) UNSIGNED NOT NULL,
  `departure_airport_id` bigint(20) UNSIGNED NOT NULL,
  `arrival_airport_id` bigint(20) UNSIGNED NOT NULL,
  `gate_id` bigint(20) UNSIGNED NOT NULL,
  `flight_time` time NOT NULL,
  `departure_date_time` datetime NOT NULL,
  `unit_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `flight`
--

INSERT INTO `flight` (`flight_id`, `plane_id`, `departure_airport_id`, `arrival_airport_id`, `gate_id`, `flight_time`, `departure_date_time`, `unit_price`) VALUES
(1, 1, 1, 2, 1, '05:30:00', '2024-12-01 08:00:00', 500),
(2, 2, 2, 1, 2, '06:15:00', '2024-12-02 09:30:00', 700);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gate`
--

CREATE TABLE `gate` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `airport_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gate`
--

INSERT INTO `gate` (`id`, `airport_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `intermediate`
--

CREATE TABLE `intermediate` (
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `intermediate_airport_id` bigint(20) UNSIGNED NOT NULL,
  `stopover_time` time NOT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `intermediate`
--

INSERT INTO `intermediate` (`flight_id`, `intermediate_airport_id`, `stopover_time`, `note`) VALUES
(1, 1, '01:00:00', 'Short stopover at JFK'),
(2, 2, '01:30:00', 'Layover at LAX');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `luggage`
--

CREATE TABLE `luggage` (
  `luggage_id` bigint(20) UNSIGNED NOT NULL,
  `weight` double NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `luggage`
--

INSERT INTO `luggage` (`luggage_id`, `weight`, `price`) VALUES
(1, 15.5, 50),
(2, 20, 75);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_11_04_053756_create_all_tables', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `plane`
--

CREATE TABLE `plane` (
  `plane_id` bigint(20) UNSIGNED NOT NULL,
  `plane_name` varchar(255) NOT NULL,
  `airline_id` bigint(20) UNSIGNED NOT NULL,
  `first_class_seats` int(11) NOT NULL,
  `second_class_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `plane`
--

INSERT INTO `plane` (`plane_id`, `plane_name`, `airline_id`, `first_class_seats`, `second_class_seats`) VALUES
(1, 'Boeing 747', 1, 20, 150),
(2, 'Airbus A380', 2, 30, 200);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotion`
--

CREATE TABLE `promotion` (
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount_percentage` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `promotion`
--

INSERT INTO `promotion` (`promotion_id`, `promotion_name`, `start_date`, `end_date`, `discount_percentage`) VALUES
(1, 'Holiday Discount', '2024-12-01', '2024-12-31', 10),
(2, 'Summer Sale', '2024-06-01', '2024-06-30', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seat`
--

CREATE TABLE `seat` (
  `seat_id` bigint(20) UNSIGNED NOT NULL,
  `seat_class_id` bigint(20) UNSIGNED NOT NULL,
  `plane_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `seat`
--

INSERT INTO `seat` (`seat_id`, `seat_class_id`, `plane_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 2),
(4, 2, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seatclass`
--

CREATE TABLE `seatclass` (
  `seat_class_id` bigint(20) UNSIGNED NOT NULL,
  `seat_class_name` varchar(255) NOT NULL,
  `price_ratio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `seatclass`
--

INSERT INTO `seatclass` (`seat_class_id`, `seat_class_name`, `price_ratio`) VALUES
(1, 'First Class', 1.5),
(2, 'Economy', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seatflight`
--

CREATE TABLE `seatflight` (
  `seat_id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `seatflight`
--

INSERT INTO `seatflight` (`seat_id`, `flight_id`, `status`) VALUES
(1, 1, 'Available'),
(2, 2, 'Reserved');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `seat_id` bigint(20) UNSIGNED NOT NULL,
  `promotion_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `luggage_id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_issuance_date` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `seat_id`, `promotion_id`, `client_id`, `luggage_id`, `flight_id`, `ticket_issuance_date`, `status`) VALUES
(1, 1, 1, 1, 1, 1, '2024-11-20', 'Active'),
(2, 2, 2, 2, 2, 2, '2024-11-21', 'Pending');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`);

--
-- Chỉ mục cho bảng `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`airline_id`);

--
-- Chỉ mục cho bảng `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `booking_seat_id_foreign` (`seat_id`),
  ADD KEY `booking_flight_id_foreign` (`flight_id`),
  ADD KEY `booking_client_id_foreign` (`client_id`),
  ADD KEY `booking_luggage_id_foreign` (`luggage_id`),
  ADD KEY `booking_promotion_id_foreign` (`promotion_id`);

--
-- Chỉ mục cho bảng `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- Chỉ mục cho bảng `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_id`),
  ADD KEY `flight_plane_id_foreign` (`plane_id`),
  ADD KEY `flight_departure_airport_id_foreign` (`departure_airport_id`),
  ADD KEY `flight_arrival_airport_id_foreign` (`arrival_airport_id`),
  ADD KEY `flight_gate_id_foreign` (`gate_id`);

--
-- Chỉ mục cho bảng `gate`
--
ALTER TABLE `gate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gate_airport_id_foreign` (`airport_id`);

--
-- Chỉ mục cho bảng `intermediate`
--
ALTER TABLE `intermediate`
  ADD PRIMARY KEY (`flight_id`,`intermediate_airport_id`),
  ADD KEY `intermediate_intermediate_airport_id_foreign` (`intermediate_airport_id`);

--
-- Chỉ mục cho bảng `luggage`
--
ALTER TABLE `luggage`
  ADD PRIMARY KEY (`luggage_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `plane`
--
ALTER TABLE `plane`
  ADD PRIMARY KEY (`plane_id`),
  ADD KEY `plane_airline_id_foreign` (`airline_id`);

--
-- Chỉ mục cho bảng `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`promotion_id`);

--
-- Chỉ mục cho bảng `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `seat_seat_class_id_foreign` (`seat_class_id`),
  ADD KEY `seat_plane_id_foreign` (`plane_id`);

--
-- Chỉ mục cho bảng `seatclass`
--
ALTER TABLE `seatclass`
  ADD PRIMARY KEY (`seat_class_id`);

--
-- Chỉ mục cho bảng `seatflight`
--
ALTER TABLE `seatflight`
  ADD PRIMARY KEY (`seat_id`,`flight_id`),
  ADD KEY `seatflight_flight_id_foreign` (`flight_id`);

--
-- Chỉ mục cho bảng `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `ticket_seat_id_foreign` (`seat_id`),
  ADD KEY `ticket_promotion_id_foreign` (`promotion_id`),
  ADD KEY `ticket_client_id_foreign` (`client_id`),
  ADD KEY `ticket_luggage_id_foreign` (`luggage_id`),
  ADD KEY `ticket_flight_id_foreign` (`flight_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `account_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `airport`
--
ALTER TABLE `airport`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `client`
--
ALTER TABLE `client`
  MODIFY `client_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `gate`
--
ALTER TABLE `gate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `luggage`
--
ALTER TABLE `luggage`
  MODIFY `luggage_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `plane`
--
ALTER TABLE `plane`
  MODIFY `plane_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `promotion`
--
ALTER TABLE `promotion`
  MODIFY `promotion_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `seat`
--
ALTER TABLE `seat`
  MODIFY `seat_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `seatclass`
--
ALTER TABLE `seatclass`
  MODIFY `seat_class_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `booking_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `booking_luggage_id_foreign` FOREIGN KEY (`luggage_id`) REFERENCES `luggage` (`luggage_id`),
  ADD CONSTRAINT `booking_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`promotion_id`),
  ADD CONSTRAINT `booking_seat_id_foreign` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`);

--
-- Các ràng buộc cho bảng `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_arrival_airport_id_foreign` FOREIGN KEY (`arrival_airport_id`) REFERENCES `airport` (`id`),
  ADD CONSTRAINT `flight_departure_airport_id_foreign` FOREIGN KEY (`departure_airport_id`) REFERENCES `airport` (`id`),
  ADD CONSTRAINT `flight_gate_id_foreign` FOREIGN KEY (`gate_id`) REFERENCES `gate` (`id`),
  ADD CONSTRAINT `flight_plane_id_foreign` FOREIGN KEY (`plane_id`) REFERENCES `plane` (`plane_id`);

--
-- Các ràng buộc cho bảng `gate`
--
ALTER TABLE `gate`
  ADD CONSTRAINT `gate_airport_id_foreign` FOREIGN KEY (`airport_id`) REFERENCES `airport` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `intermediate`
--
ALTER TABLE `intermediate`
  ADD CONSTRAINT `intermediate_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `intermediate_intermediate_airport_id_foreign` FOREIGN KEY (`intermediate_airport_id`) REFERENCES `airport` (`id`);

--
-- Các ràng buộc cho bảng `plane`
--
ALTER TABLE `plane`
  ADD CONSTRAINT `plane_airline_id_foreign` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`);

--
-- Các ràng buộc cho bảng `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `seat_plane_id_foreign` FOREIGN KEY (`plane_id`) REFERENCES `plane` (`plane_id`),
  ADD CONSTRAINT `seat_seat_class_id_foreign` FOREIGN KEY (`seat_class_id`) REFERENCES `seatclass` (`seat_class_id`);

--
-- Các ràng buộc cho bảng `seatflight`
--
ALTER TABLE `seatflight`
  ADD CONSTRAINT `seatflight_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `seatflight_seat_id_foreign` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`);

--
-- Các ràng buộc cho bảng `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `ticket_flight_id_foreign` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `ticket_luggage_id_foreign` FOREIGN KEY (`luggage_id`) REFERENCES `luggage` (`luggage_id`),
  ADD CONSTRAINT `ticket_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`promotion_id`),
  ADD CONSTRAINT `ticket_seat_id_foreign` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`seat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

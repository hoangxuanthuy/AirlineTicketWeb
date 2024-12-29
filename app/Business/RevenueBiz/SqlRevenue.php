<?php

namespace App\Business\RevenueBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlRevenue
{
    
    // Lấy thông tin thống kê doanh thu
    public function getMonthlyRevenue($year, $month = null)
{
    if ($month === null) {
        // Truy vấn khi không có tháng
        return DB::select("
            SELECT 
                f.flight_id,
                MONTH(f.departure_date_time) AS month,
                COUNT(t.ticket_id) AS tickets, -- Số lượng vé đã bán
                SUM(
                    CASE
                        WHEN sc.seat_class_id = 1 THEN f.unit_price * 1.05 -- Giá hạng 1
                        WHEN sc.seat_class_id = 2 THEN f.unit_price * 1.00 -- Giá hạng 2
                        ELSE 0
                    END
                ) AS revenue
            FROM Flight f
            LEFT JOIN Ticket t ON f.flight_id = t.flight_id 
                                AND t.status = 'confirmed' 
                                AND t.IsDeleted = 0
            LEFT JOIN Seat s ON t.seat_id = s.seat_id
            LEFT JOIN SeatClass sc ON s.seat_class_id = sc.seat_class_id
            WHERE YEAR(f.departure_date_time) = :year
              AND f.IsDeleted = 0
            GROUP BY f.flight_id, MONTH(f.departure_date_time)
            ORDER BY revenue DESC
        ", ['year' => $year]);
    } else {
        // Truy vấn khi có tháng
        return DB::select("
            SELECT 
                f.flight_id,
                COUNT(t.ticket_id) AS tickets, -- Số lượng vé đã bán
                SUM(
                    CASE
                        WHEN sc.seat_class_id = 1 THEN f.unit_price * 1.05 -- Giá hạng 1
                        WHEN sc.seat_class_id = 2 THEN f.unit_price * 1.00 -- Giá hạng 2
                        ELSE 0
                    END
                ) AS revenue,
                ROUND(
                    SUM(
                        CASE
                            WHEN sc.seat_class_id = 1 THEN f.unit_price * 1.05
                            WHEN sc.seat_class_id = 2 THEN f.unit_price * 1.00
                            ELSE 0
                        END
                    ) / (
                        SELECT 
                            COALESCE(SUM(
                                CASE
                                    WHEN sc2.seat_class_id = 1 THEN f2.unit_price * 1.05
                                    WHEN sc2.seat_class_id = 2 THEN f2.unit_price * 1.00
                                    ELSE 0
                                END
                            ), 1) -- Đảm bảo không chia cho 0
                        FROM Flight f2
                        LEFT JOIN Ticket t2 ON f2.flight_id = t2.flight_id 
                                             AND t2.status = 'confirmed'
                                             AND t2.IsDeleted = 0
                        LEFT JOIN Seat s2 ON t2.seat_id = s2.seat_id
                        LEFT JOIN SeatClass sc2 ON s2.seat_class_id = sc2.seat_class_id
                        WHERE YEAR(f2.departure_date_time) = :year_total 
                          AND MONTH(f2.departure_date_time) = :month_total
                          AND f2.IsDeleted = 0
                    ) * 100, 2
                ) AS revenue_ratio -- Tỷ lệ doanh thu
            FROM Flight f
            LEFT JOIN Ticket t ON f.flight_id = t.flight_id 
                                AND t.status = 'confirmed' 
                                AND t.IsDeleted = 0
            LEFT JOIN Seat s ON t.seat_id = s.seat_id
            LEFT JOIN SeatClass sc ON s.seat_class_id = sc.seat_class_id
            WHERE YEAR(f.departure_date_time) = :year 
              AND MONTH(f.departure_date_time) = :month
              AND f.IsDeleted = 0
            GROUP BY f.flight_id
            ORDER BY revenue DESC
        ", ['year' => $year, 'month' => $month, 'year_total' => $year, 'month_total' => $month]);
    }
}
    public function getYearlyRevenueByMonth($year)
    {
        return DB::select("
            SELECT 
                MONTH(f.departure_date_time) AS month,
                SUM(
                    CASE
                        WHEN sc.seat_class_id = 1 THEN f.unit_price * 1.05
                        WHEN sc.seat_class_id = 2 THEN f.unit_price * 1.00
                        ELSE 0
                    END
                ) AS total_revenue
            FROM Flight f
            LEFT JOIN Ticket t ON f.flight_id = t.flight_id AND t.status = 'confirmed' AND t.IsDeleted = 0
            LEFT JOIN Seat s ON t.seat_id = s.seat_id
            LEFT JOIN SeatClass sc ON s.seat_class_id = sc.seat_class_id
            WHERE YEAR(f.departure_date_time) = :year
              AND f.IsDeleted = 0
            GROUP BY MONTH(f.departure_date_time)
            ORDER BY MONTH(f.departure_date_time)
        ", ['year' => $year]);
    }
    public function getYearlyByMonth($year)
    {
        return DB::select("
            SELECT 
                MONTH(f.departure_date_time) AS month,
                COUNT(f.flight_id) AS number_of_flights,
                SUM(
                    CASE
                        WHEN sc.seat_class_id = 1 THEN f.unit_price * 1.05
                        WHEN sc.seat_class_id = 2 THEN f.unit_price * 1.00
                        ELSE 0
                    END
                ) AS revenue
            FROM Flight f
            LEFT JOIN Ticket t ON f.flight_id = t.flight_id AND t.status = 'confirmed' AND t.IsDeleted = 0
            LEFT JOIN Seat s ON t.seat_id = s.seat_id
            LEFT JOIN SeatClass sc ON s.seat_class_id = sc.seat_class_id
            WHERE YEAR(f.departure_date_time) = :year AND f.IsDeleted = 0
            GROUP BY MONTH(f.departure_date_time)
            ORDER BY MONTH(f.departure_date_time)
        ", ['year' => $year]);
    }
    public function getMonthlyByAirline($year, $month)
{
    
    return DB::select("
        SELECT 
            f.flight_id, 
            COUNT(t.ticket_id) AS tickets,
            SUM(
                CASE
                    WHEN sc.seat_class_id = 1 THEN f.unit_price * 1.05
                    WHEN sc.seat_class_id = 2 THEN f.unit_price * 1.00
                    ELSE 0
                END
            ) AS revenue,
            ROUND(
                SUM(
                    CASE
                        WHEN sc.seat_class_id = 1 THEN f.unit_price * 1.05
                        WHEN sc.seat_class_id = 2 THEN f.unit_price * 1.00
                        ELSE 0
                    END
                ) / (
                    SELECT 
                        SUM(
                            CASE
                                WHEN sc2.seat_class_id = 1 THEN f2.unit_price * 1.05
                                WHEN sc2.seat_class_id = 2 THEN f2.unit_price * 1.00
                                ELSE 0
                            END
                        )
                    FROM Flight f2
                    LEFT JOIN Ticket t2 ON f2.flight_id = t2.flight_id AND t2.status = 'confirmed' AND t2.IsDeleted = 0
                    LEFT JOIN Seat s2 ON t2.seat_id = s2.seat_id
                    LEFT JOIN SeatClass sc2 ON s2.seat_class_id = sc2.seat_class_id
                    WHERE YEAR(f2.departure_date_time) = :year2 AND MONTH(f2.departure_date_time) = :month2
                      AND f2.IsDeleted = 0
                ) * 100, 2
            ) AS revenue_ratio
        FROM Flight f
        LEFT JOIN Ticket t ON f.flight_id = t.flight_id AND t.status = 'confirmed' AND t.IsDeleted = 0
        LEFT JOIN Seat s ON t.seat_id = s.seat_id
        LEFT JOIN SeatClass sc ON s.seat_class_id = sc.seat_class_id
        WHERE YEAR(f.departure_date_time) = :year AND MONTH(f.departure_date_time) = :month
          AND f.IsDeleted = 0
        GROUP BY f.flight_id
        ORDER BY revenue DESC
    ", [
        'year' => $year,
        'month' => $month,
        'year2' => $year, // Tham số cho câu lệnh con
        'month2' => $month // Tham số cho câu lệnh con
    ]);

}
}
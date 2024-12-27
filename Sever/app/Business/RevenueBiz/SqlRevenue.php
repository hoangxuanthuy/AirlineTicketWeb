<?php

namespace App\Business\RevenueBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlRevenue
{
    // Lấy thông tin thống kê doanh thu
    public function getMonthlyRevenue(int $year, ?int $month = null)
    {
        $bindings = ['year' => $year];
        $query = "
            SELECT 
                rm.month,
                SUM(rm.revenue) AS revenue
            FROM RevenueYear ry
            LEFT JOIN RevanueDetailYear rdy ON ry.year = rdy.year
            LEFT JOIN RevenueMonth rm ON rdy.month_report_id = rm.month_report_id
            WHERE ry.year = :year AND ry.IsDeleted = 0
        ";

        if ($month) {
            $query .= " AND rm.month = :month";
            $bindings['month'] = $month;
        }

        $query .= " GROUP BY rm.month ORDER BY rm.month ASC";

        $details = DB::select($query, $bindings);

        // Tính tổng doanh thu
        $totalRevenue = array_reduce($details, function ($sum, $item) {
            return $sum + $item->revenue;
        }, 0);

        return [
            'revenue' => $totalRevenue,
            'details' => $details
        ];
    }
    public function getYearlyReport($year)
{
    // Khởi tạo biến row_number
    DB::statement("SET @row_number = 0;");

    // Truy vấn chính
    $query = "
        SELECT 
            (@row_number := @row_number + 1) AS row_number, -- Số thứ tự
            rm.month AS month, -- Tháng
            rdy.number_of_flights AS number_of_flights, -- Số chuyến bay
            rm.revenue AS revenue, -- Doanh thu
            ROUND(rm.revenue / ry.total_revenue, 2) AS revenue_ratio -- Tỷ lệ doanh thu
        FROM RevenueMonth rm
        JOIN RevanueDetailYear rdy ON rm.month_report_id = rdy.month_report_id
        JOIN RevenueYear ry ON rdy.year = ry.year
        WHERE rdy.year = ? AND ry.IsDeleted = 0
        ORDER BY rm.month ASC
    ";

    // Chạy truy vấn SELECT
    return DB::select($query, [$year]);
}

public function getMonthlyReport($month, $year)
{
    // Khởi tạo biến row_number
    DB::statement("SET @row_number = 0;");

    // Truy vấn chính
    $query = "
        SELECT 
            (@row_number := @row_number + 1) AS row_number, -- Số thứ tự
            rm.flight_id AS flight_id, -- Mã chuyến bay
            (rm.first_class_tickets + rm.second_class_tickets) AS tickets, -- Tổng số vé
            rm.revenue AS revenue, -- Doanh thu
            ROUND(rm.revenue / ry.total_revenue, 2) AS revenue_ratio -- Tỷ lệ doanh thu
        FROM RevenueMonth rm
        JOIN RevanueDetailYear rdy ON rm.month_report_id = rdy.month_report_id
        JOIN RevenueYear ry ON rdy.year = ry.year
        WHERE rdy.year = ? AND rm.month = ? AND rm.IsDeleted = 0
        ORDER BY rm.revenue DESC
    ";

    // Chạy truy vấn SELECT
    return DB::select($query, [$year, $month]);
}




}

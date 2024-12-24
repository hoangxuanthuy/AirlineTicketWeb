<?php

namespace App\Business\RevenueBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlRevenue
{
    // Lấy thông tin thống kê doanh thu
    public function getRevenueStatistics()
    {
        $query = "
            SELECT 
                ry.year,
                rm.month,
                SUM(rm.revenue) AS total_revenue,
                SUM(rm.first_class_tickets) AS total_first_class_tickets,
                SUM(rm.second_class_tickets) AS total_second_class_tickets
            FROM RevenueYear ry
            LEFT JOIN RevanueDetailYear rdy ON ry.year = rdy.year
            LEFT JOIN RevenueMonth rm ON rdy.month_report_id = rm.month_report_id
            WHERE ry.IsDeleted = 0
            GROUP BY ry.year, rm.month
            ORDER BY ry.year DESC, rm.month ASC
        ";

        return DB::select($query);
    }
}

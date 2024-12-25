<?php

namespace App\Business\RevenueBiz;

use App\Business\RevenueBiz\SqlRevenue;
use Illuminate\Http\Request;

class RevenueBusiness
{
    protected SqlRevenue $sqlRevenue;

    public function __construct()
    {
        $this->sqlRevenue = new SqlRevenue();
    }

    // Lấy thông tin thống kê doanh thu
    public function getMonthlyRevenue(int $year, ?int $month = null)
    {
        return $this->sqlRevenue->getMonthlyRevenue($year, $month);
    }
    // Xử lý báo cáo năm
    public function getYearlyReport($year)
    {
        return $this->sqlRevenue->getYearlyReport($year);
    }

    // Xử lý báo cáo tháng
    public function getMonthlyReport($month, $year)
    {
        return $this->sqlRevenue->getMonthlyReport($month, $year);
    }
}

<?php

namespace App\Business\RevenueBiz;

use App\Business\RevenueBiz\SqlRevenue;
use Illuminate\Http\Request;

class RevenueBusiness
{
    protected SqlRevenue $sqlRevenue;

    public function __construct()
    {
        $this->revenueSql = new SqlRevenue(); // Khởi tạo SqlRevenue
    }

    public function getMonthlyRevenue($year, $month = null)
{
    return $this->revenueSql->getMonthlyRevenue($year, $month);
}


public function getYearlyRevenue($year)
{
    return $this->revenueSql->getYearlyRevenueByMonth($year);
}

    // Xử lý báo cáo năm
    public function getMonthlyRevenueByAirline($year, $month)
    {
        return $this->revenueSql->getMonthlyByAirline($year, $month);
    }
    public function getYearlyRevenueByMonth($year)
    {
        return $this->revenueSql->getYearlyByMonth($year);
    }
}

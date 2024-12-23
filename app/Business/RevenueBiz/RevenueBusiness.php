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
    public function getRevenueStatistics()
    {
        return $this->sqlRevenue->getRevenueStatistics();
    }
}

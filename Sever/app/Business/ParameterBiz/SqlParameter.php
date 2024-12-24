<?php

namespace App\Business\ParameterBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlParameter
{
    // Lấy danh sách tham số hệ thống
    public function getAllParameters()
    {
        $query = "SELECT * FROM Parameter WHERE IsDeleted = 0";
        return DB::select($query);
    }

    // Cập nhật tham số theo ID
    public function updateParameter(int $parameterId, array $data)
    {
        $query = "UPDATE Parameter 
                  SET min_flight_time = :min_flight_time,
                      max_intermediate_airport = :max_intermediate_airport,
                      min_stopover_time = :min_stopover_time,
                      max_stopover_time = :max_stopover_time,
                      latest_booking_time = :latest_booking_time,
                      latest_cancellation_time = :latest_cancellation_time,
                      IsDeleted = :IsDeleted
                  WHERE parameter_id = :parameter_id";

        DB::update($query, [
            'min_flight_time' => $data['min_flight_time'],
            'max_intermediate_airport' => $data['max_intermediate_airport'],
            'min_stopover_time' => $data['min_stopover_time'],
            'max_stopover_time' => $data['max_stopover_time'],
            'latest_booking_time' => $data['latest_booking_time'],
            'latest_cancellation_time' => $data['latest_cancellation_time'],
            'IsDeleted' => $data['IsDeleted'] ?? 0,
            'parameter_id' => $parameterId
        ]);
    }
}

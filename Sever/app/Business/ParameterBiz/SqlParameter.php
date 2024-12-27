<?php

namespace App\Business\ParameterBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlParameter
{
    public function getParameter()
    {
        $query = "SELECT * FROM Parameter WHERE IsDeleted = 0";
        return DB::select($query);
    }

    public function updateParameter(array $data)
    {
        // Xây dựng câu lệnh UPDATE động dựa trên các tham số được truyền
        $updateColumns = [];
        $bindings = [];

        if (isset($data['min_flight_time'])) {
            $updateColumns[] = "min_flight_time = :min_flight_time";
            $bindings['min_flight_time'] = $data['min_flight_time'];
        }

        if (isset($data['max_intermediate_airport'])) {
            $updateColumns[] = "max_intermediate_airport = :max_intermediate_airport";
            $bindings['max_intermediate_airport'] = $data['max_intermediate_airport'];
        }

        if (isset($data['min_stopover_time'])) {
            $updateColumns[] = "min_stopover_time = :min_stopover_time";
            $bindings['min_stopover_time'] = $data['min_stopover_time'];
        }

        if (isset($data['max_stopover_time'])) {
            $updateColumns[] = "max_stopover_time = :max_stopover_time";
            $bindings['max_stopover_time'] = $data['max_stopover_time'];
        }

        if (isset($data['latest_booking_time'])) {
            $updateColumns[] = "latest_booking_time = :latest_booking_time";
            $bindings['latest_booking_time'] = $data['latest_booking_time'];
        }

        if (isset($data['latest_cancellation_time'])) {
            $updateColumns[] = "latest_cancellation_time = :latest_cancellation_time";
            $bindings['latest_cancellation_time'] = $data['latest_cancellation_time'];
        }

        // Nếu không có tham số nào, trả về lỗi
        if (empty($updateColumns)) {
            throw new \InvalidArgumentException("No valid parameters provided for update.");
        }

        // Ghép các cột cập nhật thành chuỗi
        $updateQuery = implode(", ", $updateColumns);

        // Thực hiện truy vấn
        $query = "UPDATE Parameter 
                  SET $updateQuery
                  WHERE parameter_id = 1 AND IsDeleted = 0";

        DB::update($query, $bindings);
    }
}

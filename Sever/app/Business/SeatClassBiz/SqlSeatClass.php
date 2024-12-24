<?php

namespace App\Business\SeatClassBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlSeatClass
{
    public function getAllSeatClasses()
    {
        $query = "SELECT * FROM SeatClass WHERE IsDeleted = 0";
        return DB::select($query);
    }

    public function createSeatClass(array $data)
    {
        $query = "INSERT INTO SeatClass (seat_class_name, price_ratio, IsDeleted) VALUES (:seat_class_name, :price_ratio, 0)";
        DB::insert($query, [
            'seat_class_name' => $data['seat_class_name'],
            'price_ratio' => $data['price_ratio']
        ]);

        return DB::getPdo()->lastInsertId();
    }

    public function updateSeatClass(int $seatClassId, array $data)
    {
        $query = "UPDATE SeatClass SET seat_class_name = :seat_class_name, price_ratio = :price_ratio WHERE seat_class_id = :seat_class_id AND IsDeleted = 0";
        DB::update($query, [
            'seat_class_name' => $data['seat_class_name'],
            'price_ratio' => $data['price_ratio'],
            'seat_class_id' => $seatClassId
        ]);
    }

    public function deleteSeatClass(int $seatClassId)
    {
        $query = "UPDATE SeatClass SET IsDeleted = 1 WHERE seat_class_id = :seat_class_id";
        DB::update($query, ['seat_class_id' => $seatClassId]);
    }
}

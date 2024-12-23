<?php

namespace App\Business\LuggageBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlLuggage
{
    // Lấy tất cả hành lý
    public function getAllLuggage()
    {
        return DB::select("SELECT * FROM Luggage WHERE IsDeleted = 0");
    }

    // Lấy hành lý theo ID
    public function getLuggageById(int $luggageId)
    {
        return DB::selectOne("SELECT * FROM Luggage WHERE luggage_id = :luggage_id AND IsDeleted = 0", ['luggage_id' => $luggageId]);
    }

    // Thêm hành lý mới
    public function createLuggage(array $data)
    {
        return DB::insert("
            INSERT INTO Luggage (weight, price, IsDeleted) 
            VALUES (:weight, :price, 0)
        ", [
            'weight' => $data['weight'],
            'price' => $data['price']
        ]);
    }

    // Cập nhật hành lý theo ID
    public function updateLuggage(int $luggageId, array $data)
    {
        return DB::update("
            UPDATE Luggage 
            SET weight = :weight, price = :price 
            WHERE luggage_id = :luggage_id AND IsDeleted = 0
        ", [
            'weight' => $data['weight'],
            'price' => $data['price'],
            'luggage_id' => $luggageId
        ]);
    }

    // Xóa hành lý (cập nhật IsDeleted thành 1)
    public function deleteLuggage(int $luggageId)
    {
        return DB::update("
            UPDATE Luggage 
            SET IsDeleted = 1 
            WHERE luggage_id = :luggage_id
        ", ['luggage_id' => $luggageId]);
    }
}

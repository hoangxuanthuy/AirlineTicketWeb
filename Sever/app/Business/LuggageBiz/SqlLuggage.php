<?php

namespace App\Business\LuggageBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlLuggage
{
    // Lấy tất cả hành lý
    public function countLuggage(?string $search = null)
{
    $query = "SELECT COUNT(*) as total FROM Luggage WHERE IsDeleted = 0";

    $bindings = [];

    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND (weight LIKE :search1 OR price LIKE :search2 )";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
    }
    // Thực thi query
    $result = DB::select($query, $bindings);
    return $result[0]->total ?? 0;
}
    public function getAllLuggage(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT *
                FROM Luggage
                WHERE IsDeleted = 0";

        $bindings = [];

        if (!empty($search)) {
            $query .= " AND (weight LIKE :search1 OR price LIKE :search2 )";
            $bindings['search1'] = '%' . $search . '%';
            $bindings['search2'] = '%' . $search . '%';
        }

        // Thêm giới hạn và phân trang
        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
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

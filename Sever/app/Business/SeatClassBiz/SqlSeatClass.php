<?php

namespace App\Business\SeatClassBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlSeatClass
{
    public function countSeatClass(?string $search = null)
{
    $query = "SELECT COUNT(*) as total FROM SeatClass WHERE IsDeleted = 0";

    $bindings = [];

    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND (seat_class_name LIKE :search1 OR price_ratio LIKE :search2 )";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
    }
    // Thực thi query
    $result = DB::select($query, $bindings);
    return $result[0]->total ?? 0;
}
    public function getAllSeatClass(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT *
                FROM SeatClass
                WHERE IsDeleted = 0";

        $bindings = [];

        if (!empty($search)) {
            $query .= " AND (seat_class_name LIKE :search1 OR price_ratio LIKE :search2 )";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
        }

        // Thêm giới hạn và phân trang
        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
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

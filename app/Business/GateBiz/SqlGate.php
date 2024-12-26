<?php

namespace App\Business\GateBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlGate
{
    // Lấy danh sách tất cả các cổng bay
    public function countGates(?string $search = null)
{
    $query = "SELECT COUNT(*) as total FROM Gate WHERE IsDeleted = 0";

    $bindings = [];

    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND airport_id = :search";
        $bindings['search'] = $search;
    }
    // Thực thi query
    $result = DB::select($query, $bindings);
    return $result[0]->total ?? 0;
}
    public function getAllGates(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT *
                FROM Gate
                WHERE IsDeleted = 0";

        $bindings = [];

        // Thêm điều kiện tìm kiếm nếu có
        if (!empty($search)) {
            $query .= " AND airport_id = :search";
            $bindings['search'] = $search;
        }

        // Thêm giới hạn và phân trang
        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }


    // Thêm cổng bay mới
    public function createGate(array $data)
    {
        $query = "INSERT INTO Gate (airport_id, IsDeleted) VALUES (:airport_id, 0)";
        DB::insert($query, ['airport_id' => $data['airport_id']]);
        return DB::getPdo()->lastInsertId();
    }

    // Cập nhật thông tin cổng bay theo ID
    public function updateGate(int $gateId, array $data)
    {
        $query = "UPDATE Gate SET airport_id = :airport_id WHERE gate_id = :gateId AND IsDeleted = 0";
        DB::update($query, [
            'airport_id' => $data['airport_id'],
            'gateId' => $gateId
        ]);
    }

    // Xóa cổng bay (xóa mềm - chỉ cập nhật IsDeleted)
    public function deleteGate(int $gateId)
    {
        $query = "UPDATE Gate SET IsDeleted = 1 WHERE gate_id = :gateId";
        DB::update($query, ['gateId' => $gateId]);
    }
}

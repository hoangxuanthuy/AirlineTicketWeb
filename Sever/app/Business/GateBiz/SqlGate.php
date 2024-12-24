<?php

namespace App\Business\GateBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlGate
{
    // Lấy danh sách tất cả các cổng bay
    public function getAllGates()
    {
        $query = "SELECT * FROM Gate WHERE IsDeleted = 0";
        return DB::select($query);
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

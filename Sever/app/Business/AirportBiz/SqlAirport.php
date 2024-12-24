<?php

namespace App\Business\AirportBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlAirport
{
    /**
     * Lấy danh sách tất cả sân bay
     *
     * @return array
     */
    public function getAllAirports()
    {
        $query = "SELECT * FROM Airport WHERE IsDeleted = 0";
        return DB::select($query);
    }

    /**
     * Thêm sân bay mới
     *
     * @param array $data
     * @return int
     */
    public function createAirport(array $data)
    {
        $query = "INSERT INTO Airport (airport_name, address, IsDeleted) VALUES (:airport_name, :address, 0)";
        DB::insert($query, [
            'airport_name' => $data['airport_name'],
            'address' => $data['address']
        ]);

        return DB::getPdo()->lastInsertId();
    }

    /**
     * Cập nhật thông tin sân bay
     *
     * @param int $airportId
     * @param array $data
     * @return void
     */
    public function updateAirport(int $airportId, array $data)
    {
        $query = "UPDATE Airport SET airport_name = :airport_name, address = :address WHERE airport_id = :airport_id AND IsDeleted = 0";
        DB::update($query, [
            'airport_name' => $data['airport_name'],
            'address' => $data['address'],
            'airport_id' => $airportId
        ]);
    }

    /**
     * Xóa mềm sân bay (soft delete)
     *
     * @param int $airportId
     * @return void
     */
    public function deleteAirport(int $airportId)
    {
        $query = "UPDATE Airport SET IsDeleted = 1 WHERE airport_id = :airport_id";
        DB::update($query, ['airport_id' => $airportId]);
    }
}

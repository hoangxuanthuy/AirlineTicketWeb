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
    public function countAirports(?string $search = null)
{
    $query = "SELECT COUNT(*) as total FROM Airport WHERE IsDeleted = 0";

    $bindings = [];

    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND (airport_name LIKE :search1 OR address LIKE :search2 )";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
    }
    // Thực thi query
    $result = DB::select($query, $bindings);
    return $result[0]->total ?? 0;
}
    public function getAllAirports(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT *
                FROM Airport
                WHERE IsDeleted = 0";

        $bindings = [];

        // Thêm điều kiện tìm kiếm nếu có
        if (!empty($search)) {
            $query .= " AND (airport_name LIKE :search1 OR address LIKE :search2 )";
            $bindings['search1'] = '%' . $search . '%';
            $bindings['search2'] = '%' . $search . '%';
        }

        // Thêm giới hạn và phân trang
        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
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

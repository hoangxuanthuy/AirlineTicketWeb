<?php

namespace App\Business\ClientBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlClient
{
    // Lấy danh sách tất cả các khách hàng
    public function getAllClients()
    {
        $query = "SELECT * FROM Client WHERE IsDeleted = 0";
        return DB::select($query);
    }

    // Lấy chi tiết khách hàng theo ID
    public function getClientById(int $clientId)
    {
        $query = "SELECT * FROM Client WHERE client_id = :client_id AND IsDeleted = 0";
        return DB::selectOne($query, ['client_id' => $clientId]);
    }
    public function searchCustomer(int $limit = 10, int $offset = 0, ?string $search = null, ?string $country = null)
    {
        $query = "SELECT *
                FROM Client 
                WHERE IsDeleted = 0";

        $bindings = [];

        // Thêm điều kiện tìm kiếm nếu có
        if (!empty($search)) {
        $query .= " AND (client_name LIKE :search1 OR citizen_id LIKE :search2 OR phone LIKE :search3)";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
        $bindings['search3'] = '%' . $search . '%';
        }

        // Thêm điều kiện quốc gia nếu có
        if (!empty($country)) {
        $query .= " AND TRIM(LOWER(country)) = TRIM(LOWER(:country))";
        $bindings['country'] = $country;
        }

        // Thêm giới hạn và phân trang
        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }

    // Thêm mới khách hàng
    public function createClient(array $data)
    {
        $query = "INSERT INTO Client (client_name, citizen_id, phone, gender, birth_day, country, IsDeleted) 
                  VALUES (:client_name, :citizen_id, :phone, :gender, :birth_day, :country, 0)";
        DB::insert($query, [
            'client_name' => $data['client_name'],
            'citizen_id' => $data['citizen_id'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'birth_day' => $data['birth_day'],
            'country' => $data['country']
        ]);
        return DB::getPdo()->lastInsertId();
    }

    // Cập nhật thông tin khách hàng theo ID
    public function updateClient(int $clientId, array $data)
    {
        $query = "UPDATE Client 
                  SET client_name = :client_name, citizen_id = :citizen_id, phone = :phone, gender = :gender, birth_day = :birth_day, country = :country 
                  WHERE client_id = :client_id AND IsDeleted = 0";
        return DB::update($query, [
            'client_name' => $data['client_name'],
            'citizen_id' => $data['citizen_id'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'birth_day' => $data['birth_day'],
            'country' => $data['country'],
            'client_id' => $clientId
        ]);
    }

    // Xóa khách hàng theo ID (xóa mềm)
    public function deleteClient(int $clientId)
    {
        $query = "UPDATE Client SET IsDeleted = 1 WHERE client_id = :client_id";
        return DB::update($query, ['client_id' => $clientId]);
    }
}

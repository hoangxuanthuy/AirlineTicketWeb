<?php

namespace App\Business\ClientBiz;

use App\Business\ClientBiz\SqlClient;
use Exception;
use Illuminate\Http\Request;
class ClientBusiness
{
    protected SqlClient $sqlClient;

    public function __construct()
    {
        $this->sqlClient = new SqlClient();
    }

    // Lấy danh sách tất cả khách hàng
    public function getAllClients()
    {
        return $this->sqlClient->getAllClients();
    }

    // Lấy thông tin khách hàng theo ID
    public function getClientById(int $clientId)
    {
        $client = $this->sqlClient->getClientById($clientId);
        if (!$client) {
            throw new Exception("Khách hàng không tồn tại");
        }
        return $client;
    }
    public function searchCustomer(int $limit = 10, int $offset = 0, ?string $search = null, ?string $country = null)
    {
        return $this->sqlClient->searchCustomer($limit, $offset, $search, $country);
    }
    // Thêm khách hàng mới
    public function createClient(array $data)
    {
        if (empty($data['client_name']) || empty($data['phone'])) {
            throw new Exception("Tên khách hàng và số điện thoại không được để trống");
        }
        return $this->sqlClient->createClient($data);
    }

    // Cập nhật thông tin khách hàng
    public function updateClient(int $clientId, array $data)
    {
        $updatedRows = $this->sqlClient->updateClient($clientId, $data);
        if ($updatedRows === 0) {
            throw new Exception("Cập nhật thất bại hoặc không tìm thấy khách hàng");
        }
    }

    // Xóa khách hàng
    public function deleteClient(int $clientId)
    {
        $deletedRows = $this->sqlClient->deleteClient($clientId);
        if ($deletedRows === 0) {
            throw new Exception("Xóa thất bại hoặc không tìm thấy khách hàng");
        }
    }
}

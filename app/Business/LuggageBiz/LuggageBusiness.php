<?php

namespace App\Business\LuggageBiz;

use App\Business\LuggageBiz\SqlLuggage;
use Exception;
use Illuminate\Http\Request;

class LuggageBusiness
{
    protected SqlLuggage $sqlLuggage;

    public function __construct()
    {
        $this->sqlLuggage = new SqlLuggage();
    }

    // Lấy danh sách hành lý
    public function getAllLuggage()
    {
        try {
            return $this->sqlLuggage->getAllLuggage();
        } catch (Exception $e) {
            throw new Exception("Không thể lấy danh sách hành lý: " . $e->getMessage());
        }
    }

    // Lấy hành lý theo ID
    public function getLuggageById(int $luggageId)
    {
        try {
            return $this->sqlLuggage->getLuggageById($luggageId);
        } catch (Exception $e) {
            throw new Exception("Không thể lấy hành lý: " . $e->getMessage());
        }
    }

    // Thêm hành lý mới
    public function createLuggage(array $data)
    {
        try {
            $this->sqlLuggage->createLuggage($data);
        } catch (Exception $e) {
            throw new Exception("Không thể thêm hành lý: " . $e->getMessage());
        }
    }

    // Cập nhật thông tin hành lý
    public function updateLuggage(int $luggageId, array $data)
    {
        try {
            $this->sqlLuggage->updateLuggage($luggageId, $data);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật hành lý: " . $e->getMessage());
        }
    }

    // Xóa hành lý theo ID
    public function deleteLuggage(int $luggageId)
    {
        try {
            $this->sqlLuggage->deleteLuggage($luggageId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa hành lý: " . $e->getMessage());
        }
    }
}

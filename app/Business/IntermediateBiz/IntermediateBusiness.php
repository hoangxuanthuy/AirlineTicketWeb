<?php

namespace App\Business\IntermediateBiz;

use App\Business\IntermediateBiz\SqlIntermediate;
use Exception;
use Illuminate\Http\Request;
class IntermediateBusiness
{
    protected SqlIntermediate $sqlIntermediate;

    public function __construct()
    {
        $this->sqlIntermediate = new SqlIntermediate();
    }

    public function getAllIntermediates(?int $flightId = null)
    {
        return $this->sqlIntermediate->getAllIntermediates($flightId);
    }

    public function createIntermediate(array $data)
    {
        try {
            $this->sqlIntermediate->createIntermediate($data);
        } catch (Exception $e) {
            throw new Exception("Không thể thêm sân bay trung gian: " . $e->getMessage());
        }
    }

    public function updateIntermediate(int $flightId, int $airportId, array $data)
    {
        try {
            $this->sqlIntermediate->updateIntermediate($flightId, $airportId, $data);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật sân bay trung gian: " . $e->getMessage());
        }
    }

    public function deleteIntermediate(int $flightId, int $airportId)
    {
        try {
            $this->sqlIntermediate->deleteIntermediate($flightId, $airportId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa sân bay trung gian: " . $e->getMessage());
        }
    }
}

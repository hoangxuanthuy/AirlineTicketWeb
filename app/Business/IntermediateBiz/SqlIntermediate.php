<?php

namespace App\Business\IntermediateBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlIntermediate
{
    public function getAllIntermediates(?int $flightId = null)
    {
        $query = "SELECT * FROM Intermediate WHERE IsDeleted = 0";
        $bindings = [];

        if ($flightId) {
            $query .= " AND flight_id = :flight_id";
            $bindings['flight_id'] = $flightId;
        }

        return DB::select($query, $bindings);
    }
    public function countIntermediates(int $flightId)
    {
        $query = "SELECT COUNT(*) as totalCount 
                  FROM Intermediate 
                  WHERE flight_id = :flight_id AND IsDeleted = 0";
    
        $result = DB::selectOne($query, ['flight_id' => $flightId]);
        return $result->totalCount ?? 0;
    }
    
    public function createIntermediate(array $data)
    {
        // Kiểm tra xem bản ghi đã tồn tại hay chưa, kể cả các bản ghi đã bị xóa
        $queryCheck = "SELECT * FROM Intermediate 
                       WHERE flight_id = :flight_id AND intermediate_airport_id = :intermediate_airport_id";
        $existingRecord = DB::selectOne($queryCheck, [
            'flight_id' => $data['flight_id'],
            'intermediate_airport_id' => $data['intermediate_airport_id']
        ]);
    
        if ($existingRecord) {
            if ($existingRecord->IsDeleted == 1) {
                // Nếu bản ghi tồn tại và bị đánh dấu là đã xóa, khôi phục bản ghi
                $queryRestore = "UPDATE Intermediate 
                                 SET stopover_time = :stopover_time, IsDeleted = 0
                                 WHERE flight_id = :flight_id AND intermediate_airport_id = :intermediate_airport_id";
                DB::update($queryRestore, [
                    'stopover_time' => $data['stopover_time'],
                    'flight_id' => $data['flight_id'],
                    'intermediate_airport_id' => $data['intermediate_airport_id']
                ]);
            } else {
                // Nếu bản ghi đã tồn tại và không bị xóa, không thực hiện chèn mới
                throw new Exception("Sân bay trung gian đã tồn tại.");
            }
        } else {
            // Nếu không tồn tại, thêm bản ghi mới
            $queryInsert = "INSERT INTO Intermediate (flight_id, intermediate_airport_id, stopover_time, IsDeleted)
                            VALUES (:flight_id, :intermediate_airport_id, :stopover_time, 0)";
            DB::insert($queryInsert, [
                'flight_id' => $data['flight_id'],
                'intermediate_airport_id' => $data['intermediate_airport_id'],
                'stopover_time' => $data['stopover_time']
            ]);
        }
    }
    

    public function updateIntermediate(int $flightId, int $airportId, array $data)
    {
        $query = "UPDATE Intermediate
                  SET stopover_time = :stopover_time
                  WHERE flight_id = :flight_id AND intermediate_airport_id = :airport_id AND IsDeleted = 0";
        DB::update($query, [
            'stopover_time' => $data['stopover_time'],
            'flight_id' => $flightId,
            'airport_id' => $airportId
        ]);
    }

    public function deleteIntermediate(int $flightId, int $airportId)
    {
        $query = "UPDATE Intermediate SET IsDeleted = 1
                  WHERE flight_id = :flight_id AND intermediate_airport_id = :airport_id";
        DB::update($query, [
            'flight_id' => $flightId,
            'airport_id' => $airportId
        ]);
    }
}

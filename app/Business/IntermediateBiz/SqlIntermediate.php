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

    public function createIntermediate(array $data)
    {
        $query = "INSERT INTO Intermediate (flight_id, intermediate_airport_id, stopover_time, IsDeleted)
                  VALUES (:flight_id, :intermediate_airport_id, :stopover_time, 0)";
        DB::insert($query, [
            'flight_id' => $data['flight_id'],
            'intermediate_airport_id' => $data['intermediate_airport_id'],
            'stopover_time' => $data['stopover_time']
        ]);
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

<?php

namespace App\Business\BookingBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlBooking
{
    public function countBookings(?string $search = null)
    {
        $query = "SELECT COUNT(*) as total FROM Booking WHERE IsDeleted = 0";
        $bindings = [];

        if (!empty($search)) {
            $query .= " AND (status LIKE :search1 OR booking_id LIKE :search2)";
            $bindings['search1'] = '%' . $search . '%';
            $bindings['search2'] = '%' . $search . '%';
        }

        $result = DB::select($query, $bindings);
        return $result[0]->total ?? 0;
    }

    public function getAllBookings(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT * FROM Booking WHERE IsDeleted = 0";
        $bindings = [];

        if (!empty($search)) {
            $query .= " AND (status LIKE :search1 OR booking_id LIKE :search2)";
            $bindings['search1'] = '%' . $search . '%';
            $bindings['search2'] = '%' . $search . '%';
        }

        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }

    public function exportBooking(int $bookingId)
    {
        $query = "UPDATE Booking 
              SET status = 'Confirmed' 
              WHERE booking_id = :booking_id AND IsDeleted = 0";
    return DB::update($query, [
        'booking_id' => $bookingId
    ]);
    }

    public function updateBooking(int $bookingId)
    {
        $query = "UPDATE Booking 
              SET status = 'Canceled' 
              WHERE booking_id = :booking_id AND IsDeleted = 0";
    return DB::update($query, [
        'booking_id' => $bookingId
    ]);
    }

    public function deleteBooking(int $bookingId)
    {
        $query = "UPDATE Booking SET IsDeleted = 1 WHERE booking_id = :booking_id";
        DB::update($query, ['booking_id' => $bookingId]);
    }
}

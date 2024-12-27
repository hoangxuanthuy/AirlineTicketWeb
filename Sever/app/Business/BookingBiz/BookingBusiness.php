<?php

namespace App\Business\BookingBiz;

use App\Business\BookingBiz\SqlBooking;
use Exception;
use Illuminate\Http\Request;
class BookingBusiness
{
    protected SqlBooking $sqlBooking;

    public function __construct()
    {
        $this->sqlBooking = new SqlBooking();
    }

    public function getAllBookings(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        return $this->sqlBooking->getAllBookings($limit, $offset, $search);
    }

    public function countBookings(?string $search = null)
    {
        return $this->sqlBooking->countBookings($search);
    }

    public function exportBooking(int $bookingId)
    {
        try {
            return $this->sqlBooking->exportBooking($bookingId);
        } catch (Exception $e) {
            throw new Exception("Xuất phiếu thành công: " . $e->getMessage());
        }
    }

    public function updateBooking(int $bookingId)
    {
        try {
            $this->sqlBooking->updateBooking($bookingId);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật Booking: " . $e->getMessage());
        }
    }

    public function deleteBooking(int $bookingId)
    {
        try {
            $this->sqlBooking->deleteBooking($bookingId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa Booking: " . $e->getMessage());
        }
    }
}

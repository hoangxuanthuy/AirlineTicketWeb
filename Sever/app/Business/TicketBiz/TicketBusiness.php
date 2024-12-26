<?php

namespace App\Business\TicketBiz;

use App\Business\TicketBiz\SqlTicket;
use Exception;
use Illuminate\Http\Request;
use App\Models\Ticket;
class TicketBusiness
{
    protected SqlTicket $sqlTicket;

    public function __construct()
    {
        $this->sqlTicket = new SqlTicket();
    }

    // Lấy danh sách tất cả vé
    public function getAllTickets()
    {
        return $this->sqlTicket->getAllTickets();
    }

    // Thêm vé mới
    public function createTicket(array $data)
    {
        if (empty($data['seat_id']) || empty($data['promotion_id']) || empty($data['client_id']) || empty($data['flight_id'])) {
            throw new Exception("Các thông tin cần thiết không được để trống");
        }
        return $this->sqlTicket->createTicket($data);
    }

    // Cập nhật thông tin vé
    public function updateTicket(int $ticketId, array $data)
    {
        $updatedRows = $this->sqlTicket->updateTicket($ticketId, $data);
        if ($updatedRows === 0) {
            throw new Exception("Cập nhật thất bại hoặc vé không tồn tại");
        }
    }

    // Xóa vé
    public function deleteTicket(int $ticketId)
    {
        $deletedRows = $this->sqlTicket->deleteTicket($ticketId);
        if ($deletedRows === 0) {
            throw new Exception("Xóa thất bại hoặc vé không tồn tại");
        }
    }

    // Tìm vé theo flight_id và seat_id
    public function findTicket(int $flightId, int $seatId)
    {
        $ticket = $this->sqlTicket->findTicket($flightId, $seatId);
        if (!$ticket) {
            throw new Exception(message: "Không tìm thấy vé với flight_id và seat_id đã cho");
        }
        return $ticket;
    }

    public function getTicketsByFlight(int $flightId)
    {
        // Retrieve tickets for the specified flight ID
        return $this->sqlTicket->getTicketsByFlightId($flightId);
    }

}

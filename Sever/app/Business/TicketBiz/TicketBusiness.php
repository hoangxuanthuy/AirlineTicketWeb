<?php

namespace App\Business\TicketBiz;

use App\Business\TicketBiz\SqlTicket;
use Exception;
use Illuminate\Http\Request;
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
}

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
    public function getTicketsByClient(int $clientId)
{
    if (empty($clientId)) {
        throw new Exception("Client ID không được để trống");
    }

    return $this->sqlTicket->getTicketsByClient($clientId);
}

    public function getAllTickets(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        return $this->sqlTicket->getAllTickets($limit, $offset, $search);
    }
    public function countTickets(?string $search = null)
    {
        return $this->sqlTicket->countTickets($search);
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
    public function updateTicket(int $ticketId)
    {
        $updatedRows = $this->sqlTicket->updateTicket($ticketId);
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

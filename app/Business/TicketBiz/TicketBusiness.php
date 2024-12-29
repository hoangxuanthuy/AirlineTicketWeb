<?php

namespace App\Business\TicketBiz;

use App\Business\TicketBiz\SqlTicket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TicketBusiness
{
    protected SqlTicket $sqlTicket;

    public function __construct()
    {
        $this->sqlTicket = new SqlTicket();
    }

    public function getTicketsByAccount(int $accountId)
{
    if (empty($accountId)) {
        throw new Exception("Account ID không được để trống");
    }

    return $this->sqlTicket->getTicketsByAccount($accountId);
}

    public function countTickets(?string $search = null)
{
    $query = "SELECT COUNT(*) as total FROM Ticket WHERE IsDeleted = 0";

    $bindings = [];

    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND (client_id LIKE :search1 OR luggage_id LIKE :search2  OR flight_id LIKE :search3 OR status LIKE :search4)";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
        $bindings['search3'] = '%' . $search . '%';
        $bindings['search4'] = '%' . $search . '%';
    }   
    // Thực thi query
    $result = DB::select($query, $bindings);
    return $result[0]->total ?? 0;
}
    public function getAllTickets(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT *
                FROM Ticket
                WHERE IsDeleted = 0";

        $bindings = [];

        // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND (client_id LIKE :search1 OR luggage_id LIKE :search2  OR flight_id LIKE :search3 OR status LIKE :search4)";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
        $bindings['search3'] = '%' . $search . '%';
        $bindings['search4'] = '%' . $search . '%';
    }  

        // Thêm giới hạn và phân trang
        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }

    // Thêm mới vé
    public function createTicket(array $data)
    {
        $query = "INSERT INTO Ticket (seat_id, promotion_id, client_id, luggage_id, flight_id, ticket_issuance_date, status, IsDeleted) 
                  VALUES (:seat_id, :promotion_id, :client_id, :luggage_id, :flight_id, :ticket_issuance_date, :status, 0)";
        DB::insert($query, [
            'seat_id' => $data['seat_id'],
            'promotion_id' => $data['promotion_id'],
            'client_id' => $data['client_id'],
            'luggage_id' => $data['luggage_id'],
            'flight_id' => $data['flight_id'],
            'ticket_issuance_date' => $data['ticket_issuance_date'],
            'status' => $data['status']
        ]);
        return DB::getPdo()->lastInsertId();
    }

    // Cập nhật thông tin vé
    public function updateTicket(int $ticketId)
    {
        $query = "UPDATE Ticket 
              SET status = 'Canceled' 
              WHERE ticket_id = :ticket_id AND IsDeleted = 0";
    return DB::update($query, [
        'ticket_id' => $ticketId
    ]);
    }

    // Xóa vé (xóa mềm)
    public function deleteTicket(int $ticketId)
    {
        $query = "UPDATE Ticket SET IsDeleted = 1 WHERE ticket_id = :ticket_id";
        return DB::update($query, ['ticket_id' => $ticketId]);
    }
    public function findTicket(int $flightId, int $seatId)
    {
        $query = "SELECT * FROM Ticket WHERE flight_id = :flight_id AND seat_id = :seat_id AND IsDeleted = 0";
        return DB::selectOne($query, ['flight_id' => $flightId, 'seat_id' => $seatId]);
    }

    //function get ticket all ticket have flight id

    // Lấy danh sách tất cả các vé theo flight_id
    public function getTicketsByFlightId(int $flightId)
    {
        $query = "SELECT * FROM Ticket WHERE flight_id = :flight_id AND IsDeleted = 0";
        return DB::select($query, ['flight_id' => $flightId]);
    }
    // Tìm vé theo flight_id và seat_id
   
   // Cập nhật thông tin vé
   public function updateTicketData(int $ticketId, array $data)
   {
       $updatedRows = $this->sqlTicket->updateTicket($ticketId, $data);
       if ($updatedRows === 0) {
           throw new Exception("Cập nhật thất bại hoặc vé không tồn tại");
       }
   }

    public function getTicketsByFlight(int $flightId)
    {
        // Retrieve tickets for the specified flight ID
        return $this->sqlTicket->getTicketsByFlightId($flightId);
    }

}
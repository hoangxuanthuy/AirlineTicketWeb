<?php

namespace App\Business\TicketBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlTicket
{
    // Lấy danh sách tất cả các vé
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
}

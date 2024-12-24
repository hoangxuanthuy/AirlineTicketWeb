<?php

namespace App\Business\TicketBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlTicket
{
    // Lấy danh sách tất cả các vé
    public function getAllTickets()
    {
        $query = "SELECT * FROM Ticket WHERE IsDeleted = 0";
        return DB::select($query);
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
    public function updateTicket(int $ticketId, array $data)
    {
        $query = "UPDATE Ticket 
                  SET seat_id = :seat_id, promotion_id = :promotion_id, client_id = :client_id, luggage_id = :luggage_id, flight_id = :flight_id, 
                      ticket_issuance_date = :ticket_issuance_date, status = :status 
                  WHERE ticket_id = :ticket_id AND IsDeleted = 0";
        return DB::update($query, [
            'seat_id' => $data['seat_id'],
            'promotion_id' => $data['promotion_id'],
            'client_id' => $data['client_id'],
            'luggage_id' => $data['luggage_id'],
            'flight_id' => $data['flight_id'],
            'ticket_issuance_date' => $data['ticket_issuance_date'],
            'status' => $data['status'],
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

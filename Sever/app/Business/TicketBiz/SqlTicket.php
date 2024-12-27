<?php

namespace App\Business\TicketBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ticket;
class SqlTicket
{
    // Lấy danh sách tất cả các vé
    public function getTicketsByClient(int $clientId)
{
    $query = "
        SELECT 
            T.ticket_id,
            T.seat_id,
            T.promotion_id,
            T.client_id,
            T.flight_id,
            T.ticket_issuance_date,
            T.status,
            F.flight_time,
            F.departure_date_time AS departure_time,
            F.unit_price,
            A1.airport_name AS departure_airport,
            A2.airport_name AS arrival_airport,
            AL.airline_name AS airline_name,
            P.first_class_seats + P.second_class_seats - (
                SELECT COUNT(*)
                FROM Ticket T2
                WHERE T2.flight_id = F.flight_id AND T2.status = 'Confirmed'
            ) AS available_seats
        FROM 
            Ticket T
        INNER JOIN Flight F ON T.flight_id = F.flight_id
        INNER JOIN Plane P ON F.plane_id = P.plane_id
        INNER JOIN Airline AL ON P.airline_id = AL.airline_id
        INNER JOIN Airport A1 ON F.departure_airport_id = A1.airport_id
        INNER JOIN Airport A2 ON F.arrival_airport_id = A2.airport_id
        WHERE 
            T.client_id = :client_id AND T.IsDeleted = 0
    ";

    return DB::select($query, [
        'client_id' => $clientId
    ]);
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
    public function updateTicket(int $ticketId, array $data)
    {
        $query = "UPDATE Ticket SET 
                    seat_id = :seat_id,
                    promotion_id = :promotion_id,
                    client_id = :client_id,
                    luggage_id = :luggage_id,
                    flight_id = :flight_id,
                    ticket_issuance_date = :ticket_issuance_date,
                    status = :status
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
}

<?php

namespace App\Http\Controllers\Ticket;

use App\Business\TicketBiz\TicketBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class TicketController
{
    protected TicketBusiness $ticketBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->ticketBusiness = new TicketBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }
    public function getTicketsByClient(Request $request, int $clientId)
{
    try {
        $user = Auth::user();
        $userId = $user->id;
        $pageName = "View Tickets";

        $permission = $this->permissionBiz->getPermission($pageName, $userId);

        if ($permission) {
            $tickets = $this->ticketBusiness->getTicketsByClient($clientId);
            return response()->json($tickets);
        } else {
            return response()->json(['message' => 'Bạn không có quyền xem danh sách vé.'], 403);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
    }
}
    // Lấy danh sách vé
    public function countTickets(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Tickets";
    
            $permission = $this->permissionBiz->getPermission($pageName, $userId);
    
            if ($permission) {
                $search = $request->get('search', null);
    
                $totalTickets = $this->ticketBusiness->countTickets($search);
    
                return response()->json(['totalCount' => $totalTickets]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách vé.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getAllTickets(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Tickets";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $ticket= $this->ticketBusiness->getAllTickets($limit, $offset, $search);
                return response()->json($ticket);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách vé.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Thêm vé mới
    public function createTicket(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Add Ticket";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $ticketId = $this->ticketBusiness->createTicket($request->all());
                return response()->json(['message' => 'Thêm vé thành công', 'ticket_id' => $ticketId]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền thêm vé.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật thông tin vé
    public function updateTicket(Request $request, int $ticketId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Update Ticket";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->ticketBusiness->updateTicket($ticketId);
                return response()->json(['message' => 'Cập nhật vé thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật vé.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa vé
    public function deleteTicket(int $ticketId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Delete Ticket";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->ticketBusiness->deleteTicket($ticketId);
                return response()->json(['message' => 'Xóa vé thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xóa vé.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}

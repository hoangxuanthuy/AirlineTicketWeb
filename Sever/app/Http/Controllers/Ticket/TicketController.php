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

    // Lấy danh sách vé
    public function getAllTickets()
    {
        try {
            // $user = Auth::user();
            // $userId = $user->id;
            // $pageName = "View Tickets";

            // $permission = $this->permissionBiz->getPermission($pageName, $userId);
            
            // if ($permission) {
            //     return response()->json($tickets);
            // } else {
            //     return response()->json(['message' => 'Bạn không có quyền xem vé.'], 403);
            // }
            $tickets = $this->ticketBusiness->getAllTickets();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Thêm vé mới
    public function createTicket(Request $request)
    {
        try {
            // $user = Auth::user();
            // $userId = $user->id;
            // $pageName = "Add Ticket";

            // $permission = $this->permissionBiz->getPermission($pageName, $userId);

            // if ($permission) {
            // } else {
            //     return response()->json(['message' => 'Bạn không có quyền thêm vé.'], 403);
            // }
            $ticketId = $this->ticketBusiness->createTicket($request->all());
            return response()->json(['message' => 'Thêm vé thành công', 'ticket_id' => $ticketId]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật thông tin vé
    public function updateTicket(Request $request, int $ticketId)
    {
        try {
            // $user = Auth::user();
            // $userId = $user->id;
            // $pageName = "Update Ticket";

            // $permission = $this->permissionBiz->getPermission($pageName, $userId);

            // if ($permission) {
            //     return response()->json(['message' => 'Cập nhật vé thành công']);
            // } else {
            //     return response()->json(['message' => 'Bạn không có quyền cập nhật vé.'], 403);
            // }
            $this->ticketBusiness->updateTicket($ticketId, $request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa vé
    public function deleteTicket(int $ticketId)
    {
        try {
            // $user = Auth::user();
            // $userId = $user->id;
            // $pageName = "Delete Ticket";

            // $permission = $this->permissionBiz->getPermission($pageName, $userId);

            // if ($permission) {
            //     return response()->json(['message' => 'Xóa vé thành công']);
            // } else {
            //     return response()->json(['message' => 'Bạn không có quyền xóa vé.'], 403);
            // }
            $this->ticketBusiness->deleteTicket($ticketId);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}

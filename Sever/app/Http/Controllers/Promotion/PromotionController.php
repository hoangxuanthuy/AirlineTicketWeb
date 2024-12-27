<?php

namespace App\Http\Controllers\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Business\PromotionBiz\PromotionBusiness;
use App\Business\PermissionBiz\PersmissionBusiness;

class PromotionController
{
    protected PromotionBusiness $promotionBusiness;
    protected PersmissionBusiness $permissionBiz;

    public function __construct()
    {
        $this->promotionBusiness = new PromotionBusiness();
        $this->permissionBiz = new PersmissionBusiness();
    }

    public function countPromotions(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Promotions";
    
            $permission = $this->permissionBiz->getPermission($pageName, $userId);
    
            if ($permission) {
                $search = $request->get('search', null);
    
                $totalPromotions = $this->promotionBusiness->countPromotions($search);
    
                return response()->json(['totalCount' => $totalPromotions]);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách khuyến mãi.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    public function getAllPromotions(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "View Promotions";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $limit = $request->get('limit', 10);
                $offset = $request->get('offset', 0);
                $search = $request->get('search', null);

                $promotion= $this->promotionBusiness->getAllPromotions($limit, $offset, $search);
                return response()->json($promotion);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xem danh sách khuyến mãi.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
    // Thêm chương trình khuyến mãi mới
    public function createPromotion(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Promotions";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $promotionId = $this->promotionBusiness->createPromotion($request->all());
                return response()->json(['message' => 'Thêm khuyến mãi thành công', 'promotion_id' => $promotionId], 201);
            } else {
                return response()->json(['message' => 'Bạn không có quyền thêm chương trình khuyến mãi.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Cập nhật thông tin khuyến mãi
    public function updatePromotion(Request $request, int $promotionId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Promotions";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->promotionBusiness->updatePromotion($promotionId, $request->all());
                return response()->json(['message' => 'Cập nhật chương trình khuyến mãi thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền cập nhật chương trình khuyến mãi.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }

    // Xóa chương trình khuyến mãi
    public function deletePromotion(int $promotionId)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $pageName = "Manage Promotions";

            $permission = $this->permissionBiz->getPermission($pageName, $userId);

            if ($permission) {
                $this->promotionBusiness->deletePromotion($promotionId);
                return response()->json(['message' => 'Xóa chương trình khuyến mãi thành công']);
            } else {
                return response()->json(['message' => 'Bạn không có quyền xóa chương trình khuyến mãi.'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi', 'error' => $e->getMessage()], 500);
        }
    }
}

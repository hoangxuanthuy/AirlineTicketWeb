<?php

namespace App\Business\PromotionBiz;

use App\Business\PromotionBiz\SqlPromotion;
use Exception;
use Illuminate\Http\Request;
class PromotionBusiness
{
    protected SqlPromotion $sqlPromotion;

    public function __construct()
    {
        $this->sqlPromotion = new SqlPromotion();
    }
    public function getAllPromotions(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        return $this->sqlPromotion->getAllPromotions($limit, $offset, $search);
    }
    public function countPromotions(?string $search = null)
    {
        return $this->sqlPromotion->countPromotions($search);
    }

    // Thêm chương trình khuyến mãi mới
    public function createPromotion(array $data)
    {
        try {
            return $this->sqlPromotion->createPromotion($data);
        } catch (Exception $e) {
            throw new Exception("Không thể thêm chương trình khuyến mãi: " . $e->getMessage());
        }
    }

    // Cập nhật chương trình khuyến mãi
    public function updatePromotion(int $promotionId, array $data)
    {
        try {
            $this->sqlPromotion->updatePromotion($promotionId, $data);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật chương trình khuyến mãi: " . $e->getMessage());
        }
    }

    // Xóa chương trình khuyến mãi
    public function deletePromotion(int $promotionId)
    {
        try {
            $this->sqlPromotion->deletePromotion($promotionId);
        } catch (Exception $e) {
            throw new Exception("Không thể xóa chương trình khuyến mãi: " . $e->getMessage());
        }
    }
}

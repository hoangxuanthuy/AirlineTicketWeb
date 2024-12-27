<?php

namespace App\Business\PromotionBiz;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class SqlPromotion
{
    // Lấy tất cả chương trình khuyến mãi
    public function countPromotions(?string $search = null)
{
    $query = "SELECT COUNT(*) as total FROM Promotion WHERE IsDeleted = 0";

    $bindings = [];

    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $query .= " AND (promotion_name LIKE :search1 OR discount_percentage LIKE :search2 )";
        $bindings['search1'] = '%' . $search . '%';
        $bindings['search2'] = '%' . $search . '%';
    }
    // Thực thi query
    $result = DB::select($query, $bindings);
    return $result[0]->total ?? 0;
}
    public function getAllPromotions(int $limit = 10, int $offset = 0, ?string $search = null)
    {
        $query = "SELECT *
                FROM Promotion
                WHERE IsDeleted = 0";

        $bindings = [];

        if (!empty($search)) {
            $query .= " AND (promotion_name LIKE :search1 OR discount_percentage LIKE :search2 )";
            $bindings['search1'] = '%' . $search . '%';
            $bindings['search2'] = '%' . $search . '%';
        }

        // Thêm giới hạn và phân trang
        $query .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        return DB::select($query, $bindings);
    }

    // Tạo chương trình khuyến mãi mới
    public function createPromotion(array $data)
    {
        $query = "
            INSERT INTO Promotion (promotion_name, start_date, end_date, discount_percentage, IsDeleted) 
            VALUES (:promotion_name, :start_date, :end_date, :discount_percentage, 0)
        ";

        DB::insert($query, [
            'promotion_name' => $data['promotion_name'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'discount_percentage' => $data['discount_percentage']
        ]);

        return DB::getPdo()->lastInsertId();
    }

    // Cập nhật chương trình khuyến mãi
    public function updatePromotion(int $promotionId, array $data)
    {
        $query = "
            UPDATE Promotion 
            SET 
                promotion_name = :promotion_name,
                start_date = :start_date,
                end_date = :end_date,
                discount_percentage = :discount_percentage
            WHERE 
                promotion_id = :promotion_id 
                AND IsDeleted = 0
        ";

        DB::update($query, [
            'promotion_id' => $promotionId,
            'promotion_name' => $data['promotion_name'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'discount_percentage' => $data['discount_percentage']
        ]);
    }

    // Xóa chương trình khuyến mãi
    public function deletePromotion(int $promotionId)
    {
        $query = "
            UPDATE Promotion 
            SET IsDeleted = 1 
            WHERE promotion_id = :promotion_id
        ";

        DB::update($query, ['promotion_id' => $promotionId]);
    }
}

<?php
namespace App\Business\PermissionBiz;

use App\Business\PermissionBiz\SqlPermission;
use Exception;
use Illuminate\Http\Request;

/**
 * Persmission Business
 * 
 * @auth Nguyen Minh Nhut
 */
class PersmissionBusiness
{
    protected SqlPermission $sqlPermission;

    /**
     * Contructor
     * 
     */
    public function __construct()
    {
        $this->sqlPermission = new SqlPermission();
    }

    /**
     * Get All Students
     */
    public function getPermission(string $permissionName, int $userId): array
    {
        try {
            $result = $this->sqlPermission->getPermission($permissionName, $userId);
        } catch (Exception $e) {

        }

        return $result;
    }
}
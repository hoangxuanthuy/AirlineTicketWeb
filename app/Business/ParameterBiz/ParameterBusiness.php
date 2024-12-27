<?php

namespace App\Business\ParameterBiz;

use App\Business\ParameterBiz\SqlParameter;
use Exception;
use Illuminate\Http\Request;
class ParameterBusiness
{
    protected SqlParameter $sqlParameter;

    public function __construct()
    {
        $this->sqlParameter = new SqlParameter();
    }

    public function getParameter()
    {
        return $this->sqlParameter->getParameter();
    }

    public function updateParameter( array $data)
    {
        try {
            $this->sqlParameter->updateParameter( $data);
        } catch (Exception $e) {
            throw new Exception("Không thể cập nhật tham số: " . $e->getMessage());
        }
    }
}

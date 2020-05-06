<?php

namespace App\Helpers;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Helper
{
    public static function delete($model)
    {
        if (!$model instanceof Model) {
            throw new Exception('Not Instance Of Model');
        }
        try {
            $model->delete();
        } catch (\Throwable $th) {
            return  Response::error('Không thể xoá');
        }
        return Response::deleted();
    }
}

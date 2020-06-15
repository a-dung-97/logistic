<?php

namespace App\Helpers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
    public static function uploadImage($image, $folder)
    {
        $name = time() . uniqid() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        Storage::put('public/' . $folder . '/' . $name, \Image::make($image)->stream());
        return $name;
    }
    public static  function validateLatLong($lat, $long)
    {
        if (!$lat && !$long) return true;
        return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $lat . ',' . $long);
    }
}

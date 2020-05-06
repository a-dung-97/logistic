<?php

namespace App\Helpers;

class Response
{
    const _HTTP_OK = 200;
    const _HTTP_CREATED = 201;
    const _HTTP_ACCEPTED = 202;
    const _HTTP_NO_CONTENT = 204;
    const _HTTP_BAD_REQUEST = 400;
    const _HTTP_UNAUTHORIZED = 401;
    const _HTTP_NOT_FOUND = 404;
    public static function created()
    {
        return response(['messsage' => 'Thêm mới thành công'], self::_HTTP_OK);
    }
    public static function updated()
    {
        return response(['messsage' => 'Cập nhật thành công'], self::_HTTP_ACCEPTED);
    }
    public static function deleted()
    {
        return response(null, self::_HTTP_NO_CONTENT);
    }
    public static function error($msg = null)
    {
        return response(['message' => $msg], self::_HTTP_BAD_REQUEST);
    }
    public static function notFound($msg = null)
    {
        return response(['message' => 'Không tìm thấy yêu cầu'], self::_HTTP_NOT_FOUND);
    }
    public static function unauthorized()
    {
        return response(['message' => 'Bạn không có quyền thực hiện hành động này'], self::_HTTP_UNAUTHORIZED);
    }
}

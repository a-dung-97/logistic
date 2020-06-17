<?php

namespace App\Http\Controllers\Api\System;

use App\Helpers\Helper;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $search = $request->query('search');
        $role = $request->query('role_id');
        $driver = $request->query('driver');
        $query = User::query()->latest('id');
        if ($search) $query->whereLike(['name', 'username', 'email', 'phone_number'], '%' . $search . '%');
        if ($role) $query->where('role_id', $role);
        if ($driver) {
            $query->whereHas('role', function ($query) {
                $query->where('code', 'lx');
            });
            return ['data' => $query->select('id', 'name')->get()];
        }
        return UserResource::collection($query->with('role:id,name')->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $info = $request->except('password_confirmation');
        $info['password'] = Hash::make($request->password);
        User::create($info);
        return Response::created();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $info = $request->except('password_confirmation');
        if ($request->password) $info['password'] = Hash::make($request->password);
        $user->update($info);
        return Response::updated();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($this->user->id == $user->id) return Response::error('Bạn không thể xoá chính bạn');
        return Helper::delete($user);
    }
    public function changeAvatar(Request $request)
    {
        $oldAvatar = $this->user->avatar;
        if ($oldAvatar) {
            Storage::delete('public/avatar/', $oldAvatar);
        }
        if ($request->avatar) {
            $name = Helper::uploadImage($request->avatar, 'avatars');
            $this->user->update(['avatar' => $name]);
            return ['message' => 'Cập nhật thành công', 'data' => ['avatar' => Storage::url('avatars/' . $name)]];
        } else return response(['message' => 'Bạn chưa tải ảnh lên'], 400);
    }
    function uploadImage(Request $request)
    {
        if ($request->file) {
            $image = $request->file;
            $name = $image->getClientOriginalName();
            $image->storeAs('public/upload/', $name);
            return response()->json([
                'data' => [
                    "url" => '/storage/upload/' . $name
                ]
            ], 200, []);
        }
    }
}

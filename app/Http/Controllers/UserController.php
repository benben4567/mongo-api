<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return ResponseFormatter::success($users, 'Data user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Data tidak valid', 402);
        }

        try {
            $user = User::create($request->all());
            return ResponseFormatter::success($user, "Data berhasil disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), "Terjadi Kesalahan Server", 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user) {
            return ResponseFormatter::success($user, "Data ditemukan");
        }
        return ResponseFormatter::error(null, "Data tidak ditemukan", 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Data tidak valid', 402);
        }

        try {
            $user->update($request->all());
            return ResponseFormatter::success($user, "Data berhasil disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), "Terjadi Kesalahan Server", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user) {
            $user->delete();
            return ResponseFormatter::success($user, "Data berhasil dihapus");
        }
        return ResponseFormatter::error(null, "Data tidak ditemukan", 404);
    }
}

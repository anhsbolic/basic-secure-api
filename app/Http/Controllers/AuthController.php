<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request) {
        try {
            DB::beginTransaction();

            $newUser = new User();
            $newUser->username = $request->username;
            $newUser->email = $request->email;
            $newUser->password = $request->password;
            $newUser->save();

            DB::commit();

            $data = [
                'code' => 1,
                'message' => 'Anda berhasil mendaftar',
                'data' => []
            ];

            return response()->json($data, 200);

        } catch(QueryException $qe) {
            Log::error($qe);
            DB::rollback();

            $data = [
                'code' => 2,
                'message' => 'Username / Email Tidak Tersedia',
                'data' => []
            ];

            return response()->json($data, 200);

        } catch(Exception $e) {
            Log::error($e);
            DB::rollback();

            $data = [
                'code' => 500,
                'message' => 'Internal Server Error',
                'data' => []
            ];

            return response()->json($data, 500);
        }
    }

    public function login(Request $request) {
        dd($request->all());
    }

    public function logout(Request $request) {
        dd($request->all());
    }
}

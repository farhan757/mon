<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function listuser()
    {
        # code...
        $data = DB::table('users')
                ->join('group_user','users.id_group','=','group_user.id')
                ->select('users.*','group_user.nm_group')
                ->orderBy('users.id','DESC')->get();
        $group = DB::table('group_user')->get();

        return view('master.users.list')->with([
            'data' => $data,
            'group' => $group
        ]);
    }

    public function storeUser(Request $request)
    {
        # code...
        $request->validate([
            'username' => 'unique:users',
            'email' => 'unique:users',
            'password' => 'min:8|confirmed'
        ]);

        DB::beginTransaction();
        try {
            //code...
            DB::table('users')->insert([
                'id_group' => $request->id_group,
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Success add user'
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }
    }

    public function destroyUser(Request $request)
    {
        # code...
        DB::beginTransaction();
        try {
            //code...
            DB::table('users')->where('id','=',$request->id)->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Success delete user'
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }
    }
}

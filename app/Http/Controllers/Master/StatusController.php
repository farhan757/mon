<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class StatusController extends Controller
{
    //
    public function listStatus()
    {
        # code...
        $data = DB::table('mst_status')->orderBy('id','DESC')->get();
        return view('master.status.list')->with([
            'data' => $data
        ]);
    }

    public function editByid(Request $request)
    {
        # code...
        $data = DB::table('mst_status')->where('id','=',$request->id)->first();
        return $data;
    }

    public function destroyStatus(Request $request)
    {
        # code...
        DB::beginTransaction();
        try {
            //code...
            DB::table('mst_status')->where('id','=',$request->id)->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Success delete data'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }
    }

    public function saveAll(Request $request)
    {
        # code...
        DB::beginTransaction();
        try {
            //code...
            DB::table('mst_status')->insert([
                'icon' => $request->icon,
                'nama_status' => $request->nama_status,
                'desc_status' => $request->desc_status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Success add data'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }
    }

    public function saveAllEdit(Request $request)
    {
        # code...
        DB::beginTransaction();
        try {
            //code...
            DB::table('mst_status')->where('id','=',$request->id)->update([
                'icon' => $request->icone,
                'nama_status' => $request->nama_statuse,
                'desc_status' => $request->desc_statuse,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Success edit data'
            ]);
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

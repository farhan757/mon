<?php

namespace App\Http\Controllers\Ops;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class DistribusiController extends Controller
{
    //
    public $idStatusDistribusi = 4;

    public function listdistribusi()
    {
        # code...
        $data = DB::table('master_soft')
                ->join('mst_status','master_soft.id_status_last','=','mst_status.id')
                ->leftJoin('ttd_to_kurir','master_soft.id','=','ttd_to_kurir.id_master_data')
                ->select('master_soft.*','mst_status.nama_status','ttd_to_kurir.no_ttd','ttd_to_kurir.jml_awb')
                ->whereOr('master_soft.id_status_last','=',$this->idStatusDistribusi)->whereOr('master_soft.id_status_last','=',5)
                ->orderBy('id', 'DESC')->get();
        $listcomp = $this->dataComponent();
        $liststatus = DB::table('mst_status')->get();
        return view('ops.distribusi.listdistribusi')->with([
            'data' => $data,
            'listcomp' => $listcomp,
            'liststs' => $liststatus
        ]);
    }

    public function storeTtdKurir(Request $request)
    {
        # code...
        $jml_awb = DB::table('data_soft')->where('id_master_data','=',$request->id)->count();
        $nottd = $this->getnoTTD();

        $status = false; $msg = ""; $statuscode = 200;
        DB::beginTransaction();
        try {
            //code...
            DB::table('ttd_to_kurir')->insert([
                'no_ttd' => $nottd,
                'id_master_data' => $request->id,
                'user_id' => Auth::user()->id,
                'jml_awb' => $jml_awb,
                'desc' => $request->desc,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('master_soft')->where('id','=',$request->id)->update([
                'id_status_last' => 5
            ]);

            DB::commit();
            $status = true; $msg = "No TTD ".$nottd; $statuscode = 200;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $status = false; $msg = $th->getMessage(); $statuscode = 500;
        }

        if($status){
            $this->updateStatus($request->id,5);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg
        ],$statuscode);
    }

    public function print(Request $request)
    {
        # code...
        $dt_mst = DB::table('master_soft')->where('id','=',$request->id)->first();
        $dt_ttd = DB::table('ttd_to_kurir')->where('id_master_data','=',$request->id)->get();

        return view('ops.distribusi.printttd')->with([
            'dt_mst' => $dt_mst,
            'dt_ttd' => $dt_ttd
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;
use Auth;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dataComponent($id = 0)
    {
        # code...
        $data = DB::table('master_component');

        if($id == 0){
            $data = $data->orderBy('id','DESC')->get();
        }else{
            $data = $data->where('id','=',$id)->first();
        }

        return $data;
    }

    public function updateStatus($id_master,$id_status)
    {
        # code...
        DB::table('mastersoft_to_status')->insertGetId([
            'id_master_data' => $id_master,
            'id_status' => $id_status,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function getPriceComp($id)
    {
        # code...
        $price = DB::table('master_component')->where('id','=',$id)->first();
        return $price->price;
    }

    public function getnoTTD()
    {
        # code...
        $nottd = "TTD-".random_int(100000, 999999);
        if(DB::table('ttd_to_kurir')->where('no_ttd','=',$nottd)->exists()){
            return $this->getnoTTD();
        }

        return $nottd;
    }
}

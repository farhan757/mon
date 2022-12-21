<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class StokComponentController extends Controller
{
    //
    public function listStok()
    {
        # code...
        $data = DB::table('master_component')->where('key_group','=','material')->get();
        return view('report.stock.list')->with([
            'data' => $data
        ]);
    }
}

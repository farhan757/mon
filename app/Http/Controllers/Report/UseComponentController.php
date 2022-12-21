<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UseComponentController extends Controller
{
    //
    public function listusecomp(Request $request)
    {
        # code...

        $data = DB::table('master_soft')
                ->join('history_component','master_soft.id','=','history_component.id_master_data')
                ->join('master_component','history_component.id_material','=','master_component.id')
                ->select('history_component.id_material','master_soft.created_at',DB::raw('SUM(history_component.qty) AS tt_qty'),'master_component.nm_component');
        if($request->cycle1 != "" && $request->cycle2 != ""){
            $data = $data->where('master_soft.created_at','>=',"$request->cycle1 00:00:00")->where('master_soft.created_at','<=',"$request->cycle2 23:59:59");
        }
        $data = $data->groupBy('history_component.id_material')->paginate(10);

        return view('report.usecomp.list')->with([
            'data' => $data,
            'cycle1' => $request->cycle1,
            'cycle2' => $request->cycle2
        ]);
    }
}

<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Exception;

class ComponentController extends Controller
{
    //
    public function list(Request $request)
    {
        # code...
        $data = $this->dataComponent();
        return view('master.component.list')->with('data',$data);
    }

    public function storeComponent(Request $request)
    {
        # code...
        $key_group = $request->key_group;
        $nm_comp = $request->nm_component;

        DB::beginTransaction();
        try{
            DB::table('master_component')->insert([
                'key_group' => $key_group,
                'nm_component' => $nm_comp,
                'stok' => $request->stok,
                'price' => $request->price,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Success add data'
            ], 200);
        }catch(Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }
    }

    public function destroyComponent(Request $request)
    {
        # code...
        $id_comp = $request->id_comp;

        DB::beginTransaction();
        try{
            DB::table('master_component')->where('id','=',$id_comp)->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Success delete data'
            ], 200);
        }catch(Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }
    }

    public function getByid(Request $request)
    {
        # code...
        return $this->dataComponent($request->id);
    }

    public function putComponent(Request $request)
    {
        # code...
        $id = $request->id;
        $key_group = $request->key_groupe;
        $nm_comp = $request->nm_componente;

        DB::beginTransaction();
        try{
            DB::table('master_component')->where('id','=',$id)->update([
                'key_group' => $key_group,
                'nm_component' => $nm_comp,
                'stok' => $request->stoke,
                'price' => $request->pricee,
                'updated_at' => Carbon::now()
            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Success edit data'
            ], 200);
        }catch(Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

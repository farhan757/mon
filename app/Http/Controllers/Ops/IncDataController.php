<?php

namespace App\Http\Controllers\Ops;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Exception;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class IncDataController extends Controller
{
    //
    public function listIncData(Request $request)
    {
        # code...
        $data = DB::table('master_soft')
                ->join('mst_status','master_soft.id_status_last','=','mst_status.id')
                ->select('master_soft.*','mst_status.nama_status')
                ->orderBy('id', 'DESC')->get();
        $listcomp = $this->dataComponent();
        $liststatus = DB::table('mst_status')->get();
        return view('ops.incomingdata.listincoming')->with([
            'data' => $data,
            'listcomp' => $listcomp,
            'liststs' => $liststatus
        ]);
    }

    public function storeData(Request $request)
    {
        # code...
        //return $request->all();
        $idmaster_soft = 0; $status = false; $msg = ""; $statuscode = 200;
        if ($request->file('softcopy1') && $request->file('softcopy2')) {

            DB::beginTransaction();
            try{
                $file = $request->file('softcopy1');
                $filedata = $file->getClientOriginalName();

                $tujuan_upload = storage_path('data_file');
                $file->move($tujuan_upload, $file->getClientOriginalName());

                $filename = $tujuan_upload . '\\' . $filedata;
                $filtype = IOFactory::identify($filename);
                $reader = IOFactory::createReader($filtype);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($filename);

                $sheet = $spreadsheet->getActiveSheet();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $file2 = $request->file('softcopy2');
                $filedata2 = $file2->getClientOriginalName();

                $file2->move($tujuan_upload, $file2->getClientOriginalName());

                $filename2 = $tujuan_upload . '\\' . $filedata2;
                $filtype2 = IOFactory::identify($filename2);
                $reader2 = IOFactory::createReader($filtype2);
                $reader2->setReadDataOnly(true);
                $spreadsheet2 = $reader2->load($filename2);

                $sheet2 = $spreadsheet2->getActiveSheet();
                $highestRow2 = $sheet2->getHighestRow();
                $highestColumn2 = $sheet2->getHighestColumn();

                $idmaster_soft = DB::table('master_soft')->insertGetId([
                    'nm_file' => $file->getClientOriginalName(),
                    'nm_file2' => $file2->getClientOriginalName(),
                    'cycle' => $request->cycle,
                    'create_by' => Auth::user()->id,
                    'id_status_last' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                foreach($request->id_comp as $key => $id_comp){
                    $qty = $request->qty[$key];

                    $mst_to_comp[] = array(
                        'id_master_data' => $idmaster_soft,
                        'id_material' => $id_comp,
                        'qty' => $qty,
                        'price' => $this->getPriceComp($id_comp),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    );
                }

                for($row = 2; $row <= $highestRow; $row++){
                    $tmp[] = array(
                        'id_master_data' => $idmaster_soft,
                        'awb' => $sheet->getCellByColumnAndRow(2,$row)->getValue(),
                        'tipe' => $sheet->getCellByColumnAndRow(3,$row)->getValue(),
                        'date_proses' => $sheet->getCellByColumnAndRow(4,$row)->getValue(),
                        'koli' => $sheet->getCellByColumnAndRow(5,$row)->getValue(),
                        'weight' => $sheet->getCellByColumnAndRow(6,$row)->getValue(),
                        'desti_kota' => $sheet->getCellByColumnAndRow(7,$row)->getValue(),
                        'no_order' => $sheet->getCellByColumnAndRow(8,$row)->getValue(),
                        'consignee_name' => $sheet->getCellByColumnAndRow(9,$row)->getValue(),
                        'consignee_address' => $sheet->getCellByColumnAndRow(10,$row)->getValue(),
                        'consignee_telp' => $sheet->getCellByColumnAndRow(11,$row)->getValue(),
                        'service_tipe' => $sheet->getCellByColumnAndRow(12,$row)->getValue(),
                        'value_cod' => $sheet->getCellByColumnAndRow(13,$row)->getValue(),
                        'remarks' => $sheet->getCellByColumnAndRow(14,$row)->getValue(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    );
                }

                for($row2 = 2; $row2 <=$highestRow2; $row2++){
                    $tmp2[] = array(
                        'id_master_data' => $idmaster_soft,
                        'awb' => $sheet2->getCellByColumnAndRow(2,$row2)->getValue(),
                        'nama' => $sheet2->getCellByColumnAndRow(3,$row2)->getValue(),
                        'bank' => $sheet2->getCellByColumnAndRow(4,$row2)->getValue(),
                        'address' => $sheet2->getCellByColumnAndRow(5,$row2)->getValue(),
                        'no_sertifikat' => $sheet2->getCellByColumnAndRow(6,$row2)->getValue(),
                        'jenis_dok' => $sheet2->getCellByColumnAndRow(7,$row2)->getValue(),
                        'tgl_kirim' => $sheet2->getCellByColumnAndRow(8,$row2)->getValue(),
                        'media_pengiriman' => $sheet2->getCellByColumnAndRow(9,$row2)->getValue(),
                        'status_pengiriman' => $sheet2->getCellByColumnAndRow(10,$row2)->getValue(),
                        'tgl_terima' => $sheet2->getCellByColumnAndRow(11,$row2)->getValue(),
                        'nama_penerima' => $sheet2->getCellByColumnAndRow(12,$row2)->getValue(),
                        'sla' => $sheet2->getCellByColumnAndRow(13,$row2)->getValue(),
                        'keterangan' => $sheet2->getCellByColumnAndRow(14,$row2)->getValue(),
                        'remarks' => $sheet2->getCellByColumnAndRow(15,$row2)->getValue(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    );
                }

                DB::table('mastersoft_use_comp')->insert($mst_to_comp);
                DB::table('data_soft')->insert($tmp);
                DB::table('data_soft2')->insert($tmp2);

                DB::commit();
                $status = true;
                $msg = "Success add data";
            }catch(Exception $e){
                DB::rollback();
                $status = false;
                $statuscode = 500;
                $msg = $e->getMessage();
            }

            if($status){
                $this->updateStatus($idmaster_soft,1);
            }

            return response()->json([
                'status' => $status,
                'message' => $msg
            ], $statuscode);
        }

    }

    public function destroyData(Request $request)
    {
        # code...
        DB::beginTransaction();
        try{
            DB::table('master_soft')->where('id','=',$request->id_comp)->delete();
            DB::table('data_soft')->where('id_master_data','=',$request->id_comp)->delete();
            DB::table('data_soft2')->where('id_master_data','=',$request->id_comp)->delete();
            DB::table('mastersoft_use_comp')->where('id_master_data','=',$request->id_comp)->delete();
            DB::table('mastersoft_to_status')->where('id_master_data','=',$request->id_comp)->delete();
            DB::table('history_component')->where('id_master_data','=',$request->id_comp)->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Success data delete'
            ],200);
        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function getCurrentsts(Request $request)
    {
        # code...
        $data = DB::table('master_soft')
                ->join('mst_status','master_soft.id_status_last','=','mst_status.id')
                ->select('mst_status.nama_status')->where('master_soft.id','=',$request->id)->first();

        return $data;
    }

    public function UpdateSts(Request $request)
    {
        # code...
        $status = false; $msg = ""; $statuscode = 200;
        DB::beginTransaction();
        try {
            //code...
            DB::table('master_soft')->where('id','=',$request->id)->update([
                'id_status_last' => $request->id_status
            ]);

            if($request->id_status == 2){
                $detail_dt = DB::table('mastersoft_use_comp')->where('id_master_data','=',$request->id)->get();
                $tmp = null;
                foreach($detail_dt as $item){
                    $tmp[] = array(
                        'id_master_data' => $item->id_master_data,
                        'keterangan' => 'keluar',
                        'id_material' => $item->id_material,
                        'qty' => $item->qty,
                        'price' => $item->price,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    );
                }
                DB::table('history_component')->insert($tmp);
            }

            DB::commit();
            $status = true;
            $msg = "Success update status";
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            $status = false;
            $statuscode = 500;
            $msg = $th->getMessage();
        }

        if($status == true){
            $this->updateStatus($request->id,$request->id_status);
        }

        return response()->json([
            'status' => $status,
            'message' => $msg
        ], $statuscode);
    }

    public function detailMaster(Request $request)
    {
        # code...
        $component = DB::table('mastersoft_use_comp')
                    ->join('master_component','mastersoft_use_comp.id_material','=','master_component.id')
                    ->select('master_component.nm_component','mastersoft_use_comp.qty')
                    ->where('mastersoft_use_comp.id_master_data','=',$request->id)->get();

        $liststatus = DB::table('mastersoft_to_status')
                    ->join('mst_status','mastersoft_to_status.id_status','=','mst_status.id')
                    ->select('mst_status.nama_status','mst_status.desc_status','mastersoft_to_status.created_at')
                    ->where('mastersoft_to_status.id_master_data','=',$request->id)
                    ->orderBy('mastersoft_to_status.id','ASC')->get();
        
        return response()->json([
            'component' => $component,
            'liststatus' => $liststatus
        ]);
    }
}

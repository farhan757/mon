<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

	public function getrange($per='year',$segment=0,$info=1, $start=null,$end=null){
		$MONTHS = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December','Null');		
        $query = DB::table('master_soft');
        $lb = "Printing";
        if($info == 1){
            $query->select(DB::raw('SUM(history_component.qty) AS jumlah'));
        }
        if($info == 2){
            $lb = "Data";
            $query->select(DB::raw('COUNT(data_soft2.id_master_data) AS jumlah'));            
        }
        if($info == 3){
            $lb = "Pendapatan Rp";
            $query->select(DB::raw('SUM(history_component.qty * history_component.`price`) AS jumlah'));            
        }
		
		$query->addSelect(DB::raw('YEAR(master_soft.created_at) as tahun'));
		
        if($info == 1 || $info == 3){
            $query->leftJoin('history_component','history_component.id_master_data','=','master_soft.id');
		    $query->leftJoin('master_component','history_component.id_material','=','master_component.id');
        }
        if($info == 2){
            $query->leftJoin('data_soft2','master_soft.id','=','data_soft2.id_master_data');
        }
        // if($info == 1){
        //     $query->where('components_out.group','=','jasa');
        // }
        if($info == 1){
            $query->where('master_component.nm_component','LIKE','%printing%');
        }

		$query->where('master_soft.id_status_last','=',5);
        if($start != null && $end != null){
            $query->where('master_soft.created_at','>=',$start.' 00:00:00')->where('master_soft.created_at','<=',$end.' 23:59:59');
        }		
		if($segment != 0){
			$query->where('master_soft.customer_id','=',$segment);
		}
        if($per=='month' || $per=='day')
        {
            $query->addSelect(DB::raw('MONTH(master_soft.created_at) as bulan'));                
        }
        if($per=='day')
        {
            $query->addSelect(DB::raw('DAY(master_soft.created_at) as tanggal'));
        }

        //var_dump($query->get());

        switch ($per) {                
            case 'day':
                $query->groupBy('tahun','bulan','tanggal')->orderBy('tanggal','ASC');
                break;
            case 'month':
                $query->groupBy('tahun','bulan');
                break;
            default:
                $query->groupBy('tahun');
                break;
		}	
		$data = $query->get();
        


        $nwArray=array();
        $nwArray['total']= array();
		$nwArray['labels']= array();
		
		$total = 0;

        foreach ($data as $key => $value) {
            array_push($nwArray['total'], $value->jumlah);

            $total = $total+$value->jumlah;
            if($per=='month' || $per=='day') {
                if($value->bulan==null){ 
                    $bulan = "Null";
                }
                else {
                    $bulan = $MONTHS[$value->bulan-1];
                }
            }
            switch ($per) {
                case 'day':
                    array_push($nwArray['labels'], sprintf('%02d',$value->tanggal)."-".$bulan."-".$value->tahun);
                    break;
                case 'month':
                    array_push($nwArray['labels'], $bulan."-".$value->tahun);
                    break;                
                default:
                    array_push($nwArray['labels'], $value->tahun);
                    break;
            }

        }

        $nwArray['lbl_total'] = number_format($total);
        $nwArray['lbl_info'] = $lb;
        return response()->json($nwArray);
	}    

    public function get($type) {
    	switch ($type) {
    		case 'submit':
				return $this->getDataToday();
    			break;
    		case 'awb':
    			return $this->getAwbToday();
    			break;
    		case 'material':
    			return $this->getMaterialToday();
    			break;
    		case 'deliv':
    			return $this->getDeliveryToday();
	    		break;
    	}
    }

    function getDataToday() {		

    	$sql = DB::table('master_soft')
    	->join('data_soft2','master_soft.id','=','data_soft2.id_master_data')
    	->whereDate('master_soft.created_at', Carbon::today());
    	
    	return $sql->count();
    }

    function getAwbToday() {
		
    	$sql = DB::table('master_soft')
    	->join('data_soft','master_soft.id','=','data_soft.id_master_data')    	
    	->whereDate('master_soft.created_at', Carbon::today());

    	return $sql->count();
    }

    function getMaterialToday() {		

    	$sql = DB::table('master_soft')
    	->join('history_component','master_soft.id','=','history_component.id_master_data')
    	->join('master_component','history_component.id_material','=','master_component.id')    	
    	->whereDate('master_soft.created_at', Carbon::today())
		->where('master_component.key_group','=','material');	

    	return $sql->sum('history_component.qty');
    }

    function getDeliveryToday() {
	
		$sql = DB::table('master_soft')
		->join('data_soft','master_soft.id','=','data_soft.id_master_data')
		->where('master_soft.id_status_last','=',4)
    	->whereDate('master_soft.created_at', Carbon::today());		

        return $sql->count();
    }    
}

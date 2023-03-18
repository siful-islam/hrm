<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Travel;
use Session;
use Illuminate\Support\Facades\Redirect;
////session_start();

class TravelController extends Controller
{

    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}	
	
	public function index()
    {        	
		$data['purposes'] = DB::table('travel_purpose')
							->get();
		$data['countries'] = DB::table('country')
							->get();
										
		return view('admin.employee.manage_travels',$data);					
    }
	
	
    public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['insert_status'] = Travel::insertGetId($data);
		echo json_encode($data);
    }
	
    public function edit($id)
    {
        return $data = Travel::find($id);
    }
	
    public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);		
		$data['insert_status']         = DB::table('tbl_travels')
            ->where('id', $id)
            ->update($data);
		echo json_encode($data);
    } 



	public function all_travels(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_travels.id', 
			1 =>'tbl_travels.emp_id',
			2=> 'tbl_travels.travel_country',
			3=> 'tbl_travels.departure_date',
			4=> 'tbl_travels.return_date',
			5=> 'tbl_travels.purpose_id',
			6=> 'tbl_travels.sponsor_by',
		); 
        $totalData = Travel::count();
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');           
        if(empty($request->input('search.value')))
        {            
            $infos = Travel:: leftjoin('tbl_emp_basic_info', 'tbl_travels.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->leftjoin('country', 'country.id', '=', 'tbl_travels.travel_country')
							->leftjoin('travel_purpose', 'travel_purpose.purpose_id', '=', 'tbl_travels.purpose_id')
							->offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->select('tbl_travels.*','tbl_emp_basic_info.emp_name_eng','country.country_name','travel_purpose.purpose_name')
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos =  Travel::leftjoin('tbl_emp_basic_info', 'tbl_travels.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->leftjoin('country', 'country.id', '=', 'tbl_travels.travel_country')
							->leftjoin('travel_purpose', 'travel_purpose.purpose_id', '=', 'tbl_travels.purpose_id')
							->where('emp_id','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
							->select('tbl_travels.*','tbl_emp_basic_info.emp_name_eng','country.country_name','travel_purpose.purpose_name')
                            ->get();
            $totalFiltered = Travel::where('emp_id','LIKE',"%{$search}%")
                             ->count();
        }
        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {                
				$nestedData['sl'] 				= $i++;
                $nestedData['emp_id'] 			= $info->emp_id;
                $nestedData['emp_name'] 		= $info->emp_name_eng;
                $nestedData['departure_date'] 	= $info->departure_date;             
				$nestedData['return_date'] 		= $info->return_date;
				$nestedData['travel_country'] 	= $info->country_name;
				$nestedData['purpose'] 			= $info->purpose_name;
				$nestedData['options'] 			= '<a class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->id.')" href="#"><i class="glyphicon glyphicon-pencil"></i></a>';$data[] = $nestedData;
            }
        }         
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );            
        echo json_encode($json_data);       
    }
	
	
}

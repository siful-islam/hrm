<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Supervisor;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class SupervisorController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		

		
		//$data['supervisors'] = DB::table('reported_to_new')->where('status',1)->groupBy('reported_emp_id')->get();
		$data['supervisors'] = DB::table('supervisors')
									->join('tbl_designation', 'tbl_designation.designation_code', '=', 'supervisors.designation_code')
									->where('supervisors.active_status',1)
									->select('tbl_designation.designation_name','supervisors.supervisors_emp_id','supervisors.supervisors_name')
									->orderBy('orderd_show','ASC')
									->get();
									
									
									
									
									
									
									
		//print_r($data['supervisors']);							
									
									
									
									
		return view('admin.settings.manage_supervisor',$data);					
    }
	
	public function create()
    {
		
    }	

	public function edit($id)
	{
		$data = array();
		$info = DB::table('supervisor_mapping_ho')->where('mapping_id',$id)->first();
		$data['mapping_id'] 				= $info->mapping_id;
		$data['emp_name'] 					= $info->emp_name;
		$data['emp_id'] 					= $info->emp_id;
		$data['supervisor_id'] 				= $info->supervisor_id;
		$data['supervisor_type'] 			= $info->supervisor_type;
		$data['active_from'] 				= $info->active_from;
		echo json_encode($data); 
	}
	
	public function store(Request $request)
    {
		//$data = request()->except(['_token','_method']);
		
		$emp_id 					= $request->input('emp_id');
		if($emp_id < 100000)
		{
			$emp_name = DB::table('tbl_emp_basic_info')->where('emp_id',$emp_id)->select('emp_name_eng')->first();
			$data['emp_name']			= $emp_name->emp_name_eng;
		}
		else
		{
			$emp_name = DB::table('tbl_emp_non_id')->where('emp_id',$emp_id)->select('emp_name')->first();
			$data['emp_name']			= $emp_name->emp_name;
		}
		//
		$data['emp_id']						= $emp_id;
		$data['supervisor_id']				= $request->input('supervisor_id');
		$data['supervisor_type']			= $request->input('supervisor_type');
		$data['active_from']				= $request->input('active_from');
		$data['mapping_status']				= 1;
		
		$insert['status'] = DB::table('supervisor_mapping_ho')->insert($data);
		echo json_encode($insert);
    }
	
	public function update(Request $request, $id)
    {				
		$emp_id 					= $request->input('emp_id');
		if($emp_id < 100000)
		{
			$emp_name = DB::table('tbl_emp_basic_info')->where('emp_id',$emp_id)->select('emp_name_eng')->first();
			$data['emp_name']			= $emp_name->emp_name_eng;
		}
		else
		{
			$emp_name = DB::table('tbl_emp_non_id')->where('emp_id',$emp_id)->select('emp_name')->first();
			$data['emp_name']			= $emp_name->emp_name;
		}
		//
		$data['emp_id']						= $emp_id;
		$data['supervisor_id']				= $request->input('supervisor_id');
		$data['supervisor_type']			= $request->input('supervisor_type');
		$data['active_from']				= $request->input('active_from');
		//
		$update['status'] = DB::table('supervisor_mapping_ho')
								->where('mapping_id', $id)
								->update($data);
		echo json_encode($update);
    }
	
	
	
	public function show($id)
	{

	}

	
	public function allsupervisor(Request $request)
    {       
		$columns = array( 
			0 =>'mapping_id', 
			1 =>'emp_id',
			2 =>'emp_name',
			3=> 'supervisor_id',
			4=> 'supervisor_type',
			5=> 'active_from'
		);
  
        $totalData = Supervisor::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Supervisor::leftjoin('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'supervisor_mapping_ho.supervisor_id')
							->offset($start)
							->select('supervisor_mapping_ho.*','tbl_emp_basic_info.emp_name_eng')
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else {
            $search = $request->input('search.value'); 

            $infos =  Supervisor::leftjoin('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'supervisor_mapping_ho.supervisor_id')
							->where('supervisor_mapping_ho.emp_id',$search)
                            ->offset($start)
                            ->select('supervisor_mapping_ho.*','tbl_emp_basic_info.emp_name_eng')
							->limit($limit)							
                            ->orderBy($order,$dir)
							//->orderBy('supervisor_mapping_ho.emp_id', 'asc')
                            ->get();
            $totalFiltered = Supervisor::where('supervisor_mapping_ho.emp_id',$search)
                             ->count();
        }
		

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                if($info->supervisor_type == 1) {
					$supervisortype = 'Supervisor';
				} else if($info->supervisor_type == 2) {
					$supervisortype = 'Sub Supervisor';
				}
				
				$nestedData['sl'] 						= $i++;
                $nestedData['emp_id'] 					= $info->emp_id;
                $nestedData['emp_name'] 				= $info->emp_name;
                $nestedData['supervisor_id']			= $info->supervisor_id.' - '.$info->emp_name_eng;
				$nestedData['supervisor_type'] 			= $supervisortype;                   
				$nestedData['active_from'] 				= $info->active_from;            
				$nestedData['options'] 					= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->mapping_id.')"><i class="fa fa-pencil" aria-hidden="true"></i></button>';				
				$data[] = $nestedData;
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
	
	

	private function cheeck_action_permission($action_id)
	{
		$access_label 	= Session::get('admin_access_label');		
		$nav_name 		=  '/'.request()->segment(1);
		$nav_info		= DB::table('tbl_navbar')->where('nav_action',$nav_name)->first();	
		$nav_id 		= $nav_info->nav_id;
		$permission    	= DB::table('tbl_user_permissions')
							->where('user_role_id',$access_label)
							->where('nav_id',$nav_id)
							->where('status',1)
							->first();
		if($permission)
		{
			if(in_array($action_id,$p = explode(",", $permission->permission)))
			{
				return true;
			}
			else
			{
				return false;
			}
		}	
		else
		{
			return false;
		}
	}

}

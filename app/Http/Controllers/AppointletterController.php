<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Appointletter;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class AppointletterController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['app_letter'] = DB::table('tbl_appointment_letter')
									->join('tbl_appointment_info', 'tbl_appointment_letter.emp_id', '=', 'tbl_appointment_info.emp_id')
									->orderBy('tbl_appointment_info.emp_id', 'desc')
									->get();
		return view('admin.employee.manage_appoint_letter',$data);					
    }

	public function view_appoint_letter($emp_id)
	{
		$data = array();
		$letter_info = DB::table('tbl_appointment_letter')
												->where('emp_id', $emp_id)
												->first();										
		$data['emp_id']		= $letter_info->emp_id;	
		$data['letter_body']= $letter_info->letter_body;	
		return $data;	
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
	
	public function all_appoint_letter(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_appointment_letter.emp_id',
			1 =>'tbl_appointment_info.emp_name',
			2=>'tbl_appointment_info.letter_date',
			3=>'tbl_appointment_info.joining_date',
			4=>'tbl_appointment_letter.id',
		);
  
        $totalData = Appointletter::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $letters = Appointletter::join('tbl_appointment_info', 'tbl_appointment_letter.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->select('tbl_appointment_letter.id','tbl_appointment_info.emp_id','tbl_appointment_info.letter_date','tbl_appointment_info.emp_name','tbl_appointment_info.joining_date')
							->get();
        }
        else {
            $search = $request->input('search.value'); 

            $letters =  Appointletter::join('tbl_appointment_info', 'tbl_appointment_letter.emp_id', '=', 'tbl_appointment_info.emp_id' )
                            ->where('tbl_appointment_letter.emp_id', $search)
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
							->select('tbl_appointment_letter.id','tbl_appointment_info.emp_id','tbl_appointment_info.letter_date','tbl_appointment_info.emp_name','tbl_appointment_info.joining_date')
                            ->get();

            $totalFiltered = Appointletter::join('tbl_appointment_info', 'tbl_appointment_letter.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->where('tbl_appointment_letter.emp_id', $search)
                             ->count();
        }

        $data = array();
        if(!empty($letters))
        {
            $i=1;
            foreach ($letters as $letter)
            {
                $nestedData['id'] 			= $i++;
                $nestedData['emp_id'] 		= $letter->emp_id;
                $nestedData['emp_name'] 	= $letter->emp_name;
                $nestedData['letter_date'] 	= $letter->letter_date;
				$nestedData['joining_date'] = $letter->joining_date;
				$nestedData['options'] 		= '<a class="btn btn-sm btn-default btn-xs" title="Appoinment Letter" onclick="view_letter('.$letter->emp_id.')"><i class="glyphicon glyphicon-print"></i> Print Letter</a>
				<a class="btn btn-sm btn-danger btn-xs" title="Edit" href="emp-general/'.$letter->emp_id.'/1"><i class="glyphicon glyphicon-pencil"></i>Create C.V</a>';				
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
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Transfer;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class TransferController extends Controller
{
    public function __construct() 
	{
		date_default_timezone_set("Asia/Dhaka");
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		/*$data['transfer_info'] = Transfer::leftjoin('tbl_appointment_info', 'tbl_transfer.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->orderBy('tbl_transfer.id', 'desc')
							->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_transfer.br_code' )
							->select('tbl_transfer.id','tbl_transfer.emp_id','tbl_transfer.sarok_no','tbl_transfer.letter_date','tbl_transfer.effect_date','tbl_transfer.status','tbl_appointment_info.emp_name','tbl_branch.branch_name')
							->get();	*/					
		return view('admin.employee.manage_transfer');			
    }
	public function all_transfer(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_transfer.id', 
			1 =>'tbl_transfer.emp_id',
			2 =>'tbl_appointment_info.emp_name',
			3 =>'tbl_transfer.sarok_no',
			4 =>'tbl_transfer.letter_date',
			5 =>'tbl_transfer.effect_date',
			6 =>'tbl_transfer.id',
		);
  
        $totalData = Transfer::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $transfers = Transfer::join('tbl_appointment_info', 'tbl_transfer.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_transfer.designation_code' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_transfer.br_code' )
							->offset($start)
							->limit($limit)
							->orderBy('tbl_transfer.letter_date', 'desc')
							->select('tbl_transfer.id','tbl_transfer.emp_id','tbl_transfer.sarok_no','tbl_transfer.letter_date','tbl_transfer.effect_date','tbl_transfer.status','tbl_appointment_info.emp_name','tbl_designation.designation_name','tbl_branch.branch_name')
							->get();
        }
        else {
            $search = $request->input('search.value'); 

            $transfers =  Transfer::join('tbl_appointment_info', 'tbl_transfer.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_transfer.designation_code' )
							->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_transfer.br_code' )
							->where('tbl_transfer.emp_id', $search)
                            ->offset($start)
                            ->limit($limit)
							->orderBy('tbl_transfer.letter_date', 'desc')
							->select('tbl_transfer.id','tbl_transfer.emp_id','tbl_transfer.sarok_no','tbl_transfer.letter_date','tbl_transfer.effect_date','tbl_transfer.status','tbl_appointment_info.emp_name','tbl_designation.designation_name','tbl_branch.branch_name')
                            ->get();

            $totalFiltered = Transfer::join('tbl_appointment_info', 'tbl_transfer.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->where('tbl_transfer.emp_id', $search)
                             ->count();
        }

        $data = array();
        if(!empty($transfers))
        {
            $i=1;
            foreach ($transfers as $v_transfers)
            {
                $nestedData['id'] 			= $i++;
                $nestedData['emp_id'] 		= $v_transfers->emp_id;
                $nestedData['emp_name'] 	= $v_transfers->emp_name;
                $nestedData['sarok_no'] 	= $v_transfers->designation_name;
                $nestedData['letter_date'] 	= $v_transfers->branch_name;
				$nestedData['effect_date'] 	= $v_transfers->letter_date;
				$nestedData['status'] 		= $v_transfers->effect_date;
				$nestedData['options'] 		= '<a class="btn btn-sm btn-danger btn-xs" title="Edit" href="transfer/'.$v_transfers->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';				
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

    public function create()
    {
		// SAVE = 2 
		$action_id = 2;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		//
		$data['action'] 				= '/save-transection';
		$data['action_table'] 			= 'tbl_transfer';
		$data['action_controller'] 		= 'transfer';
		$data['transection_type'] 		= 8;
		$data['Heading'] 				= 'Add Transfer';
		$data['button_text'] 			= 'Save';
		$data['designation_name'] 		= '';
		$data['branch_name'] 			= '';
		$data['is_permanent'] 			= '';			
		//
		$data['id'] 					= '';
		$data['emp_id'] 				= '';		
		$data['emp_name'] 				= '';
		$data['joining_date'] 			= '';
		//
		$data['letter_date'] 			= date('Y-m-d');  
		$data['effect_date'] 			= date('Y-m-d');
		$data['br_joined_date'] 		= date('Y-m-d');
		$data['sarok_no'] 				= 0;
		$data['br_code'] 				= '';
		$data['designation_code'] 		= '';
		$data['grade_code'] 			= '';
		$data['grade_step'] 			= '';
		$data['department_code'] 		= '';
		$data['report_to'] 				= '' ;
		$data['remarks'] 				= '' ;
		$data['comments'] 				= '' ;
		$todate 		= date('Y-m-d');
		$tomonth 		= date('m');
		$toyear 		= date('Y');
		if($tomonth == '01' || $tomonth == '02' || $tomonth == '03' ||$tomonth == '04' ||$tomonth == '05' ||$tomonth == '06')
		{
			$next_year 		= $toyear;
		}
		else if($tomonth == '07' || $tomonth == '08' || $tomonth == '09' ||$tomonth == '10' ||$tomonth == '11' ||$tomonth == '12')
		{
			$next_year 		= $toyear+1;
		}
		$data['next_increment_date'] = $next_year.'-07-01';
		
		$data['status'] 				= 1;
		$data['emp_photo'] 				= 'default.png';
		
		
		//
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();								
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['transfer_remarks'] 		= DB::table('tbl_transfer_remarks')->where('status',1)->where('org_code',Session::get('admin_org_code'))->get();
		return view('admin.employee.transfer_form',$data);	

    }	

    public function edit($id)
    {
		//UPDATE = 3;
		$action_id = 3;
		$get_permission 				= $this->cheeck_action_permission($action_id);
		if($get_permission == false)
		{
			return view('admin.access_denyd');
			exit;
		}
		$data = array();
		$transfer_info = DB::table('tbl_transfer')->where('id', $id)->first();
		$emp_id 						= $transfer_info->emp_id;
		$data['letter_date'] 			= $transfer_info->letter_date;
		$data['effect_date'] 			= $transfer_info->effect_date;
		$data['br_joined_date'] 		= $transfer_info->effect_date;
		$data['sarok_no'] 				= $transfer_info->sarok_no;
		$data['br_code'] 				= $transfer_info->br_code;
		$data['designation_code'] 		= $transfer_info->designation_code;
		$data['department_code'] 		= $transfer_info->department_code;
		$data['report_to'] 				= $transfer_info->report_to ;
		$data['grade_code'] 			= $transfer_info->grade_code;
		$data['grade_step'] 			= $transfer_info->grade_step;
		$data['next_increment_date'] 	= $transfer_info->next_increment_date;
		$data['status'] 				= $transfer_info->status;
		$data['remarks'] 				= $transfer_info->remarks;
		$data['comments'] 				= $transfer_info->comments;
		$data['is_permanent'] 			= '';	
		//
		$data['action'] 				= "/update-transection";
		$data['action_table'] 			= 'tbl_transfer';
		$data['action_controller'] 		= 'transfer';
		$data['transection_type'] 		= 8;
		$data['Heading'] 				= 'Edit Transfer';
		$data['button_text'] 			= 'Update';
		//

		$employee_info = DB::table('tbl_appointment_info')
				->leftjoin('tbl_transfer', 'tbl_transfer.emp_id', '=', 'tbl_appointment_info.emp_id')
				->leftjoin('tbl_designation', 'tbl_designation.designation_code', '=', 'tbl_transfer.designation_code')
				->leftjoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
				->leftjoin('tbl_emp_photo', 'tbl_emp_photo.emp_id', '=', 'tbl_appointment_info.emp_id')
				->where('tbl_appointment_info.emp_id', $emp_id)
				->first();			
	
		$data['id'] 					= $id;
		$data['emp_id'] 				= $employee_info->emp_id;		
		$data['emp_name'] 				= $employee_info->emp_name;
		$data['joining_date'] 			= $employee_info->joining_date;
		//$data['br_joined_date'] 		= $employee_info->joining_date;
		$data['designation_name'] 		= $employee_info->designation_name;
		$data['branch_name'] 			= $employee_info->branch_name;
		if(!empty($employee_info->emp_photo))
		{
			$data['emp_photo'] 			= $employee_info->emp_photo;
		}
		else
		{
			$data['emp_photo'] 			= 'default.png';
		}
		//
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['grades'] 		    	= DB::table('tbl_grade_new')->where('status',1)->get();
		$data['departments'] 		    = DB::table('tbl_department')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['transfer_remarks'] 		= DB::table('tbl_transfer_remarks')->where('status',1)->where('org_code',Session::get('admin_org_code'))->get();
		return view('admin.employee.transfer_form',$data);	
    }
	
	
	public function get_transfer_info($emp_id , $q_type)
	{
		$results = DB::table('tbl_transfer')
						->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_transfer.br_code')
						->select('tbl_transfer.id','tbl_transfer.effect_date','tbl_branch.branch_name')
						->where('emp_id',$emp_id) 
						->orderBy('tbl_transfer.effect_date', 'desc')
						->get();

		echo '<tr>';
		echo "<th>Sl</th>";
		echo "<th>Date From</th>";
		echo "<th>Date To</th>";
		echo "<th>Duration</th>";
		echo "<th>Branch Name</th>";
		echo '</tr>';
		$i = 1; 
		$next_day = date("Y-m-d");
		$to_date = date("Y-m-d");
		foreach($results as $result){
			if($i == 1)
			{
				$date_upto = $to_date;
			}
			else
			{
				$date_upto = $next_day;
			}
			$big_date=date_create($date_upto);
			$small_date=date_create($result->effect_date);
			$diff=date_diff($big_date,$small_date);
			echo '<tr>';
			echo "<td>$i</td>";
			echo "<td>$result->effect_date</td>";
			echo "<td>$date_upto</td>";
			echo "<td style='color:blue;'>";
			printf($diff->format('%y Year %m Month %d Day' ));
			echo "</td>";
			echo "<td>$result->branch_name</td>";
			echo '</tr>';
			$next_day = $result->effect_date;
			$i++;
		}		
		
	}
	
	
    public function show($id)
    {
       $data = array();
	   return view('admin.reports.lpc',$data);	
    }
	
    public function destroy($id)
    {
        echo 'Delete '.$id;
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

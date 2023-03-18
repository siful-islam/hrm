<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Heldup;
use DB;
use Session;

class HeldupController extends Controller
{
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		/*$data['heldup_info'] = Heldup::join('tbl_emp_basic_info', 'tbl_heldup.emp_id', '=', 'tbl_emp_basic_info.emp_id' )
							->join('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_heldup.br_code')
							->join('tbl_designation', 'tbl_designation.id', '=', 'tbl_heldup.designation_code')
							->select('tbl_heldup.id','tbl_heldup.emp_id','tbl_heldup.letter_date','tbl_heldup.what_heldup','tbl_emp_basic_info.emp_name_eng','tbl_designation.designation_name','tbl_branch.branch_name')
							->get();*/
		return view('admin.pages.heldup.heldup_list');			
    }
	
	public function all_heldup(Request $request)
    {       
		$columns = array( 
			0 =>'tbl_heldup.id', 
			1 =>'tbl_heldup.emp_id',
			2 =>'tbl_appointment_info.emp_name',
			3 =>'tbl_heldup.sarok_no',
			4 =>'tbl_heldup.letter_date',
			5 =>'tbl_heldup.id',
		);
  
        $totalData = Heldup::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $info = Heldup::join('tbl_appointment_info', 'tbl_heldup.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->offset($start)
							->limit($limit)
							//->orderBy($order,$dir)
							->orderBy('tbl_heldup.letter_date', 'desc')
							->select('tbl_heldup.id','tbl_heldup.emp_id','tbl_heldup.sarok_no','tbl_heldup.letter_date','tbl_heldup.status','tbl_appointment_info.emp_name')
							->get();
        }
        else {
            $search = $request->input('search.value'); 

            $info =  Heldup::join('tbl_appointment_info', 'tbl_heldup.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->where('tbl_heldup.emp_id', $search)
                            ->offset($start)
                            ->limit($limit)
                            //->orderBy($order,$dir)
							->orderBy('tbl_heldup.letter_date', 'desc')
							->select('tbl_heldup.id','tbl_heldup.emp_id','tbl_heldup.sarok_no','tbl_heldup.letter_date','tbl_heldup.status','tbl_appointment_info.emp_name')
                            ->get();

            $totalFiltered = Heldup::join('tbl_appointment_info', 'tbl_heldup.emp_id', '=', 'tbl_appointment_info.emp_id' )
							->where('tbl_heldup.emp_id', $search)
                             ->count();
        }

        $data = array();
        if(!empty($permanents))
        {
            $i=1;
            foreach ($permanents as $v_permanents)
            {
                $nestedData['id'] 			= $i++;
                $nestedData['emp_id'] 		= $v_permanents->emp_id;
                $nestedData['emp_name'] 	= $v_permanents->emp_name;
                $nestedData['sarok_no'] 	= $v_permanents->sarok_no;
                $nestedData['letter_date'] 	= $v_permanents->letter_date;
				$nestedData['effect_date'] 	= $v_permanents->effect_date;
				$nestedData['status'] 		= $v_permanents->status;
				$nestedData['options'] 		= '<a class="btn btn-sm btn-danger btn-xs" title="Edit" href="permanent/'.$v_permanents->id.'/edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';				
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
		$data = array();
		$data['action'] 				= '/heldup';
		$data['method'] 				= 'post';
		$data['method_field'] 			= '';
		$data['id'] 					= '';
		$data['emp_id'] 				= '';
		//
		$data['letter_date'] = date('Y-m-d');  $data['sarok_no'] 	= 0;  $data['br_code'] 			 = '';	$data['designation_code'] = '';
		$data['what_heldup'] = '';			   $data['heldup_time'] = ''; $data['heldup_until_date'] = '';  $data['heldup_cause'] 	  = '';
		$data['status'] 	 = 1;
		//
		$data['emp_name'] 	 = '';  $data['joining_date'] = '';  $data['designation_name'] = '';  $data['branch_name'] = '';
		$data['Heading'] 	 = 'Add Heldup';
		$data['button_text'] = 'Save';
		//
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		return view('admin.pages.heldup.heldup_form',$data);	

    }


	public function store(Request $request)
    {
		$data = request()->except(['_token','_method']);

		$sarok_id = DB::table('tbl_sarok')->max('sarok_no');
		$data['sarok_no'] 		   		= $sarok_id+1;
		$data['created_by'] 	   		= Session::get('admin_id');
		$data['org_code'] 		   		= Session::get('admin_org_code');
		//insert for Sarok Data//
		$sarok_data['sarok_no']    		= $data['sarok_no'];
		$sarok_data['emp_id'] 	   		= $request->input('emp_id');
		$sarok_data['letter_date'] 		= $request->input('letter_date');
		$sarok_data['transection_type'] = 7;
		
		//FOR MASTER Table
			/*-------------*/
		//
		//Data Insert in heldup Table
	
		$status = DB::table('tbl_heldup')->insertGetId($data);
		if($status)
		{	//Data Insert in Sarok Table
            DB::table('tbl_sarok')->insert($sarok_data);
			//Data Insert in Master Table
			//DB::table('tbl_master_tran')->insert($master_data);
			Session::put('message','Data Saved Successfully');
            return Redirect::to('/heldup');			
		}
		else
		{
			Session::put('message','Error: Unable to Save Data');
		}
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
		$heldup_info = DB::table('tbl_heldup')->where('id', $id)->first();
		$emp_id 					= $heldup_info->emp_id;
		$data['letter_date'] 		= $heldup_info->letter_date;
		$data['sarok_no'] 			= $heldup_info->sarok_no;
		$data['br_code'] 			= $heldup_info->br_code;
		$data['designation_code'] 	= $heldup_info->designation_code;
		$data['what_heldup'] 		= $heldup_info->what_heldup;
		$data['heldup_time'] 		= $heldup_info->heldup_time;
		$data['heldup_until_date'] 	= $heldup_info->heldup_until_date;
		$data['heldup_cause'] 		= $heldup_info->heldup_cause;
		$data['button_text'] 		= 'Update';
		//print_r ($training_info);
		$employee_info = DB::table('tbl_appointment_info')
						->leftJoin('tbl_designation', 'tbl_designation.id', '=', 'tbl_appointment_info.emp_designation')
						->leftJoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_appointment_info.joining_branch')
						->where('tbl_appointment_info.emp_id', $emp_id)
						->first();
		$data['action'] 				= '/heldup/'.$id;
		$data['method'] 				= 'post';
		$data['method_field'] 			= '<input name="_method" value="PATCH" type="hidden">';
		$data['id'] 					= $id;
		$data['emp_id'] 				= $employee_info->emp_id;		
		$data['emp_name'] 				= $employee_info->emp_name;
		$data['joining_date'] 			= $employee_info->joining_date;
		$data['designation_name'] 		= $employee_info->designation_name;
		$data['branch_name'] 			= $employee_info->branch_name;
		//
		$data['branches'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		return view('admin.pages.heldup.heldup_form',$data);	
    }
	
    public function show($id)
    {
        $data['heldup_info'] = DB::table('tbl_heldup')
						->leftJoin('tbl_emp_basic_info', 'tbl_emp_basic_info.emp_id', '=', 'tbl_heldup.emp_id')
						->leftJoin('tbl_designation', 'tbl_designation.id', '=', 'tbl_heldup.designation_code')
						->leftJoin('tbl_branch', 'tbl_branch.br_code', '=', 'tbl_heldup.br_code')
						->where('tbl_heldup.id', $id)
						->select('tbl_heldup.emp_id','tbl_heldup.letter_date','tbl_heldup.what_heldup','tbl_heldup.heldup_time','tbl_heldup.heldup_until_date','tbl_heldup.heldup_cause','tbl_emp_basic_info.emp_name_eng','tbl_designation.designation_name','tbl_branch.branch_name')
						->first();
		//print_r ($data['heldup_info']);
		return view('admin.pages.heldup.heldup_view',$data);
    }
	
	public function update(Request $request, $id)
    {
        $data = request()->except(['_token', '_method']);
		$data['updated_by'] = Session::get('admin_id');
		//print_r ($data); exit;
		$status = Heldup::where('id', $id)->update($data); // its working
		return redirect('heldup');
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

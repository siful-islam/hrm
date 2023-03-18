<?php

namespace App\Http\Controllers;
use App\Models\Cvs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
    public function index()
    {
        $data = array();
		
		/*$data['all_emp_list'] = DB::table('tbl_emp_basic_info as e')
								->leftJoin('tbl_district as d', 'e.district_code', '=', 'd.district_code')
								->leftJoin('tbl_thana as t', 'e.thana_code', '=', 't.thana_code')
								->orderBy('e.emp_id', 'DESC')
								->get();
								
								
		*/						
								
								
					
								
		//print_r ($data['all_emp_list']);
		return view('admin.pages.employee.employee_list',$data);
    }
		
	
	
	public function all_cv(Request $request)
    {       
		$columns = array( 
			0 =>'id', 
			1 =>'emp_id',
			2=> 'emp_name_eng',
			3=> 'org_join_date',
			4=> 'contact_num',
			5=> 'national_id',
			6=> 'thana_name',
			7=> 'district_name',
			8 =>'id', 
		);
  
        $totalData = Cvs::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Cvs::leftJoin('tbl_district as d', 'tbl_emp_basic_info.district_code', '=', 'd.district_code')
							->leftJoin('tbl_thana as t', 'tbl_emp_basic_info.thana_code', '=', 't.thana_code')
							->offset($start)
							->limit($limit)
							->orderBy('tbl_emp_basic_info.id', 'DESC')
							->get();
        }
        else {
            $search = $request->input('search.value'); 
            $infos =  Cvs::leftJoin('tbl_district as d', 'tbl_emp_basic_info.district_code', '=', 'd.district_code')
						->leftJoin('tbl_thana as t', 'tbl_emp_basic_info.thana_code', '=', 't.thana_code')
						->where('tbl_emp_basic_info.emp_id',$search)
						->offset($start)
						->limit($limit)							
						//->orderBy($order,$dir)
						->orderBy('tbl_emp_basic_info.emp_id', 'DESC')
						->get();
            $totalFiltered = Cvs::where('tbl_emp_basic_info.emp_id',$search)
                             ->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['id'] 				= $i++;
                $nestedData['emp_id'] 			= $info->emp_id;
                $nestedData['emp_name_eng'] 	= $info->emp_name_eng;
                $nestedData['org_join_date'] 	= $info->org_join_date;
				$nestedData['contact_num'] 		= $info->contact_num;
				$nestedData['national_id'] 		= $info->national_id;
                $nestedData['thana_name'] 		= $info->thana_name;             
                $nestedData['district_name'] 	= $info->district_name;             
				$nestedData['options'] 			= '<a class="btn btn-sm btn-primary btn-xs" title="View" href="emp-cv/'.$info->emp_id.'"><i class="fa fa-eye"></i></a>
				<a class="btn btn-sm btn-success btn-xs" title="Edit" href="emp-general/'.$info->emp_id.'/1"><i class="glyphicon glyphicon-pencil"></i></a>
				';				
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$emp_cv_basic=DB::table('tbl_emp_basic_info')
                                    ->where('emp_id',$id)
									->first();
							
		$emp_cv_edu=DB::table('tbl_emp_edu_info as ed')
                                    ->leftJoin('tbl_exam_name as en', 'ed.exam_code', '=', 'en.exam_code')
                                    ->leftJoin('tbl_board_university as bu', 'ed.school_code', '=', 'bu.board_uni_code')
                                    ->leftJoin('tbl_subject as sb', 'ed.subject_code', '=', 'sb.subject_code')
									->where('ed.emp_id',$id)
									->orderBy('en.level_id', 'ASC')
									->get();
		//print_r ($emp_cv_basic);
		$emp_cv_tra=DB::table('tbl_emp_train_info')
                                    ->where('emp_id',$id)
									->get();
									
		$emp_cv_exp=DB::table('tbl_emp_exp_info')
                                    ->where('emp_id',$id)
									->get();
									
		$emp_cv_ref=DB::table('tbl_emp_ref_info')
                                    ->where('emp_id',$id)
									->get();
									
		$emp_cv_photo=DB::table('tbl_emp_photo')
                                    ->where('emp_id',$id)
									->first();
		//print_r ($emp_cv_photo);							
		$emp_cv_view=view('admin.pages.employee.emp_cv_view')
						->with('emp_cv_basic',$emp_cv_basic)
						->with('emp_cv_edu',$emp_cv_edu)
						->with('emp_cv_tra',$emp_cv_tra)
						->with('emp_cv_exp',$emp_cv_exp)
						->with('emp_cv_ref',$emp_cv_ref)
						->with('emp_cv_photo',$emp_cv_photo);
		
        return view('admin.admin_master')
                            ->with('main_content',$emp_cv_view);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

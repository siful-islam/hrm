<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Training;
use DB;
use Session;

class TrainingController extends Controller
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
		/* $all_training 	= DB::table('tbl_employee_training')->where('tr_date_from','2018-09-11')->where('tr_date_to','2018-09-12')->get();
		//print_r ($all_training);
		foreach ($all_training as $post_data) {
			$data['training_detail_id']   	= 11;
			$data['training_no']   	= 11;
			$data['emp_id']   	= $post_data->emp_id;
			$data['br_code']   	= $post_data->br_code;
			$data['designation_code']   	= $post_data->designation_code;
			$data['tr_result']   	= $post_data->tr_result;
			//DB::table('tbl_emp_training_result')->insert($data);
		} */

		$data['training_info'] = DB::table('tbl_emp_training_detail')->orderBy('tr_date_from','DESC')->get();
		return view('admin.pages.training.training_list',$data);
    }
	
	public function get_employee_info($emp_id)
	{
		$data = array();
		$emp_id = $emp_id;
		$letter_date = date('Y-m-d');
		$max_sarok = DB::table('tbl_master_tra as m')
						->where('m.emp_id', '=', $emp_id)
						->where('m.letter_date', '=', function($query) use ($emp_id,$letter_date)
								{
									$query->select(DB::raw('max(letter_date)'))
										  ->from('tbl_master_tra')
										  ->where('emp_id',$emp_id)
										  ->where('letter_date', '<=', $letter_date);
								})
						->select('m.emp_id',DB::raw('max(m.sarok_no) as sarok_no'))
						->groupBy('emp_id')
						->first();	
		//echo $max_id;		
		if($max_sarok !=NULL) {
			$employee_info = DB::table('tbl_master_tra as m')
						->Leftjoin('tbl_emp_basic_info as e', 'm.emp_id', '=', 'e.emp_id')
						->where('m.sarok_no', $max_sarok->sarok_no)
						->select('m.emp_id','m.designation_code','m.br_code','e.emp_name_eng') 
						->first();	

			$data['emp_id'] 				= $emp_id;
			$data['emp_name'] 				= $employee_info->emp_name_eng;
			$data['designation_code'] 		= $employee_info->designation_code;
			$data['br_code'] 				= $employee_info->br_code;
			$data['error'] 					= '';
		
		} else {
			$data['error'] 					= 1;
		}

		return $data;
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
		$data['action'] 				= '/training';
		$data['method'] 				= 'post';
		$data['method_field'] 			= '';
		//
		$data['emp_id']		= '';	$data['br_code']   = '';  $data['designation_code']	= '';	$data['tr_date_from']	= date('Y-m-d');
		$data['tr_date_to']	= '';	$data['tr_venue']  = '';  $data['tr_result'] 		= '';	$data['tr_venue_other'] = '';
		$data['emp_name'] 	 = '';	$data['designation_name']	= '';	$data['joining_date'] 	= '';	$data['branch_name'] = '';	
		$data['training_name'] 	 = '';	$data['institute_name']	= '';	$data['training_detail_id']	= '';	
		$data['button_text'] = 'Save';
		//
		$max_training_no = DB::table('tbl_emp_training_detail')->max('training_no');
		//print_r ($max_training_no);exit;								
		if (empty($max_training_no)) {
			$data['max_tra_no'] = 1;
		} else {
			$data['max_tra_no'] = $max_training_no+1;
		}
		$data['training_data'] = array();
		//print_r ($data['training_data']);
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		
		return view('admin.pages.training.training_form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* public function store(Request $request)
    {
        $data = request()->except(['_token']);
		$data['created_by'] = Session::get('admin_id');
        //print_r ($data); exit;
		Training::create($data);

        return redirect('training');
    } */
	
	public function store(Request $request)
    {
		
		$exist_array = array();
		//$postvalue = unserialize($request->val_id);
		//print_r($postvalue);
		/* $training_name = $request->training_name;
		$institute_name = $request->institute_name;
		$tr_date_from = $request->tr_date_from;
		$tr_date_to = $request->tr_date_to;
		$tr_venue = $request->tr_venue; */
		$training_data = $request->training;
		$training_no = $request->training_no;
		$data = request()->except(['_token','training','val_id','training_detail_id']);
		$data['created_by'] 	= Session::get('admin_id');
		//print_r ($data); exit;
		//print_r ($training_data); exit;
		if (!empty($training_data)) {
			DB::beginTransaction();
			try {
				$last_insert_id = DB::table('tbl_emp_training_detail')->insertGetId($data);			
				//echo $last_insert_id; exit;
				foreach ($training_data as $post_data) {
					$result_data['training_detail_id']   	= $last_insert_id;
					$result_data['training_no']   	= $training_no;
					$result_data['emp_id']   	= $post_data['emp_id'];
					$result_data['br_code']   	= $post_data['br_code'];
					$result_data['designation_code']   	= $post_data['designation_code'];
					$result_data['tr_result']   	= $post_data['tr_result'];
					$result_data['created_by'] = Session::get('admin_id');
					DB::table('tbl_emp_training_result')->insert($result_data);
				}
				DB::commit();
				//PUSH SUCCESS MESSAGE
				Session::put('message','Data Saved Successfully');
			} catch (\Exception $e) {
				//PUSH FAIL MESSAGE
				Session::put('message','Error: Unable to Save Data');
				//DB ROLLBACK
				DB::rollback();
			}
		}

		//Session::put('message','Data Saved Successfully');
		//return back()->withInput();
		return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
		$training_info = DB::table('tbl_emp_training_detail')->where('training_no', $id)->first();
		//print_r ($training_info); exit;
		$data['max_tra_no'] 		= $training_info->training_no;
		$data['training_name'] 	= $training_info->training_name;
		$data['institute_name'] 		= $training_info->institute_name;
		$data['tr_date_from'] 		= $training_info->tr_date_from;
		$data['tr_date_to'] 		= $training_info->tr_date_to;
		$data['tr_venue'] 			= $training_info->tr_venue;
		$data['tr_venue_other'] 	= $training_info->tr_venue_other;
		$data['button_text'] 		= 'Update';
		//print_r ($training_info);
		$data['training_data'] = DB::table('tbl_emp_training_result as et')
                                    ->Leftjoin('tbl_emp_basic_info as e', 'et.emp_id', '=', 'e.emp_id')
									->where('et.training_no',$id)
									->select('et.*','e.emp_name_eng')
									->get();
		
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		//$data['all_designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.training.training_view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
		$training_info = DB::table('tbl_emp_training_detail')->where('training_no', $id)->first();
		//print_r ($training_info); exit;
		$data['max_tra_no'] 		= $training_info->training_no;
		$data['training_name'] 		= $training_info->training_name;
		$data['institute_name'] 	= $training_info->institute_name;
		$data['tr_date_from'] 		= $training_info->tr_date_from;
		$data['tr_date_to'] 		= $training_info->tr_date_to;
		$data['tr_venue'] 			= $training_info->tr_venue;
		$data['tr_venue_other'] 	= $training_info->tr_venue_other;
		$data['button_text'] 		= 'Update';
		//print_r ($training_info);
		$data['training_data'] = DB::table('tbl_emp_training_result as et')
                                    ->Leftjoin('tbl_emp_basic_info as e', 'et.emp_id', '=', 'e.emp_id')
									->where('et.training_no',$id)
									->select('et.*','e.emp_name_eng')
									->get();
		$data['action'] 				= '/training/'.$id;
		$data['method'] 				= 'post';
		$data['method_field'] 			= '<input name="_method" value="PATCH" type="hidden">';
		
		//
		$data['all_branch'] 		    	= DB::table('tbl_branch')->where('status',1)->get();
		//$data['all_designation'] 		    = DB::table('tbl_designation')->where('status',1)->get();
		$data['all_designation'] 		    = DB::table('tbl_designation')->get();
		return view('admin.pages.training.training_form',$data);
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
        /* $data = request()->except(['_token', '_method']);
		$data['updated_by'] = Session::get('admin_id');
		print_r ($data); exit; */
		/* $status = Training::where('id', $id)->update($data); // its working
		return redirect('training'); */
		$exist_array = array();
		$training_data = $request->training;
		$training_detail_id = $request->training_detail_id;
		$postvalue = unserialize($request->val_id);
		//print_r($postvalue); exit;
		$data = request()->except(['_token','_method','training','val_id','training_detail_id']);
		$data['created_by'] 	= Session::get('admin_id');
		//print_r ($data); exit;
		//print_r ($training_data); exit;
		if (!empty($training_data)) {
			$status = DB::table('tbl_emp_training_detail')->where('training_no', $id)->update($data);			
			foreach ($training_data as $post_data) {
				if (!empty($post_data['id'])) {			 
					$exist_array[]=$post_data['id'];
					$id   	= $post_data['id'];
					$post_data['training_no']   	= $data['training_no'];
					$post_data['training_detail_id']   	= $training_detail_id;
					$post_data['emp_id']   	= $post_data['emp_id'];
					$post_data['br_code']   	= $post_data['br_code'];
					$post_data['designation_code']   	= $post_data['designation_code'];
					$post_data['tr_result']   	= $post_data['tr_result'];					
					$post_data['updated_by'] = Session::get('admin_id');
				//print_r ($data);exit;	
				DB::table('tbl_emp_training_result')
							->where('id',$id)
							->update($post_data);
				} else {
					$post_data['training_no']   	= $data['training_no'];
					$post_data['training_detail_id']   	= $training_detail_id;
					$post_data['emp_id']   	= $post_data['emp_id'];
					$post_data['br_code']   	= $post_data['br_code'];
					$post_data['designation_code']   	= $post_data['designation_code'];
					$post_data['tr_result']   	= $post_data['tr_result'];
					$post_data['created_by'] = Session::get('admin_id');
					
				DB::table('tbl_emp_training_result')->insert($post_data);
				}
			}
			//print_r ($exist_array); exit;
			$delete_data = array_diff($postvalue,$exist_array);
			foreach($delete_data as $del_data) {

				DB::table('tbl_emp_training_result')
				->where('id',$del_data)
				->delete();
			}
		}
		return redirect('training');
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use PDF;

class GeneralGoverningController extends Controller
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
        $data['result_info'] = DB::table('tbl_board_member as gm')
							->orderBy('gm.designation', 'ASC')
							->get();
		return view('admin.pages.board_view.general_governing_list',$data);	
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
		$data['action'] 				= '/board-member';
		$data['method'] 				= 'post';
		$data['method_field'] 			= '';
		$data['all_exam'] = DB::table('tbl_exam_name')->where('status',1)->get();
		$data['all_board_no'] = DB::table('tbl_board_no_config')->orderBy('id', 'DESC')->get();
		
		$data['body_name'] = ''; $data['board_serial_no'] = ''; $data['name_eng'] = ''; $data['name_ban'] = ''; $data['fathers_name_eng'] = '';
		$data['fathers_name_ban'] = '';	$data['mothers_name_eng'] = '';	$data['mothers_name_ban'] = '';	$data['spouse_name_eng'] = '';
		$data['spouse_name_ban'] = ''; $data['permanent_address'] = '';	$data['present_address'] = ''; $data['profession'] = '';
		$data['education'] = ''; $data['birth_date'] = ''; $data['mobile_phone'] = ''; $data['national_id'] = '';
		$data['tin_no'] = ''; $data['nationality'] = ''; $data['photo'] = ''; $data['designation_code'] = ''; $data['effect_date'] = '';	
		$data['close_date'] = ''; $data['email'] = ''; $data['agm_serial_no'] = ''; $data['agm_date'] = ''; $data['remarks'] = '';	
		$data['political_involve'] = ''; $data['relation_other_member'] = ''; $data['pre_exp_social_work'] = '';	$data['status'] = '';
		return view('admin.pages.board_view.general_governing_form',$data);
    }
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$data = request()->except(['_token','_method','emp_photo']);
		//print_r ($data); exit;
		/* $this->validate($request, [
			'emp_id' => 'required|unique:tbl_emp_basic_info',
		]); */
		$data['board_serial_no'] = !empty($data['board_serial_no']) ? $data['board_serial_no'] : 1;
		$data['created_by'] = Session::get('admin_id');
		//print_r ($data); exit;
		$last_insert_id = DB::table('tbl_board_member')->insertGetId($data);
		/////////////////
		$image = $request->file('emp_photo'); 
		
		if($image){
			$ext = strtolower($image->getClientOriginalExtension());
			$image_name = $last_insert_id.'.'.$ext;
			$dataa['photo'] = $image_name;
			/* echo '<pre>';
			print_r($image_name);
			exit; */
			$upload_path ='public/board_member/';
			$success = $image->move($upload_path,$image_name);
			if($success) {
			DB::table('tbl_board_member')->where('id', $last_insert_id)->update($dataa);
			}
		}
		
		////////////////
		
		Session::flash('message1','Data Save Successfully');
		return Redirect::to("/board-member");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$data['result_info'] = DB::table('tbl_board_member as gm')
							->leftJoin('tbl_designation as d', 'gm.designation', '=', 'd.designation_code')
							->leftJoin('tbl_exam_name as ex', 'gm.education', '=', 'ex.exam_code')
							->where('gm.id',$id)
							->orderBy('gm.id', 'DESC')
							->select('gm.*','d.designation_name','ex.exam_name')
							->first();
									
		return view('admin.pages.board_view.general_governing_view',$data);
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
		$data['action'] 				= '/board-member/'.$id;
		$data['method'] 				= 'post';
		$data['method_field'] 			= '<input name="_method" value="PATCH" type="hidden">';
		$data['id'] 					= $id;
		
		$result_info = DB::table('tbl_board_member as gm')
							->leftJoin('tbl_designation as d', 'gm.designation', '=', 'd.designation_code')
							->where('gm.id',$id)
							->orderBy('gm.id', 'DESC')
							->select('gm.*','d.designation_name')
							->first();
		$data['body_name'] = $result_info->body_name;	
		$data['board_serial_no'] = $result_info->board_serial_no;	
		$data['name_eng'] = $result_info->name_eng;	
		$data['name_ban'] = $result_info->name_ban;	
		$data['fathers_name_eng'] = $result_info->fathers_name_eng;	
		$data['fathers_name_ban'] = $result_info->fathers_name_ban;	
		$data['mothers_name_eng'] = $result_info->mothers_name_eng;	
		$data['mothers_name_ban'] = $result_info->mothers_name_ban;	
		$data['spouse_name_eng'] = $result_info->spouse_name_eng;	
		$data['spouse_name_ban'] = $result_info->spouse_name_ban;	
		$data['permanent_address'] = $result_info->permanent_address;	
		$data['present_address'] = $result_info->present_address;	
		$data['profession'] = $result_info->profession;	
		$data['education'] = $result_info->education;	
		$data['birth_date'] = $result_info->birth_date;	
		$data['mobile_phone'] = $result_info->mobile_phone;	
		$data['national_id'] = $result_info->national_id;	
		$data['tin_no'] = $result_info->tin_no;	
		$data['nationality'] = $result_info->nationality;	
		$data['photo'] = $result_info->photo;	
		$data['designation_code'] = $result_info->designation;	
		$data['effect_date'] = $result_info->effect_date;	
		$data['close_date'] = $result_info->close_date;	
		$data['email'] = $result_info->email;	
		$data['agm_serial_no'] = $result_info->agm_serial_no;	
		$data['agm_date'] = $result_info->agm_date;	
		$data['remarks'] = $result_info->remarks;	
		$data['political_involve'] = $result_info->political_involve;	
		$data['relation_other_member'] = $result_info->relation_other_member;	
		$data['pre_exp_social_work'] = $result_info->pre_exp_social_work;	
		$data['status'] = $result_info->status;	
		
		$data['all_board_no'] = DB::table('tbl_board_no_config')->orderBy('id', 'DESC')->get();
		$data['all_exam'] = DB::table('tbl_exam_name')->where('status',1)->get();
		
		return view('admin.pages.board_view.general_governing_form',$data);
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
        $data = request()->except(['_token','_method','emp_photo']);
		$data['board_serial_no'] = !empty($data['board_serial_no']) ? $data['board_serial_no'] : 1;
		$data['updated_by'] = Session::get('admin_id');
		//print_r($data); exit;
		$image = $request->file('emp_photo'); 
		
		if($image){
			$ext = strtolower($image->getClientOriginalExtension());
			$image_name = $id.'.'.$ext;
			$dataa['photo'] = $image_name;
			/* echo '<pre>';
			print_r($image_name);
			exit; */
			$upload_path ='public/board_member/';  
			//$image_url = $upload_path.$image_name;
			$image_url = $image_name;
			
			$result=DB::table('tbl_board_member')->where('id',$id)->value('photo');
			if (!empty($result)) {
				$unlink_path = $_SERVER['DOCUMENT_ROOT'].'/hrm/'.$upload_path.$result;
				//print_r ($unlink_path); exit;
				if(is_readable($unlink_path))
				{
					unlink($unlink_path);
				}
				$success = $image->move($upload_path,$image_name);
				if($success){
					DB::table('tbl_board_member')->where('id', $id)->update($dataa);
				}
			
			} else {
				$success = $image->move($upload_path,$image_name);
				if($success) {
					DB::table('tbl_board_member')->where('id', $id)->update($dataa);
				}
			}
			
		}		
		DB::table('tbl_board_member')->where('id', $id)->update($data);
		Session::put('message','Data Update Successfully');
		return Redirect::to("/board-member");
    }
	
	public function BoardView() 
	{
		$data = array();
		$data['result_info'] = DB::table('tbl_board_member as gm')
							->leftJoin('tbl_designation as d', 'gm.designation', '=', 'd.designation_code')
							->orderBy('gm.id', 'DESC')
							->select('gm.*','d.designation_name')
							->get();
		$data['all_board_no'] = DB::table('tbl_board_no_config')->orderBy('id', 'DESC')->get();					
		return view('admin.pages.board_view.board_view',$data);
	}
	
	public function BoardViews($id, $board_no, $status) 
	{
		//echo $id.'-'.$board_no.'-'.$status;
		$data = array();
		$data['result'] = array();
		$result_info = DB::table('tbl_board_member as gm')
							->where(function($query) use ($id, $board_no, $status) {
								if($id ==1) {
									$query->where('gm.body_name', '=', 1);
									if($status != 'all') {
									$query->where('gm.status', '=', $status);
									}
									//$query->whereIn('gm.body_name', array(1, 2));
								} else if ($id ==2) {
									$query->where('gm.body_name', '=', 2);
									$query->where('gm.board_serial_no', '=', $board_no);
									if($status != 'all') {
									$query->where('gm.status', '=', $status);
									}
								}
							})
							->orderBy('gm.designation', 'ASC')
							->get();
		if(!empty($result_info)) {
		foreach ($result_info as $result) {
			if($result->designation == 1) {
				$designation_name = 'Chairman';
			} else if ($result->designation == 2) {
				$designation_name = 'Vice Chairman';
			}  else if ($result->designation == 3) {
				$designation_name = 'Secretary';
			}  else if ($result->designation == 4) {
				$designation_name = 'Member';
			} 
			$data['result'][] = array(
				'id' => $result->id,
				'name_eng' => $result->name_eng,
				'permanent_address' => $result->permanent_address,
				'nationality' => $result->nationality == 1 ? "Bangladeshi" : "Others",
				'designation_name' => $designation_name,
				'remarks' => $result->remarks .' (AGM Held on '. $result->agm_serial_no .' '.date('d/m/Y', strtotime($result->agm_date)).')',
				'status' => $result->status == 1 ? "Active" : "Inactive",
			);
		}
		//return $data['result'];
		} //else {
			//return 0;
		//}
					
		return json_encode(array('data'=>$data['result']));
		
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

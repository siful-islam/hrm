<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class IncrementLetterConfigController extends Controller
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
      //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
		$data['action'] 		= '/incre-letter-config';
		$data['Heading'] 		= 'Add';
		$increment_letter_info 	= DB::table('tbl_increment_letter')->first();
		$data['id'] 			= $increment_letter_info->id;
		$data['letter_heading'] = $increment_letter_info->letter_heading;
		$data['letter_body_1'] 	= $increment_letter_info->letter_body_1;
		$data['letter_body_2'] 	= $increment_letter_info->letter_body_2;
		$data['letter_body_3'] 	= $increment_letter_info->letter_body_3;		
		
		return view('admin.pages.increment_letter.increment_letter_config_form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->except(['_token']);
		//$data['created_by'] = Session::get('admin_id');
        //print_r ($data); exit;

		//DB::table('tbl_increment_letter_body')->insert($data);
		DB::table('tbl_increment_letter')
							->where('id',$data['id'])
							->update($data);

        return redirect('incre-letter-config/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
		$data['Heading'] 		= 'Add';
		$data['status'] 		= 1;
		$data['action'] 		= '/incre-letter-config';
		$increment_letter_info 	= DB::table('tbl_increment_letter')->where('id', $id)->first();
		$data['id'] 			= $increment_letter_info->id;
		$data['letter_heading'] = $increment_letter_info->letter_heading;
		$data['letter_body_1'] 	= $increment_letter_info->letter_body_1;
		$data['letter_body_2'] 	= $increment_letter_info->letter_body_2;
		$data['letter_body_3'] 	= $increment_letter_info->letter_body_3;
		
		return view('admin.pages.increment_letter.increment_letter_config_form',$data);
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

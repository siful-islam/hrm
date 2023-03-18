<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class FunctionalDesignationController extends Controller
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['all_result'] = DB::table('tbl_functional_designation')->get();
		return view('admin.pages.functional_designation.functional_designation_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['fun_deg_name'] = '';
        $data['fun_deg_name_ban'] = '';
        $data['status'] = '';
		$data['action'] = '/functional-designation';
		$data['method_field'] = '';
		return view('admin.pages.functional_designation.functional_designation_form', $data);
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
		$data['created_by'] = Session::get('admin_id');
		DB::table('tbl_functional_designation')->insert($data);
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/functional-designation');
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
        $ext_info = DB::table('tbl_functional_designation')->where('id', $id)->first();
		$data['fun_deg_name'] = $ext_info->fun_deg_name;
		$data['fun_deg_name_ban'] = $ext_info->fun_deg_name_ban;
		$data['status'] = $ext_info->status;
		$data['action'] = '/functional-designation/'.$id;
		$data['method_field'] = '<input name="_method" value="PATCH" type="hidden">';
		return view('admin.pages.functional_designation.functional_designation_form', $data);
    }
	
	public function update($id, Request $request)
    {
		$data = $request->only(['fun_deg_name', 'fun_deg_name_ban', 'status']); // its working
		//$data = request()->except(['_token', '_method']); // its working
		DB::table('tbl_functional_designation')->where('id', $id)->update($data);
		Session::put('message','Data Update Successfully');
		return redirect('functional-designation');

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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class ExtraDeducTypeController extends Controller
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
        $data['all_result'] = DB::table('tbl_ext_deduc_config')->get();
		return view('admin.pages.extra_deduction.extra_deduc_type_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['type_name'] = '';
        $data['status'] = '';
		$data['action'] = '/extra_deduc_type';
		$data['method_field'] = '';
		return view('admin.pages.extra_deduction.extra_deduc_type_form', $data);
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
		DB::table('tbl_ext_deduc_config')->insert($data);
		Session::put('message','Data Saved Successfully');
		return Redirect::to('/extra_deduc_type');
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
        $ext_info = DB::table('tbl_ext_deduc_config')->where('id', $id)->first();
		$data['type_name'] = $ext_info->type_name;
		$data['status'] = $ext_info->status;
		$data['action'] = '/extra_deduc_type/'.$id;
		$data['method_field'] = '<input name="_method" value="PATCH" type="hidden">';
		return view('admin.pages.extra_deduction.extra_deduc_type_form', $data);
    }
	
	public function update($id, Request $request)
    {
		$data = $request->only(['type_name', 'status']); // its working
		//$data = request()->except(['_token', '_method']); // its working
		DB::table('tbl_ext_deduc_config')->where('id', $id)->update($data);
		Session::put('message','Data Update Successfully');
		return redirect('extra_deduc_type');

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

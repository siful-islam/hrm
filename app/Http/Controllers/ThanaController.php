<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\District;
use App\Models\Thana;
use DB;

class ThanaController extends Controller
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
       /*  $all_thana= Thana::get();
		//print_r ($all_thana);
		return view('admin.district_thana.thana_list', get_defined_vars()); */
		
		//$all_thana= Thana::get();
		
		$all_thana=Thana::join('tbl_district', 'tbl_thana.district_code', '=', 'tbl_district.district_code')
					->select('tbl_thana.id','tbl_thana.thana_code','tbl_thana.thana_name','tbl_thana.status','tbl_district.district_name')
					->get();
		//print_r ($all_thana);							
        return view('admin.pages.district_thana.thana_list', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['all_district']= District::all();
		//print_r ($all_district);
		$data['district_code'] = '';
		$data['thana_name'] = '';
		$data['thana_bangla'] = '';
		$data['status'] = '';
		$data['action'] = '/thana';
		$data['method_field'] = '';
		return view('admin.pages.district_thana.thana_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$data= $request->all();
		$data = request()->except(['_token']);
		$thana_code = Thana::max('thana_code');
		$data['thana_code'] = $thana_code+1;
		$data['org_code'] = 181;
        //print_r ($data); exit;
		Thana::create($data);

        return redirect('thana');
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
        //$thana = Thana::find($id);
		$thana = DB::table('tbl_thana')->where('thana_code', $id)->first();
		$data['all_district']= District::all();
		$data['thana_name'] = $thana->thana_name;
		$data['thana_bangla'] = $thana->thana_bangla;
		$data['district_code'] = $thana->district_code;
		$data['status'] = $thana->status;
		$data['action'] = '/thana/'.$id;
		$data['method_field'] = '<input name="_method" value="PATCH" type="hidden">';
		return view('admin.pages.district_thana.thana_form', $data);
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
        //$data = $request->all();
		$data = $request->only(['district_code', 'thana_name', 'thana_bangla', 'status']); // its working
		//print_r ($data); exit;
		//$data = request()->except(['_token', '_method']); // its working
		Thana::where('thana_code', $id)->update($data); // its working
		return redirect('thana');
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

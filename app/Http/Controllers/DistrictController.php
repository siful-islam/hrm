<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\District;

class DistrictController extends Controller
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
        $all_district= District::get();
		//print_r ($all_district);
		return view('admin.pages.district_thana.district_list', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['district_name'] = '';
        $data['status'] = '';
		$data['action'] = '/district';
		$data['method_field'] = '';
		return view('admin.pages.district_thana.district_form', $data);
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
		$data['district_code'] = 64;
		$data['org_code'] = 181;
		//print_r ($data); exit;
		District::create($data);

        return redirect('district');
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
        $district = District::find($id);
		$data['district_name'] = $district->district_name;
		$data['status'] = $district->status;
		$data['action'] = '/district/'.$id;
		$data['method_field'] = '<input name="_method" value="PATCH" type="hidden">';
		return view('admin.pages.district_thana.district_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	/* Its Working for Update */
    /* public function update(District $district, Request $request)
    {

		$district->update($request->all());
		return redirect('district');

    } */
	
	public function update($id, Request $request)
    {
        //$data = $request->all();
		$data = $request->only(['district_name', 'status']); // its working
		//$data = request()->except(['_token', '_method']); // its working
		//$district->update($request()->all());
		District::where('id', $id)->update($data); // its working
		return redirect('district');

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

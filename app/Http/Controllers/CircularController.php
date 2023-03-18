<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class CircularController extends Controller
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
        $data['circular_info'] = DB::table('tbl_recruitment_circular')->get();
		return view('admin.pages.recruitment.circular_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CircularAdd()
    {
        $data['circular_name'] = '';
        $data['start_date'] = '';
        $data['end_date'] = '';
        $data['status'] = '';
		$data['action'] = '/circular-store';
		return view('admin.pages.recruitment.circular_form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CircularStore(Request $request)
    {
		$data = request()->except(['_token']);
		//print_r ($data); exit;
		DB::table('tbl_recruitment_circular')->insert($data);

        return redirect('circular');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function CircularEdit($id)
    {
        $result_data = DB::table('tbl_recruitment_circular')->where('id', $id)->first();
		$data['circular_name'] = $result_data->circular_name;
		$data['start_date'] = $result_data->start_date;
		$data['end_date'] = $result_data->end_date;
		$data['status'] = $result_data->status;
		$data['action'] = '/update-circular/'.$id;
		return view('admin.pages.recruitment.circular_form',$data);
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
	
	public function CircularUpdate(Request $request, $id)
    {
        $data = request()->except(['_token']);
		//print_r ($data); exit;
		DB::table('tbl_recruitment_circular')
				->where('id', $id)
				->update($data);
		return redirect('circular');

    }
	
	public function IndexPost()
    {
        $data['post_info'] = DB::table('tbl_recruit_circular_post as rp')
								->leftJoin('tbl_recruitment_circular as rc', 'rp.circular_id', '=', 'rc.id')
								->select('rp.*','rc.circular_name','rc.start_date')
								->get();
		return view('admin.pages.recruitment.post_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PostAdd()
    {
        $data['all_circular'] = DB::table('tbl_recruitment_circular')->get();
		$data['circular_id'] = '';
        $data['post_name'] = '';
        $data['experience_age'] = '';
        $data['normal_age'] = '';
        $data['status'] = '';
		
		$data['action'] = '/post-store';
		return view('admin.pages.recruitment.post_form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function PostStore(Request $request)
    {
		$data = request()->except(['_token']);
		//print_r ($data); exit;
		DB::table('tbl_recruit_circular_post')->insert($data);

        return redirect('circular-post');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function PostEdit($id)
    {
        $result_data = DB::table('tbl_recruit_circular_post')->where('id', $id)->first();
		$data['all_circular'] = DB::table('tbl_recruitment_circular')->get();
		$data['circular_id'] = $result_data->circular_id;
		$data['post_name'] = $result_data->post_name;
		$data['normal_age'] = $result_data->normal_age;
		$data['experience_age'] = $result_data->experience_age;
		$data['status'] = $result_data->status;
		$data['action'] = '/update-post/'.$id;
		return view('admin.pages.recruitment.post_form',$data);
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
	
	public function PostUpdate(Request $request, $id)
    {
        $data = request()->except(['_token']);
		//print_r ($data); exit;
		DB::table('tbl_recruit_circular_post')
				->where('id', $id)
				->update($data);
		return redirect('circular-post');

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

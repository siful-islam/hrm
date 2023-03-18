<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Exam;
use DB;

class ExamController extends Controller
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
        $all_exam=DB::table('tbl_exam_name as e')
									->leftJoin('tbl_degree_level as d', 'e.level_id', '=', 'd.level_id')
									->get();
		//print_r ($all_exam);
        return view('admin.pages.education.exam_list', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['all_level']= DB::table('tbl_degree_level')->get();
		$data['exam_name'] = '';
		$data['level_id'] = '';
		$data['status'] = '';
		$data['action'] = '/exam';
		$data['method_field'] = '';
		return view('admin.pages.education.exam_form', $data);
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
		$max_exam_code = DB::table('tbl_exam_name')->max('exam_code');
		$data['exam_code'] = $max_exam_code+1;
		$data['org_code'] = 181;
		//print_r($data);exit;
		Exam::create($data);

        return redirect('exam');
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
        $exam = DB::table('tbl_exam_name')->where('exam_code',$id)->first();
		$data['all_level']= DB::table('tbl_degree_level')->get();
		$data['exam_name'] = $exam->exam_name;
		$data['level_id'] = $exam->level_id;
		$data['status'] = $exam->status;
		$data['action'] = '/exam/'.$id;
		$data['method_field'] = '<input name="_method" value="PATCH" type="hidden">';
		return view('admin.pages.education.exam_form', $data);
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
        $data = request()->except(['_token', '_method']); // its working
		//$district->update($request()->all());
		Exam::where('exam_code', $id)->update($data); // its working
		return redirect('exam');
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\GroupSubject;

class GroupSubjectController extends Controller
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
        $all_group_subject = GroupSubject::get();
		return view('admin.pages.education.group_subject_list', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['subject_name'] = '';
        $data['status'] = '';
		$data['action'] = '/group-subject';
		$data['method_field'] = '';
		return view('admin.pages.education.group_subject_form', $data);
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
		$subject_code = GroupSubject::max('subject_code');
		$data['subject_code'] = $subject_code+1;
		$data['org_code'] = 181;
		GroupSubject::create($data);

        return redirect('group-subject');
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
        $group_subject = GroupSubject::find($id);
		$data['subject_name'] = $group_subject->subject_name;
		$data['status'] = $group_subject->status;
		$data['action'] = '/group-subject/'.$id;
		$data['method_field'] = '<input name="_method" value="PATCH" type="hidden">';
		return view('admin.pages.education.group_subject_form', $data);
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
		GroupSubject::where('id', $id)->update($data); // its working
		return redirect('group-subject');
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

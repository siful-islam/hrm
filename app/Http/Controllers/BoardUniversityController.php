<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\BoardUniversity;

class BoardUniversityController extends Controller
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
        $all_board_university= BoardUniversity::get();
		//print_r ($all_board_university);
		return view('admin.pages.education.board_university_list', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['board_uni_name'] = '';
        $data['status'] = '';
		$data['action'] = '/board-university';
		$data['method_field'] = '';
		return view('admin.pages.education.board_university_form', $data);
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
		$board_uni_code = BoardUniversity::max('board_uni_code');
		$data['board_uni_code'] = $board_uni_code+1;
		$data['org_code'] = 181;
        //print_r ($data); exit;
		BoardUniversity::create($data);

        return redirect('board-university');
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
        $board_university = BoardUniversity::find($id);
		$data['board_uni_name'] = $board_university->board_uni_name;
		$data['status'] = $board_university->status;
		$data['action'] = '/board-university/'.$id;
		$data['method_field'] = '<input name="_method" value="PATCH" type="hidden">';
		return view('admin.pages.education.board_university_form', $data);
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
		BoardUniversity::where('id', $id)->update($data); // its working
		return redirect('board-university');
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

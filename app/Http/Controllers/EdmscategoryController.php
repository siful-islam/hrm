<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Edmscategory;

class EdmscategoryController extends Controller
{ 
	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
    public function index()
    {
        $emp_category_list= Edmscategory::get();
		return view('admin.document.emp_category_list', get_defined_vars());
    }
    public function create()
    {
        
        $data['method_control'] = '';
        $data['button'] = 'Save';
        $data['category_name'] = '';
        $data['status'] = 1;
		$data['action'] = '/edms-category';
		return view('admin.document.emp_category_form', $data);
    }
    public function store(Request $request)
    {
		$data = request()->except(['_token']);  
		
		Edmscategory::create($data);

        return redirect('edms-category');
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $category = Edmscategory::find($id);
		$data['category_name'] 	= $category->category_name;
		$data['status'] 		= $category->status;
		$data['button'] 		= 'Update';
		$data['action'] 		= '/edms-category/'.$id;
		$data['method_control'] = '<input name="_method" value="PATCH" type="hidden">';
		return view('admin.document.emp_category_form', $data);
    }
    public function update(Request $request, $id)
    {
        $data = request()->except(['_token', '_method']); // its working
		Edmscategory::where('category_id', $id)->update($data); // its working
		return redirect('edms-category');
    }
}

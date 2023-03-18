<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Edmssubcategory;
use App\Models\Edmscategory;

class EdmssubcategoryController extends Controller
{ 
	 public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
    public function index()
    { 
		$emp_subcategory_list = Edmssubcategory::leftJoin('tbl_edms_category', 'tbl_edms_subcategory.category_id', '=', 'tbl_edms_category.category_id')
            ->select(['*'])->get(); 
		return view('admin.document.emp_subcategory_list', get_defined_vars());
    }
    public function create()
    {
		$data['all_category']	 	= Edmscategory::get();
        $data['method_control'] 	= '';
        $data['button'] 			= 'Save';
        $data['subcategory_name'] 		= '';
        $data['category_id'] 		= '';
        $data['status'] 			= 1;
		$data['action'] 			= '/edms-subcategory';
		return view('admin.document.emp_subcategory_form', $data);
    }
    public function store(Request $request)
    {
		$data = request()->except(['_token']);  
		
		Edmssubcategory::create($data);

        return redirect('edms-subcategory');
    } 
    public function edit($id)
    {
		$data['all_category']	 	= Edmscategory::get();
        $category = Edmssubcategory::find($id);
		$data['subcategory_name'] 	= $category->subcategory_name;
		$data['category_id'] 	= $category->category_id;
		$data['status'] 		= $category->status;
		$data['button'] 		= 'Update';
		$data['action'] 		= '/edms-subcategory/'.$id;
		$data['method_control'] = '<input name="_method" value="PATCH" type="hidden">';
		return view('admin.document.emp_subcategory_form', $data);
    }
    public function update(Request $request, $id)
    {
        $data = request()->except(['_token', '_method']); // its working
		Edmssubcategory::where('subcat_id', $id)->update($data); // its working
		return redirect('edms-subcategory');
    }
}

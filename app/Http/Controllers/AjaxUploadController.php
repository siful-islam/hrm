<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class AjaxuploadController extends Controller
{


    function action(Request $request)
    {
		
		$data =array();
		
		
		/*
		$validation = Validator::make($request->all(), [
		  'attachments' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
		]);
		if($validation->passes())
		{
			$image = $request->file('attachments');
			$new_name = rand() . '.' . $image->getClientOriginalExtension();
			$image->move(public_path('images'), $new_name);
			return response()->json([
			'message'   => 'Image Upload Successfully',
			'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
			'class_name'  => 'alert-success'
			]);
		}
		else
		{
			return response()->json([
				'message'   => $validation->errors()->all(),
				'uploaded_image' => '',
				'class_name'  => 'alert-danger'
			]);
		}
		
		*/
		
		/*
		$id 						= $request->input('id');
		$data['reported_to'] 		= $request->input('reported_to');
		$data['application_date'] 	= $request->input('application_date');
		$data['leave_type'] 		= $request->input('leave_type');
		$data['leave_from'] 		= $request->input('leave_from');
		$data['leave_to'] 			= $request->input('leave_to');
		$data['remarks'] 			= $request->input('remarks');
		$data['attachments'] 		= 'hello.jpg';
		
		
		if($id == '')
		{
			$data['insert_status'] = Leave::insertGetId($data);
		}
		else
		{
			DB::table('leave_application')
						->where('id', $id) 
						->update($data);
			$data['insert_status'] = true;						
		}
		*/
		
		$data['insert_status'] = true;	
		echo json_encode($data);
    }
}
?>
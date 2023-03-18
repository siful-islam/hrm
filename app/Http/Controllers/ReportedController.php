<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
//session_start();

class ReportedController extends Controller 
{
    public function __construct() 
	{
		$this->middleware("CheckUserSession");	
	}
	
	public function index()
	{
		$data =array();
		
		$bosses = DB::table('tbl_designation')	            
							->where('is_reportable', '=', 1)
							->where('use_for_ho_bo', '=', 1)
							->where('status', '=', 1)
							->get();
							
							

		
		foreach($bosses as $boss)
		{
			$id 		= $boss->id;
			$to_reported = $boss->to_reported;
			
			
			$kamlas = DB::table('tbl_designation')	            
							->where('to_reported', '=', $to_reported)
							->where('status', '=', 1)
							->get();
			
		}
		
		
		
		//return view('admin.my_info.my_profile',$data);
		
		
		
		print_r($kamlas);
	}	
	


	

	
	
	
	
	
	
	
	
	
	
	

	
}

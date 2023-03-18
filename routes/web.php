<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

/*
 * Website
 */
 
//Route::get('/spms_edms','ApiController@PerformanceReportStaff');
 
Route::any('/am_abc', 'AdminController@abcd');


Route::any('/attendence', 'AttendenceController@index');

//LOAN APPLICATION
Route::resource('/my_loan','StaffLoanController');
Route::POST('/my_loanss','StaffLoanController@store');
Route::POST('/all_loan_application','StaffLoanController@all_loan_application'); 
Route::POST('/all_loan_application_bellow_bm','StaffLoanController@all_loan_application_bellow_bm');
Route::POST('/all_loan_application_audit','StaffLoanController@all_loan_application_audit');
Route::POST('/all_loan_application_sc','StaffLoanController@all_loan_application_sc');
Route::POST('/all_loan_application_agri','StaffLoanController@all_loan_application_agri');
Route::get('/banks_branch/{bank_id}','StaffLoanController@banks_branch');
Route::get('/loan_product_info/{loan_product_id}','StaffLoanController@loan_product_info');
Route::get('/loan_report/{date_from}/{date_to}','StaffLoanController@loan_report');
Route::get('/loan_test/{date_from}','StaffLoanController@loan_test');
Route::get('/loan-validations/{application_date}/{emp_id}/{loan_type_id}/{loan_amount}/{loan_duration}','StaffLoanController@application_validation');
Route::get('/pending_approval','StaffLoanController@pending_approval');
Route::get('/loan-approval/{loan_app_id}/{action_type}','StaffLoanController@loan_approval');
Route::POST('/loan_recomendation_process','StaffLoanController@loan_recomendation_process');
Route::POST('/loan_approve_process','StaffLoanController@loan_approve_process');
Route::get('/GetBMAMDM/{br_code}','StaffLoanController@GetData');
Route::get('/loan_approval_list','StaffLoanController@loan_approval_list'); // APPROVAL 
Route::get('/loan_disburs_list','StaffLoanController@loan_disburs_list');
Route::get('/hr_recomendation_pf','StaffLoanController@hr_recomendation_pf');
Route::POST('/pf_loan_recomendation_process','StaffLoanController@pf_loan_recomendation_process'); 
Route::get('/bellow_bm_application','StaffLoanController@bellow_bm_application'); 
Route::get('/my_staffs_br/{br_code}','StaffLoanController@my_staffs_br'); 
Route::POST('/loan_save','StaffLoanController@loan_save'); 
Route::get('/emp_info/{emp_id}','StaffLoanController@emp_info'); 
Route::get('/my_info/{br_id}','StaffLoanController@get_emp'); 
Route::get('/get_emp/{br_id}/{type}','StaffLoanController@get_emp'); 
Route::get('/designation_staff/{self_group}','StaffLoanController@designation_staff'); 
Route::get('/designation_staff_zone/{self_group}/{zone_code}','StaffLoanController@designation_staff_zone'); 
Route::get('/acc_pending_application','StaffLoanController@acc_pending_application'); 
Route::POST('/acc_loan_recomendation_process','StaffLoanController@acc_loan_recomendation_process'); 
Route::get('/auditor_application','StaffLoanController@auditor_application'); 
Route::POST('/loan_save_audit','StaffLoanController@loan_save_audit'); 
Route::get('/sc_application','StaffLoanController@sc_application'); 
Route::POST('/loan_save_sc','StaffLoanController@loan_save_sc'); 
Route::get('/sc_recomendation_list','StaffLoanController@sc_recomendation_list'); 
Route::POST('/sc_loan_recomendation_process','StaffLoanController@sc_loan_recomendation_process'); 
// agri  
Route::get('/agri_application','StaffLoanController@agri_application'); 
Route::POST('/loan_save_agri','StaffLoanController@loan_save_agri'); 
Route::get('/agri_recomendation_list','StaffLoanController@agri_recomendation_list'); 
Route::POST('/agri_recomendation_process','StaffLoanController@agri_recomendation_process');
// health 
Route::get('/health_recomendation_list','StaffLoanController@health_recomendation_list'); 
Route::POST('/health_recomendation_process','StaffLoanController@health_recomendation_process');  
Route::get('/get_loan_details_by_id/{id}','StaffLoanController@getLoanDetailsById'); 
Route::get('/dm_scp/','StaffLoanController@dm_scp');
Route::POST('/loan_save','StaffLoanController@loan_save'); 
Route::POST('/dm_scp_save','StaffLoanController@dm_scp_save');
Route::get('/field_ho_recomendation','StaffLoanController@field_ho_recomendation');
Route::any('/loan_reports','StaffLoanController@loan_reports');
Route::get('/application_location/{application_id}','StaffLoanController@application_location');
//END LOAN APPLICATION







Route::get('/emp_pay_slips', 'ProfileController@emp_pay_slips');
Route::get('/get-pay-slips/{salary_month}/{emp_id}','ProfileController@paySliplDetails');

Route::get('/upcomming-notification/','SelfNotificationController@index');
Route::get('/hr-upcomming-notification/','SelfNotificationController@notification');
 
Route::get('/leave-validations/{emp_id}/{leave_from}/{leave_to}/{leave_duration}/{leave_type}', 'LeaveController@leave_attachment_validation');
 
Route::resource('/my_loan','StaffLoanController');
Route::POST('/my_loanss','StaffLoanController@store');
Route::POST('/all_loan_application','StaffLoanController@all_loan_application');
Route::get('/banks_branch/{bank_id}','StaffLoanController@banks_branch');
Route::get('/loan_product_info/{loan_product_id}','StaffLoanController@loan_product_info');
Route::get('/loan_product_infos/{loan_product_id}/{emp_id}','StaffLoanController@loan_product_infos');


Route::get('/circulars','AdminController@circulars');
Route::get('/loan_view/{id}','SuperAdminController@loan_view');
 
 
 
 
Route::any('/update_salary_non','SuperAdminController@update_salary_non');
Route::any('/leave_application_recovery_server','ProfileController@leave_application_recovery_server');
 
 
//START Payroll
Route::get('/get_br_employee/{br_code}/{upto_date}/{status}/{staff_type}','PayrollController@get_br_employee');
Route::get('/get_regular_salary_plus/{head_id}/{emp_ho_bo}/{emp_designation}/{emp_grade}/{basic_salary}','PayrollController@get_regular_salary_plus');
Route::get('/get_allowance_value/{upto_date}/{pay_head_id}/{emp_id}/{emp_ho_bo}/{emp_designation}/{emp_grade}/{emp_is_permanent}/{emp_basic}','PayrollController@get_allowance_value');
Route::any('/payroll','PayrollController@index');
Route::any('/generate_payroll','PayrollController@generate_payroll');



//END Payroll

 
 
 
Route::get('/set_leave_balance_manual/{application_id}', 'MailController@set_leave_balance_manual');
//Route::get('/set_leave_balance/{application_id}', 'LeaveController@set_leave_balance');

Route::get('/admin-login-check', 'AdminController@getadminLoginCheck');

// Movement STARTS //
Route::get('/movement_approve', 'MovementsupervisorController@index');
Route::POST('/move_appliacation_approve', 'MovementsupervisorController@move_appliacation_approve'); 
Route::get('/movement_approval/{move_id}/{supervisor_id}/{is_need_vehicle_sup}/{action_id}', 'MovementsupervisorController@movement_approval');
Route::POST('/move_bulk_action', 'MovementsupervisorController@move_bulk_action');
Route::GET('approval_report_visit', 'MovementsupervisorController@approval_report_visit');
Route::POST('approval_report_visit', 'MovementsupervisorController@approval_reports_visit');
Route::resource('movement', 'Movement_registerController');
Route::get('/movement_approved', 'Movement_registerController@appr_movement_list');
Route::get('/movement_reject/{status}/{move_id}', 'Movement_registerController@movement_reject');
Route::POST('movement_appr_update', 'Movement_registerController@movementapprovedupdate');
Route::get('/movement_approved/{move_id}/{emp_id}/{emp_type}', 'Movement_registerController@movement_approved_edit');
Route::get('/select-branch/{area_id}', 'Movement_registerController@selectbranch'); 
Route::resource('movement_application', 'Movement_applicationController'); 
Route::POST('/all_movement_application','Movement_applicationController@all_movement_application'); 
Route::POST('/save_visit_close','Movement_applicationController@save_visit_close'); 
Route::get('/movement_close/{move_id}', 'Movement_applicationController@movement_close');
Route::get('/get_move_info/{id}','Movement_applicationController@get_move_info');
Route::get('/get_movement_info/{id}','Movement_applicationController@get_movement_info'); 
Route::get('/delete_move_application/{id}/{reference_id}','Movement_applicationController@delete_move_application');
Route::get('/visit_detail_info/{emp_id}','Movement_applicationController@visit_detail_info');
Route::get('/eid_leave_execute/', 'Movement_applicationController@eid_leave_execute'); 
Route::POST('insert_eid_leave_execute/', 'Movement_applicationController@insert_eid_leave_execute');
Route::get('/visit_check_date/{emp_id}/{from_date}/{to_date}/{db_id}/{leave_time}/{c_arrival_time}', 'Movement_applicationController@visit_check_date'); 
Route::get('/test_mail', 'Movement_applicationController@test_mail'); 
Route::resource('movement_bill', 'Movement_BillcreateController');
Route::get('/movement_bill_create/{move_id}', 'Movement_BillcreateController@movement_bill_create');
Route::get('/travel_edit/{travel_id}', 'Movement_BillcreateController@travel_edit');
Route::get('/bill_edit/{bill_id}', 'Movement_BillcreateController@bill_edit');
Route::get('/movement_delete/{table}/{travel_id}', 'Movement_BillcreateController@movement_delete');
Route::get('/tra_bill_save/{move_id}/{grade_code}/{designation_code}', 'Movement_BillcreateController@tra_bill_save');
Route::get('/create_bill_list', 'Movement_BillcreateController@create_bill_list');
Route::get('/get_travel_bill_info/{move_id}/{visit_type}', 'Movement_BillcreateController@get_travel_bill_info');
Route::POST('travel_insert', 'Movement_BillcreateController@travel_insert');
Route::POST('bill_insert', 'Movement_BillcreateController@bill_insert');
Route::POST('movement_bill_update', 'Movement_BillcreateController@movement_bill_update');
Route::get('/select_travel_amt/{source_br_code}/{dest_br_code}/{travel_date}', 'Movement_BillcreateController@select_travel_amt'); 
Route::get('/get_grade_wise_allowance/{grade_code}/{bill_date}', 'Movement_BillcreateController@get_grade_wise_allowance');
Route::get('emp_visit_report/', 'VisitReportController@emp_visit_report');   
Route::POST('emp_visit_reprt/', 'VisitReportController@emp_visit_reprt');
// Movement ENDS //

// LEAVE And PROFILE STARTS
Route::get('/delete_leave_application/{id}','ProfileController@delete_leave_application');
Route::get('/leave_report_profile/{emp_id}','ProfileController@leave_reprt_2');
Route::get('/pay_roll_details/{id}','ProfileController@payRollDetails');
Route::get('/get-pay-slip/{salary_month}','ProfileController@payRollDetails');
//leave Mail Approval 
//Route::get('/leave_mail', 'MailController@leave_mail');
//Route::get('/leave_mail_action/{application_id}/{supervisor_id}/{action_id}', 'MailController@leave_mail_response');
Route::get('/leave_mail_action/{application_id}/{supervisor_id}/{action_id}/{supervisor_type}','MailController@leave_approval_mail'); 
Route::get('/visit_mail_action/{move_id}/{supervisor_id}/{action_id}/{supervisor_type}','MailController@visit_approval_mail'); 
Route::get('/reported', 'ReportedController@index');
Route::get('/profile', 'ProfileController@index');
Route::get('/basic_info', 'ProfileController@basic_info');
Route::get('/pay_slips', 'ProfileController@pay_slips');
Route::get('/my_benefit', 'ProfileController@my_benefit');
//Route::get('/my_loan', 'ProfileController@my_loan');
Route::get('/my_documents', 'ProfileController@my_documents');
Route::get('/leave_visit', 'ProfileController@leave_visit');
Route::get('/e_approval', 'ProfileController@e_approval');
Route::get('/weblinks', 'ProfileController@weblinks');
Route::get('/get-leave-info/{id}','ProfileController@get_leave_info');
Route::get('/get-leave-validation/{leave_type}/{leave_from}/{leave_to}/{leave_balance}/{apply_for}', 'LeaveController@validation');
Route::get('/get-leave-modify-validation/{leave_type}/{leave_from}/{leave_to}/{leave_balance}/{apply_for}', 'LeaveController@modify_validation');
Route::get('/leave_approved', 'ProfileController@leave_approved');
Route::get('/leave_approval/{application_id}/{supervisor_id}/{action_id}', 'ProfileController@leave_approval');


Route::POST('/leave-appliacation-approve', 'ProfileController@leave_approve');
Route::POST('/leave_bulk_action', 'ProfileController@leave_bulk_action');
Route::GET('approval_report', 'LeaveController@approval_report');
Route::POST('approval_report', 'LeaveController@approval_reports'); 
// LEAVE And PROFILE END 


 
 
 
Route::resource('/supervisor','SupervisorController');
Route::POST('/all-supervisor','SupervisorController@allsupervisor'); 
Route::get( '/pay_roll_details/{id}', 'ProfileController@payRollDetails' );
Route::get('/get-pay-slip/{salary_month}','ProfileController@payRollDetails');
//Route::get('/leave_report_profile/{emp_id}','ProfileController@leave_reprt_2'); 
Route::get('/delete_leave_application/{id}','ProfileController@delete_leave_application');  










Route::get('/update_salary','AdminController@update_salary' );
Route::get('/tester','SuperadminController@test' );


Route::get('/reported_to/{emp_id}/{br_code}/{department_code}/{designation_code}','ProfileController@index' );
 
Route::get('/','CdipController@index' );

//Route::get('leave_check/', 'NonIdController@leave_check'); 
/*
 * Admin Panel
 */
Route::get('/admin','AdminController@index');

Route::get('/abc','AdminController@abc');

Route::get('/manual','AdminController@Manual');
//Route::get('admin', 'AdminController@index')->middleware('CheckSession');

Route::get('/add_user_br','AdminUserController@add_user_br');
Route::POST('/stote_user_br','AdminUserController@stote_user_br');

Route::post('/admin-login-check','AdminController@adminLoginCheck' );
Route::get('/dashboard','SuperAdminController@index' );
Route::get('/logout','SuperAdminController@logout' );

/*
 * Api
 */
Route::get('/branch-staff/{br_code}/{form_date}','ApiController@BranchStaff');
/* Api for spms */
Route::get('/branch_staff/{br_code}/{form_date}','ApiController@Branch_Staff');
//Route::get('/am_mb/{ambmcode}/{form_date}','ApiController@AmBmStaff');
//Route::get('/hrm_gha_marks/{emp_id}','ApiController@HrmGhaMarks');
//Route::get('/spms_grade/{emp_id}','ApiController@SpmsGrade');




/*
 * Email Send
 */
Route::get('/email-send','EmailController@SendEmail');

/*START Config*/

// NAV Group Manager
Route::get('/manage-menu-group','MenuGroupController@index' );
Route::get('/add_group_menu','MenuGroupController@add_menu_group');
Route::POST('/store-menu-group','MenuGroupController@stote_menu_group' );
Route::get('/edit-nav-group/{nav_group_id}','MenuGroupController@edit_nav_group' );
Route::post('/update-menu-group','MenuGroupController@update_nav_group' );
//NAV Manager
Route::get('/manage-menu','MenusController@index' );
Route::get('/add_menu','MenusController@add_menu');
Route::POST('/store-menu','MenusController@stote_menu' );
Route::get('/edit-nav/{nav_id}','MenusController@edit_nav' );
Route::post('/update-menu','MenusController@update_nav' );

//Branch Manager 
Route::get('/manage-branch','BranchController@index' );
Route::get('/add-branch','BranchController@add_branch');
Route::POST('/store-branch','BranchController@store_branch' );
Route::get('/edit-branch/{id}','BranchController@edit_branch' );
Route::post('/update-branch','BranchController@update_branch' );
//Area Manager
Route::get('/manage-area','AreaController@index' );
Route::get('/add-area','AreaController@add_area');
Route::POST('/store-area','AreaController@store_area' );
Route::get('/edit-area/{id}','AreaController@edit_area' );
Route::post('/update-area','AreaController@update_area' );

//Area Manager
Route::get('/manage-holiday','HolidayController@index' );
Route::get('/add-holiday','HolidayController@add_holiday');
Route::POST('/store-holiday','HolidayController@store_holiday' );
Route::get('/edit-holiday/{id}','HolidayController@edit_holiday' );
Route::post('/update-holiday','HolidayController@update_holiday' );
Route::get('/delete-holiday/{id}','HolidayController@delete_holiday' );


Route::get('/extra_mobile_allowance','ExtraAllowanceController@index');
Route::get('/add-extra_mobile','ExtraAllowanceController@add');
Route::POST('/store-extra_mobile','ExtraAllowanceController@store' );
Route::get('/edit-extra_mobile/{id}','ExtraAllowanceController@edit' );
Route::post('/update-extra_mobile','ExtraAllowanceController@update' );
Route::get('/delete-extra_mobile/{id}','ExtraAllowanceController@delete_extra_mobile' );






//Zone Manager
Route::get('/manage-zone','ZoneController@index' );
Route::get('/add-zone','ZoneController@add_zone');
Route::POST('/store-zone','ZoneController@store_zone' );
Route::get('/edit-zone/{id}','ZoneController@edit_zone' );
Route::post('/update-zone','ZoneController@update_zone' );

//User Manager
Route::get('/manage-user','AdminUserController@index');
Route::get('/add_user','AdminUserController@add_user');
Route::POST('/store-user','AdminUserController@stote_user' );
Route::post('/update-user','AdminUserController@update_user');
Route::get('/edit-user/{admin_id}','AdminUserController@edit_user');
Route::get('/delete-user/{admin_id}','AdminUserController@destroy_user');

Route::get('/paward_change','AdminUserController@paward_change');
Route::get('/check_password_old/{old_password}','AdminUserController@check_password_old');
Route::POST('/new_password_insert','AdminUserController@new_password_insert');


Route::get('/ad_reset_pw','AdminUserController@admin_reset_password');
Route::get('/update_reset_password/{admin_id}','AdminUserController@update_reset_password');
//


Route::resource('/transfer-remarks','Transfer_remarksController');

//Role Manager
Route::resource('/user-role','UserRollController');
Route::POST('/update-role','UserRollController@update');
Route::get('/role-status-update/{id}/{val}','UserRollController@role_status_update');

//Role Permission
Route::get('/set-permission/{role_id}','UserPermissionController@set_permission');
Route::POST('/save-permission','UserPermissionController@store');

//Config Organization 
Route::resource('org-manager','OrganizationController');

//Config Grade
Route::resource('config-grade','GradeController');
//Config Designation
Route::resource('config-designation','DesignationController');
//Config Designation
Route::resource('config-department','DepartmentController');
//Settings offense
Route::resource('settings-offense','OffenseController');
//Settings Punishment Type
Route::resource('punishment-type','Punishment_typeController');
//Config Scale
Route::resource('config-scale','ScaleController');

//common transection
Route::get('/get-crime-info/{id}','CommonController@get_crime_info');
Route::get('/get-max-effect-date/{id}','CommonController@get_max_effect_date');
Route::get('/get-assign-info/{emp_id}/{effect_date}/{tran_type_no}','CommonController@get_assign_info');




/************************************************** END Config ********************************************************************/
Route::get('age_calculation/{birth_date}', 'NonIdController@age_calculation');
/*START Appoinment*/
Route::resource('/employee-appointment','AppoinmentController');
Route::POST('/save-appoimtment-letter','AppoinmentController@save_appoimtment_letter');
Route::get('/select-emp-type/{emp_group}','AppoinmentController@SelectEmpType');
Route::get('/select-unit/{department_code}','AppoinmentController@SelectUnit');

Route::POST('/store-appointment','AppoinmentController@store_appointment');
Route::get('/get-max-emp-id','AppoinmentController@get_last_emp_id');
Route::get('/edit-appoinment/{id}','AppoinmentController@edit_appoinment');
Route::POST('/update-appoinment','AppoinmentController@update_appoinment');
Route::get('/select-nationalid/{national_id}/{emp_id}/{id}','AppoinmentController@SelectNationalId');

/* For ID Card */
Route::get('/get_emp_idcard','AppoinmentController@get_emp_idcard');

Route::resource('/appointment-letter','AppointletterController');
Route::get('/view-appoint-letter/{id}','AppointletterController@view_appoint_letter');


Route::resource('/non-cancel','NonIdCancelController');
Route::POST('/all-non-id_cancel','NonIdCancelController@all_data');


Route::get('/branch_staff_cancel','NonIdbranchCancelController@index');
Route::get('/non_id_cancel_br_create','NonIdbranchCancelController@non_id_cancel_br_create');
Route::get('/get_nonid_info_br/{emp_id}/{emp_type}','NonIdbranchCancelController@get_nonid_info_br');
Route::get('/non_id_branch_wise_staff/{emp_type}','NonIdbranchCancelController@non_id_branch_wise_staff');
Route::get('/non_id_cancel_br_edit/{id}','NonIdbranchCancelController@non_id_cancel_br_edit');
Route::POST('/non_id_cancel_insert_br','NonIdbranchCancelController@non_id_cancel_insert_br');
Route::POST('/non_id_cancel_br','NonIdbranchCancelController@non_id_cancel_br');
Route::POST('/non_id_cancel_br_update','NonIdbranchCancelController@non_id_cancel_br_update');


//Route::get('nonid_check/', 'NonIdController@nonid_check'); 

Route::resource('/non-appoinment','NonIdController');
Route::POST('/all-non-id','NonIdController@all_data');
Route::get('/get-non-max/{id}','NonIdController@get_non_max');
Route::get('/view-non-id/{id}','NonIdController@show');
Route::POST('/non_id_info_update','NonIdController@non_id_info_update');
Route::get('/non_id_info_edit/{id}','NonIdController@non_id_info_edit');

Route::get('/get-nonid-info/{emp_code}/{emp_type}','NonIdCancelController@get_emp_info');


Route::resource('/con_salary','NonIdSalaryController');
Route::get('/con_salary_edit/{id}/{effect_date}','NonIdSalaryController@con_salary_edit');
Route::get('/get_nonemployee_info/{sacmo_id}/{emp_type}','NonIdSalaryController@get_nonemployee_info'); 
Route::get('/view_nonid_salary/{id}/{effect_date}','NonIdSalaryController@view_nonid_salary');
Route::get('/get_nonid_salary_info/{emp_id}','NonIdSalaryController@get_nonid_salary_info'); 
Route::get('/del_nonid_salary_info/{id}','NonIdSalaryController@del_nonid_salary_info');
Route::get('/check_nonid_salary_effect_date/{emp_id}/{effect_date}','NonIdSalaryController@check_nonid_salary_effect_date');

Route::resource('/con_official_info','NonIdOfficialInfoController');
Route::get('/get_nonemployee_official_info/{sacmo_id}/{emp_type}','NonIdOfficialInfoController@get_nonemployee_official_info');
Route::get('/view_nonid_official_info/{id}','NonIdOfficialInfoController@view_nonid_official_info');
Route::get('/del_nonid_official_info/{id}','NonIdOfficialInfoController@del_nonid_official_info');
Route::get('/get_nonid_official_info/{emp_id}','NonIdOfficialInfoController@get_nonid_official_info');

Route::resource('/contractual_renew','Contractual_renewController');
Route::get('/get_nonemployee_contract_info/{emp_id}','Contractual_renewController@get_nonemployee_contract_info');
Route::get('/check_contract_effect_date/{emp_id}/{effect_date}', 'Contractual_renewController@check_contract_effect_date');
Route::get('/view_contract_renew_info/{id}','Contractual_renewController@view_contract_renew_info');
 
Route::resource('/con_transfer','NonIdTransferController');
Route::get('/view_nonid_transfer/{id}','NonIdTransferController@view_nonid_transfer'); 
Route::get('/get_nonemployee_transfer/{sacmo_id}/{emp_type}','NonIdTransferController@get_nonemployee_transfer');
Route::get('/get_nonid_transfer_info/{emp_id}','NonIdTransferController@get_nonid_transfer_info');

Route::get('/is_contract_check_edit/{id}/{emp_id}','NonIdController@is_contract_check_edit');

Route::get('/check_nonid_effect_date/{emp_id}/{effect_date}','NonIdTransferController@check_nonid_effect_date');
Route::get('/del_nonid_transfer/{id}','NonIdTransferController@del_nonid_transfer');

Route::resource('/con_designation','NonIdDesignationController');
Route::get('/get_nonemployee_designation/{sacmo_id}/{emp_type}','NonIdDesignationController@get_nonemployee_designation');
Route::get('/del_nonid_designation/{id}/{sarok_no}','NonIdDesignationController@del_nonid_designation');
Route::get('/view_nonid_designation/{id}','NonIdDesignationController@view_nonid_designation');
Route::get('/get_nonid_designation_info/{emp_id}','NonIdDesignationController@get_nonid_designation_info');



Route::resource('/bra_contractual','NonIdbranchController'); 
Route::get('/bra_view_non_id/{id}','NonIdbranchController@bra_view_non_id');





/*CV Manager*/

/* START Employee CV Pronab */
//Route::resource('emp-general', 'EmployeeCvController');
Route::get('emp-general/{emp_id}/{id}', 'EmployeeCvController@ShowData');
Route::POST('/emp-general','EmployeeCvController@EmpStore');
Route::get('/select-thana/{district_code}','EmployeeCvController@SelectThana');
Route::POST('/emp-edu','EmployeeCvController@EmpCvEdu');
Route::POST('/emp-training','EmployeeCvController@EmpCvTraining');
Route::POST('/emp-experience','EmployeeCvController@EmpCvExperience');
Route::POST('/emp-reference','EmployeeCvController@EmpCvReference');
Route::POST('/emp-photo','EmployeeCvController@EmpCvPhoto');
Route::POST('/emp-necessary_phone','EmployeeCvController@EmpCvNecessaryPhone');
Route::POST('/emp-other','EmployeeCvController@EmpCvOther');
Route::POST('/update-emp/{id}','EmployeeCvController@update_emp_general');
Route::resource('emp-cv', 'EmployeeController');
Route::get('emp-cv-pdf/{emp_id}', 'EmployeeCvController@EmpCvPdf');

/* END Employee CV Pronab */

/* Start Board Members Informatiion */
Route::resource('/board-member', 'GeneralGoverningController');
Route::get('/board-member-view', 'GeneralGoverningController@BoardView');
Route::get('/board-member-views/{id}/{id1}/{id2}', 'GeneralGoverningController@BoardViews');
/* End Board Members Informatiion */


Route::resource('incre-letter-config', 'IncrementLetterConfigController');
/*Heldup*/
Route::resource('heldup','HeldupController');
/*Employee Assign*/
Route::resource('emp-assign','EmpAssignController');
Route::POST('/emp-assign-close','EmpAssignController@EmpAssignClose');
/*Marked Assign*/
Route::resource('mark-assign','MarkAssignController');
Route::POST('/mark-assign-close','MarkAssignController@MarkAssignClose');
/*Employee Mapping*/
Route::resource('emp-mapping','EmpMappingController');
Route::get('/emp_mapping','EmpMappingController@MappingEmpCreate');
Route::POST('/emp_mapping','EmpMappingController@MappingEmp');
Route::get('/emp_mapping_view/{emp_id}/{id}','EmpMappingController@MappingEmpView');
/*Extra Deduction*/
Route::resource('extra_deduction','ExtraDeductionController');
Route::get('/get-emp-info/{emp_id}','ExtraDeductionController@GetEmpInfo');
/*Arrear Setup*/
Route::resource('arrear_setup','ArrearSetupController'); 
Route::get('/get_emp_info_arr/{emp_id}','ArrearSetupController@get_emp_info_arr');
Route::get('/day_wise_basic/{emp_id}/{effect_date}','ArrearSetupController@day_wise_basic');
Route::get('/arrear_setup_pay/{arrear_id}','ArrearSetupController@arrear_setup_pay');
Route::get('/day_wise_calculation/{from_date}/{to_date}/{basic_salary}','ArrearSetupController@day_wise_calculation'); 
Route::get('/pay_month_validation_arrear/{arrear_emp_id}/{arrear_to_pay_month}','ArrearSetupController@pay_month_validation_arrear'); 
Route::POST('/calculation_arrear_amt','ArrearSetupController@calculation_arrear_amt');
Route::POST('/calc_arrear_amt_payment','ArrearSetupController@calc_arrear_amt_payment');
Route::POST('/arrear_pay_insert','ArrearSetupController@arrear_pay_insert');

/*Arrear Allowance Setup*/
Route::resource('arrear_allow_setup','ArrearAlowanceSetupController'); 
Route::get('/get_emp_info_arr_alowance/{emp_id}','ArrearAlowanceSetupController@get_emp_info_arr_alowance'); 
Route::POST('/arrear_allow_setup_update','ArrearAlowanceSetupController@arrear_allow_setup_update'); 

/* Suspension */
Route::resource('suspension','SuspensionController');  
Route::POST('/suspension_update/{db_id}','SuspensionController@suspension_update');
Route::get('/get_emp_info_sus/{emp_id}','SuspensionController@get_emp_info_sus'); 

/*Unsettle Staff Adv. Deduction*/
Route::get('unsettle-staff-adv','UnsettleStaffAdvController@index');
Route::get('/unsettle_view/{emp_id}/{incre_id}','UnsettleStaffAdvController@UnsettleView');
Route::get('/unsettle_collection/{emp_id}/{incre_id}','UnsettleStaffAdvController@UnsettleCollection');
Route::get('/unsettle_transfer/{emp_id}/{incre_id}','UnsettleStaffAdvController@UnsettleTransfer');
Route::POST('/unsettle-transfer-store','UnsettleStaffAdvController@UnsettleTransferStore');
Route::get('/unsettle_resedule/{emp_id}/{incre_id}','UnsettleStaffAdvController@UnsettleResedule');
Route::POST('/unsettle-staff-adv-col','UnsettleStaffAdvController@UnsettleCollectionStore');
Route::get('/unsettle-staff-adv-payroll','UnsettleStaffAdvController@UnsettleCollectionPayroll');
Route::POST('unsettle-staff-adv-payroll','UnsettleStaffAdvController@GetUnsEmpInfo');
Route::POST('unsettle-staff-adv-add','UnsettleStaffAdvController@store');
Route::POST('unsettle-staff-adv','UnsettleStaffAdvController@GetEmployeeInfo');
Route::get('/get-page-info/{transaction_type}/{emp_id}/{incre_id}','UnsettleStaffAdvController@UnsettleViewLoad');
Route::POST('/unsettle-add-claim','UnsettleStaffAdvController@UnsettleAddClaim');
Route::get('/unsettle-statement/{emp_id}','UnsettleStaffAdvController@UnsettleStatement');
Route::POST('/unsettle-statement','UnsettleStaffAdvController@UnsettleStatementReport');
Route::get('/unsettle-claim-report','UnsettleStaffAdvController@UnsettleClaim');
Route::POST('/unsettle-claim-report','UnsettleStaffAdvController@UnsettleClaimReport');
/* Covid-19 */
Route::resource('covid-nineteen','CovidNineteenController');
Route::get('/covid_nineteen_view/{emp_id}/{id}','CovidNineteenController@CovidNineteenView');
/* Branch Transfer */
Route::resource('br_transfer','BrTransferController');
Route::get('/br_transfer_emp','BrTransferController@BrTransferCreate');
Route::POST('/br_transfer_emp','BrTransferController@BrTransferEmp');
Route::get('/select-branch/{area_code}','BrTransferController@SelectBranch');
Route::get('/br_transfer/{emp_id}/{id}','BrTransferController@BrTransferEdit');
Route::get('/br_transfer_view/{emp_id}/{id}','BrTransferController@BrTransferView');
Route::get('/approve_br_transfer/{id}/{emp_id}','BrTransferController@BrTransferApprove');
Route::POST('/br_transfer_edit/{emp_id}/{id}','BrTransferController@BrTransferUpdate');
/* Start Config Pronab */
Route::resource('district', 'DistrictController');
Route::resource('thana', 'ThanaController');
Route::resource('board-university', 'BoardUniversityController');
Route::resource('group-subject', 'GroupSubjectController');
Route::resource('exam', 'ExamController');
Route::resource('extra_deduc_type', 'ExtraDeducTypeController');
Route::resource('functional-designation', 'FunctionalDesignationController');

/* End Config Pronab */


/*Common Function*/
Route::get('/get-employee-info/{emp_id}/{letter_date}','CommonController@get_employee_info');

Route::POST('/save-transection','CommonController@store_transection');
Route::POST('/update-transection','CommonController@update_transection');

/*Probation*/
Route::resource('probation','ProbationController');

/*Permanent*/
Route::resource('permanent','PermanentController');

/*Increment*/
Route::resource('increment','IncrementController');
Route::GET('increment-generate','IncrementController@generate_increment');
Route::POST('search-increment-employee','IncrementController@search_increment_employee');
Route::POST('save-increment','IncrementController@save_increment');

//Pronab
Route::resource('increment-letter', 'IncrementLetterController');

/* Training */
Route::resource('training', 'TrainingController');
Route::get('/get-employee-info-training/{emp_id}','TrainingController@get_employee_info');

Route::POST('increment-salary','IncrementLetterController@increment_salary');
//

/*Promotion*/
Route::resource('promotion','PromotionController');

/*demotion*/
Route::resource('demotion','DemotionController');

/*Others*/
Route::resource('emp-others','OthersController');

/*Punishment*/
Route::resource('punishment','PunishmentController');

/*Punishment*/
Route::resource('transfer','TransfersController');

/* Resignation */
Route::resource('resignation','ResignationController');


/*View Records*/
Route::resource('view-records','ViewRecordsController');
Route::get('/view-record','ViewRecordsController@view_record');


/*---------------------*/

//Payroll Configuration 
Route::resource('salary-plus','SalaryPlusController');
Route::resource('salary-minus','SalaryMinusController');
//SALARY
Route::resource('staff-salary','Emp_salaryController');
Route::POST('generate-salary','Emp_salaryController@generate_salary');
Route::GET('generate-salary','Emp_salaryController@generate_salary');

Route::POST('view-salary','Emp_salaryController@show');
Route::GET('view-salary','Emp_salaryController@show');

Route::POST('save-salary','Emp_salaryController@save');
Route::POST('update-salary','Emp_salaryController@update');
Route::get('/test','CommonController@test');
//SECURITY
Route::resource('staff-security','StaffSecurityController');

 
/****************START SAIFUL********************/

Route::get('/bra_increment_list','IncrementlistbranchwiseController@bra_increment_list');
Route::get('/bra_increment_list2/{branch_code}','IncrementlistbranchwiseController@bra_increment_list2');

//Route::get('leave_check/', 'LeaveapprovedController@leaveyearadd1');
//Route::get('leave_check/', 'LeaveapprovedController@leave_check');


/* Employee Leave */
//Route::get('leave_check/', 'EmployeeleavController@leave_check'); 
Route::resource('emp-leave', 'EmployeeleavController');
Route::get('emp-leave/{approved-list}', 'EmployeeleavController@update');
Route::get('add-leave','EmployeeleavController@addleave');
Route::get('/yearly-tot-leave','EmployeeleavController@selecttotleave'); 
Route::get('get_emp_leave_info/{employee_id}/{f_year_id}','EmployeeleavController@get_emp_leave_info'); 
Route::Post('insert_emp_leave_br','EmployeeleavController@insert_emp_leave_br');
Route::Post('emp_leave_br_update','EmployeeleavController@emp_leave_br_update');
Route::get('emp_leave_br_edit/{id}','EmployeeleavController@emp_leave_br_edit');
Route::get('emp_leave_br_del/{id}','EmployeeleavController@emp_leave_br_del'); 
Route::get('leave_date_exist_br/{from_date}/{to_date}/{emp_id}', 'EmployeeleavController@leave_date_exist_br');
Route::get('leave_date_exist_edit_br/{from_date}/{to_date}/{emp_id}/{db_id}', 'EmployeeleavController@leave_date_exist_edit_br');
 
 
 

/* Leave Recommend */ 
Route::get('recommend_leave_view_hrhead/{id}/{emp_id}', 'LeavehrmheadController@recommend_leave_view_hrhead'); 
Route::get('approved_by_sup_approve_hrhead/{id}', 'LeavehrmheadController@approved_by_sup_approve_hrhead'); 
Route::get('approved_by_sup_reject_hrhead/{id}', 'LeavehrmheadController@approved_by_sup_reject_hrhead');
Route::get('recommend_leave_hrhead/{id}/{emp_id}', 'LeavehrmheadController@recommend_leave_hrhead');
Route::POST('approved_by_hr_head/{id}', 'LeavehrmheadController@approved_by_hr_head');
// hrm executor
Route::POST('insert_aprove_leave_byhrm', 'LeavehrmheadController@insert_aprove_leave_byhrm');
Route::get('approved_by_hrm', 'LeavehrmheadController@approved_by_hrm');
Route::get('approve_leave_byhrm/{id}', 'LeavehrmheadController@approve_leave_byhrm');
Route::get('supervisor_info/{id}', 'LeavehrmheadController@supervisor_info');
Route::get('leave_date_exist_app/{from_date}/{to_date}/{emp_id}', 'LeavehrmheadController@leave_date_exist_app');
Route::POST('leave_bulk_action_hrm', 'LeavehrmheadController@leave_bulk_action_hrm');
 

Route::resource('approved_by_sup', 'LeavesuvisorController');
Route::get('approved_by_sup_reject/{id}/{supervisor_type}', 'LeavesuvisorController@approved_by_sup_reject');
Route::get('recommend_leave/{id}/{emp_id}', 'LeavesuvisorController@recommendedit'); 
Route::get('recommend_leave_view/{id}/{emp_id}', 'LeavesuvisorController@recommend_leave_view'); 

/* Leave Approved */
Route::resource('approved-leave', 'LeaveapprovedController');
//Route::get('leave_check/', 'LeaveapprovedController@leave_check'); 


//Route::get('leave_check/', 'LeaveReportController@leave_check'); 
Route::POST('leave_reprt1/', 'LeaveReportController@leave_reprt1');  
Route::get('leave_report_branch', 'LeaveReportbranchController@index'); 
Route::POST('leave_report_branch', 'LeaveReportbranchController@leave_report_branch'); 
 
Route::get('year-close/', 'LeaveapprovedController@leaveyearclose');
Route::get('leave_year_add/{year_id}', 'LeaveapprovedController@leaveyearadd');
Route::get('add_aprove_leave', 'LeaveapprovedController@add_aprove_leave'); 
Route::POST('insert_aprove_leave', 'LeaveapprovedController@insert_aprove_leave');
Route::POST('search_emp_info', 'LeaveapprovedController@search_emp_info');
Route::POST('update_aprove_leave', 'LeaveapprovedController@update_aprove_leave');
Route::PUT('appr-reject/{id}', 'LeaveapprovedController@approvedreject'); 
Route::get('approved_leave/{id}/{f_year_id}/{emp_id}', 'LeaveapprovedController@approvedleave');
Route::get('approved_leave_delete/{id}/{f_year_id}/{emp_id}', 'LeaveapprovedController@approved_leave_delete');
Route::get('leave_date_exist/{from_date}/{to_date}/{emp_id}', 'LeaveapprovedController@leave_date_exist');
Route::get('leave_date_exist_edit/{from_date}/{to_date}/{emp_id}/{db_id}', 'LeaveapprovedController@leave_date_exist_edit');   
/* Edms Documents */


//Route::get('saiful_edms_method', 'EdmsdocumentController@saiful_edms_method'); 
Route::resource('edms-subcategory', 'EdmssubcategoryController');
Route::resource('edms-category', 'EdmscategoryController');
//// before multiple edms //// 
//Route::resource('edms-document', 'EdmsdocumentController');  



Route::get('edms/', 'EdmsdocumentController@index');

Route::get('document-view1/', 'EdmsdocumentController@viewattachment1'); 
Route::any('emp-attachment', 'EdmsdocumentController@empattachment');
Route::get('select-subcategory/{category_id}', 'EdmsdocumentController@selectsubcategory');
Route::get('edms_document_delete/{document_id}/{category_id}/{document_name}', 'EdmsdocumentController@edms_document_delete');
Route::POST('edms_search/', 'EdmsdocumentController@edms_search'); 
Route::get('select-empinfo/{emp_id}', 'EdmsdocumentController@selectempinfo');
Route::get('document-view/{emp_id}/{category_id}/{subcat_id}', 'EdmsdocumentController@viewattachment');
Route::get('edms_document_edit/{document_id}', 'EdmsdocumentController@edms_document_edit');

Route::get('/edms_document_hlist_index','EdmsdocumentController@edms_document_hlist_index'); 
Route::POST('/edms_document_hlist','EdmsdocumentController@edms_document_hlist');

Route::get('duplicate_check/{emp_id}/{category_id}/{subcat_id}/{effect_date}/{document_id}', 'EdmsdocumentController@duplicate_check');

Route::get('edms_document', 'EdmsdocumentController@edms_document');  
Route::get('edms_document_empid/{emp_id}', 'EdmsdocumentController@edms_document_empid');  
Route::get('category_permission/{access_type}', 'EdmsdocumentController@category_permission');  
Route::POST('edms_document_update', 'EdmsdocumentController@edms_document_update');  
Route::POST('edms_document_update_permanent', 'EdmsdocumentController@edms_document_update_permanent');  
Route::POST('edms_document_add', 'EdmsdocumentController@edms_document_add');  
Route::get('edms_save_flag/', 'EdmsdocumentController@edms_save_flag');
Route::get('viewattachment/', 'EdmsdocumentController@viewattachment');
Route::get('edms_document_delete_hrhead/{document_id}/{category_id}/{document_name}', 'EdmsdocumentController@edms_document_delete_hrhead');
Route::POST('edit_edms_info/', 'EdmsdocumentController@edit_edms_info');
Route::get('edit_edms_info/{emp_id}', 'EdmsdocumentController@edit_edms_info_get');
Route::get('current_department_info/{emp_id}', 'EdmsdocumentController@current_department_info');
Route::get('edms_access_check', 'EdmsdocumentController@edms_access_check');
Route::get('edms_document_edit_permanent/{document_id}', 'EdmsdocumentController@edms_document_edit_permanent');
Route::get('edit_edms_document/', 'EdmsdocumentController@edit_edms_document');
Route::get('edms_document_delet/', 'EdmsdocumentController@edms_document_delet');
Route::POST('delete_edms_info/', 'EdmsdocumentController@delete_edms_info');
Route::get('delete_edms_info/{emp_id}', 'EdmsdocumentController@delete_edms_info_get');
Route::get('/current_emp_info/{emp_id}','EdmsdocumentController@current_emp_info');   
Route::POST('/edms_document_list','EdmsdocumentController@edms_document_list'); 
// test 







/* Edms Documents personal */

Route::get('per_document/', 'EdmsdocumentpersonalController@per_document');
Route::any('per_emp_attachment/', 'EdmsdocumentpersonalController@per_emp_attachment');
Route::get('select_subcategory_per/{category_id}', 'EdmsdocumentpersonalController@selectsubcategory');
Route::get('testtt/', 'EdmsdocumentpersonalController@testtt');



//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_not_exist_delete'); 

/// migrate table to migrate table
/* Route::get('edms_migrate', 'EdmsdocumentController@edms_migrate'); */

/// migrate edu_certificate table to migrate table
//Route::get('edms_migrate', 'EdmsdocumentController@edms_migrate_ed_certificate');

/// migrate, edu_certificate migrate table to tbl_edms_document
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_certificate');
  
/// migrate, punisment migrate table to migrate table
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_punisment');

/// migrate, Resign migrate table to migrate table
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_resign');

/// migrate, punisment migrate table to tbl_edms_document
///Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_punisment_1');

/// migrate, Resign migrate table to tbl_edms_document
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_resign1');

/// migrate, migrate table to tbl_edms_document 
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate');


//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_heldup');
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_heldup_1');
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_probation_to_apointment');
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_miscellaneous');
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_miscellaneous_1');
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_training');
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_training_1');



//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_subattachment');
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_subattachment_1');

//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_cv_training1'); 
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_cv_others1');  
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_migrate_cv_experience1'); 
//Route::get('edms_migrate', 'EdmsdocumentController@edms_document_other'); 
/* driver license */
Route::get('add_license/', 'DriverlicenseController@index');
Route::get('add_create/', 'DriverlicenseController@add_create');
Route::get('select_empinfo_driver/{emp_id}', 'DriverlicenseController@select_empinfo_driver');
Route::get('license_view/{emp_id}/{dri_license_id}', 'DriverlicenseController@license_view');
Route::get('license_view1/', 'DriverlicenseController@license_view1');
Route::POST('insert_license', 'DriverlicenseController@insert_license');
Route::get('edit_license/{dri_license_id}', 'DriverlicenseController@edit_license');
Route::any('license_attachment', 'DriverlicenseController@license_attachment');
Route::POST('update_license/', 'DriverlicenseController@update_license');
Route::get('delete_license/{emp_id}/{dri_license_id}', 'DriverlicenseController@delete_license');
Route::get('check_exist_driver_license/{license_exp_date}/{emp_id}/{dri_license_id}', 'DriverlicenseController@check_exist_driver_license');

    


Route::resource('travel_allowance', 'TravelallowanceController');
Route::resource('daily_allowance', 'DailyallowanceController');
/* Office Order */
Route::resource('office_order', 'OfficeorderController');
Route::get('office_order_update/', 'OfficeorderController@office_order_update'); 
Route::get('office_order_delete/{order_id}', 'OfficeorderController@office_order_delete');
Route::POST('order_update_add/', 'OfficeorderController@order_update_add'); 
/////// download /////////// 
Route::get('br_download_general/', 'OfficeorderController@br_download_general'); 
Route::get('br_download_office_order/', 'OfficeorderController@br_download_office_order'); 
Route::get('br_download_circular/', 'OfficeorderController@br_download_circular'); 
Route::get('br_user_manual/', 'OfficeorderController@br_user_manual'); 
Route::get('br_download/', 'OfficeorderController@br_download'); 
 

Route::get('leave_report/', 'LeaveReportController@index'); 
Route::POST('leave_reprt/', 'LeaveReportController@leave_reprt'); 
Route::get('emp_leave_report/', 'LeaveReportController@emp_leave_report');   
Route::POST('emp_leave_reprt/', 'LeaveReportController@emp_leave_reprt'); 
Route::get('acco_leave_report/', 'LeaveaccountReportController@acco_leave_report');  
Route::get('emp_leave_reprt_pre/', 'LeaveReportController@emp_leave_reprt_pre');
Route::get('previous_leave_reprt/', 'LeaveReportController@previous_leave_reprt');  
Route::get('ho_leave_rpt/', 'LeaveReportController@ho_leave_rpt');  
Route::get('change_report_type/{report_type}/{emp_id}', 'LeaveReportController@change_report_type'); 


Route::get('leave_report_dm_am/', 'LeaveReportController@leave_report_dm_am'); 
Route::get('change_area_to_branch/{area_code}', 'LeaveReportController@change_area_to_branch'); 
Route::POST('leave_reprt_dm/', 'LeaveReportController@leave_reprt_dm'); 

Route::get('drivier_license_report/', 'DriverlicenseReportController@index');
Route::get('get_branch_by_area/{area_code}', 'DriverlicenseReportController@get_branch_by_area');
Route::POST('drivier_license_search_report/', 'DriverlicenseReportController@drivier_license_search_report');


Route::get('salary_certicate/', 'SalarycertificateController@salary_certicate');
Route::POST('salary_certicate_emo_info/', 'SalarycertificateController@salary_certicate_emo_info');
Route::get('salary_certicate_depo/', 'SalarycertificateController@salary_certicate_depo');
Route::POST('salary_certicate_emo_info_depo/', 'SalarycertificateController@salary_certicate_emo_info_depo');

/****************END SAIFUL********************/

/* PMS */
Route::GET('pms', 'PmsController@index');
Route::POST('pms', 'PmsController@PmsEmployee');  
Route::GET('pms-objective', 'PmsController@PmsObjectiveList'); 
Route::POST('pms-objective-save', 'PmsController@PmsObjectiveSave'); 
Route::GET('pms-delete/{id}', 'PmsController@PmsObjectiveDelete'); 
Route::GET('edit-pms/{id}', 'PmsController@PmsObjectiveEdit'); 
Route::GET('pms-supervisor', 'PmsController@PmsSupervisor'); 
Route::GET('pms-view/{emp_id}/{id}', 'PmsController@PmsView'); 
Route::GET('pms-submit-supervisor/{id}', 'PmsController@PmsSubmitSupervisor'); 
Route::POST('pms-approve-save', 'PmsController@PmsApproveSave'); 
Route::POST('pms-approve-supervisor', 'PmsController@PmsApproveSupervisor'); 
Route::POST('pms-supervisor', 'PmsController@PmsEmployeeSearch'); 
Route::GET('pms-report', 'PmsController@PmsReport'); 
Route::GET('pms-submission', 'PmsController@PmsSubmissionList'); 
Route::POST('pms-submission-save', 'PmsController@PmsSubmissionSave'); 
Route::GET('pms-submission-supervisor/{id}', 'PmsController@PmsSubmissionSupervisor'); 
Route::GET('get-marks/{id}', 'PmsController@GetMarks'); 
Route::POST('pms-final-save', 'PmsController@PmsFinalApproveSave'); 
Route::GET('pms-assessment-report', 'PmsController@PmsAssessmentReport'); 
Route::POST('pms-assessment-report', 'PmsController@PmsAssessmentReportSearch'); 
Route::GET('pms-assessment', 'PmsController@PmsAssessment'); 
Route::POST('pms-assessment-detail', 'PmsController@PmsAssessmentDetail'); 
Route::GET('pms-assessment-detail', 'PmsController@PmsAsesmentView'); 
Route::GET('pms-assessment-view/{emp_id}/{year_id}', 'PmsController@PmsAssessmentView');  

/* Basic Reports Pronab */
Route::GET('all-total-staff-report', 'ReportBasicController@AllTotalStaffReport'); 
Route::GET('all-staff-report', 'ReportBasicController@AllStaffIndex'); 
Route::POST('all-staff-report', 'ReportBasicController@StaffReport'); 
Route::GET('branch-staff-report', 'ReportBasicController@BranchStaffIndex');
Route::POST('branch-staff-report', 'ReportBasicController@BranchStaffReport');
Route::GET('area-staff-report', 'ReportBasicController@AreaStaffIndex');
Route::POST('area-staff-report', 'ReportBasicController@AreaStaffReport');
Route::GET('staff-type-report', 'ReportBasicController@StaffTypeIndex');
Route::POST('staff-type-report', 'ReportBasicController@StaffTypeReport'); 
Route::GET('employee-status', 'ReportBasicController@EmpStatusIndex');
Route::POST('employee-status', 'ReportBasicController@EmpStatusReport'); 
Route::GET('staff-joining', 'ReportBasicController@StaffJoiningIndex');
Route::POST('staff-joining', 'ReportBasicController@StaffJoiningReport');
Route::GET('district-staff-report', 'ReportBasicController@DistrictStaffIndex');
Route::POST('district-staff-report', 'ReportBasicController@DistrictStaffReport');
Route::GET('staff-join-drop', 'ReportBasicController@StaffJoinDropIndex');
Route::POST('staff-join-drop', 'ReportBasicController@StaffJoinDropReport');
Route::GET('designation-staff-report', 'ReportBasicController@DesignationStaffIndex');
Route::POST('designation-staff-report', 'ReportBasicController@DesignationStaffReport');
Route::GET('am-bm-report', 'ReportBasicController@AmBmStaffIndex');
Route::POST('am-bm-report', 'ReportBasicController@AmBmStaffReport');
Route::GET('all-report', 'ReportBasicController@AllTotalIndex');
Route::POST('all-report', 'ReportBasicController@AllTotalReport');
Route::GET('basic-salary-report', 'ReportBasicController@BasicSalaryIndex');
Route::POST('basic-salary-report', 'ReportBasicController@BasicSalaryReport');
Route::GET('transfer-history', 'ReportBasicController@TransferHistoryIndex');
Route::POST('transfer-history', 'ReportBasicController@TransferHistoryReport');
Route::GET('area-staff-no', 'ReportBasicController@AreaStaffNoIndex');
Route::POST('area-staff-no', 'ReportBasicController@AreaStaffNoReport');
Route::GET('final-clearence', 'ReportBasicController@FinalClearenceIndex');
Route::POST('final-clearence', 'ReportBasicController@FinalClearenceReport');
Route::get('/emp_type_designation/{emp_type}','ReportBasicController@EmpTypeDesignation');
Route::GET('branch-designation-report', 'ReportBasicController@BranchDesignationIndex');
Route::POST('branch-designation-report', 'ReportBasicController@BranchDesignationReport');
Route::GET('department-report', 'ReportBasicController@DepartmentStaffIndex');
Route::POST('department-report', 'ReportBasicController@DepartmentStaffReport');
Route::GET('branch-view-report', 'ReportBasicController@BranchViewReport');
Route::GET('program-report', 'ReportBasicController@ProgramStaffIndex');
Route::POST('program-report', 'ReportBasicController@ProgramStaffReport');
/* Employee Turnover Report */
Route::GET('employee_turnover_report', 'ReportBasicController@EmployeeTurnoverIndex');
Route::POST('employee_turnover_report', 'ReportBasicController@EmployeeTurnoverReport');
 
Route::resource('dropout-staff', 'DropoutStaffController');
Route::POST('dropout-staff', 'DropoutStaffController@DropoutReport');
Route::GET('district-no-staff', 'ReportBasicController@DistrictTotalStaffIndex');
Route::POST('district-no-staff', 'ReportBasicController@DistrictTotalStaffReport');
Route::GET('file-move-report', 'ReportBasicController@FileMoveReportIndex');
Route::POST('file-move-report', 'ReportBasicController@FileMoveReport');
Route::get('/GetBMAMDM/{br_code}','ReportBasicController@GetBMAMDM');

Route::get('user_manu_report', 'MenusController@user_manu_report');

/* Transactional Reports Pronab */
Route::GET('probation-report', 'ReportTransactionalController@probationIndex');
Route::POST('probation-report', 'ReportTransactionalController@probationReport');
Route::GET('permanent-report', 'ReportTransactionalController@permanentIndex');
Route::POST('permanent-report', 'ReportTransactionalController@permanentReport');
Route::GET('increment-report', 'ReportTransactionalController@incrementIndex');
Route::POST('increment-report', 'ReportTransactionalController@incrementReport');
Route::GET('promotion-report', 'ReportTransactionalController@promotionIndex');
Route::POST('promotion-report', 'ReportTransactionalController@promotionReport');
Route::GET('transfer-report', 'ReportTransactionalController@transferIndex');
Route::POST('transfer-report', 'ReportTransactionalController@transferReport');
Route::GET('other-report', 'ReportTransactionalController@otherIndex');
Route::POST('other-report', 'ReportTransactionalController@otherReport');
Route::GET('resignation-report', 'ReportTransactionalController@resignationIndex');
Route::POST('resignation-report', 'ReportTransactionalController@resignationReport');
Route::GET('heldup-report', 'ReportTransactionalController@heldupIndex');
Route::POST('heldup-report', 'ReportTransactionalController@heldupReport');
Route::GET('next-incre-report', 'ReportTransactionalController@NextIncrementIndex');
Route::POST('next-incre-report', 'ReportTransactionalController@NextIncrementReport');
Route::GET('punishment-report', 'ReportTransactionalController@PunishmentIndex');
Route::POST('punishment-report', 'ReportTransactionalController@punishmentReport');
Route::GET('demotion-report', 'ReportTransactionalController@DemotionIndex');
Route::POST('demotion-report', 'ReportTransactionalController@DemotionReport');
Route::get('/grade-history/{emp_id}','ReportTransactionalController@GradeDetailsReport');
Route::GET('sacmo-salary-review-report', 'ReportTransactionalController@SalaryReviewIndex');
Route::POST('sacmo-salary-review-report', 'ReportTransactionalController@SalaryReviewReport');
Route::GET('contractual-report', 'ReportTransactionalController@ContractualIndex');
Route::POST('contractual-report', 'ReportTransactionalController@ContractualReport');

/* Service Length Reports Pronab */
Route::GET('org-service-length', 'ReportServiceLengthController@orgServicesIndex');
Route::POST('org-service-length', 'ReportServiceLengthController@orgServicesReport');
Route::GET('grade-service-length', 'ReportServiceLengthController@gradeServicesIndex');
Route::POST('grade-service-length', 'ReportServiceLengthController@gradeServicesReport');

//Auto Promotion
Route::GET('auto-promotion', 'AutopromotionController@Index');
Route::POST('auto-promotion', 'AutopromotionController@Report');
//end Auto Promotion


/* Branch/HO Designation wise all staff report for mis */
Route::GET('all-staff-mis-reports', 'ReportMisController@BranchWiseMisIndex');
Route::POST('all-staff-mis-reports', 'ReportMisController@BranchWiseMisReport');

/* Auto Increment Check */
Route::GET('increment-staff-check', 'ReportMisController@AutoIncrementIndex');
Route::POST('increment-staff-check', 'ReportMisController@AutoIncrementReport');

/* Staff Strength Organization Report */
Route::GET('staff-info-glance', 'ReportServiceLengthController@StaffInfoGlanceIndex');
Route::POST('staff-info-glance', 'ReportServiceLengthController@StaffInfoGlanceReport');
Route::get('/emp_type_designation_group/{emp_group}', 'ReportServiceLengthController@EmpTypeDesignationGroup');

/* POMIS-3 Report */
Route::GET('pomis_three_report', 'ReportServiceLengthController@PomisThreeIndex');

Route::GET('pomis_getno_branch/{date_within}', 'ReportServiceLengthController@pomis_getno_branch');
Route::POST('pomis_three_report', 'ReportServiceLengthController@PomisThreeReport');

Route::GET('pomis_three_reportprowise', 'ReportServiceLengthController@PomisThreeIndexprojectwise');
Route::POST('pomis_three_reportprowise', 'ReportServiceLengthController@PomisThreeReportprojectwise');

/* Project wise staff report */
Route::GET('project-branch-staff', 'ReportServiceLengthController@ProjectBranchStaffIndex');
Route::POST('project-branch-staff', 'ReportServiceLengthController@ProjectBranchStaffReport');
Route::GET('project_branch_staff', 'ReportServiceLengthController@ProjectBranchIndex');
Route::POST('project_branch_staff', 'ReportServiceLengthController@ProjectBranchReport');
Route::POST('project-staff-save', 'ReportServiceLengthController@ProjectStaffSave');

/* Final Payment */
Route::resource('final-payment', 'FinalPaymentController');
Route::POST('final-payment', 'FinalPaymentController@FinalPaymentReport');
Route::POST('final-payment-insert', 'FinalPaymentController@FinalPaymentInsert');
Route::GET('fp_file_info', 'FinalPaymentController@fpfileInfo');
Route::GET('fp_file_info_create', 'FinalPaymentController@fpfileInfoCreate');
Route::get('/get_emp_name/{fp_emp_id}','FinalPaymentController@get_employee_name');
Route::POST('fp_file_info_insert', 'FinalPaymentController@fpfileInfoInsert');
Route::get('/update_fp_status/{id}', 'FinalPaymentController@fpfileStatus');
Route::get('/fp_file_resend/{id}', 'FinalPaymentController@fpfileResend');
Route::get('/delete_fp_status/{id}/{fp_emp_id}', 'FinalPaymentController@fpfileDelete');




Route::get('/get-transfer-info/{emp_id}/{q_type}','TransfersController@get_transfer_info');

Route::resource('/salary-adjustment', 'Salary_adjustmentController'); 
 


//Route::resource('/migration', 'MigrationController'); 
Route::get('/migration','MigrationController@index');
Route::get('/myWork','MigrationController@myWork');
Route::get('/department','MigrationController@department');


Route::POST('/all-appoinments','AppoinmentController@allappoinments');
Route::POST('/all-cv','EmployeeController@all_cv');
Route::POST('/all-appointletter','AppointletterController@all_appoint_letter');
Route::POST('/all-probation','ProbationController@all_probation');
Route::POST('/all-permanent','PermanentController@all_permanent');
Route::POST('/all-increment','IncrementController@all_increment');
Route::POST('/all-promotion','PromotionController@all_promotion');
Route::POST('/all-punishment','PunishmentController@all_punishment');
Route::POST('/all-transfer','TransfersController@all_transfer');
Route::POST('/all-heldup','HeldupController@all_heldup');
Route::POST('/all-salary','Emp_salaryController@all_salary');


//// Saiful Recruitment


Route::get('/recruitment', 'RecruitmentController@index');
Route::get('/recruitment_view/{recruitment_id}', 'RecruitmentController@recruitment_view');
Route::get('/select_circular_date/{circuler_id}/{post_id}', 'RecruitmentController@select_circular_date');
Route::get('/select_circular_post/{circuler_id}', 'RecruitmentController@select_circular_post');
Route::get('/add-recruit', 'RecruitmentController@AddRecruit');
Route::POST('/store-recruit', 'RecruitmentController@StoreRecruit');
Route::get('edit-recruit/{id}/{tab_id}', 'RecruitmentController@EditRecruit');
Route::POST('/update-recruit/{id}','RecruitmentController@UpdateRecruit');
Route::POST('/recruit-edu','RecruitmentController@RecruitEdu');
Route::POST('/recruit-training','RecruitmentController@RecruitTraining');
Route::POST('/recruit-experience','RecruitmentController@RecruitExperience'); 
Route::get('/delete_recruit/{id}', 'RecruitmentController@delete_recruit');
Route::get('/circular', 'CircularController@index');
Route::get('/circular-add', 'CircularController@CircularAdd');
Route::POST('/circular-store', 'CircularController@CircularStore');
Route::get('/edit-circular/{id}', 'CircularController@CircularEdit');
Route::POST('/update-circular/{id}', 'CircularController@CircularUpdate');
Route::get('/circular-post', 'CircularController@IndexPost');
Route::get('/post-add', 'CircularController@PostAdd');
Route::POST('/post-store', 'CircularController@PostStore');
Route::get('/edit-post/{id}', 'CircularController@PostEdit');
Route::POST('/update-post/{id}', 'CircularController@PostUpdate');

Route::get('/recruitment_report','Recruitment_reportsController@index');
Route::POST('/recruitment_show_report','Recruitment_reportsController@recruitment_show_report');

// requisition
Route::post('rpt_dairy_calender_post/', 'RequisitiondairycalenderController@rpt_dairy_calender_post');
Route::post('rpt_dairy_calender_ind_post/', 'RequisitiondairycalenderController@rpt_dairy_calender_ind_post');
Route::get('rpt_dairy_calender/', 'RequisitiondairycalenderController@rpt_dairy_calender');
Route::get('rpt_dairy_calender_ind/', 'RequisitiondairycalenderController@rpt_dairy_calender_ind');
Route::get('requisition_can_dairy/', 'RequisitiondairycalenderController@requisition_can_dairy');
Route::get('requisition_update/', 'RequisitiondairycalenderController@requisition_update');
Route::get('requisition_create/', 'RequisitiondairycalenderController@requisition_create');
Route::POST('update_dairy_calender/', 'RequisitiondairycalenderController@update_dairy_calender');
Route::POST('insert_dairy_calender/', 'RequisitiondairycalenderController@insert_dairy_calender');

// shoesize
Route::get('shoesize/', 'ShoesizeController@shoesize');
Route::get('shoesize_update/', 'ShoesizeController@shoesize_update');
Route::get('shoesize_create/', 'ShoesizeController@shoesize_create');
Route::POST('insert_shoesize/', 'ShoesizeController@insert_shoesize');
Route::POST('update_shoesize/', 'ShoesizeController@update_shoesize');
Route::get('shoe_size_rprt/', 'ShoesizeController@shoe_size_rprt');
Route::post('shoe_size_rprt_post/', 'ShoesizeController@shoe_size_rprt_post');
// requisition Organization

Route::get('requisition_can_dairy_org/', 'RequisitiondairycalenderOrgController@requisition_can_dairy_org'); 
Route::get('requisition_update_org/{desig_group_code}', 'RequisitiondairycalenderOrgController@requisition_update_org');
Route::get('requisition_create_org/', 'RequisitiondairycalenderOrgController@requisition_create_org');
Route::POST('requisition_search_emp_info/', 'RequisitiondairycalenderOrgController@requisition_search_emp_info');
Route::POST('update_dairy_calender_org/', 'RequisitiondairycalenderOrgController@update_dairy_calender_org');
Route::POST('insert_dairy_calender_org/', 'RequisitiondairycalenderOrgController@insert_dairy_calender_org');

// Experience certificate

Route::resource('testimony', 'TestimonyController');
Route::get('testimonyadd/', 'TestimonyController@testimonyadd'); 
Route::get('testimonial_delete/{id}', 'TestimonyController@testimonial_delete');
Route::get('testimony_view/{id}/{emp_id}', 'TestimonyController@testimony_view');
Route::POST('emp_info_testimony', 'TestimonyController@emp_info_testimony');
Route::POST('insert_emp_testimony', 'TestimonyController@insert_emp_testimony');
Route::get('/duplicate_certificate_check/{emp_id}', 'TestimonyController@duplicate_certificate_check');
Route::get('/testimony_print/{get_id}/{emp_id}', 'TestimonyController@testimony_print');

Route::get('certi_general/', 'TestimonyController@certi_general');   
Route::get('testimony_view_gen/{id}/{emp_id}', 'TestimonyController@testimony_view_gen');
Route::get('testimonyadd_gen/', 'TestimonyController@testimonyadd_gen'); 
Route::POST('emp_info_testimony_gen/', 'TestimonyController@emp_info_testimony_gen');
Route::POST('insert_emp_testimony_gen/', 'TestimonyController@insert_emp_testimony_gen');
Route::get('/testimony_print_gen/{get_id}/{emp_id}', 'TestimonyController@testimony_print_gen');
//Salary update

Route::GET('salary-up', 'Emp_salaryController@salary_update');
Route::POST('salary-up', 'Emp_salaryController@salary_update');


Route::GET('next-incre-auto', 'NextIncrementGenerateController@NextIncrementIndex');
Route::POST('next-incre-auto', 'NextIncrementGenerateController@NextIncrementReport');
Route::POST('next-incre-auto-generate', 'NextIncrementGenerateController@NextIncrementGenerate');

Route::GET('next-get_br_employee', 'IncrementlistbranchwiseController@get_br_employee');
Route::GET('next-incre-list', 'IncrementlistbranchwiseController@bra_increment_list2');
Route::POST('next-incre-list', 'IncrementlistbranchwiseController@bra_increment_list2');


//Route::GET('edms', 'NextIncrementGenerateController@edms');
Route::GET('edms_file', 'NextIncrementGenerateController@edms_file');
Route::GET('undo_increment', 'NextIncrementGenerateController@undo_increment');

Route::get('/remove_increment/{emp_id}', 'NextIncrementGenerateController@remove_increment');
Route::get('/increment_statement', 'NextIncrementGenerateController@increment_statement');
Route::get('/set_extra_mobile', 'NextIncrementGenerateController@set_extra_mobile');
Route::get('increment_basic_report_fin', 'NextIncrementGenerateController@increment_basic_report');

Route::resource('leave-appliacation','LeaveController');
Route::POST('/all-leave_application','LeaveController@all_leave_application');
Route::POST('/leave-appliacation-modify', 'LeaveController@appliacation_modify');

Route::resource('travel','TravelController');
Route::POST('/all-travels','TravelController@all_travels');


//Route::get('/get_loan_details_by_id/{id}','ProfileController@getLoanDetailsById');


//Notification
Route::GET('probations', 'NotificationController@probationRemainder');
Route::GET('confirmation', 'NotificationController@confirmationRemainder');
Route::GET('retirement', 'NotificationController@retirementRemainder');
Route::GET('contract', 'NotificationController@contractRemainder');

/*
Route::GET('force_mail', 'NotificationController@forceRemainder');
Route::GET('force_ret', 'NotificationController@forceretRemainder');
*/
/**
 * MAKE ROUTES FOR Branch_locations
 */
Route::get( '/branch_locations', 'Branch_locationsController@index' );
Route::post( '/save_branch_locations', 'Branch_locationsController@saveBranch_locations' );
Route::patch( '/update_branch_locations', 'Branch_locationsController@updateBranch_locations' );
Route::get( '/location_report', 'Branch_locationsController@locationsReport' );
Route::post( '/show_data', 'Branch_locationsController@showInformation' );
Route::get( '/details_report', 'Branch_locationsController@detailsReport' );
Route::post( '/details_report', 'Branch_locationsController@pdetailsReport' );
Route::get( '/tree_report', 'Branch_locationsController@treeReport' );
Route::get( '/map_report', 'Branch_locationsController@mapReport' );

Route::post( '/branch_locations_report', 'Branch_locationsController@searchReport' );
Route::get( '/branch_locations_report', 'Branch_locationsController@branchLocationsReport' );
Route::post( '/zone_wise_area', 'Branch_locationsController@zoneWiseArea' );
Route::post( '/area_wise_branch', 'Branch_locationsController@areaWiseBranch' );
Route::get( '/app_data', 'Branch_locationsController@app_data');
Route::get( '/branch_information', 'Branch_locationsController@branch_information');
Route::get( '/select-cibupazila/{dis_code}', 'Branch_locationsController@SelectUpazila');
Route::get( '/area_zone_data', 'Branch_locationsController@area_zone_data');
/**
 * MAKE ROUTES FOR Branch_locations
 */

/// payroll task

Route::get( '/payrol_task', 'Payroll_taskController@index');
Route::POST( '/save_task_hr', 'Payroll_taskController@save_task_hr');


 /// branch wise register report
 
Route::get('/branch_wise_register/','BranchwiseregisterreportController@index');
Route::POST('/branch_wise_register_post/','BranchwiseregisterreportController@branch_wise_register_post');
 
/// vat tax  
Route::get('/vat_tax_branch_staff/{emp_id}/{emp_type_hr}', 'ApitaxvatController@vat_tax_branch_staff' );

// Blood Report
Route::GET('all-blood-report', 'ReportBasicController@AllBloodIndex');  
Route::POST('all-blood-report', 'ReportBasicController@BloodReport');

Route::GET('/national_db', 'SuperAdminController@branch_info_national_db');


//Mail Test
Route::GET('/testmail', 'ProfileController@testmail');

/* Grade Unnoyon Report */
Route::any('grade_unnoyon_report', 'ReportBasicController@grade_unnoyon_report');

// Data Pull From Attendence Machine 
Route::GET('/data_pull', 'SuperAdminController@datapull');
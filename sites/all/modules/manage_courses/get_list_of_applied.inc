<?php
function get_list_of_applied_student1(){
global $base_url;

drupal_add_css(".mid .left-panel-box{ display:none;}", 'inline');
drupal_add_css(".mid .full-right-panel{ width:100%!important;}", 'inline');
$result = db_select('application_form_table', 'pt')
    ->fields('pt')
	->orderBy('pt.form_submit_on', 'DESC')
    ->execute();
$teable="<input type='text' class='myField1' id='myInput' onkeyup='mySearchFunction()' placeholder='Search for names..'><input class='myField1' type='text' id='myInputDAte' onkeyup='mySearchDAteFunction()' placeholder='Search for date..'><input class='myField1' type='text' id='myInputEmail' onkeyup='mySearchEmailFunction()' placeholder='Search for Email address..'><input class='myField1' type='text' id='myInputContact' onkeyup='mySearchContactFunction()' placeholder='Search for contact no...'><select class='myField1' id='Ultra' onchange='run()'><option value=''>Select for Filter</option><option value='1'>Valid</option><option value='0'>Not Valid</option></select> <table id='example' class='display' width='100%' cellspacing='0'><thead><tr><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Sr. No.</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Applicant Name</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Form Submit On</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Email Address</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Payment</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Contact No.</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Operation</th></tr></thead><tbody>";	
$i = 0;
foreach($result as $i=>$val){
$count = $i  + 1;
            // echo "<pre>"; print_r($val); echo"</pre>"; 
            $getid=$val->id;  
            $submittion=$val->submittion;
			$project_category=$val->project_category;
			$name_of_applicant=$val->name_of_applicant;
			$gardion_of_applicant=$val->gardion_of_applicant; 
			$date_of_birth=$val->date_of_birth;
			$age_of_applicant_on_date_of_submittion=$val->age_of_applicant_on_date_of_submittion;
			$cast_category=$val->cast_category;
			$gender=$val->gender;
			$postal_address=$val->postal_address;
			$phone_number=$val->phone_number;
			$email_id=$val->email_id;
			$course_id=$val->course_id;
			$permanent_address=$val->permanent_address;
			$sponsoring_department_address=$val->sponsoring_department_address; 
			$post_hald_at_present=$val->post_hald_at_present;
			$examination_passed=$val->examination_passed;
			$subject=$val->subject;
			$marks=$val->marks;
			$year_of_passing=$val->year_of_passing;
			$percentage_grade_of_marks=$val->percentage_grade_of_marks;
			$name_board=$val->name_board;
			$pc_examination_passed=$val->pc_examination_passed;
			$pc_subject=$val->pc_subject;
			$pc_marks=$val->pc_marks;
			$pc_year_of_passing=$val->pc_year_of_passing;
			$pc_percentage_grade_of_marks=$val->pc_percentage_grade_of_marks;
			$pc_name_board=$val->pc_name_board;
			$file_upload_path=$val->file_upload_path;
			$amountPaid=$val->amountPaid;
			$course_applied_for_code=$val->course_applied_for_code;
			$form_submit_on=$val->form_submit_on;
			$valid=$val->valid;
			$checkbox = isset($valid) ? $valid : 0 ;
			$checkDisplay=$checkbox;
			if($valid=='1'){
			$checkDisplayMark='checked';
			}
			if($valid=='0'){
			$checkDisplayMark1='checked';
			}
			if($amountPaid!=""){
			    $getAmount= 'Success'; 
			}
			else{
			    $getAmount= 'Failure'; 
			}
			
			$getPath=$base_url.'/node/650?getid='.$getid;
			$post_link=$base_url.'/result.php';
	$teable.="<tr><td style='padding:10px;'>".$count."</td><td style='padding:10px;'><a href='".$getPath."' rel='lightframe[]' >".$name_of_applicant."</a></td><td style='padding:10px;'>".$form_submit_on."</td><td style='padding:10px;'>".$email_id."</td><td style='padding:10px;'>".$getAmount."</td><td style='padding:10px;'>".$phone_number."</td><td style='padding:10px;'><form method='post' action='".$post_link."'><div id='myinputs' style='float: left;'><input type='hidden' name='hiddenid' value='".$getid."' id='hiddenid'><input type='hidden' name='hiddenid1' value='".$valid."' id='hidden1'><input id='myradio' type='radio' name='valid' value='1' ".$checkDisplayMark."> Valid For Submittion<br><input id='myradio' type='radio' name='valid' value='0' ".$checkDisplayMark1.">Not Valid For Submittion<br></div><div id='mysubmit' style=''><input style='margin: 0 auto;margin-left: 17px;margin-top: 8px;' type='submit' name='submit' value='submit'></div></form></td></tr>";
	  //$i++;
	}
	$teable.="</tbody></table>";
	
		return $teable; 
}
<style type="text/css">
#admin-menu{
display:none;
}
div#imageDataContainer,#imageData #bottomNav {
    display: none!important;
}
th {
    background: steelblue none repeat scroll 0 0;
    color: #ffffff!important;
    font-weight: bold;
    padding-bottom: 10px;
    padding-left: 9px;
    padding-top: 10px;
	width: 50%;
}
td {
    padding: 10px;
}
#header-fixed { 
    position: fixed; 
    top: 0px; 
	display:none;
    width: 100%;
}
h2 {
    color: steelblue;
    font-size: 126%;
    font-weight: bold;
    margin: 19px;
    text-align: center;
}
 
</style>
<script type="text/javascript">
$( document ).ready(function() {
var tableOffset = $("#table-1").offset().top;
var $header = $("#table-1 > thead").clone();
var $fixedHeader = $("#header-fixed").append($header);
$("#imageDataContainer").css('height','1px');
$(window).bind("scroll", function() {
    var offset = $(this).scrollTop();
    
    if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
        $fixedHeader.show();
    }
    else if (offset < tableOffset) {
        $fixedHeader.hide();
    }
});
});
</script>
<?php
error_reporting(0);
$getId=$_GET['getid'];
$result = db_select('application_form_table', 'pt')
    ->fields('pt')
     ->condition('pt.id', $getId,'=')
	->execute();
foreach($result as $val){
//  echo "<pre>"; print_r($val); echo"</pre>";
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
			//$pc_examination_passed=$val->pc_examination_passed;
			//$pc_subject=$val->pc_subject;
			//$pc_marks=$val->pc_marks;
			//$pc_year_of_passing=$val->pc_year_of_passing;
			//$pc_percentage_grade_of_marks=$val->pc_percentage_grade_of_marks;
			//$pc_name_board=$val->pc_name_board;
			$file_upload_path=$val->file_upload_path;
			$amountPaid=$val->amountPaid;
			$course_applied_for_code=$val->course_applied_for_code;
			$form_submit_on=$val->form_submit_on;
	}
?>
<div>
<h2>Applicant Details</h2>
<table id="table-1">
<thead>
<tr>
<th>Details</th>
<th>Values Submitted by Applicant</th>
</tr>
</thead>
<tr>
<td>
Applicant Name
</td>
<td>
<?php echo $name_of_applicant;?>
</td>
</tr>
<tr>
<td>
Course Category
</td>
<td>
<?php echo $project_category;?>
</td>
</tr>
<tr>
<td>
Gardion Name 
</td>
<td>
<?php echo $gardion_of_applicant;?>
</td>
</tr>
<tr>
<td>
date_of_birth
</td>
<td>
<?php echo $date_of_birth;?>
</td>
</tr>
<tr>
<td>
age_of_applicant_on_date_of_submittion
</td>
<td>
<?php echo $age_of_applicant_on_date_of_submittion;?>
</td>
</tr>
<tr>
<td>
cast_category
</td>
<td>
<?php echo $cast_category;?>
</td>
</tr>
<tr>
<td>
gender
</td>
<td>
<?php echo $gender;?>
</td>
</tr>
<tr>
<td>
postal_address
</td>
<td>
<?php echo $postal_address;?>
</td>
</tr>
<tr>
<td>
phone_number
</td>
<td>
<?php echo $phone_number;?>
</td>
</tr>
<tr>
<td>
email_id
</td>
<td>
<?php echo $email_id;?>
</td>
</tr>
<tr>
<td>
permanent_address
</td>
<td>
<?php echo $permanent_address;?>
</td>
</tr>
<tr>
<td>
sponsoring_department_address
</td>
<td>
<?php echo $sponsoring_department_address;?>
</td>
</tr>
<tr>
<td>
post_hald_at_present
</td>
<td>
<?php echo $post_hald_at_present;?>
</td>
</tr>
<tr>
<td>
examination_passed
</td>
<td>
<?php echo $examination_passed;?>
</td>
</tr>
<tr>
<td>
subject
</td>
<td>
<?php echo $subject;?>
</td>
</tr>
<tr>
<td>
marks
</td>
<td>
<?php echo $marks;?>
</td>
</tr>
<tr>
<td>
year_of_passing
</td>
<td>
<?php echo $year_of_passing;?>
</td>
</tr>
<tr>
<td>
percentage_grade_of_marks
</td>
<td>
<?php echo $percentage_grade_of_marks;?>
</td>
</tr>
<tr>
<td>
name_board
</td>
<td>
<?php echo $name_board;?>
</td>
</tr>
<tr>
<td>
form_submit_on
</td>
<td>
<?php echo $form_submit_on;?>
</td>
</tr>
<tr>
<td>
amountPaid
</td>
<td>
<?php echo $amountPaid;?>
</td>
</tr>
</table>
<table id="header-fixed"></table>
</div>

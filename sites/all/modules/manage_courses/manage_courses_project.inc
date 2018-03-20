<?php
function manage_course_list(){
global $base_url;
$result = db_select('manage_courses', 'pt')
    ->fields('pt')
    ->execute();
$table="<table><thead><tr><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Course Applied Category</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Course Name</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Close Date</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Status</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Price</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Course Code</th><th style='background: #35e5fc none repeat scroll 0 0;color: #ffff;font-size: 13px;font-weight: bold;padding-bottom: 10px;padding-top: 10px;'>Operations</th></tr></thead><tbody>";
foreach($result as $val){
    $get_cource_id=$val->id;
	$get_cource_applied_category=$val->cource_applied_category;
	$get_cource_term=$val->cource_term;
	$get_date=$val->date;
	$get_status=$val->status;
	$get_price=$val->price;
	$get_course_code=$val->course_code;
	if($get_status=="1"){
	$status="Inactive";
	}
	else{
	$status="Active";
	}
	$table.="<tr><td style='padding: 11px;'>".$get_cource_applied_category."</td><td style='padding: 11px;'>".$get_cource_term."</td><td style='padding: 11px;'>".$get_date."</td><td style='padding: 11px;'>".$status."</td><td style='padding: 11px;'> Rs ".$get_price."</td><td>".$get_course_code."</td><td style='padding: 11px;'><a href='".$base_url."/manage_courses/?id=".$get_cource_id."'>Update</a>|<a href='".$base_url."/manage_courses/?deleteid=".$get_cource_id."'>Delete</a></td></tr>";
	}
	$table.="</tbody></table>";
	
		return $table;
}
function manage_courses_management_form($form, &$form_state) {
$path = request_uri();
if (strpos($path, '?')) {
$path_explode=explode('?',$path);
$getpathAttribute=$path_explode['1'];
$path_explode1=explode('=',$getpathAttribute);
$checkid=$path_explode1['0'];
if($checkid =='id'){
$getId=$path_explode1['1'];
$result = db_select('manage_courses', 'pt')
    ->fields('pt')
    ->condition('id', $getId,'=')
	->execute()
	->fetchAssoc();

$get_get_cource_applied_category=$result['cource_applied_category'];
$get_get_cource_term=$result['cource_term'];
$get_get_date=$result['date'];
$get_get_status=$result['status'];
$get_get_price=$result['price'];
$get_get_course_code=$result['course_code'];
 $form = array();
 $form['#tree'] = TRUE;
 $form['application_project'] = array(
    '#type' => 'fieldset',
    '#title' => t('Manage Courses'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
   $form['application_project']['cource_applied_category'] = array(
  '#type' => 'textfield',
  '#title' => t('Category'),
  '#default_value' =>$get_get_cource_applied_category,
  '#description' => t('The selected category will be shown by default on listing pages.'),
);
 $form['application_project']['subject_code'] = array(
  '#type' => 'textfield',
  '#title' => t(''),
  '#default_value' =>$get_get_cource_term,
  '#description' => t('The selected course.'),
);
$form['application_project']['display_date'] = array(
    '#type' => 'date_popup',
    '#timepicker' => 'timepicker',
	'#default_value' =>$get_get_date,
    
  );
  
$ststus=array(Active,InActive);  
$form['application_project']['status'] = array(
  '#type' => 'select',
  '#title' => t(''),
  '#options' => $ststus,
  '#default_value' =>$get_get_status,
  '#description' => t('The selected course.'),
 
);  
$form['application_project']['subject_code_code'] = array(
  '#type' => 'textfield',
  '#title' => t('Course Code'),
  '#default_value' =>$get_get_course_code,
);
$form['application_project']['price'] = array(
    '#type' => 'textfield',
	'#title' => t('Price'),
	'#default_value' =>$get_get_price,
  );  
  $form['application_project']['submit'] = array(
			'#type' => 'submit',
			'#value' => 'update', 
			'#submit'=>array('manage_courses_update_management_form_submit'),
			);	
}
if($checkid =='deleteid'){
$getId=$path_explode1['1'];
$result = db_select('manage_courses', 'pt')
    ->fields('pt')
    ->condition('id', $getId,'=')
	->execute()
	->fetchAssoc();

$get_get_cource_applied_category=$result['cource_applied_category'];
$get_get_cource_term=$result['cource_term'];
$get_get_date=$result['date'];
$get_get_status=$result['status'];
$get_get_price=$result['price'];
$get_get_course_code=$result['course_code'];
 $form = array();
 $form['#tree'] = TRUE;
 $form['application_project'] = array(
    '#type' => 'fieldset',
    '#title' => t('Manage Courses'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
   $form['application_project']['cource_applied_category'] = array(
  '#type' => 'textfield',
  '#title' => t('Category'),
  '#default_value' =>$get_get_cource_applied_category,
  '#description' => t('The selected category will be shown by default on listing pages.'),
);
 $form['application_project']['subject_code'] = array(
  '#type' => 'textfield',
  '#title' => t(''),
  '#default_value' =>$get_get_cource_term,
  '#description' => t('The selected course.'),
);
$form['application_project']['display_date'] = array(
    '#type' => 'date_popup',
    '#timepicker' => 'timepicker',
	'#default_value' =>$get_get_date,
    
  );
  
$ststus=array(Active,InActive);  
$form['application_project']['status'] = array(
  '#type' => 'select',
  '#title' => t(''),
  '#options' => $ststus,
  '#default_value' =>$get_get_status,
  '#description' => t('The selected course.'),
 
); 
$form['application_project']['subject_code_code'] = array(
  '#type' => 'textfield',
  '#title' => t('Course Code'),
  '#default_value' =>$get_get_course_code,
);
$form['application_project']['price'] = array(
    '#type' => 'textfield',
	'#title' => t('Price'),
	'#default_value' =>$get_get_price,
  );   
  $form['application_project']['submit'] = array(
			'#type' => 'submit',
			'#value' => 'delete', 
			'#submit'=>array('manage_courses_delete_management_form_submit'),
			);	
}
}
else{
 $form = array();
 $form['#tree'] = TRUE;
 $form['application_project'] = array(
    '#type' => 'fieldset',
    '#title' => t('Manage Courses'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
   $form['application_project']['cource_applied_category'] = array(
  '#type' => 'select',
  '#title' => t('Category'),
  '#options' => MYMODULE_get_tax_term_options('cource_applied_for'),
  '#description' => t('The selected category will be shown by default on listing pages.'),
);
 $form['application_project']['subject_code'] = array(
  '#type' => 'select',
  '#title' => t(''),
  '#options' => MYMODULE_get_tax_term_options('application_from'),
  '#description' => t('The selected course.'),
);

$form['application_project']['display_date'] = array(
    '#type' => 'date_popup',
    '#timepicker' => 'timepicker',
    
  );

$ststus=array(Active,InActive);  
$form['application_project']['status'] = array(
  '#type' => 'select',
  '#title' => t(''),
  '#options' => $ststus,
  '#description' => t('The selected course.'),
); 
$form['application_project']['price'] = array(
    '#type' => 'textfield',
	'#title' => t('Price'),
  ); 
$form['application_project']['subject_code_code'] = array(
  '#type' => 'textfield',
  '#title' => t('Course Code'),
);  
  $form['application_project']['submit'] = array(
			'#type' => 'submit',
			'#value' => 'submit', 
			);
}			
return $form;
}
function MYMODULE_get_tax_term_options($machine_name){
$vid = taxonomy_vocabulary_machine_name_load($machine_name)->vid;
    
    $options_source = taxonomy_get_tree($vid);
    foreach($options_source as $item) {
        $key = $item->name;
        $value = $item->name;
		$options[$key] = $value;
    }
return $options;
}
function manage_courses_management_form_validate($form, &$form_state) {
 
}

function manage_courses_management_form_submit($form, &$form_state) {
$getValues=$form_state['values']['application_project'];
$getStatus=$getValues['status'];
$subject_code=$getValues['subject_code'];
$display_date=$getValues['display_date'];
$cource_applied_category=$getValues['cource_applied_category'];
$price=$getValues['price'];
$course_code=$getValues['subject_code_code'];
$data=db_insert('manage_courses')
          ->fields(array(
	      'cource_applied_category'=>$cource_applied_category,
          'cource_term' => $subject_code,
          'date' => $display_date,
		  'status' => $getStatus,
		  'price' => $price,
		  'course_code' =>$course_code,
  ));
  $data1=$data->execute();
   drupal_set_message(t('The form has been submitted.'));
 global $base_url;
 $makepath=$base_url.'/manage_courses_list';
    drupal_goto($makepath);
 
   }
function manage_courses_update_management_form_submit($form, &$form_state){
 
 $testvalue=$form_state['values'];
 //echo "<pre>"; print_r($testvalue); echo"</pre>"; exit;
    $path = request_uri();
	$path_explode=explode('?',$path);
	$getpathAttribute=$path_explode['1'];
	$path_explode1=explode('=',$getpathAttribute);
	$getId=$path_explode1['1'];
 $get_update_cource_applied_category=$testvalue['application_project']['cource_applied_category'];
 $get_update_subject_code=$testvalue['application_project']['subject_code'];
 $get_update_display_date=$testvalue['application_project']['display_date'];
 $get_update_status=$testvalue['application_project']['status'];
  $get_update_price=$testvalue['application_project']['price'];
  $get_update_course_code=$testvalue['application_project']['subject_code_code'];
 $num_updated = db_update('manage_courses') // Table name no longer needs {}
  ->fields(array(
    'cource_applied_category' => $get_update_cource_applied_category,
    'cource_term' =>$get_update_subject_code,
	'date' =>$get_update_display_date,
	'status' =>$get_update_status,
	'price' =>$get_update_price,
	'course_code' =>$get_update_course_code,
  ))
  ->condition('id',$getId,'=')
  ->execute();
     drupal_set_message(t('The form has been updated.'));
	 global $base_url;
 $makepath=$base_url.'/manage_courses_list';
    drupal_goto($makepath);
 }
 function manage_courses_delete_management_form_submit(){
 global $base_url;
 $makepath=$base_url.'/manage_courses_list';
   $testvalue=$form_state['values'];
    $path = request_uri();
	$path_explode=explode('?',$path);
	$getpathAttribute=$path_explode['1'];
	$path_explode1=explode('=',$getpathAttribute);
	$getDeleteId=$path_explode1['1'];
 db_delete('manage_courses')
  ->condition('id', $getDeleteId)
  ->execute();
   drupal_set_message(t('The record has been deleted.'));
   drupal_goto($makepath);
 }
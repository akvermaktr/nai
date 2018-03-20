<?php

function application_management_form($form, &$form_state) {
$Currenturl= request_uri();
echo "<pre>"; print_r($Currenturl); echo"</pre>";
$form = array();
  $form['description'] = array(
    '#type' => 'item',
    '#title' => t('Welcome On Application Page'),
  );
  $form['application_project'] = array(
    '#type' => 'fieldset',
    '#title' => t('Application Form'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  

  $form['application_project']['category-tex'] = array(
  '#type' => 'select',
  '#title' => t('Category'),
  '#type' => 'select',
  '#options' => MYMODULE_get_tax_term_options('application_from'),
  '#description' => t('The selected category will be shown by default on listing pages.'),
  '#required' => TRUE,
);
  $form['application_project']['applicant'] = array(
    '#type' => 'textfield',
    '#title' => t('Name of Applicant (In block letter)'),
    '#required' => TRUE,
  );
  
  $form['application_project']['spouse'] = array(
    '#type' => 'textfield',
    '#title' => t('Father’s/Mother’s/Husband’s/Spouse Name'),
    '#required' => TRUE,
  );
 
  $form['application_project']['date_of-birth'] = array(
        '#type' => 'date_select',
		'#title' => t('Date of Birth'),
		'#date_format' => 'dd-mm-Y',
		//'#date_format' => 'm',
		'#default_value' => $expirationDate,
		'#date_year_range' => '-40:+0',
		'#required' => TRUE,
		'#date_label_position' => 'within',
  );
  
  
  $form['application_project']['age'] = array(
    '#type' => 'textfield',
    '#title' => t('Age on last date of submission of Applications'),
    '#required' => TRUE,
  );
  $category = array(
  'general' => t('General'),
  'sc' => t('SC'),
  'st' => t('ST'),
  'ph' => t('PH'),
  'obc' => t('OBC')
  );
  $form['application_project']['category'] = array(
    '#type' => 'radios',
    '#title' => t('Category'),
	'#options' => $category,
    '#required' => TRUE,
  );

  $toppings = array(
  'male' => t('Male'),
  'female' => t('Female')
  );
  
  $form['application_project']['gender'] = array(
    '#type' => 'radios',
    '#title' => t('Gender'),
	'#options' => $toppings,
    '#required' => TRUE,
  );
  $form['application_project']['postal_address'] = array(
    '#type' => 'textarea',
    '#title' => t('Postal Address'),
    '#required' => TRUE,
  );
  $form['application_project']['phone_no'] = array(
    '#type' => 'textfield',
    '#title' => t('Phone No.'),
    '#required' => TRUE,
  );
  $form['application_project']['email'] = array(
    '#type' => 'textfield',
    '#title' => t('E-mail ID'),
    '#required' => TRUE,
  );
  
$form['application_project']['permanent_address'] = array(
    '#type' => 'textarea',
    '#title' => t('Permanent Address'),
    '#required' => TRUE,
  );
$form['application_project']['spouse_address'] = array(
    '#type' => 'textarea',
    '#title' => t(' Name & address of the Sponsoring Department'),
    '#required' => TRUE,
  );
$form['application_project']['spouse_address'] = array(
    '#type' => 'textarea',
    '#title' => t(' Name & address of the Sponsoring Department'),
    '#required' => TRUE,
  );
$form['application_project']['post_held_at_present'] = array(
    '#type' => 'textarea',
    '#title' => t('Post held at present'),
  );  
 
$form['application_project']['ac_qualification']= array(
    '#type' => 'fieldset',
    '#title' => t('Qualification'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
$form['application_project']['ac_qualification']['qualification']= array(
    '#type' => 'fieldset',
    '#title' => t('Academic qualification'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );  
$form['application_project']['ac_qualification']['qualification']['examination_passed']= array(
    '#type' => 'textfield',
    '#title' => t('Examination Passed'),
	'#required' => TRUE,
  );

$form['application_project']['ac_qualification']['qualification']['subjects_details']= array(
    '#type' => 'fieldset',
    '#title' => t('Subjects Details'),
    '#prefix' => '<div id="more_sub">',
    '#suffix' => '</div>',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );  

$form['application_project']['ac_qualification']['qualification']['subjects_details']['subject']= array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
	'#required' => TRUE,
  ); 
$form['application_project']['ac_qualification']['qualification']['subjects_details']['marks']= array(
    '#type' => 'textfield',
    '#title' => t('Marks'),
	'#required' => TRUE,
  );
$form['application_project']['ac_qualification']['qualification']['subjects_details']['add_more_subjects'] = array(
    '#type' => 'button',
    '#value' => 'Add More Subjects',
   // '#submit' => array('ajax_example_add_more_add_one'),
    '#ajax' => array(
      'callback' => 'add_more_sub',
      'wrapper' => 'more_sub',
      ),
  );
$form['application_project']['ac_qualification']['qualification']['passing_year']= array(
    '#type' => 'textfield',
    '#title' => t('Year of passing'),
    '#required' => TRUE,
  );
  
$form['application_project']['ac_qualification']['qualification']['marks_percentage']= array(
    '#type' => 'textfield',
    '#title' => t('Percentage/Grade Of Marks'),
	'#required' => TRUE,
  );
$form['application_project']['ac_qualification']['qualification']['board_university']= array(
    '#type' => 'textfield',
    '#title' => t('Name of Board/University'),
	'#required' => TRUE,
  );

$form['application_project']['qualification']['pc_qualification']= array(
    '#type' => 'fieldset',
    '#title' => t('Professional qualification'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );  
$form['application_project']['qualification']['pc_qualification']['examination_passed']= array(
    '#type' => 'textfield',
    '#title' => t('Examination Passed'),
	'#required' => TRUE,
  );
$form['application_project']['qualification']['pc_qualification']['subject']= array(
    '#type' => 'textfield',
    '#title' => t('Subject'),
	'#required' => TRUE,
  ); 
$form['application_project']['qualification']['pc_qualification']['passing_year']= array(
    '#type' => 'textfield',
    '#title' => t('Year of passing'),
    '#required' => TRUE,
  );
$form['application_project']['qualification']['pc_qualification']['marks']= array(
    '#type' => 'textfield',
    '#title' => t('Marks'),
    '#required' => TRUE,
  );  
$form['application_project']['qualification']['pc_qualification']['marks_percentage']= array(
    '#type' => 'textfield',
    '#title' => t('Percentage/Grade Of Marks'),
    '#required' => TRUE,
  );
$form['application_project']['qualification']['pc_qualification']['board_university']= array(
    '#type' => 'textfield',
    '#title' => t('Name of Board/University'),
	'#required' => TRUE,
  );
 $form['application_project']['file'] = array(
    '#type' => 'file',
    '#title' => t('Upload qualification document'),
    '#description' => t('Upload a file, allowed extensions: xls, doc, docx, xlsx, txt'),
  );  
 
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Submit',
  );
  return $form;
}

function add_more_sub($form, $form_state) {
  return $form['application_project']['ac_qualification']['qualification']['subjects_details'];
}
function MYMODULE_get_tax_term_options($machine_name)
	{
			   //echo $machine_name; exit;
				$options = array( '0' => 'Please Select Value');

				//$vid = taxonomy_vocabulary_machine_name_load($machine_name)->vid;
				//$options_source = taxonomy_get_tree($vid);
				//echo "<pre>"; print_r($options_source); echo"</pre>";
          $products = db_select('node', 'n')
      ->condition('type', 'product')
      ->fields('n');
     $options_source = $products->execute();
			
	foreach($options_source as $item ) {
   // echo "<pre>"; print_r($item); echo"</pre>";					
$key = $item->title;
$value = $item->title;
$options[$key] = $value;
				}
    return $options;
	}
function application_management_form_validate($form, &$form_state) {
$myvalues=$form_state['values'];
 //echo "<pre>"; print_r($myvalues);echo"</pre>"; exit;
 $nameofApplicant=$form_state['values']['applicant'];
 $spouse=$form_state['values']['spouse'];
 $age=$form_state['values']['age'];
 $email=$form_state['values']['email'];
$phone=$form_state['values']['phone_no'];
$emailMatch=valid_email_address($email);
//echo $emailMatch;
$phoneMatch=preg_match('/^[0-9]{10,}$/',$phone);
$nameofApplicantMatch=preg_match('/^[A-Z\s]+$/', $nameofApplicant);
$spouseMatch=preg_match('/^[A-Za-z\s]+$/', $spouse);
if($nameofApplicantMatch!="1"){
form_set_error('applicant', t('Please Enter Valid Name of Applicant'));
//return false;
}
if($spouseMatch!="1"){
form_set_error('spouse', t('Please Enter Valid Father’s/Mother’s/Husband’s/Spouse Name'));
//return false;
}
if($emailMatch !="1"){
form_set_error('email', t('Please Enter Valid Email'));
//return false;
}
if($phoneMatch !="1"){
form_set_error('phone_no', t('Please Enter Valid Phone Number'));
//return false;
}

 
   $file = file_save_upload('file', array(
  	'file_validate_is_image' => array(),
  	'file_validate_extensions' => array('xls doc docx xlsx txt'),
  ));
  if ($file) {
    if ($file = file_move($file, 'public://')) {
      $form_state['values']['file'] = $file;
    }
	
    else {
      form_set_error('file', t('Failed to write the uploaded file the site\'s file folder.'));
    }
	}
 
}

function application_management_form_submit($form, &$form_state) { 
$file=$form_state['values']['file'];
  if($file!=""){
  unset($form_state['values']['file']);
  $file->status = FILE_STATUS_PERMANENT;
  file_save($file);
  }
  drupal_set_message(t('The form has been submitted.'));
  $test=array(
      'shippable' => variable_get('uc_product_shippable_product', 1),
      'type' => 'product',
    );
 $val=$form_state['values']['category-tex'];	
$products = db_select('node', 'n')
      ->condition('type', 'product')
      ->condition('title',$val,'=')
      ->fields('n');
     $result = $products->execute()->fetchAssoc();
$mytitle=$result['title'];
$mynid=$result['nid'];
uc_cart_add_item($mynid , '1', $test, NULL, variable_get('uc_cart_add_item_msg', TRUE));
  drupal_goto('cart');
}

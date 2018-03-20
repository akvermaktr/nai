<?php

/**
 * @file
 * Demonstrations of AJAX with graceful degradation.
 */

/**
 * @defgroup ajax_degradation_example Example: AJAX Graceful Degradation
 * @ingroup examples
 * @{
 * These examples show AJAX with graceful degradation when Javascript is not
 * available.
 *
 * In each of these the key idea is that the form is rebuilt different ways
 * depending on form input. In order to accomplish that, the formbuilder
 * function is in charge of almost all logic.
 */

/**
 * Dropdown form based on previous choices.
 *
 * A form with a dropdown whose options are dependent on a choice made in a
 * previous dropdown.
 *
 * On changing the first dropdown, the options in the second
 * are updated. Gracefully degrades if no javascript.
 *
 * A bit of CSS and javascript is required. The CSS hides the "add more" button
 * if javascript is not enabled. The Javascript snippet is really only used
 * to enable us to present the form in degraded mode without forcing the user
 * to turn off Javascript.  Both of these are loaded by using the
 * #attached FAPI property, so it is a good example of how to use that.
 *
 * The extra argument $no_js_use is here only to allow presentation of this
 * form as if Javascript were not enabled. ajax_example_menu() provides two
 * ways to call this form, one normal ($no_js_use = FALSE) and one simulating
 * Javascript disabled ($no_js_use = TRUE).
 */
 
function ajax_example_add_more($form, &$form_state, $no_js_use = FALSE) {
//echo $getIdFromUrl;
 
$form = array();
 $form['#tree'] = TRUE;
  $form['#attached']['css'] = array(
    drupal_get_path('module', 'ajax_example') . '/ajax_example.css',
  );
  $form['#attached']['js'] = array(
    drupal_get_path('module', 'ajax_example') . '/ajax_example.js',
  );
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
  
);

  $form['application_project']['applicant'] = array(
    '#type' => 'textfield',
    '#title' => t('Name of Applicant (In block letter)'),
    
  );
  
  $form['application_project']['spouse'] = array(
    '#type' => 'textfield',
    '#title' => t('Father’s/Mother’s/Husband’s/Spouse Name'),
    
  );
 
  $form['application_project']['date_of-birth'] = array(
        '#type' => 'date_select',
		'#title' => t('Date of Birth'),
		'#date_format' => 'dd-mm-Y',
		//'#date_format' => 'm',
		'#default_value' => $expirationDate,
		'#date_year_range' => '-40:+0',
		
		'#date_label_position' => 'within',
  );
  
  
  $form['application_project']['age'] = array(
    '#type' => 'textfield',
    '#title' => t('Age on last date of submission of Applications'),
    
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
    
  );

  $toppings = array(
  'male' => t('Male'),
  'female' => t('Female')
  );
  
  $form['application_project']['gender'] = array(
    '#type' => 'radios',
    '#title' => t('Gender'),
	'#options' => $toppings,
    
  );
  $form['application_project']['postal_address'] = array(
    '#type' => 'textarea',
    '#title' => t('Postal Address'),
    
  );
  $form['application_project']['phone_no'] = array(
    '#type' => 'textfield',
    '#title' => t('Phone No.'),
    
  );
  $form['application_project']['email'] = array(
    '#type' => 'textfield',
    '#title' => t('E-mail ID'),
    
  );
  
$form['application_project']['permanent_address'] = array(
    '#type' => 'textarea',
    '#title' => t('Permanent Address'),
    
  );
$form['application_project']['spouse_address'] = array(
    '#type' => 'textarea',
    '#title' => t(' Name & address of the Sponsoring Department'),
    
  );
$form['application_project']['spouse_address'] = array(
    '#type' => 'textarea',
    '#title' => t(' Name & address of the Sponsoring Department'),
    
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
	
  );


  // Because we have many fields with the same values, we have to set
  // #tree to be able to access them.
 
  $form['application_project']['ac_qualification']['qualification']['subjects_details'] = array(
    '#type' => 'fieldset',
    '#title' => t('Subjects Details'),
    // Set up the wrapper so that AJAX will be able to replace the fieldset.
    '#prefix' => '<div id="names-fieldset-wrapper">',
    '#suffix' => '</div>',
  );

  // Build the fieldset with the proper number of names. We'll use
  // $form_state['num_names'] to determine the number of textfields to build.
  if (empty($form_state['num_names'])) {
    $form_state['num_names'] = 1;
  }
  for ($i = 0; $i < $form_state['num_names']; $i++) {
	  $form['application_project']['ac_qualification']['qualification']['subjects_details'][$i]['seriolno'] = array(
	      '#type' => 'textfield',
		  '#title' => t('s.no'),
		  '#default_value' => $i+1,
		 // '#prefix' => '<tr><td>',
		 // '#suffix' => '</td>'
	);
    $form['application_project']['ac_qualification']['qualification']['subjects_details'][$i]['subject'] = array(
      '#type' => 'textfield',
     '#title' => t('Subject'),
	// '#prefix' => '<td>',
   // '#suffix' => '</td>',
	 
    );
	$form['application_project']['ac_qualification']['qualification']['subjects_details'][$i]['marks']= array(
    '#type' => 'textfield',
    '#title' => t('Marks'),
   // '#prefix' => '<td>',
   // '#suffix' => '</td></tr>',
  );
  }
  $form['application_project']['ac_qualification']['qualification']['subjects_details']['add_more'] = array(
    '#type' => 'button',
    '#value' => t('Add one more'),
    '#submit' => array('ajax_example_add_more_add_one'),
    // See the examples in ajax_example.module for more details on the
    // properties of #ajax.
    '#ajax' => array(
      'callback' => 'ajax_example_add_more_callback',
      'wrapper' => 'names-fieldset-wrapper',
    ),
  );
  if ($form_state['num_names'] > 1) {
    $form['application_project']['ac_qualification']['qualification']['subjects_details']['remove_name'] = array(
      '#type' => 'button',
      '#value' => t('Remove one'),
      '#submit' => array('ajax_example_add_more_remove_one'),
      '#ajax' => array(
        'callback' => 'ajax_example_add_more_callback',
        'wrapper' => 'names-fieldset-wrapper',
      ),
    );
  }
 
$form['application_project']['ac_qualification']['qualification']['passing_year']= array(
    '#type' => 'textfield',
    '#title' => t('Year of passing'),
   
  );
  
$form['application_project']['ac_qualification']['qualification']['marks_percentage']= array(
    '#type' => 'textfield',
    '#title' => t('Percentage/Grade Of Marks'),
	
  );
$form['application_project']['ac_qualification']['qualification']['board_university']= array(
    '#type' => 'textfield',
    '#title' => t('Name of Board/University'),
	
  );

$form['qualif']= array(
    '#type' => 'fieldset',
    '#title' => t('Professional qualification'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );  
$form['qualif']['examination_passed']= array(
    '#type' => 'textfield',
    '#title' => t('Examination Passed'),
	
  );

$form['qualif']['pc_qualification'] = array(
    '#type' => 'fieldset',
    '#title' => t('Professional qualification Subjects Details'),
    // Set up the wrapper so that AJAX will be able to replace the fieldset.
    '#prefix' => '<div id="names-fieldset-wrapper_1">',
    '#suffix' => '</div>',
  );  

  // Build the fieldset with the proper number of names. We'll use
  // $form_state['num_names1'] to determine the number of textfields to build.
  if (empty($form_state['num_names1'])) {
    $form_state['num_names1'] = 1;
  }
  for ($j = 0; $j < $form_state['num_names1']; $j++) {
  $form['qualif']['pc_qualification'][$j]['seriaol']= array(
			'#type' => 'textfield',
			'#title' => t('S.no.'),
			'#default_value' => $j+1,
			//'#prefix' => '<tr><td>',
		  //  '#suffix' => '</td>'
			
		  );
		$form['qualif']['pc_qualification'][$j]['subject1']= array(
			'#type' => 'textfield',
			'#title' => t('Subject'),
		//	'#prefix' => '<td>',
		 // '#suffix' => '</td>'
			
		  ); 

		$form['qualif']['pc_qualification'][$j]['marks1']= array(
			'#type' => 'textfield',
			'#title' => t('Marks'),
			//'#prefix' => '<td>',
		  // '#suffix' => '</td></tr>'
		   
		  ); 
  }
  $form['qualif']['pc_qualification']['add_more1'] = array(
    '#type' => 'button',
    '#value' => t('Add one more'),
    '#submit' => array('ajax_example_add_more_add_one_1'),
    // See the examples in ajax_example.module for more details on the
    // properties of #ajax.
    '#ajax' => array(
      'callback' => 'ajax_example_add_more_callback_1',
      'wrapper' => 'names-fieldset-wrapper_1',
    ),
  );
  if ($form_state['num_names1'] > 1) {
    $form['qualif']['pc_qualification']['remove_name1'] = array(
      '#type' => 'submit',
      '#value' => t('Remove one'),
      '#submit' => array('ajax_example_add_more_remove_one_1'),
      '#ajax' => array(
        'callback' => 'ajax_example_add_more_callback_1',
        'wrapper' => 'names-fieldset-wrapper_1',
      ),
    );
  }
 
 
$form['qualif']['pc_qualification']['passing_year1']= array(
    '#type' => 'textfield',
    '#title' => t('Year of passing'),
   
  );  
$form['qualif']['pc_qualification']['marks_percentage1']= array(
    '#type' => 'textfield',
    '#title' => t('Percentage/Grade Of Marks'),
   
  );
$form['qualif']['pc_qualification']['board_university1']= array(
    '#type' => 'textfield',
    '#title' => t('Name of Board/University'),
	
  );
  
 $form['application_project']['file'] = array(
    '#type' => 'file',
    '#title' => t('Upload qualification document'),
    '#description' => t('Upload a file, allowed extensions: xls, doc, docx, xlsx, txt'),
  );  
  
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
  );

  
  if ($no_js_use) {
    // Remove the #ajax from the above, so ajax.js won't be loaded.
    if (!empty($form['application_project']['ac_qualification']['qualification']['subjects_details']['remove_name']['#ajax'])) {
      unset($form['application_project']['ac_qualification']['qualification']['subjects_details']['remove_name']['#ajax']);
    }
	unset($form['application_project']['ac_qualification']['qualification']['subjects_details']['add_more']['#ajax']);
	
  }
 if ($no_js_use) {
    // Remove the #ajax from the above, so ajax.js won't be loaded.
    if (!empty($form['qualif']['remove_name1']['#ajax'])) {
      unset($form['qualif']['remove_name1']['#ajax']);
    }
	unset($form['qualif']['add_more1']['#ajax']);
	
  }

  return $form;
}

function ajax_example_add_more_callback($form, $form_state) {
  return $form['application_project']['ac_qualification']['qualification']['subjects_details'];
}
//function ajax_example_add_more_callback_1($form, $form_state) {
//  return $form['qualif'];
//}
function ajax_example_add_more_add_one($form, &$form_state) {
  $form_state['num_names']++;
  $form_state['rebuild'] = TRUE;
}
//function ajax_example_add_more_add_one_1($form, &$form_state) {
//  $form_state['num_names1']++;
//  $form_state['rebuild'] = TRUE;
//}
function ajax_example_add_more_remove_one($form, &$form_state) {
  if ($form_state['num_names'] > 1) {
    $form_state['num_names']--;
  }
  $form_state['rebuild'] = TRUE;
}
//function ajax_example_add_more_remove_one_1($form, &$form_state) {
//  if ($form_state['num_names1'] > 1) {
//    $form_state['num_names1']--;
//  }
//  $form_state['rebuild'] = TRUE;
//}
function ajax_example_add_more_submit($form, &$form_state) {
     echo "<pre>"; print_r($form_state['values']); echo"</pre>"; exit;
    $category=$form_state['values']['application_project']['category-tex'];
    $applicant=$form_state['values']['application_project']['applicant'];
    $spouse=$form_state['values']['application_project']['spouse'];
    $date_ofbirth=$form_state['values']['application_project']['date_of-birth'];
    $age=$form_state['values']['application_project']['age'];
    $application_project_category=$form_state['values']['application_project']['category'];
    $gender=$form_state['values']['application_project']['gender'];
    $postal_address=$form_state['values']['application_project']['postal_address'];
    $phone_no=$form_state['values']['application_project']['phone_no'];
    $email=$form_state['values']['application_project']['email'];
    $permanent_address=$form_state['values']['application_project']['permanent_address'];
    $spouse_address=$form_state['values']['application_project']['spouse_address'];
    $post_held_at_present=$form_state['values']['application_project']['post_held_at_present'];  
    $examination_passed=$form_state['values']['application_project']['ac_qualification']['qualification']['examination_passed'];
    $ac_qualification_subject=$form_state['values']['application_project']['ac_qualification']['qualification']['subjects_details']['subject'];
	//echo "<pre>"; print_r($ac_qualification_subject); echo"</pre>"; 
      foreach($ac_qualification_subject as $ac_subjects){
	     $getAc_subjects[]=$ac_subjects;
	  }
	$ac_qualification_marks=$form_state['values']['application_project']['ac_qualification']['qualification']['subjects_details']['marks'];
      foreach($ac_qualification_marks as $ac_marks){
	     $getAc_marks[]=$ac_marks;
	  }
	$ac_qualification_passing_year=$form_state['values']['application_project']['ac_qualification']['qualification']['passing_year'];
    $ac_qualification_marks_percentage=$form_state['values']['application_project']['ac_qualification']['qualification']['marks_percentage'];
	$ac_qualification_board_university=$form_state['values']['application_project']['ac_qualification']['qualification']['board_university'];
	$ac_qualification_examination_passed=$form_state['values']['application_project']['ac_qualification']['qualification']['examination_passed'];
	
	$pc_qualification_subject1=$form_state['values']['application_project']['qualification']['pc_qualification']['subjects_details1']['subject1'];
		foreach($pc_qualification_subject1 as $pc_subjects){
			$getPc_subject[]=$pc_subjects;
		}
	$pc_qualification_marks1=$form_state['values']['application_project']['qualification']['pc_qualification']['subjects_details1']['marks1'];
      foreach($pc_qualification_marks1 as $pc_marks){
	     $getPc_marks[]=$pc_marks;
	  }
	    //echo "<pre>"; print_r($getPc_marks); echo"</pre>";
	$pc_qualification_passing_year1=$form_state['values']['application_project']['qualification']['pc_qualification']['subjects_details1']['passing_year1'];
	$pc_qualification_marks_percentage1=$form_state['values']['application_project']['qualification']['pc_qualification']['marks_percentage1'];
	$pc_qualification_board_university1=$form_state['values']['application_project']['qualification']['pc_qualification']['board_university1'];
	$pc_qualification_examination_passed=$form_state['values']['application_project']['qualification']['pc_qualification']['examination_passed'];
    //echo "<pre>"; print_r($pc_qualification_examination_passed); echo"</pre>";exit;
		 $query = db_insert('application_form_table')
				->fields(array(
				  'project_category' => 'Example',
				  'name_of_applicant' => 1,
				  'gardion_of_applicant' => REQUEST_TIME,
				  'date_of_birth' => 'Example',
				  'age_of_applicant_on_date_of_submittion' => 1,
				  'cast_category' => REQUEST_TIME,
				  'gender' => 'Example',
				  'postal_address' => 1,
				  'phone_number' => REQUEST_TIME,
				  'email_id' => 'Example',
				  'course_id' => 1,
				  'permanent_address' => REQUEST_TIME,
				  'sponsoring_department_address' => 'Example',
				  'post_hald_at_present' => 1,
				  'examination_passed' => REQUEST_TIME,
				  'subject' => 'Example',
				  'marks' => 1,
				  'year_of_passing' => REQUEST_TIME,
				))
				->execute();
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
 $val=$form_state['values']['application_project']['category-tex'];	
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

function MYMODULE_get_tax_term_options($machine_name)
	{
			$Currenturl= request_uri();
     		$explodeUrl=explode('?',$Currenturl);
	    	$explodeUrl1=$explodeUrl['1'];
		    $explodeUrl2=explode('=',$explodeUrl1);
		    $getIdFromUrl=$explodeUrl2['1'];
            if(!empty($getIdFromUrl)){
		  //$options = array( '0' => 'Please Select Value');
		   $query = db_select('field_data_field_product_id_', 't');
					$query->join('node', 'n', 'n.vid = t.entity_id');
					$result = $query->fields('t', array('entity_id', 'field_product_id__value'))->fields('n')->condition('t.field_product_id__value',$getIdFromUrl,'=')->execute();
					// echo"<pre>"; print_r($query); echo"</pre>"; exit;
			foreach($result as $item1 ) {
                   $key = $item1->title;
				   $value = $item1->title;
				   $options[$key] = $value;
			  }			
			}
			else{
			     //echo $machine_name; exit;
				//$options = array( '0' => 'Please Select Value');

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
				}
    return $options;
	}

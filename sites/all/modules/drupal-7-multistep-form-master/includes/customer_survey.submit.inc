<?php

/**
 * @file 
 * Handles the form submission of the customer survey form
 */


/**
 * Handles what to do with the submitted form depending on what stage has been
 * completed.
 * 
 * @see customer_survey_form()
 * @see customer_survey_form_validate()
 * 
 * @param type $form
 * @param type $form_state 
 */
function customer_survey_form_submit($form, &$form_state) {
  
  switch ($form_state['stage']) {
    
    case 'personal_details':
      $form_state['multistep_values'][$form_state['stage']] = $form_state['values'];
      if ($form_state['triggering_element']['#value'] != 'Back') {
        customer_survey_personal_details_submit($form, $form_state);
        $form_state['complete'] = TRUE;
      }
     break;
 
    default:
      $form_state['multistep_values'][$form_state['stage']] = $form_state['values'];
      $form_state['new_stage'] = customer_survey_move_to_next_stage($form, $form_state);
     break;
 
  } 

  if (isset($form_state['complete'])) drupal_goto('complete-page');   
  
  if ($form_state['triggering_element']['#value'] == 'Back') {
    $form_state['new_stage'] = customer_survey_move_to_previous_stage($form, $form_state);
  } 
  
  if (isset($form_state['multistep_values']['form_build_id'])) {
    $form_state['values']['form_build_id'] = $form_state['multistep_values']['form_build_id'];
  }
  $form_state['multistep_values']['form_build_id'] = $form_state['values']['form_build_id'];
  $form_state['stage'] = $form_state['new_stage'];
  $form_state['rebuild'] = TRUE;
    
}

 /**
  * Handles the submission of the final stage
  * 
  * Sends an email to the user confirming their entry
  * 
  * @param type $form
  * @param type $form_state 
  */
  
function customer_survey_personal_details_submit($form, &$form_state) {
  
  
}

/**
 * Returns what to show on the completion page.
 * 
 * @return type 
 */
function customer_survey_complete() {
    $GetPOST=$_POST;
	$amount=$GetPOST['amount'];
	$email=$GetPOST['email'];
	$course_get=$GetPOST['productinfo'];
	$udf1=$GetPOST['udf1'];
    $num_updated = db_update('application_form_table') // Table name no longer needs {}
  ->fields(array(
    'amountPaid' => $amount,
	'course_applied_for_code' => $course_get,
	
  ))
  ->condition('email_id', $email , '=')
  ->condition('submittion', $udf1 , '=')
  ->execute();    

	 
	 return  drupal_set_message(t('Your form has been submitted successfully. The Online payment services will start soon. You are requested to remit the Fee offline through IPO,DD drawn in favor of "Drawing and Disbursing officer, National Archives of India" and payable at New Delhi and Cash.'));
	}

	if($_SERVER['REQUEST_URI']=='/complete-page')
{ ?>
	<input class="rebtn" type='button' value='Go Back To Main Form' onclick="window.location.href='/page/application'"/>
<?php }
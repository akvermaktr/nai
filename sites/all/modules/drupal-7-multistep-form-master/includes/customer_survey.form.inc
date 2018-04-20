<?php

/**
 * @file
 * Handles the form elements of the customer survey form
 * All hooks are in the .module file.
 */

/**
 * Master form which calls an individual form for each step.
 * 
 * @see customer_survey_form_validate().
 * @see customer_survey_form_submit().
 * 
 * @param type $form
 * @param string $form_state
 * @return type 
 */
function customer_survey_form($form, &$form_state) {

    drupal_add_css(drupal_get_path('module', 'customer_survey') . '/css/customer_survey.css');
    if (!isset($form_state['stage']))
        $form_state['stage'] = 'Basic_details';

    $form = array();
    $form = customer_survey_get_header($form, $form_state);

    switch ($form_state['stage']) {

        case 'Basic_details':
            return customer_survey_Basic_details_form($form, $form_state);
            break;

        case 'general_qualification':
            return customer_survey_general_qualification_form($form, $form_state);
            break;

        case 'personal_details':
            return customer_survey_personal_details_form($form, $form_state);
            break;

        default:
            return customer_survey_Basic_details_form($form, $form_state);
            break;
    }

    return $form;
}

function customer_survey_Basic_details_form($form, &$form_state) {


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
      '#date_label_position' => 'within',
      '#required' => TRUE,
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
    $form['application_project']['post_held_at_present'] = array(
      '#type' => 'textarea',
      '#title' => t('Post held at present'),
      '#required' => TRUE,
    );


    $form['next'] = array(
      '#type' => 'submit',
      '#value' => t('Next')
    );

    return $form;
}

function MYMODULE_get_tax_term_options($machine_name) {
    //echo $machine_name; exit;
    $options = array('0' => 'Please Select Value2');

    $vid = taxonomy_vocabulary_machine_name_load($machine_name)->vid;
    $options_source = taxonomy_get_tree($vid);
   // echo "<pre>"; print_r($options_source); echo"</pre>";
//    $products = db_select('node', 'n')
//        ->condition('type', 'product')
//        ->fields('n');
//    $options_source = $products->execute();

    foreach ($options_source as $item) {
        // echo "<pre>"; print_r($item); echo"</pre>";					
        $key = $item->tid;
        $value = $item->name. " (" . "NAI-" . $item->tid . ")";
        $options[$key] = $value;
    }
    return $options;
}

function customer_survey_general_qualification_form($form, &$form_state) {

    $form = array();
    $form['#tree'] = TRUE;
    $form['application_project']['ac_qualification']['qualification']['examination_passed'] = array(
      '#type' => 'textfield',
      '#title' => t('Examination Passed'),
      '#required' => TRUE,
    );
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

        $form['application_project']['ac_qualification']['qualification']['subjects_details'][$i]['subject'] = array(
          '#type' => 'textfield',
          '#title' => t('Subject'),
          '#required' => TRUE,
        );
        $form['application_project']['ac_qualification']['qualification']['subjects_details'][$i]['marks'] = array(
          '#type' => 'textfield',
          '#title' => t('Marks'),
          '#required' => TRUE,
        );
    }
    $form['application_project']['ac_qualification']['qualification']['add_more'] = array(
      '#type' => 'submit',
      '#value' => t('Add one more'),
      '#submit' => array('ajax_example_add_more_add_one'),
      '#ajax' => array(
        'callback' => 'ajax_example_add_more_callback',
        'wrapper' => 'names-fieldset-wrapper',
      ),
    );
    if ($form_state['num_names'] > 1) {
        $form['application_project']['ac_qualification']['qualification']['remove_name'] = array(
          '#type' => 'button',
          '#value' => t('Remove one'),
          '#submit' => array('ajax_example_add_more_remove_one'),
          '#ajax' => array(
            'callback' => 'ajax_example_add_more_callback',
            'wrapper' => 'names-fieldset-wrapper',
          ),
        );
    }

    $form['application_project']['ac_qualification']['qualification']['passing_year'] = array(
      '#type' => 'textfield',
      '#title' => t('Year of passing'),
      '#required' => TRUE,
    );

    $form['application_project']['ac_qualification']['qualification']['marks_percentage'] = array(
      '#type' => 'textfield',
      '#title' => t('Percentage/Grade Of Marks'),
      '#required' => TRUE,
    );
    $form['application_project']['ac_qualification']['qualification']['board_university'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of Board/University'),
      '#required' => TRUE,
    );
    $form['next'] = array(
      '#type' => 'submit',
      '#value' => t('Next')
    );
    if ($no_js_use) {
        // Remove the #ajax from the above, so ajax.js won't be loaded.
        if (!empty($form['application_project']['ac_qualification']['qualification']['remove_name']['#ajax'])) {
            unset($form['application_project']['ac_qualification']['qualification']['remove_name']['#ajax']);
        }
        unset($form['application_project']['ac_qualification']['qualification']['add_more']['#ajax']);
    }
    return $form;
}

function commerce_payu_india_get_hash($params, $salt) {
    $posted = array();

    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $posted[$key] = htmlentities($value, ENT_QUOTES);
        }
    }

    $hash_sequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

    $hash_vars_seq = explode('|', $hash_sequence);
    $hash_string = NULL;

    foreach ($hash_vars_seq as $hash_var) {
        $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
        $hash_string .= '|';
    }

    $hash_string .= $salt;
    return strtolower(hash('sha512', $hash_string));
}

function customer_survey_personal_details_form($form, &$form_state) {


    $multstep_values = $form_state['multistep_values'];
    $course = taxonomy_term_load($multstep_values['Basic_details']['application_project']['category-tex']);
    $price =  $course->field_price['und'][0]['value'];                 
  //  echo "<pre>"; print_r($course);   print_r($multstep_values); echo"</pre>"; exit;
    $texonomy_category = $multstep_values['Basic_details']['application_project']['category-tex'];
    $type = "product";
    $result = db_query("SELECT n.nid FROM {node} n WHERE n.title = :title AND n.type = :type", array(":title" => $texonomy_category, ":type" => $type));
    $nid = $result->fetchField();
    //echo "<pre>"; print_r($nid); echo"</pre>";
    $node_data = node_load($nid);
    $course_id = $node_data->field_product_id_['und']['0']['value'];
    //echo $course_id;  
    //exit;  
    $applicant = $multstep_values['Basic_details']['application_project']['applicant'];
    $spouse = $multstep_values['Basic_details']['application_project']['spouse'];
    $date_of_birth = $multstep_values['Basic_details']['application_project']['date_of-birth'];
    $age = $multstep_values['Basic_details']['application_project']['age'];
    $category = $multstep_values['Basic_details']['application_project']['category'];
    $gender = $multstep_values['Basic_details']['application_project']['gender'];
    $postal_address = $multstep_values['Basic_details']['application_project']['postal_address'];
    $phone_no = $multstep_values['Basic_details']['application_project']['phone_no'];
    $email = $multstep_values['Basic_details']['application_project']['email'];
    $permanent_address = $multstep_values['Basic_details']['application_project']['permanent_address'];
    $spouse_address = $multstep_values['Basic_details']['application_project']['spouse_address'];
    $post_held_at_present = $multstep_values['Basic_details']['application_project']['post_held_at_present'];
    $general_qualification_examination_passed = $multstep_values['general_qualification']['application_project']['ac_qualification']['qualification']['examination_passed'];
    $general_qualification_subjects_details = $multstep_values['general_qualification']['application_project']['ac_qualification']['qualification']['subjects_details'];
    //echo "<pre>"; print_r($general_qualification_subjects_details); echo"</pre>";
    unset($general_qualification_subjects_details['add_more']);
    unset($general_qualification_subjects_details['remove_name']);
    // echo "<pre>"; print_r($general_qualification_subjects_details); echo"</pre>";
    $subject = array();
    $marks = array();
    foreach ($general_qualification_subjects_details as $val) {
        $subject[] = $val['subject'];
        $marks[] = $val['marks'];
    }

    $getstringsubjects = implode(',', $subject);
    $getstringmarks = implode(',', $marks);
    // echo $getstringsubjects;
    // echo $getstringmarks;
    //exit;
    $general_qualification_passing_year = $multstep_values['general_qualification']['application_project']['ac_qualification']['qualification']['passing_year'];
    $general_qualification_marks_percentage = $multstep_values['general_qualification']['application_project']['ac_qualification']['qualification']['marks_percentage'];
    $general_qualification_board_university = $multstep_values['general_qualification']['application_project']['ac_qualification']['qualification']['board_university'];

    $pc_qualificationboard_examination_passed1 = $multstep_values['personal_details']['pc_qualification']['examination_passed1'];
    $pc_qualificationboard_subjects_details = $multstep_values['personal_details']['pc_qualification']['subjects_details'];
    $subject1 = array();
    $marks1 = array();
    foreach ($pc_qualificationboard_subjects_details as $val1) {
        $subject1[] = $val1['subject1'];
        $marks1[] = $val1['marks1'];
    }
    $getstringsubjects1 = implode(',', $subject1);
    $getstringmarks1 = implode(',', $marks1);

    $pc_qualificationboard_passing_year1 = $multstep_values['personal_details']['pc_qualification']['subjects_details1']['passing_year1'];
    $pc_qualificationboard_marks_percentage1 = $multstep_values['personal_details']['pc_qualification']['subjects_details1']['marks_percentage1'];
    $pc_qualificationboard_board_university1 = $multstep_values['personal_details']['pc_qualification']['subjects_details1']['board_university1'];

    $last_id = db_query('SELECT MAX(id) FROM {application_form_table}')->fetchField();
    $getLatid = $last_id;
    $getTodayDate = date("d/m/Y");
    $query = db_insert('application_form_table') // Table name no longer needs {}
        ->fields(array(
          'submittion' => $getLatid,
          'project_category' => $texonomy_category,
          'name_of_applicant' => $applicant,
          'gardion_of_applicant' => $spouse,
          'date_of_birth' => $date_of_birth,
          'age_of_applicant_on_date_of_submittion' => $age,
          'cast_category' => $category,
          'gender' => $gender,
          'postal_address' => $postal_address,
          'phone_number' => $phone_no,
          'email_id' => $email,
          'course_id' => $course_id,
          'permanent_address' => $permanent_address,
          'sponsoring_department_address' => $spouse_address,
          'post_hald_at_present' => $post_held_at_present,
          'examination_passed' => $general_qualification_examination_passed,
          'subject' => $getstringsubjects,
          'marks' => $getstringmarks,
          'year_of_passing' => $general_qualification_passing_year,
          'percentage_grade_of_marks' => $general_qualification_marks_percentage,
          'name_board' => $general_qualification_board_university,
          'pc_examination_passed' => $pc_qualificationboard_examination_passed1,
          'pc_subject' => $getstringsubjects1,
          'pc_marks' => $getstringmarks1,
          'pc_year_of_passing' => $pc_qualificationboard_passing_year1,
          'pc_percentage_grade_of_marks' => $pc_qualificationboard_marks_percentage1,
          'pc_name_board' => $pc_qualificationboard_board_university1,
          'file_upload_path' => '',
          'amountPaid' => '',
          'form_submit_on' => $getTodayDate,
        ))
        ->execute();
// submit handler insert data end here ..... coded by Gaurav Sharma()
    $file = $form_state['values']['file'];
    if ($file != "") {
        unset($form_state['values']['file']);
        $file->status = FILE_STATUS_PERMANENT;
        file_save($file);
    }


    drupal_set_message(t('The form has been submitted.'));

    $merchant_key = "gtKFFx";
    $salt = "eCwWELxi";
    //$payu_base_url = "https://test.payu.in/_payment"; // For Test environment
    //secure.payu.in
    $payu_base_url = "https://secure.payu.in/_payment"; // For Prod environment
    //$payu_base_url = 'http://164.100.58.100/page/application';
    $posted = array();

    $getExplode = explode('=', $texonomy_category);
    $getdataId = $getExplode['0'];
    $result = db_select('manage_courses', 'pt')
        ->fields('pt')
        ->condition('id', $getdataId, '=')
        ->execute()
        ->fetchAssoc();
    // echo "<pre>"; print_r($result); echo"</pre>"; exit;
    $amount = $price;  // $result['price'];
    $course_code1 = $course->name; // $result['course_code'];

    global $base_url;
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    $surl = $base_url . '/complete-page';
    $furl = $base_url . '/nai';
    $hash_data['key'] = $merchant_key;
    $hash_data['txnid'] = $txnid;
    $hash_data['amount'] = $amount;
    $hash_data['productinfo'] = $course_code1;
    $hash_data['firstname'] = $applicant;
    $hash_data['email'] = $email;
    $hash_data['udf1'] = $getLatid;
    
    $hash = commerce_payu_india_get_hash($hash_data, $salt);
    $data = array(
      'hash' => $hash,
      'key' => $merchant_key,
      'txnid' => $txnid,
      'amount' => $amount,
      'surl' => $surl,
      'furl' => $furl,
      'firstname' => $applicant,
      'productinfo' => $course_code1,
      'email' => $email,
      'udf1' => $getLatid,
    );

    $form = array();
    $form['#action'] = $payu_base_url;
    $form['#tree'] = TRUE;
    // Put the data on a form.
    foreach ($data as $name => $value) {
        $form[$name] = array(
          '#type' => 'hidden',
          '#value' => $value,
        );
    }

    $form['next'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );


    //payu_base_url
    return $form;
}

function ajax_example_add_more_callback($form, $form_state) {
    return $form['application_project']['ac_qualification']['qualification']['subjects_details'];
}

function ajax_example_add_more_add_one($form, &$form_state) {
    $form_state['num_names'] ++;
    $form_state['rebuild'] = TRUE;
}

function ajax_example_add_more_callback_one($form, $form_state) {
    return $form['pc_qualification']['subjects_details'];
}

function ajax_example_add_more_add_one_one($form, &$form_state) {
    $form_state['num_names_test'] ++;
    $form_state['rebuild'] = TRUE;
}

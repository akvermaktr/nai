<?php
define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
//menu_execute_active_handler();
global $base_url;
//echo $base_url;
$test=$_POST;
$getId=$_POST['hiddenid'];
$getvalidCalue=$_POST['valid'];
$num_updated = db_update('application_form_table') // Table name no longer needs {}
  ->fields(array(
    'valid' => $getvalidCalue,
  ))
  ->condition('id',$getId, '=')
  ->execute();
$newPath=$base_url.'/get_list_of_applied_student';
drupal_goto($newPath);
?>
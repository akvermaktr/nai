<?php

/**
 * @file
 * Provide structure for the administrative interface to enable mime type.
 */
/**
 * Callback for File Mime type form.
 */
function file_mime_type_checker_form() {
  $form = array();
  $form['file_mime_type_checker'] = array(
    '#title' => t('File Extension'),
    '#description' => t('Enable if you want to check mime type of file.'),
    '#type' => 'radios',
    '#options' => drupal_map_assoc(array(t('Enable'), t('Disable'))),
    '#default_value' => variable_get('file_mime_type_checker'),
  );
  return system_settings_form($form);
}

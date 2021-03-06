<?php

/**
 * @file
 * Hooks provided by the Media WYSIWYG Embed module.
 */


/**
 * Alter a list of formatters allowed for a file embedded in the WYSIWYG.
 *
 * @param array $options
 *   An associative array of formatter "name => label" pairs.
 * @param object $file
 *   A file entity.
 *
 * @see media_embed_formatter_options()
 */
function hook_media_embed_formatter_options_alter(&$options, $file) {
  $options['file_field_file_default'] = t('Default');
  if ('video' == $file->type) {
    unset($options['file_field_file_url_plain']);
  }
}


/**
 * Alter default formatter for a file embedded in the WYSIWYG.
 *
 * @param string $formatter
 *   A formatter name.
 * @param object $file
 *   A file entity.
 *
 * @see media_embed_default_formatter()
 */
function hook_media_embed_default_formatter_alter(&$formatter, $file) {
  if ('video' == $file->type) {
    $scheme = file_uri_scheme($file->uri);
    switch ($scheme) {
      case 'brightcove':
        $formatter = 'brightcove_media_video';
        break;

      case 'brightcove-playlist':
        $formatter = 'brightcove_media_playlist';
        break;

      case 'youtube':
        $formatter = 'media_youtube_video';
        break;
    }
  }
}


/**
 * Alter the output generated by media embed token.
 *
 * @param array $element
 *   The renderable array of output generated for media embed token.
 * @param array $display
 *   An associative array containing following keys:
 *   - type: formatter name;
 *   - settings: formatter settings.
 * @param object $file
 *   A file entity.
 */
function hook_media_embed_formatted_alter(&$element, $display, $file) {
  if ('audio' == $file->type && 'file_field_file_audio' == $display['type']) {
    $element = array(
      '#theme_wrappers' => array('container'),
      '#attributes' => array(
        'class' => array('audio-item'),
      ),
      $element,
    );
  }
}


/**
 * Alter view mode the file will be displayd in when formatter
 * doesn't render the file for the WYSIWYG mode.
 *
 * Some formatters don't render files for the WYSIWYG mode.
 * In this case we just render the file in a specified view mode.
 *
 * @param string $view_mode
 *   A view mode. Defaults to "default".
 * @param object $file
 *   A file entity.
 *
 * @see media_embed_formatted_wysiwyg()
 */
function hook_media_embed_wisiwyg_view_mode_alter(&$view_mode, $file) {
  if ('video' == $file->type) {
    $view_mode = 'preview';
  }
}

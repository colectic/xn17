<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>

<?php
  if (strip_tags($fields['field_agenda_imatge']->content) != ''){
    $rawImatge = strip_tags($fields['field_agenda_imatge']->content);
  }else{
    $rawImatge = strip_tags($fields['field_imatges']->content);
  }

  /*if (strip_tags($rawImatge, '<img>') == '') $rawImatge = "<a href='" . strip_tags($fields['path']->content) . "'>" . theme_image_style (array('style_name' => 'tag-mig', 'path' => 'public://no-image.jpg', 'title' => 'just a test image', 'alt' => 'test image')) . "</a>";
  if ((strip_tags($fields['field_imatge_emergent']->content) != '') || (strip_tags($fields['field_video_emergent']->content) != '')) {
    if (strip_tags($fields['field_imatge_emergent']->content) != '') {
      //Imatge emergent
      $class = 'imatge';
      $newurl = strip_tags($fields['field_imatge_emergent']->content);
      $rel = "lightbox";
    }
    if (strip_tags($fields['field_video_emergent']->content) != '') {
      //Vídeo emergent
      $class = 'video';
      $rel = "lightframe";
      $newurl = strip_tags($fields['field_video_emergent']->content);
    }
    $title = strip_tags($fields['title']->content);
    $rawImatge = strip_tags($rawImatge, "<img>");
    $rawImatge = '	<div class="field-content lightbox-item">
                      '.$rawImatge.'
                <div class="content">
                <a rel="'.$rel.'" href="'.$newurl.'" class="info" title="'.$title.'"><img alt="icona '.$class.'" src="/sites/all/themes/sasson_xarxanet/images/pictos/emergent-'.$class.'.svg" /></a>
                </div>
                  </div>';
  }*/

  $view = views_get_current_view();
  print "<div class='titol-regio'>" . check_plain($view->get_title()) . "</div>";
  print '<div class="modul-monografic-portada" style="background-image: url(' . $rawImatge . ');">';
    print '<div class="cont_titular_entradeta">';
      print '<div class="titular_content"><h2>'.$fields['title']->content.'</h2>';
      print '<h3>'.$fields['title_1']->content.'</h3></div>';
      print '<div class="hidden-xs resum" style="z-index:0;">' . $fields['field_resum']->content . '</div>';
    print '</div>';
  print '</div>';
?>

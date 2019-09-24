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

  // Get the image url of the background

  if (strip_tags($fields['field_agenda_imatge']->content) != '') {
    $raw_image = strip_tags($fields['field_agenda_imatge']->content);
  }
  else {
    $raw_image = strip_tags($fields['field_imatges']->content);
  }

  // Get the title and url for external content

  $row_entity = $row->_field_data['node_field_data_field_noticia_monografic_nid']['entity'];

  if ($row_entity->type == 'noticia_externa_monografic') {
    $external_url = $row_entity->field_enllac_monogrific['und'][0]['url'];
    $external_title = $row_entity->field_enllac_monogrific['und'][0]['title'];
  } 

  // Get all info about this View

  $view = views_get_current_view();
?>

<div class='titol-regio'>
  <?php print check_plain($view->get_title()); ?>
</div>
<div class="modul-monografic-portada" style="background-image: url(<?php print $raw_image; ?>);">
  <div class="cont_titular_entradeta">
    <div class="titular_content">
      <h2><?php print $fields['title']->content; ?></h2>
      <?php if ($row_entity->type == 'noticia_externa_monografic'): ?>
        <h3>
          <a href="<?php print $external_url; ?>"><?php print $external_title; ?></a>
        </h3>
      <?php else: ?>
        <h3>
          <?php print $fields['title_1']->content; ?>
        </h3>
      <?php endif; ?>
    </div>
    <div class="hidden-xs resum" style="z-index:0;"><?php print $fields['field_resum']->content; ?></div>
  </div>
</div>

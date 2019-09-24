<?php 

  /**
   * XARXANET-277
   * 
   * Making some customizations to allow external content to be shown also in the pager.
   * The regular content shows a link to it's piece of content or node, but in the case 
   * of external content, we build the link accessing a custom field of type "Link" (provided
   * by the "Link" module).
   * 
   * In addition, we wrappered the HTML with a conditional that avoids rendering duplicates 
   * of the external content pager items.
   *
   */
  $is_external = ($view->result[$count]->node_field_data_field_noticia_monografic_type == 'noticia_externa_monografic');
  $link = $view->result[$count]->_field_data['node_field_data_field_noticia_monografic_nid']['entity']->field_enllac_monogrific['und'][0];
?>

<?php if (!($is_external && drupal_clean_css_identifier($view->field[$field]->field) == 'views-conditional')):?>
  <div class="views-field-<?php print drupal_clean_css_identifier($view->field[$field]->field); ?>">
    <?php if ($view->field[$field]->label()): ?>
      <label class="view-label-<?php print drupal_clean_css_identifier($view->field[$field]->field); ?>">
        <?php print $view->field[$field]->label(); ?>:
      </label>
    <?php endif; ?>
    <div class="views-content-<?php print drupal_clean_css_identifier($view->field[$field]->field); ?>">
      <?php if ($is_external): ?>
        <a href="<?php print $link['url']; ?>"><?php print $link['title']; ?></a>
      <?php else: ?>
        <?php print $view->style_plugin->rendered_fields[$count][$field]; ?>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

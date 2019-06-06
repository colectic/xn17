<?php

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
<?php if ($block->subject): ?>
  <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
<?php endif;?>
  <?php print render($title_suffix); ?>
  <?php
    $params = drupal_get_query_parameters();
    $type = 'All';
    if ($params['field_event_type_value']) $type = $params['field_event_type_value'];

    function filtertype($type) {
      $params = drupal_get_query_parameters();
      $params['field_event_type_value'] = $type;
      $query = array( 'query' => $params);
      return $query;
    }
  ?>
  <div class="content"<?php print $content_attributes; ?>>
    <div id="type-selectors">
      <div class="type-selector <?php if ($type == 'All') echo 'active'; ?>" id="all-selctor">
        <?php echo l('Tots', arg(), filtertype('All'));?>
      </div>
      <div class="type-selector <?php if ($type == 'Acte') echo 'active'; ?>" id="events-selctor">
        <?php echo l('Actes', arg(), filtertype('Acte'));?>
      </div>
      <div class="type-selector <?php if ($type == 'Curs') echo 'active'; ?>" id="courses-selctor">
        <?php echo l('Cursos', arg(), filtertype('Curs'));?>
      </div>
    </div>
    <div id="type-arrows">
      <div class="type-arrow <?php if ($type == 'All') echo 'active'; ?>" id="all-arrow">
        <img src="/sites/all/themes/xn17/assets/images/elements/punta-avall.svg" />&nbsp;
      </div>
      <div class="type-arrow <?php if ($type == 'Acte') echo 'active'; ?>" id="events-arrow">
        <img src="/sites/all/themes/xn17/assets/images/elements/punta-avall.svg" />&nbsp;
      </div>
      <div class="type-arrow <?php if ($type == 'Curs') echo 'active'; ?>" id="courses-arrow">
        <img src="/sites/all/themes/xn17/assets/images/elements/punta-avall.svg" />&nbsp;
      </div>
    </div>
    <?php print $content ?>
    <a id="publish-link" href="/node/add/event"><img src="/sites/all/themes/xn17/assets/images/icon/icon-publish-red.svg" />PUBLICA UN ESDEVENIMENT</a>
  </div>
</div>

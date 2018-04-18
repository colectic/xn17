<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>
<?php print $wrapper_prefix; ?>
  <?php if (!empty($title)) : ?>
    <h3><?php print $title; ?></h3>
  <?php endif; ?>
  <?php print $list_type_prefix; ?>
    <?php foreach ($rows as $id => $row): ?>
      <li class="<?php print $classes_array[$id]; ?>"><?php print $row; ?></li>
    <?php endforeach; ?>
      <li id="button" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="more-link">
          <a href="/financaments">Veure tot</a>
        </div>
      </li>
  <?php print $list_type_suffix; ?>
<?php print $wrapper_suffix; ?>

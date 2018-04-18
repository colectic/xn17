<?php

/**
 * @file
 * Default views template for displaying a slideshow.
 *
 * - $view: The View object.
 * - $options: Settings for the active style.
 * - $rows: The rows output from the View.
 * - $title: The title of this group of rows. May be empty.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($slideshow)): ?>
  <div class="skin-<?php print $skin; ?>">
    <?php if (!empty($top_widget_rendered)): ?>
      <div class="views-slideshow-controls-top clearfix">
        <?php print $top_widget_rendered; ?>
      </div>
    <?php endif; ?>
    <div class="imatge col-lg-9 col-md-9 col-sm-12 col-xs-12 pdng_mdl">
      <?php print "<div class='titol-regio'>" . check_plain($view->get_title()) . "</div>"; ?>
      <?php print $slideshow; ?>
    </div>
    <?php if (!empty($bottom_widget_rendered)): ?>
      <div class="views-slideshow-controls-bottom clearfix col-lg-3 col-md-3 col-sm-12 hidden-xs">
        <?php print '<div class="titol-paginador col-lg-12 col-md-12 col-sm-3">Més sobre...<br>' . $view->result[0]->node_title . '</div>'; ?>
        <div class="paginador col-lg-12 col-md-12 col-sm-9">
          <?php print $bottom_widget_rendered; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

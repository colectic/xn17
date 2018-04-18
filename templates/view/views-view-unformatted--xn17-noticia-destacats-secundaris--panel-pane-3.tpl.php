<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php
$itRow = 1;
foreach ($rows as $id => $row):
  if($itRow == 2){
    $float = "float-r";
  }else{
    $float = "float-l";
  }
  ?>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pdng_mdl <?php print $float; ?>">
    <?php print $row; ?>
  </div>
<?php
$itRow++;
endforeach; ?>

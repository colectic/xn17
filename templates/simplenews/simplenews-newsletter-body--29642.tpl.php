<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
$node = $build['#node']; 
$wrapper = entity_metadata_wrapper('node', $node);
$pathroot = 'http://www.xarxanet.org';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title>My Email Subject</title>
  </head>
  <body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;box-sizing:border-box;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important">
    <style>@media only screen{html{min-height:100%;background:#eceff0}}@media only screen and (max-width:596px){.small-float-center{margin:0 auto!important;float:none!important;text-align:center!important}.small-text-center{text-align:center!important}.small-text-left{text-align:left!important}.small-text-right{text-align:right!important}}@media only screen and (max-width:596px){table.body table.container .hide-for-large{display:block!important;width:auto!important;overflow:visible!important}}@media only screen and (max-width:596px){table.body table.container .row.hide-for-large{display:table!important;width:100%!important}}@media only screen and (max-width:596px){table.body table.container .show-for-large{display:none!important;width:0;mso-hide:all;overflow:hidden}}@media only screen and (max-width:596px){table.body img{width:auto!important;height:auto!important}table.body center{min-width:0!important}table.body .container{width:95%!important}table.body .column,table.body .columns{height:auto!important;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;padding-left:16px!important;padding-right:16px!important}table.body .column .column,table.body .column .columns,table.body .columns .column,table.body .columns .columns{padding-left:0!important;padding-right:0!important}table.body .collapse .column,table.body .collapse .columns{padding-left:0!important;padding-right:0!important}td.small-1,th.small-1{display:inline-block!important;width:8.33333%!important}td.small-2,th.small-2{display:inline-block!important;width:16.66667%!important}td.small-3,th.small-3{display:inline-block!important;width:25%!important}td.small-4,th.small-4{display:inline-block!important;width:33.33333%!important}td.small-5,th.small-5{display:inline-block!important;width:41.66667%!important}td.small-6,th.small-6{display:inline-block!important;width:50%!important}td.small-7,th.small-7{display:inline-block!important;width:58.33333%!important}td.small-8,th.small-8{display:inline-block!important;width:66.66667%!important}td.small-9,th.small-9{display:inline-block!important;width:75%!important}td.small-10,th.small-10{display:inline-block!important;width:83.33333%!important}td.small-11,th.small-11{display:inline-block!important;width:91.66667%!important}td.small-12,th.small-12{display:inline-block!important;width:100%!important}.column td.small-12,.column th.small-12,.columns td.small-12,.columns th.small-12{display:block!important;width:100%!important}table.body td.small-offset-1,table.body th.small-offset-1{margin-left:8.33333%!important;Margin-left:8.33333%!important}table.body td.small-offset-2,table.body th.small-offset-2{margin-left:16.66667%!important;Margin-left:16.66667%!important}table.body td.small-offset-3,table.body th.small-offset-3{margin-left:25%!important;Margin-left:25%!important}table.body td.small-offset-4,table.body th.small-offset-4{margin-left:33.33333%!important;Margin-left:33.33333%!important}table.body td.small-offset-5,table.body th.small-offset-5{margin-left:41.66667%!important;Margin-left:41.66667%!important}table.body td.small-offset-6,table.body th.small-offset-6{margin-left:50%!important;Margin-left:50%!important}table.body td.small-offset-7,table.body th.small-offset-7{margin-left:58.33333%!important;Margin-left:58.33333%!important}table.body td.small-offset-8,table.body th.small-offset-8{margin-left:66.66667%!important;Margin-left:66.66667%!important}table.body td.small-offset-9,table.body th.small-offset-9{margin-left:75%!important;Margin-left:75%!important}table.body td.small-offset-10,table.body th.small-offset-10{margin-left:83.33333%!important;Margin-left:83.33333%!important}table.body td.small-offset-11,table.body th.small-offset-11{margin-left:91.66667%!important;Margin-left:91.66667%!important}table.body table.columns td.expander,table.body table.columns th.expander{display:none!important}table.body .right-text-pad,table.body .text-pad-right{padding-left:10px!important}table.body .left-text-pad,table.body .text-pad-left{padding-right:10px!important}table.menu{width:100%!important}table.menu td,table.menu th{width:auto!important;display:inline-block!important}table.menu.small-vertical td,table.menu.small-vertical th,table.menu.vertical td,table.menu.vertical th{display:block!important}table.menu[align=center]{width:auto!important}}</style>
    <span class="preheader"></span>
    <table class="body" style="Margin:0;background:#eceff0;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;height:100%;line-height:19px;margin:0;padding:0;text-align:left;vertical-align:top;width:100%">
      <tr style="padding:0;text-align:left;vertical-align:top">
        <td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:19px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
          <center data-parsed="" style="min-width:580px;width:100%">
            <table class="container float-center" style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px">
              <tbody>
                <tr style="padding:0;text-align:left;vertical-align:top">
                  <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:19px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                  	<table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                      <tbody>
                        <tr style="padding:0;text-align:left;vertical-align:top">
                          <th class="large-12 small-12 small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                  <p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;line-height:5px;margin:0;margin-bottom:0px;padding:5px 0;text-align:right;">Si no visualitzes correctament el butlletí clica aquest <a href="<?php print drupal_get_path_alias('node/'.$node->nid);?>" style="color:black">enllaç</a></p>
                                </th>
                                <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                    <table class="row header" style="background-color:#b1290b;border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                      <tbody>
                        <tr style="padding:0;text-align:left;vertical-align:top">
                          <th class="large-8 small-12 small-12 large-6 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:8px;text-align:left;width:370.67px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                  <table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                    <tbody>
                                      <tr style="padding:0;text-align:left;vertical-align:top">
                                        <td height="20px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:400;hyphens:auto;line-height:20px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <h2 class="small-float-center" style="Margin:0;Margin-bottom:10px;color:#fefefe;font-family:Helvetica,Arial,sans-serif;font-size:23px;font-weight:400;line-height:1;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal">Alerta per a periodistes</h2>
                                  <p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;line-height:19px;margin:0;margin-bottom:0px;padding:0;text-align:left; color:white"><?php print $wrapper->title->value(); ?></p>
                                </th>
                              </tr>
                            </table>
                          </th>
                          <th class="large-4 small-12 small-12 large-6 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:8px;padding-right:16px;text-align:left;width:274px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                  <table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                    <tbody>
                                      <tr style="padding:0;text-align:left;vertical-align:top">
                                        <td height="20px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:400;hyphens:auto;line-height:20px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <a href="http://xarxanet.org" style="text-decoration:none;">
                                  	<img class="small-float-center float-right" src="http://www.xarxanet.org/sites/default/files/butlletins/premsa/logo_blanc.png" alt="logotip xarxanet" style="-ms-interpolation-mode:bicubic;clear:both;display:block;float:right;max-width:100%;outline:0;text-align:right;text-decoration:none;width:auto;border:0 none;" />
                                  </a>
                                </th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                      <tbody>
                        <tr style="padding:0;text-align:left;vertical-align:top">
                          <th class="large-12 small-12 small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">	
                                  <table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                    <tbody>
                                      <tr style="padding:0;text-align:left;vertical-align:top">
                                        <td height="20px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:400;hyphens:auto;line-height:20px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;margin-bottom:10px;padding:0;text-align:left">Aquest servei d’alertes us mantindrà informats sobre els principals esdeveniments que han de passar o han passat al tercer sector i al conjunt de l’àmbit no lucratiu. L’objectiu d’aquests enviaments és acostar-vos la realitat del sector per tal de facilitar-vos la tasca de donar veu al món de l’associacionisme i el voluntariat. Aquest és un servei del portal <a href="<?php echo $pathroot?>/sobre-el-projecte">xarxanet.org</a> per a periodistes.</p>
                                </th>
                                <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                    <hr style="Margin:20px auto;border-bottom:1px solid #cacaca;border-left:0;border-right:0;border-top:0;clear:both;height:0;margin:20px auto;max-width:580px">
                    <!-- 
                    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                      <tbody>
                        <tr style="padding:0;text-align:left;vertical-align:top">
                          <th class="large-12 small-12 small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                  <h1 style="Margin:0;Margin-bottom:10px;color:inherit;font-family:Helvetica,Arial,sans-serif;font-size:30px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal">Esdeveniments</h1>
                                </th>
                                <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                   -->
    <?php
    $events = array();
    foreach ($wrapper->field_premsa_esdeveniments as $event){
    	$link = $event->field_premsa_esd_enllac->value();
    	$date = $event->field_premsa_esd_data->value();    	
    	$start=new DateTime($date['value'],new DateTimeZone($date['timezone_db']));
    	$end=new DateTime($date['value2'],new DateTimeZone($date['timezone_db']));
    	$start->setTimezone(new DateTimeZone($date['timezone']));
    	$end->setTimezone(new DateTimeZone($date['timezone']));
    	if ($start != $end) {
    		$date_str = "Del {$start->format('d/m/Y, H:i')} al {$end->format('d/m/Y, H:i')}";
    	} else {
    		if ($start->format('H:i') == '00:00') { 
    			$date_str = "{$start->format('d/m/Y')}, tot el dia";
    		} else {
    			$date_str = $start->format('d/m/Y, H:i');
    		}
    	}    	
    	$events[strtotime($date['value'])] = array('link' => $link, 'date' => $date_str, 'teaser' => $event->field_premsa_esd_desc->value());
    }
    foreach ($wrapper->field_premsa_esdeveniments_xn as $event){
    	$event = $event->value();
    	$event = node_load($event->nid);
    	$link = array('url' => url('node/' . $event->nid, array('absolute' => TRUE)), 'title' => $event->title );
    	$event_wrapper = entity_metadata_wrapper('node', $event);
    	$date = $event_wrapper->field_date_event->value();
    	$start=new DateTime($date['value'],new DateTimeZone($date['timezone_db']));
    	$end=new DateTime($date['value2'],new DateTimeZone($date['timezone_db']));
    	$start->setTimezone(new DateTimeZone($date['timezone']));
    	$end->setTimezone(new DateTimeZone($date['timezone']));
    	$teaser = strip_html_tags(render(field_view_field('node', $event, 'field_resum', array('label' => 'hidden'))));
    	if ($start != $end) {
    		$date_str = "Del {$start->format('d/m/Y, H:i')} al {$end->format('d/m/Y, H:i')}";
    	} else {
    		if ($start->format('H:i') == '00:00') {
    			$date_str = "{$start->format('d/m/Y')}, tot el dia";
    		} else {
    			$date_str = $start->format('d/m/Y, H:i');
    		}
    	}
    	$events[strtotime($date['value'])] = array('link' => $link, 'date' => $date_str, 'teaser' => $teaser);
    }
    ksort($events);
    foreach ($events as $event): ?>
    			    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                      <tbody>
                        <tr style="padding:0;text-align:left;vertical-align:top">
                          <th class="large-12 small-12 small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                  <table class="callout" style="Margin-bottom:16px;border-collapse:collapse;border-spacing:0;margin-bottom:16px;padding:0;text-align:left;vertical-align:top;width:100%">
                                    <tr style="padding:0;text-align:left;vertical-align:top">
                                      <th class="callout-inner" style="Margin:0;background:#fefefe;border:1px solid #cbcbcb;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:10px 10px 0 10px;text-align:left;width:100%">
                                        <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                            <tr style="padding:0;text-align:left;vertical-align:top">
                                              <th class="large-12 small-12 small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:16px;text-align:left;width:100%">
                                                <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                  <tr style="padding:0;text-align:left;vertical-align:top">
                                                    <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                                      <h3 style="Margin:0;Margin-bottom:10px;color:inherit;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal"><a href="<?php print $event['link']['url'];?>" style="Margin:0;color:#b1290b;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><?php print $event['link']['title']?></a></h3>
                                                      <p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;margin-bottom:10px;padding:0;text-align:left"><i><?php print $event['date']; ?></i></p>
                                                      <p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php print $event['teaser']; ?></p>
                                                      <table class="button alert small" style="Margin:0 0 16px 0;border-collapse:collapse;border-spacing:0;margin:0 0 16px 0;padding:0;text-align:left;vertical-align:top;width:auto!important">
                                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                                          <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:19px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                              <tr style="padding:0;text-align:left;vertical-align:top">
                                                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background:#b1290b;border:2px solid #b1290b;border-collapse:collapse!important;color:#fefefe;font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;hyphens:auto;line-height:19px;margin:0;padding:5px 10px 5px 10px;text-align:left;vertical-align:top;word-wrap:break-word"><a href="<?php print $event['link']['url'];?>" style="Margin:0;border:0 solid #b1290b;border-radius:3px;color:#fefefe;display:inline-block;font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:700;line-height:1.3;margin:0;padding:5px 10px 5px 10px;text-align:left;text-decoration:none">Llegeix m&#xE9;s...</a></td>
                                                              </tr>
                                                            </table>
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </th>
                                                    <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                                                  </tr>
                                                </table>
                                              </th>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </th>
                                      <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                                    </tr>
                                  </table>
                                </th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
    <?php endforeach; ?>
    				<hr style="Margin:20px auto;border-bottom:1px solid #cacaca;border-left:0;border-right:0;border-top:0;clear:both;height:0;margin:20px auto;max-width:580px">
                    <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                      <tbody>
                        <tr style="padding:0;text-align:left;vertical-align:top">
                          <th class="large-12 small-12 small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                  <h1 style="Margin:0;Margin-bottom:10px;color:inherit;font-family:Helvetica,Arial,sans-serif;font-size:30px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal">També us pot interessar!</h1>
                                </th>
                                <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
    <?php 
    foreach ($wrapper->field_premsa_xarxanet as $xn): 
    	$xn = $xn->value();
    	$xn = node_load($xn->nid);
    	$url = url('node/' . $xn->nid, array('absolute' => TRUE)); ?>
    				<table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                      <tbody>
                        <tr style="padding:0;text-align:left;vertical-align:top">
                          <th class="large-12 small-12 small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                  <table class="callout" style="Margin-bottom:16px;border-collapse:collapse;border-spacing:0;margin-bottom:16px;padding:0;text-align:left;vertical-align:top;width:100%">
                                    <tr style="padding:0;text-align:left;vertical-align:top">
                                      <th class="callout-inner" style="Margin:0;background:#fefefe;border:1px solid #cbcbcb;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:10px 10px 0 10px;text-align:left;width:100%">
                                        <table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                          <tbody>
                                            <tr style="padding:0;text-align:left;vertical-align:top">
                                              <th class="large-12 small-12 small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:16px;text-align:left;width:100%">
                                                <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                  <tr style="padding:0;text-align:left;vertical-align:top">
                                                    <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                                      <h3 style="Margin:0;Margin-bottom:10px;color:inherit;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal"><a href="<?php print $url; ?>" style="Margin:0;color:#b1290b;font-family:Helvetica,Arial,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><?php print $xn->title; ?></a></h3>
                                                      <p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php print strip_html_tags(render(field_view_field('node', $xn, 'field_resum', array('label' => 'hidden'))));?></p>
                                                      <table class="button alert small" style="Margin:0 0 16px 0;border-collapse:collapse;border-spacing:0;margin:0 0 16px 0;padding:0;text-align:left;vertical-align:top;width:auto!important">
                                                        <tr style="padding:0;text-align:left;vertical-align:top">
                                                          <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;hyphens:auto;line-height:19px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                                              <tr style="padding:0;text-align:left;vertical-align:top">
                                                                <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background:#b1290b;border:2px solid #b1290b;border-collapse:collapse!important;color:#fefefe;font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;hyphens:auto;line-height:19px;margin:0;padding:5px 10px 5px 10px;text-align:left;vertical-align:top;word-wrap:break-word"><a href="<?php print $url; ?>" style="Margin:0;border:0 solid #b1290b;border-radius:3px;color:#fefefe;display:inline-block;font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:700;line-height:1.3;margin:0;padding:5px 10px 5px 10px;text-align:left;text-decoration:none">Llegeix m&#xE9;s...</a></td>
                                                              </tr>
                                                            </table>
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </th>
                                                    <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                                                  </tr>
                                                </table>
                                              </th>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </th>
                                      <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                                    </tr>
                                  </table>
                                </th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
    <?php endforeach; ?>
    				<table class="row footer" style="background-color:#cacaca;border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
                      <tbody>
                        <tr style="padding:0;text-align:left;vertical-align:top">
                          <th class="large-12 small-12 small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0 auto;padding:0;padding-bottom:10px;padding-left:16px;padding-right:16px;text-align:left;width:564px">
                            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                <th style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0;text-align:left">
                                  <table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                    <tbody>
                                      <tr style="padding:0;text-align:left;vertical-align:top">
                                        <td height="20px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:400;hyphens:auto;line-height:20px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <p class="text-right" style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;margin-bottom:10px;padding:0;text-align:right">
                                  	<a href="<?php echo $pathroot?>/baixa_premsa" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-weight:700;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">Donar-me de baixa</a>
                                  	| <a href="<?php echo $pathroot?>/alta_premsa" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-weight:700;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">Donar-me d'alta</a>
                                   	| <a href="mailto:incidencies@xarxanet.org?Subject=Consulta%20butlletí" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-weight:700;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">Contacte</a>
                                   	| <a href="<?php echo $pathroot?>/avis-legal" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-weight:700;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none">Avís legal</a></p>
                                </th>
                                <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:19px;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th>
                              </tr>
                            </table>
                          </th>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </center>
        </td>
      </tr>
    </table>
    <!-- prevent Gmail on iOS font size manipulation -->
    <div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0; &#xA0;</div>
  </body>
</html>

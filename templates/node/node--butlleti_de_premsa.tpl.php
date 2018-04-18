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
 
$wrapper = entity_metadata_wrapper('node', $node);
?>
<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <p>Aquest servei d’alertes us mantindrà informats sobre els principals esdeveniments que han de passar o han passat al tercer sector i al conjunt de l’àmbit no lucratiu. L’objectiu d’aquests enviaments és acostar-vos la realitat del sector per tal de facilitar-vos la tasca de donar veu al món de l’associacionisme i el voluntariat. Aquest és un servei del portal <a href="http://xarxanet.org/sobre-el-projecte">xarxanet.org</a> per a periodistes.</p>
    <hr/>
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
    
    foreach ($events as $event) {
    	print "<h3><a href='{$event['link']['url']}'>{$event['link']['title']}</a></h3>";
    	print "<p style='margin-bottom: 25px;'><i>{$event['date']}</i><br/>{$event['teaser']}</p>";
    }
    ?>
    <hr />
    <h1 style="margin:15px 0;">També us pot interessar!</h1>
    <?php 
    foreach ($wrapper->field_premsa_xarxanet as $xn){
    	$xn = $xn->value();
    	$xn = node_load($xn->nid);
    	$url = url('node/' . $xn->nid, array('absolute' => TRUE));
    	print "<h3><a href='{$url}'>{$xn->title}</a></h3><p style='margin-bottom: 25px;'>";
    	print strip_html_tags(render(field_view_field('node', $xn, 'field_resum', array('label' => 'hidden'))));
    	print "</p>";
    }
    ?>
</article><!-- /.node -->

<?php
/**
 * @file views-view-fields.tpl.php
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
*   - $field->separator: an optional separator that may appear before a field.
* - $row: The raw result object from the query, with all data it fetched.
*
* @ingroup views_templates
*/

$fb = strip_tags($fields['field_pagina_facebook']->content);
$tw = strip_tags($fields['field_twitter']->content);  
$inst = strip_tags($fields['field_instagram']->content);
$yt = strip_tags($fields['field_youtube']->content);  
$goo = strip_tags($fields['field_google']->content);    

if (!empty($fb) || !empty($tw) || !empty($inst) || !empty($yt) || !empty($goo) ) {
	print '<div id="social-block">
	<h2 class="sr-only">Xarxes Socials</h2>';
	if (!empty($fb)) {
		print '<a href="'.$fb.'" title="'.$fb.'"><img src="/sites/all/themes/xn17/assets/images/xxss/fb-icon.png"/></a>';
	}
	if (!empty($tw)) {
		print '<a href="'.$tw.'" title="'.$tw.'"><img src="/sites/all/themes/xn17/assets/images/xxss/twitter-icon.png"/></a>';
	}
	if (!empty($inst)) {
		print '<a href="'.$inst.'" title="'.$inst.'"><img src="/sites/all/themes/xn17/assets/images/xxss/inst-icon.png"/></a>';
	}
	if (!empty($yt)) {
		print '<a href="'.$yt.'" title="'.$yt.'"><img src="/sites/all/themes/xn17/assets/images/xxss/youtube-icon.png"/></a>';
	}
	if (!empty($goo)) {
		print '<a href="'.$goo.'" title="'.$goo.'"><img src="/sites/all/themes/xn17/assets/images/xxss/gplus-icon.png"/></a>';
	}
	print '</div>';
}

$uid = strip_tags($fields['uid']->content);
$news = views_get_view_result('noticies_de_l_entitat', NULL, $uid);
$events = views_get_view_result('esdeveniments_de_l_entitat', NULL, $uid);
$user=user_load($uid);
$username=$user->name;
$breadcrumb[] = l('Inici', null);
$breadcrumb[] = l('Entitats', 'entitats-col-laboradores');
$breadcrumb[] .= $username;
drupal_set_breadcrumb($breadcrumb);
print '<div id="content-block" >';
if (!empty($news)) {
	print '<div class="content-block-part">
				<div id="news-block">
					<a href="/noticies' . $_SERVER['REQUEST_URI'] . '">Notícies</a>
				</div>
			</div>';
}
if (!empty($events)) {
	print '<div class="content-block-part">
				<div id="events-block">
					<a href="/agenda' . $_SERVER['REQUEST_URI'] . '">Esdeveniments</a>
				</div>
			</div>';
}
print '</div>';

?>

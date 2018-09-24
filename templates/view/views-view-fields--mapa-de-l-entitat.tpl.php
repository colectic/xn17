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
//print "<pre>";
//print_r($fields['coordinates']->handler->view->result[0]);
//print "</pre>";
$latitude = $fields[coordinates]->handler->view->result[0]->location_latitude;
$longitude = $fields[coordinates]->handler->view->result[0]->location_longitude; 
$location = '' ;
print '<div class="entitatmapa ">';				
	if ($fields[coordinates]->handler->view->result[0]->location_street && $fields[coordinates]->handler->view->result[0]->location_city) {
		if ($fields[coordinates]->handler->view->result[0]->location_street != '') $location .= '<b>'.$fields[coordinates]->handler->view->result[0]->location_name.'</b> <br/>';
		$location .= '<b>'.$fields[coordinates]->handler->view->result[0]->users_name.'</b><br/>'.$fields[coordinates]->handler->view->result[0]->location_street.'<br/>'.$fields[coordinates]->handler->view->result[0]->location_city;
		
	}              	
	if ($latitude != 0 || $longitude != 0) {
		print gmap_simple_map($latitude, $longitude, '', $location, 'default', '269px', 'default');
	}

print '</div>'
?>

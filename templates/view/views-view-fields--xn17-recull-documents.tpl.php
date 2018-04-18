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
?>
<?php
print '<div class="modul_4x3">';
if(isset($fields['title']))  print '<'.$fields['title']->inline_html.' class="views-field-'.$fields['title']->class.'"><h2>'.$fields['title']->content.'</h2></'.$fields['title']->inline_html.'>';
$docs = explode('##||##', $fields['field_recull_docs_doc']->content);
$imgs = array();
$keys = array('','_1','_2','_3');

$i=0;
foreach ($keys as $key) {
	$fieldkey = 'field_doc_imatge'.$key;
	$img = $fields[$fieldkey]->content;
	$imgs[] = $img;

	$fieldkeysinopsi = 'field_doc_sinopsi'.$key;
	$sinopsi = $fields[$fieldkeysinopsi]->content;
	$sinopsis[] = $sinopsi;

	$fieldkeynid = 'nid'.$key;
	$nid = $fields[$fieldkeynid]->content;
	$nids[] = $nid;

	print '<div class="document-biblioteca">';
	$options = array('absolute' => TRUE);
	$path_alias = url('node/' . strip_tags($nids[$i]), $options);
		print '<div class="imatge">'.$imgs[$i];
			print '<a href="'. $path_alias . '"><div class="sinopsi field-item">'.$sinopsis[$i].'</div></a>';
		print '</div>';
	print '</div>';
	$i++;
}
print '</div>';
?>

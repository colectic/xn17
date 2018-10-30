	<?php
	/**
	 * @file
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
	 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
	 *   - $field->wrapper_suffix: The closing tag for the wrapper.
	 *   - $field->separator: an optional separator that may appear before a field.
	 *   - $field->label: The wrap label text to use.
	 *   - $field->label_html: The full HTML of the label to use including
	 *     configured element type.
	 * - $row: The raw result object from the query, with all data it fetched.
	 *
	 * @ingroup views_templates
	 */
	?>

	<?php
		
		/*if (strip_tags($rawImatge, '<img>') == '') $rawImatge = "<a href='" . strip_tags($fields['path']->content) . "'>" . theme_image_style (array('style_name' => 'tag-mig', 'path' => 'public://no-image.jpg', 'title' => 'just a test image', 'alt' => 'test image')) . "</a>";
		if ((strip_tags($fields['field_imatge_emergent']->content) != '') || (strip_tags($fields['field_video_emergent']->content) != '')) {
			if (strip_tags($fields['field_imatge_emergent']->content) != '') {
				//Imatge emergent
				$class = 'imatge';
				$newurl = strip_tags($fields['field_imatge_emergent']->content);
				$rel = "lightbox";
			}
			if (strip_tags($fields['field_video_emergent']->content) != '') {
				//Vídeo emergent
				$class = 'video';
				$rel = "lightframe";
				$newurl = strip_tags($fields['field_video_emergent']->content);
			}
			$title = strip_tags($fields['title']->content);
			$rawImatge = strip_tags($rawImatge, "<img>");
			$rawImatge = '	<div class="field-content lightbox-item">
				                '.$rawImatge.'
							  	<div class="content">
	 								<a rel="'.$rel.'" href="'.$newurl.'" class="info" title="'.$title.'"><img alt="icona '.$class.'" src="/sites/all/themes/sasson_xarxanet/images/pictos/emergent-'.$class.'.svg" /></a>
							  	</div>
				            </div>';
		}*/
		$rawImatge = $fields['field_agenda_imatge']->content;
		$type = $fields['type']->raw;

		if ($type == "opinio") { ?>
			<div class="view-id-xn17-opinio-secundaries view-id-xn17-opinio-secundaries_home">
				<div class="views-field views-field-field-autor-foto-quadrada">        
					<div class="field-content">
						<div class="modul_2x1">
							<div class="cont_titular_entradeta">
								<div class="rightimage">
									<?php echo $fields['field_autor_foto_quadrada']->content ?>
								</div>
								<div class="titular">
									<h4>
										<?php echo $fields['title']->content ?>
									</h4>
								</div>
							</div>
						</div>
						<div class="pie">
							<?php echo $fields['title_2']->content; ?>
						</div>
					</div>
				</div>
			</div>
		<?php	} else {
			print '<div class="modul_2x1">';
			print '<div>' . $rawImatge . '</div>';
			print '<div class="titular">';
				print '<h4>'. $fields['title']->content .'</h4>';
				
				if ($type == 'noticia_general'){
					$type = 'Notícies';
					$tipus = strip_tags($fields['field_ambit_noticia']->content);
					$tipus = "<a href='/noticies/{$tipus}'>{$tipus}</a>";
				}
				if ($type == 'event'){
					$type = 'Agenda';
					$tipus = strip_tags($fields['field_event_type']->content);
					$tipus = "<a href='/agenda?field_event_type_value={$tipus}'>{$tipus}</a>";
				}

			print '</div>';
			print '<div class="tipo-noticia">';
				print $type . ' > ' . $tipus;
			print '</div>';
			print '</div>';	
		}

	?>

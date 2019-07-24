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
	$title = $fields['title']->content;
	$image = $fields['field_agenda_imatge']->content;
	$content_type = $fields['type']->raw;
	$type = '';

	if (isset($content_type) && $content_type == 'noticia_general') {
		$type = strip_tags($fields['field_ambit_noticia']->content);
	}
	else if (isset($content_type) && $content_type == 'event') {
		$type = strip_tags($fields['field_event_type']->content);
	}
?>


<?php	if ($content_type == 'opinio'): ?>
	
	<!-- Box type: 'Opinion' -->
	
	<div class="box box-opinion">
		<article>
			<div class="first">
				<figure><?php print $image; ?></figure>
			</div>
			<div class="last">
				<div class="title">
					<header>
						<h2><?php print $title; ?></h2>
					</header>
				</div>
				<div class="type">
					<a href="/opinio">Opinió</a>
				</div>
			</div>
		</article>
	</div>
<?php endif; ?>


<?php	if ($content_type == 'noticia_general'): ?>
	
<!-- Box type: 'News' -->
	
	<div class="box box-news">
		<article>
			<div class="first">
				<figure><?php print $image; ?></figure>
				<?php if (!empty($fields['field_video_emergent']->content)): ?>
					<div class="video-trigger">
						<a rel="lightframe" role="button" href="<?php print $fields['field_video_emergent']->content; ?>" title="Fes clic per veure el vídeo sobre: <?php print $fields['title_1']->content; ?>">
							<img alt="icona video" src="/sites/all/themes/xn17/assets/images/icon/emergent-video.svg" />
						</a>
					</div>
				<?php endif; ?>
			</div>
			<div class="last">
				<div class="title">
					<header>
						<h2><?php print $title; ?></h2>
					</header>
				</div>
				<div class="type">
					<span>Notícies &gt;</span>
					<span><a href="/noticies/<?php print $type; ?>"><?php print $type; ?></a></span>
				</div>
			</div>
		</article>
	</div>
<?php endif; ?>


<?php	if ($content_type == 'event'): ?>

	<!-- Box type: 'Esdeveniment agenda' -->

	<div class="box box-news">
		<article>
			<div class="first">
				<figure><?php print $image; ?></figure>
			</div>
			<div class="last">
				<div class="title">
					<header>
						<h2><?php print $title; ?></h2>
					</header>
				</div>
				<div class="type">
					<span>Agenda &gt;</span>
					<span><a href="/agenda?field_event_type_value=<?php print $type; ?>"><?php print $type; ?></a></span>
				</div>
			</div>
		</article>
	</div>
<?php endif; ?>

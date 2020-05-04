<?php 

/**
* @file node.tpl.php
* Theme implementation to display a node.
*
* Available variables:
* - $title: the (sanitized) title of the node.
* - $content: Node body or teaser depending on $teaser flag.
* - $picture: The authors picture of the node output from
*   theme_user_picture().
* - $date: Formatted creation date (use $created to reformat with
*   format_date()).
* - $links: Themed links like "Read more", "Add new comment", etc. output
*   from theme_links().
* - $name: Themed username of node author output from theme_user().
* - $node_url: Direct url of the current node.
* - $terms: the themed list of taxonomy term links output from theme_links().
* - $submitted: themed submission information output from
*   theme_node_submitted().
*
* Other variables:
* - $node: Full node object. Contains data that may not be safe.
* - $type: Node type, i.e. story, page, blog, etc.
* - $comment_count: Number of comments attached to the node.
* - $uid: User ID of the node author.
* - $created: Time the node was published formatted in Unix timestamp.
* - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
*   teaser listings.
* - $id: Position of the node. Increments each time it's output.
*
* Helper variables:
* - $node_id: Outputs a unique id for each node.
* - $classes: Outputs dynamic classes for advanced themeing.
*
* Node status variables:
* - $teaser: Flag for the teaser state.
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
* @see template_preprocess()
* @see template_preprocess_node()
* @see genesis_preprocess_node()
* 
*/
?>

<?php

	// Variable declarations

	$path_root = 'https://xarxanet.org';
	$months = array('de gener', 'de febrer', 'de març', 'd\'abril', 'de maig', 'de juny', 'de juliol', 'd\'agost', 'de setembre', 'd\'octubre', 'de novembre', 'de desembre');
	$days = array('Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres', 'Dissabte', 'Diumenge');
	

	/**
	 * Destacats - data preprocessing
	 */

	$highlights_to_show = 3;
	$highlights = array();
	$wrapper = entity_metadata_wrapper('node', $node);

	foreach ($wrapper->field_abast_destacades as $item) {
		$referenced_node = $item->field_abast_destacades_xarxanet->value();
		$custom_title = $item->field_abast_destacades_titular->value();
		$picture = $item->field_abast_crop->value();
		$type = $referenced_node->type;
		
		if ($highlights_to_show != 0 && (($referenced_node) || ($custom_title))) {
			
			// Build the image

			if ($picture) {
				$image = file_create_url($picture[0]['uri']);
				$image = str_replace('xarxanet.local', 'xarxanet.org', $image);
				$alt_attribute = $picture[0]['alt'];
			}
			else if ($type == 'opinio') {
				// Let's get the author and his/her image
				$author = $referenced_node->field_autor_a['und'][0]['nid'];
				$author = node_load($author);
				$image = image_style_url('abast-gran', $author->field_autor_foto_horitzontal['und'][0]['uri']);
				$image = str_replace('xarxanet.local', 'xarxanet.org', $image);
				$alt_attribute = $author->field_autor_foto_horitzontal['und'][0]['alt'];
			}
			else if (!empty($referenced_node->field_agenda_imatge['und'])) {
				$image = image_style_url('abast-gran', $referenced_node->field_agenda_imatge['und'][0]['uri']);
				$image = str_replace('xarxanet.local', 'xarxanet.org', $image);
				$alt_attribute = $referenced_node->field_agenda_imatge['und'][0]['alt'];
			}
			else {
				$image = image_style_url('abast-gran', $referenced_node->field_imatges['und'][0]['uri']);
				$image = str_replace('xarxanet.local', 'xarxanet.org', $image);
				$alt_attribute = $referenced_node->field_imatges['und'][0]['alt'];
			}

			// Build the title & the link pointing to the content

			if ($custom_title) {
				$custom_title_anchor = $custom_title['title'];
				$custom_title_link = $custom_title['display_url'];
			} 
			else if ($referenced_node) {
				$custom_title_anchor = $referenced_node->title;
				$custom_title_link = url('node/' . $referenced_node->nid, array('absolute' => TRUE));
			}
			
			// Store the resulting data in an object, and add it to the array

			$highlight = new stdClass();
			$highlight->title = $custom_title_anchor;
			$highlight->link = $custom_title_link;
			$highlight->image = $image;
			$highlight->alt = $alt_attribute;
			$highlights[] = $highlight;

			$highlights_to_show--;
		}
	}

	/**
	 * Notícies - data preprocessing
	 */
	
	$articles = array();
	
	foreach ($wrapper->field_abast_noticies as $item) {
		$referenced_node = $item->field_abast_noticies_xarxanet->value();
		
		if ($referenced_node->nid) {
			$article_title = $referenced_node->title;
			$article_link = url('node/' . $referenced_node->nid, array('absolute' => TRUE));
			$article_teaser = $referenced_node->field_resum['und'][0]['value'];
			$article_type = $referenced_node->type;
			
			// Build the image

			if ($article_type == 'opinio') {
				// Let's get the author and his/her image
				$author = $referenced_node->field_autor_a['und'][0]['nid'];
				$author = node_load($author);
				$article_image = image_style_url('abast-gran', $author->field_autor_foto_horitzontal['und'][0]['uri']);
				$article_image = str_replace('xarxanet.local', 'xarxanet.org', $article_image);
				$article_alt_attribute = $author->field_autor_foto_horitzontal['und'][0]['alt'];
			}
			else if (!empty($referenced_node->field_agenda_imatge['und'])) {
				$article_image = image_style_url('abast-gran', $referenced_node->field_agenda_imatge['und'][0]['uri']);
				$article_image = str_replace('xarxanet.local', 'xarxanet.org', $article_image);
				$article_alt_attribute = $referenced_node->field_agenda_imatge['und'][0]['alt'];
			}
			else {
				$article_image = image_style_url('abast-gran', $referenced_node->field_imatges['und'][0]['uri']);
				$article_image = str_replace('xarxanet.local', 'xarxanet.org', $article_image);
				$article_alt_attribute = $referenced_node->field_imatges['und'][0]['alt'];
			}
		} 
		else {
			$custom_title = $item->field_abast_noticies_titular->value();
			$article_title = $custom_title['title'];
			$article_link = $custom_title['display_url'];
			$article_teaser = $item->field_abast_noticies_resum->value();
			$img = $item->field_abast_crop1->value();
			$article_image = file_create_url($img['uri']);
			$article_image = str_replace('xarxanet.local', 'xarxanet.org', $article_image);
			$article_alt_attribute = $img['alt'];
		}

		// Store the resulting data in an object, and add it to the array

		$article = new stdClass();
		$article->title = $article_title;
		$article->link = $article_link;
		$article->image = $article_image;
		$article->alt = $article_alt_attribute;
		$articles[] = $article;
	}

	/**
	 * Crides de voluntariat - data preprocessing
	 */

	$volunteerings = array();
	
	foreach ($wrapper->field_voluntariat as $item) {
		$referenced_node = $item->field_abast_voluntariat_xarxanet->value();
		
		if ($referenced_node->nid) {
			$volunteering_title = $referenced_node->title;
			$volunteering_link = url('node/' . $referenced_node->nid, array('absolute' => TRUE));
		} 
		else {
			$custom_title = $item->field_abast_voluntariat_titol->value();
			$volunteering_title = $custom_title['title'];
			$volunteering_link = $custom_title['url'];
		}

		$volunteering_entity = $item->field_abast_voluntariat_entitat->value();
		$volunteering_place = $item->field_abast_voluntariat_lloc->value();
		$volunteering_sector = $item->field_abast_voluntariat_dedicaci->value();
		$volunteering_profile = str_replace(array('<p>', '</p>'), '', $item->field_abast_voluntariat_perfil->value());

		// Store the resulting data in an object, and add it to the array

		$volunteering = new stdClass();
		$volunteering->title = $volunteering_title;
		$volunteering->link = $volunteering_link;
		$volunteering->entity = $volunteering_entity;
		$volunteering->place = $volunteering_place;
		$volunteering->sector = $volunteering_sector;
		$volunteering->profile = $volunteering_profile;
		$volunteerings[] = $volunteering;
	}

	/**
	 * Formació PFVC - data preprocessing
	 */

	$pfvcs = array();

	foreach ($wrapper->field_abast_pfvc as $item) {
		
		if ($custom_title = $item->field_abast_pfvc_titol->value()) {

			// Store the resulting data in an object, and add it to the array

			$pfvc = new stdClass();
			$pfvc->title = $custom_title['title'];
			$pfvc->link = $custom_title['url'];
			$pfvc->dates = $item->field_abast_pfvc_dates->value();
			$pfvc->place = $item->field_abast_pfvc_lloc->value();
			$pfvc->entity = $item->field_abast_pfvc_entitat->value();
			$pfvcs[] = $pfvc;
		}
	}

	/**
	 * Altres formacions (Formacions Xarxanet) - data preprocessing
	 */

	$trainings = array();

	foreach ($wrapper->field_abast_formacions_xn as $item) {
		$custom_training_place = '';
		$referenced_node = $item->field_abast_formacions_xarxanet->value();
		
		if ($referenced_node->nid) {
			$training_title = $referenced_node->title;
			$training_url = url('node/' . $referenced_node->nid, array('absolute' => TRUE));
			
			// Build the date of the training

			if ($item->field_abast_formacions_dates->value()) {
				$training_date = $item->field_abast_formacions_dates->value();
			}
			else {
				$timestamp = strtotime($referenced_node->field_date_event['und'][0]['value']);
				$training_date = $days[date('N', $timestamp) - 1] . ', ' . date('j', $timestamp) . ' ' . $months[date('n', $timestamp) - 1] . ' de ' . date('Y', $timestamp);
			}

			// Build the place of the training
			
			if ($referenced_node->location['name'] || $referenced_node->location['street'] || $referenced_node->location['city']) {
				
				if ($referenced_node->location['name']) {
					$custom_training_place .= $referenced_node->location['name'] . '. ';
				}
				if ($referenced_node->location['street']) {
					$custom_training_place .= $referenced_node->location['street'] . '. ';
				}
				if ($referenced_node->location['city']) {
					$custom_training_place .= $referenced_node->location['city'];
				}
			}
			
			$training_place = $item->field_abast_formacions_lloc->value();
			
			if (!$training_place && $custom_training_place) {
				$training_place = $custom_training_place;
			}
			if (!$training_place && $referenced_node->field_esdeveniment_en_linia['und'][0]['value']) {
				$training_place = 'Esdeveniment en línia';
			}

			// Build the entity
			
			if ($item->field_abast_formacions_entitat->value()) {
				$training_entity = $item->field_abast_formacions_entitat->value();
			}
			else {
				$training_entity = $referenced_node->field_organizer['und'][0]['value'];				
			}
			
			// Store the resulting data in an object, and add it to the array

			$training = new stdClass();
			$training->title = $training_title;
			$training->link = $training_url;
			$training->date = $training_date;
			$training->place = $training_place;
			$training->entity = $training_entity;
			$trainings[] = $training;
		}
	}

	/**
	 * Agenda d'activitats - data preprocessing
	 */

	$activities = array();

	foreach ($wrapper->field_abast_activitats as $item) {
		$referenced_node = $item->field_abast_activitats_xarxanet->value();
		
		if ($referenced_node->nid) {
			$activity_title = $referenced_node->title;
			$activity_url = url('node/' . $referenced_node->nid, array('absolute' => TRUE));
			
			// Build the date

			if ($item->field_abast_activitats_dates->value()) {
				$activity_date = $item->field_abast_activitats_dates->value();
			}
			else {
				$timestamp = strtotime($referenced_node->field_date_event['und'][0]['value']);
				$activity_date = $days[date('N', $timestamp) - 1] . ', ' . date('j', $timestamp) . ' ' . $months[date('n', $timestamp) - 1] . ' de ' . date('Y', $timestamp);
			}

			// Build the place

			$activity_location = $referenced_node->location['city'];
			
			if ($referenced_node->location['name']) {
				$activity_location = $referenced_node->location['name'] . ', ' . $activity_location;
			}
			
			if ($item->field_abast_activitats_lloc->value()) {
				$activity_place = $item->field_abast_activitats_lloc->value();
			}
			else {
				$activity_place = $activity_location;
			}
			
			// Build the entity

			if ($item->field_abast_activitats_entitat->value()) {
				$activity_entity = $item->field_abast_activitats_entitat->value();
			}
			else {
				$activity_entity = $referenced_node->field_organizer['und'][0]['value'];
			}
			
			// Store the resulting data in an object, and add it to the array

			$activity = new stdClass();
			$activity->title = $activity_title;
			$activity->link = $activity_url;
			$activity->date = $activity_date;
			$activity->place = $activity_place;
			$activity->entity = $activity_entity;
			$activities[] = $activity;
		}
	}

	/**
	 * Finançaments - data preprocessing
	 */

	$finances = array();

	foreach ($wrapper->field_abast_financament as $item) {
		$referenced_node = $item->field_abast_financament_xarxanet->value();
		
		if ($referenced_node->nid) {
			$finance_title = $referenced_node->title;
			$finance_url = url('node/' . $referenced_node->nid, array('absolute' => TRUE));
					
			if ($item->field_abast_financament_termini->value()) {
				$finance_period = $item->field_abast_financament_termini->value();
			}
			else {
				$begin_timestamp = strtotime($referenced_node->field_date['und'][0]['value']);
				$end_timestamp	 = strtotime($referenced_node->field_date['und'][0]['value2']);
				$finance_period  =	'Del ';
				$finance_period .=	lcfirst($days[date('N', $begin_timestamp) - 1]) . ', ' . date('j', $begin_timestamp) . ' ' . $months[date('n', $begin_timestamp) - 1] . ' de ' . date('Y', $begin_timestamp);
				$finance_period .=	' al ';
				$finance_period .=	lcfirst($days[date('N', $end_timestamp) - 1]) . ', ' . date('j', $end_timestamp) . ' ' . $months[date('n', $end_timestamp) - 1] . ' de ' . date('Y', $end_timestamp);
			}
			
			if ($item->field_abast_financament_convocan->value()) {
				$finance_entity = $item->field_abast_financament_convocan->value();
			}
			else {
				$finance_entity = strip_tags($referenced_node->field_convocant['und'][0]['value']);
			}

			// Store the resulting data in an object, and add it to the array

			$finance = new stdClass();
			$finance->title = $finance_title;
			$finance->link = $finance_url;
			$finance->date = $finance_period;
			$finance->entity = $finance_entity;
			$finances[] = $finance;
		}
	}

	/**
	 * Flexible block - data preprocessing
	 */

	$flexibles = array();

	$i = 0;
	foreach ($wrapper->field_abast_flexible as $item) {
		$flexible_section_title 		= $item->field_abast_flexible_titol->value();
		$internal_flexible_content 	= $item->field_abast_flexible_contingut->value();
		$external_flexible_content 	= $item->field_abast_extern->value();
				
		if ($flexible_section_title) {
			$flexibles[$i]['section_title'] = $flexible_section_title;
			
			// Build the internal contents (From xarxanet.org)
			
			foreach ($internal_flexible_content as $internal_content) {
				
				if ($internal_content->nid) {
					$internal_content_title = $internal_content->title;
					$internal_content_url = url('node/' . $internal_content->nid, array('absolute' => TRUE));
					$internal_content_type = $internal_content->type;
					
					if ($internal_content_type == 'opinio') {
						// Let's get the author and his/her image
						$author = $internal_content->field_autor_a['und'][0]['nid'];
						$author = node_load($author);
						$internal_content_image = image_style_url('abast-petit', $author->field_autor_foto_horitzontal['und'][0]['uri']);
						$internal_content_image = str_replace('xarxanet.local', 'xarxanet.org', $internal_content_image);
						$internal_content_alt_attribute = $author->field_autor_foto_horitzontal['und'][0]['alt'];
					}
					else if (isset($internal_content->field_agenda_imatge['und'][0]['uri'])) {
						$internal_content_image = image_style_url('abast-petit', $internal_content->field_agenda_imatge['und'][0]['uri']);
						$internal_content_image = str_replace('xarxanet.local', 'xarxanet.org', $internal_content_image);
						$internal_content_alt_attribute = $internal_content->field_agenda_imatge['und'][0]['alt'];
					}
					else {
						$internal_content_image = image_style_url('abast-petit', $internal_content->field_imatges['und'][0]['uri']);
						$internal_content_image = str_replace('xarxanet.local', 'xarxanet.org', $internal_content_image);
						$internal_content_alt_attribute = $internal_content->field_imatges['und'][0]['alt'];
					}

					// Store the resulting data in an object, and add it to the array

					$flexible = new stdClass();
					$flexible->title = $internal_content_title;
					$flexible->link = $internal_content_url;
					$flexible->image = $internal_content_image;
					$flexible->alt = $internal_content_alt_attribute;
					$flexible->teaser = strip_tags($internal_content->field_resum['und'][0]['value']);
					$flexibles[$i]['section_contents'][] = $flexible;
				}
			}

			// Build the external contents (From other sources)

			foreach ($external_flexible_content as $external_content) {
				$external_content_title = $external_content->field_abast_flexible_extern['und'][0]['title'];
				$external_content_url = $external_content->field_abast_flexible_extern['und'][0]['url'];
				$external_content_image = file_create_url($external_content->field_abast_flexible_imatge['und'][0]['uri']);
				$external_content_image = str_replace('xarxanet.local', 'xarxanet.org', $external_content_image);
				$external_content_alt_attribute = $external_content->field_abast_flexible_imatge['und'][0]['alt'];
				$external_content_teaser = strip_tags($external_content->field_abast_flexible_resum['und'][0]['value']);

				// Store the resulting data in an object, and add it to the array

				$flexible = new stdClass();
				$flexible->title = $external_content_title;
				$flexible->link = $external_content_url;
				$flexible->image = $external_content_image;
				$flexible->alt = $external_content_alt_attribute;
				$flexible->teaser = $external_content_teaser;
				$flexibles[$i]['section_contents'][] = $flexible;
			}

			// Build the bottom link of each section
			
			$link = $item->field_abast_flexible_enllac->value();

			if (!empty($link['title']) && !empty($link['url'])) {
				$flexible_bottom_link = new stdClass();
				$flexible_bottom_link->title = $link['title'];
				$flexible_bottom_link->url = $link['url'];
				$flexibles[$i]['bottom_link'] = $flexible_bottom_link;
			}
		}
		$i++;
	}

	/**
	 * Free block - data preprocessing
	 */

	$free_contents = array();

	foreach ($wrapper->field_abast_lliure as $item) {
		$free_content_title = $item->field_monografic_titol_1->value();
		$free_content_body = $item->field_monografic_cos_1->value();

		$free_content = new stdClass();

		if ($free_content_title) {
			$free_content->title = $free_content_title;
		}
		if ($free_content_body) {
			$free_content->body = $free_content_body['value'];
		}

		$free_contents[] = $free_content;
	}

	/**
	 * Interviews - data preprocessing
	 */

	$interviews = array();

	if ($wrapper->field_abast_entrevista_coll->count()) {
		$interview_section_title = $node->field_abast_entrevista_titol_sec['und'][0]['value'];
	}
			
	foreach ($wrapper->field_abast_entrevista_coll as $item) {
		$referenced_node = $item->field_abast_entrevista->value();
		
		if ($referenced_node->nid) {
			if (isset($referenced_node->field_agenda_imatge['und'][0]['uri'])) {
				$interview_image = image_style_url('abast-petit', $referenced_node->field_agenda_imatge['und'][0]['uri']);
				$interview_image = str_replace('xarxanet.local', 'xarxanet.org', $interview_image);
				$interview_image_alt_attribute = $referenced_node->field_agenda_imatge['und'][0]['alt'];
			}
			else{
				$interview_image = image_style_url('abast-petit', $referenced_node->field_imatges['und'][0]['uri']);
				$interview_image = str_replace('xarxanet.local', 'xarxanet.org', $interview_image);
				$interview_image_alt_attribute = $referenced_node->field_imatges['und'][0]['alt'];
			}
			$interview_title = ($item->field_abast_entrevista_titol->value()) ? $item->field_abast_entrevista_titol->value() : $referenced_node->title;
			$interview_link = url('node/' . $referenced_node->nid, array('absolute' => TRUE));
		} 
		else {
			$external_interview = $item->field_abast_entrevista_externa->value();
			$interview_title = $external_interview['title'];
			$interview_link = $external_interview['url'];
			$external_image = $item->field_abast_entrevista_imatge->value();
			$interview_image_alt_attribute = $external_image['alt'];
			$interview_image = file_create_url($external_image['uri']);
			$interview_image = str_replace('xarxanet.local', 'xarxanet.org', $interview_image);
		}
		
		// Store the resulting data in an object, and add it to the array

		$interview = new stdClass();
		$interview->title = $interview_title;
		$interview->link = $interview_link;
		$interview->image = $interview_image;
		$interview->alt = $interview_image_alt_attribute;
		$interview->quote = strip_tags($item->field_abast_entrevista_cita->value());
		$interviews[] = $interview;
	}

	/**
	 * Video - data preprocessing
	 */

	if ($node->field_abast_video['und'][0]['fid']) {
		
		// Build the title

		if (isset($node->field_abast_video_titol['und'][0]['value'])) {
			$video_title = $node->field_abast_video_titol['und'][0]['value'];
		}
		else {
			$video_title = 'El vídeo de la quinzena';
		}

		// Build the link

		if (isset($node->field_abast_video['und'][0]['url'])) {
			$video_link = $node->field_abast_video['und'][0]['url'];
		}
		else {
			$video_link = null;
		}

		// Build the cover

		if (isset($node->field_abast_video['und'][0]['uri'])) {
			$video_cover = file_create_url($node->field_abast_video['und'][0]['uri']);
			$video_cover = str_replace('xarxanet.local', 'xarxanet.org', $video_cover);
		}
		else {
			$video_cover = null;
		}

		// Build the alt attribute

		if (isset($node->field_abast_video['und'][0]['alt'])) {
			$video_alt_attribute = $node->field_abast_video['und'][0]['alt'];
		}
		else {
			$video_alt_attribute = null;
		}

		// Store the resulting data in an object

		$video = new stdClass();
		$video->title = $video_title;
		$video->link = $video_link;
		$video->image = $video_cover;
		$video->alt = $video_alt_attribute;
	}
?>

<!-- CSS Styles from TOTHOMweb -->
<style type="text/css">

	#main #content {
		background-color: #ffffff;
	}

	tbody {
		border: 0px;
	}

	table, table td, table tr {
		border-spacing: 0px !important;
		border-collapse: collapse !important;
		padding: 0px;
	}
	
	table td {
		border-top: 0px;
	}
</style>
<!-- @END CSS Styles from TOTHOMweb -->


<style>
	/* Basics */
	body {
		margin: 0 !important;
		padding: 0;
		/* background-color: #ffffff; */
	}
	#newsletter table {
		border-spacing: 0;
		font-family: sans-serif;
		color: #333333;
	}
	#newsletter td {
		padding: 0;
	}
	#newsletter img {
		border: 0;
	}
	#newsletter div[style*="margin: 16px 0"] { 
		margin:0 !important;
	}
	#newsletter.wrapper {
		width: 100%;
		table-layout: fixed;
		-webkit-text-size-adjust: 100%;
		-ms-text-size-adjust: 100%;
	}
	#newsletter .webkit {
		max-width: 602px;
		margin: 0 auto;
	}
	#newsletter .outer {
		Margin: 0 auto;
		width: 100%;
		max-width: 602px;
	}
	#newsletter .inner {
		padding: 20px;
	}
	#newsletter .contents {
		width: 100%;
	}
	#newsletter p {
		Margin: 0;
	}
	#newsletter a {
		color: #671013;
		text-decoration: underline;
	}
	#newsletter .h1 {
		Margin-bottom: 20px;
	}
	#newsletter .h2 {
		Margin-bottom: 15px;
	}
	#newsletter .full-width-image img {
		width: 100%;
		max-width: 600px;
		height: auto;
	}

	/* One column layout */

	#newsletter .one-column .contents {
		text-align: left;
	}
	#newsletter .one-column p {
		font-size: 14px;
		Margin-bottom: 10px;
	}
  
	/* Two column layout */

	#newsletter .two-column {
		text-align: center;
		font-size: 0;
	}
	#newsletter .two-column .column {
		width: 100%;
		max-width: 279px;
		display: inline-block;
		vertical-align: top;
	}
	#newsletter .two-column .contents {
		font-size: 14px;
		text-align: left;
	}
	#newsletter .two-column img {
		width: 100%;
		max-width: 279px;
		height: auto;
	}
	#newsletter .two-column .text {
		padding-top: 10px;
	}

	/* Three column layout */

	#newsletter .three-column {
		text-align: center;
		font-size: 0;
		padding-top: 10px;
		padding-bottom: 10px;
	}
	#newsletter .three-column .column {
		width: 100%;
		max-width: 180px;
		display: inline-block;
		vertical-align: top;
	}
	#newsletter .three-column img {
		width: 100%;
		max-width: 160px;
		height: auto;
	}
	#newsletter .three-column .contents {
		font-size: 14px;
		text-align: center;
	}
	#newsletter 	.three-column .text {
		padding-top: 10px;
	}

	/* Left sidebar layout */

	#newsletter .left-sidebar {
		text-align: center;
		font-size: 0;
	}
	#newsletter .left-sidebar .column {
		width: 100%;
		display: inline-block;
		vertical-align: middle;
	}
	#newsletter .left-sidebar .left {
		max-width: 140px;
	}
	#newsletter .left-sidebar .right {
		max-width: 460px;
	}
	#newsletter .left-sidebar .img {
		width: 100%;
		max-width: 60px;
		height: auto;
	}
	#newsletter .left-sidebar .contents {
		font-size: 14px;
		text-align: center;
	}
	#newsletter .left-sidebar a {
		color: #85ab70;
	}

	/* Right sidebar layout */

	#newsletter .right-sidebar {
		text-align: center;
		font-size: 0;
	}
	#newsletter .right-sidebar .column {
		width: 100%;
		display: inline-block;
		vertical-align: middle;
	}
	#newsletter .right-sidebar .left {
		max-width: 100px;
	}
	#newsletter .right-sidebar .right {
		max-width: 500px;
	}
	#newsletter .right-sidebar .img {
		width: 100%;
		max-width: 60px;
		height: auto;
	}
	#newsletter .right-sidebar .contents {
		font-size: 14px;
		text-align: center;
	}
	#newsletter .right-sidebar a {
		color: #70bbd9;
	}

	/* Media Queries */

	@media screen and (max-width: 400px) {
		#newsletter .two-column .column,
		#newsletter .three-column .column {
			max-width: 100% !important;
		}
		#newsletter .two-column img {
			max-width: 100% !important;
		}
		#newsletter .three-column img {
			max-width: 50% !important;
		}
	}

	@media screen and (min-width: 401px) and (max-width: 620px) {
		#newsletter .three-column .column {
			max-width: 33% !important;
		}
		#newsletter .two-column .column {
			max-width: 50% !important;
		}
	}
</style>

<!-- Custom styles  -->

<style>
	@font-face {
		font-family: 'Open Sans';
		src:  url(https://xarxanet.org/sites/all/themes/xn17/assets/fonts/butlleti_a_labast/opensans-regular-webfont.eot);
		src:  url(https://xarxanet.org/sites/all/themes/xn17/assets/fonts/butlleti_a_labast/opensans-regular-webfont.eot?#iefix) format('embedded-opentype'),
					url(https://xarxanet.org/sites/all/themes/xn17/assets/fonts/butlleti_a_labast/opensans-regular-webfont.woff2) format('woff2'),
					url(https://xarxanet.org/sites/all/themes/xn17/assets/fonts/butlleti_a_labast/opensans-regular-webfont.woff) format('woff'),
					url(https://xarxanet.org/sites/all/themes/xn17/assets/fonts/butlleti_a_labast/opensans-regular-webfont.ttf) format('truetype'),
					url(https://xarxanet.org/sites/all/themes/xn17/assets/fonts/butlleti_a_labast/opensans-regular-webfont.svg#open_sansregular) format('svg');
		font-display: swap;
		font-style: normal;
		font-weight: 400;
		mso-font-alt: 'Arial';
	}
	body {
		background-color: #fafafa;
		background: #fafafa;
	}
	#newsletter .outer {
		border: 1px solid #dddddd;
	}
	#newsletter .outer * {
		font-family: 'Open sans' !important;
	}
	#newsletter .background-red {
		background: #671013;
	}
	#newsletter .background-gray {
		background: #eeeeee;
	}
	#newsletter .background-white {
		background: #ffffff;
	}
	#newsletter .section-title {
		font-weight: 800;
		font-size: 22px !important;
		Margin: 0px;
		color: #333333;
	}
	#newsletter .post-title {
		color: #333333;
		font-weight: 800;
		text-decoration: none;
		line-height: 1em;
	}
	#newsletter .thin {
		font-weight: 400;
	}
	#newsletter .regular {
		font-weight: 600;
	}
	#newsletter .bold {
		font-weight: 800;
	}
	#newsletter .text-xxs {
		font-size: 10px !important;
	}
	#newsletter .text-xs {
		font-size: 12px !important;
	}
	#newsletter .text-sm {
		font-size: 14px !important;
	}
	#newsletter .text-md {
		font-size: 16px !important;
	}
	#newsletter .text-lg {
		font-size: 18px !important;
	}
	#newsletter .text-xl {
		font-size: 20px !important;
	}
	#newsletter .text-xxl {
		font-size: 22px !important;
	}
	#newsletter .text-white {
		color: #ffffff;
	}
	#newsletter .text-black {
		color: #333333;
	}
	#newsletter .text-black {
		color: #333333;
	}
	#newsletter .text-red {
		color: #671013 !important;
	}
	#newsletter .text-center {
		text-align: center;
	}
	#newsletter .text-left {
		text-align: left;
	}
	#newsletter .inner-top {
		padding-top: 20px;
	}
	#newsletter .inner-left {
		padding-left: 20px;
	}
	#newsletter .inner-right {
		padding-right: 20px;
	}
	#newsletter .inner-bottom {
		padding-bottom: 20px;
	}
	#newsletter .lh-0 {
		line-height: 0px;
	}
	#newsletter .bordered {
		border: 1px solid #dddddd !important;
	}
	#newsletter .box-shadow {
		background: #eeeeee;
	}
	#newsletter .box-shadow img {
		width: 100% !important;
		max-width: none !important;
		vertical-align: top;
	}
	#newsletter .button {
		padding: 4px 10px;
	}
	#newsletter .button a {
		font-weight: 200;
	}
	#newsletter .no-decoration {
		text-decoration: none;
	}
	#newsletter .list {
		padding-left: 20px;
		Margin: 0px 0px 20px 0px;
	}
	#newsletter .list h3 {
		Margin: 0 0 15px 0;
	}
	#newsletter .list h3 a {
		color: #671013;
		text-decoration: none;
	}
	#newsletter .list li {
		color: #671013;
		Margin-left: 0px;
		Margin-bottom: 20px;
	}
	#newsletter .list p {
		color: #333333;
	}
	#newsletter .quote-begin {
		vertical-align: top;
	}
	#newsletter .quote {
		vertical-align: center;
		font-style: italic;
		color: #333333;
		text-align: center;
	}
	#newsletter .quote-end {
		vertical-align: bottom;
	}
	#newsletter img.one-column-image  {
		width: 100%;
		max-width: 558px;
		height: auto;
	}
	#newsletter .inline-links {
		display: inline-block;
		Margin: 0 5px;
		width: auto;
	}

	/* Media Queries */

	@media screen and (max-width: 400px) {

		#newsletter #logo-gencat {
			width: 100%;
			height: auto;
			max-width: 100px;
		}
		#newsletter #logo-abast {
			width: 100%;
			height: auto;
			min-width: 130px;
		}
		#newsletter .box-shadow img {
			Margin-bottom: 10px;
		}
		#newsletter .inline-links {
			display: block;
			Margin: 3px 20px;
			width: 100%;
		}
	}
</style>

<center id="newsletter" class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
	<div class="webkit" style="max-width:602px;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;">
		<!--[if (gte mso 9)|(IE)]>
		<table width="600" align="center" style="border-spacing:0;font-family:sans-serif;color:#333333;">
		<tr>
		<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
		<![endif]-->
		<table class="outer" align="center" style="border-spacing:0;font-family:sans-serif;color:#333333;Margin:0 auto;width:100%;max-width:602px;border-width:1px;border-style:solid;border-color:#dddddd;">
			
			<!-- Header -->

			<tr>
				<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
					<table width="100%" class="background-red" bgcolor="#671013" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#671013;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
						<tr>
							<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
								<img id="logo-gencat" src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/logotip_generalitat_catalunya_header.png?token=<?php print time(); ?>" width="120" alt="" style="border-width:0;font-family:'Open sans' !important;" />
							</td>
							<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
								<img id="logo-abast" src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/logotip_a_labast.png?token=<?php print time(); ?>" width="180" alt="" style="border-width:0;font-family:'Open sans' !important;" />
							</td>
						</tr>
						<tr>
							<td class="inner contents" colspan="2" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
								<p class="h1 text-xxl text-white bold" style="Margin:0;font-family:'Open sans' !important;font-weight:800;color:#ffffff;font-size:22px !important;Margin-bottom:10px;">Butlletí del voluntariat català</p>
								<p class="text-xxl text-white regular" style="Margin:0;font-family:'Open sans' !important;font-weight:600;color:#ffffff;font-size:22px !important;Margin-bottom:10px;">A l'abast</p>
								<p class="text-lg text-white thin" style="Margin:0;font-family:'Open sans' !important;font-weight:400;color:#ffffff;font-size:18px !important;Margin-bottom:10px;"><?php print t(date('F', $node->created)); ?> <?php print t(date('Y', $node->created)); ?> #<?php print $title; ?></p>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<!-- Section: "Destacats" -->

			<?php if (!empty($highlights)): ?>
				<tr>
					<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
									<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
										<tr>
											<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
												<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;">Destacats</h2>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<?php $i = 1; ?>
				<?php foreach ($highlights as $highlight): ?>
					<?php if ($i % 2 != 0): ?>

						<!-- Model A (image to the left) -->

						<tr>
							<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
									<tr summary="two-columns" style="font-family:'Open sans' !important;">
										<td class="inner-left inner-right" style="padding-top:0;padding-bottom:0;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;">
											<table width="100%" bgcolor="#ffffff" class="background-white bordered" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-width:1px !important;border-style:solid !important;border-color:#dddddd !important;">
												<tr>
													<td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;font-family:'Open sans' !important;">
														<!--[if (gte mso 9)|(IE)]>
														<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
														<tr>
														<td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="lh-0" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;line-height:0px;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
																					<a href="<?php print $highlight->link; ?>">
																						<img src="<?php print $highlight->image; ?>" width="279" alt="" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																					</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td><td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td class="text" style="padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;padding-top:10px;">
																					<a class="post-title text-md" href="<?php print $highlight->link; ?>" style="font-family:'Open sans' !important;color:#333333;font-weight:800;text-decoration:none;font-size:16px !important;"><?php print $highlight->title; ?></a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																		<table bgcolor="#671013" class="background-red" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#671013;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;width: auto;">
																			<tr>
																				<td class="button" style="font-family:'Open sans' !important;padding-top:4px;padding-bottom:4px;padding-right:10px;padding-left:10px;">
																					<a class="text-sm no-decoration text-white" href="<?php print $highlight->link; ?>" style="font-family:'Open sans' !important;font-size:14px !important;color:#ffffff;text-decoration:none;font-weight:200;">Llegiu-ne més</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
											</table>
											<table width="100%" class="box-shadow" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
												<tr>
													<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/shadow_bottom.jpg?token=<?php print time(); ?>" border="0" alt="" width="558" style="border-width:0;font-family:'Open sans' !important;width:100% !important;max-width:none !important;" />
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php else: ?>

						<!-- Model B (image to the right) -->

						<tr>
							<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
									<tr summary="two-columns" style="font-family:'Open sans' !important;">
										<td class="inner-left inner-right" style="padding-top:0;padding-bottom:0;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;">
											<table width="100%" bgcolor="#ffffff" class="background-white bordered" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-width:1px !important;border-style:solid !important;border-color:#dddddd !important;">
												<tr>
													<td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;font-family:'Open sans' !important;">
														<!--[if (gte mso 9)|(IE)]>
														<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
														<tr>
														<td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td class="text" style="padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;padding-top:10px;">
																					<a class="post-title text-md" href="<?php print $highlight->link; ?>" style="font-family:'Open sans' !important;color:#333333;font-weight:800;text-decoration:none;font-size:16px !important;"><?php print $highlight->title; ?></a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																		<table bgcolor="#671013" class="background-red" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#671013;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;width: auto;">
																			<tr>
																				<td class="button" style="font-family:'Open sans' !important;padding-top:4px;padding-bottom:4px;padding-right:10px;padding-left:10px;">
																					<a class="text-sm no-decoration text-white" href="<?php print $highlight->link; ?>" style="font-family:'Open sans' !important;font-size:14px !important;color:#ffffff;text-decoration:none;font-weight:200;">Llegiu-ne més</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td><td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="lh-0" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;line-height:0px;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
																					<a href="<?php print $highlight->link; ?>">
																						<img src="<?php print $highlight->image; ?>" width="279" alt="" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																					</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
											</table>
											<table width="100%" class="box-shadow" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
												<tr>
													<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/shadow_bottom.jpg?token=<?php print time(); ?>" border="0" alt="" width="558" style="border-width:0;font-family:'Open sans' !important;width:100% !important;max-width:none !important;" />
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php endif; ?>
					<?php $i++; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<!-- Section: "Notícies" -->
			
			<?php if (!empty($articles)): ?>
				<tr>
					<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
									<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
										<tr>
											<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
												<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;">Notícies</h2>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<?php $i = 1; ?>
				<?php foreach ($articles as $article): ?>
					<?php if ($i % 2 != 0): ?>

						<!-- Model A (image to the left) -->

						<tr>
							<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
									<tr summary="two-columns" style="font-family:'Open sans' !important;">
										<td class="inner-left inner-right" style="padding-top:0;padding-bottom:0;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;">
											<table width="100%" bgcolor="#ffffff" class="background-white bordered" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-width:1px !important;border-style:solid !important;border-color:#dddddd !important;">
												<tr>
													<td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;font-family:'Open sans' !important;">
														<!--[if (gte mso 9)|(IE)]>
														<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
														<tr>
														<td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="lh-0" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;line-height:0px;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
																					<a href="<?php print $article->link; ?>">
																						<img src="<?php print $article->image; ?>" width="279" alt="" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																						</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td><td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td class="text" style="padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;padding-top:10px;">
																					<a class="post-title text-md" href="<?php print $article->link; ?>" style="font-family:'Open sans' !important;color:#333333;font-weight:800;text-decoration:none;font-size:16px !important;"><?php print $article->title; ?></a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																		<table bgcolor="#671013" class="background-red" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#671013;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;width: auto;">
																			<tr>
																				<td class="button" style="font-family:'Open sans' !important;padding-top:4px;padding-bottom:4px;padding-right:10px;padding-left:10px;">
																					<a class="text-sm no-decoration text-white" href="<?php print $article->link; ?>" style="font-family:'Open sans' !important;font-size:14px !important;color:#ffffff;text-decoration:none;font-weight:200;">Llegiu-ne més</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
											</table>
											<table width="100%" bgcolor="#eeeeee" class="box-shadow" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
												<tr>
													<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/shadow_bottom.jpg?token=<?php print time(); ?>" border="0" alt="" width="558" style="border-width:0;font-family:'Open sans' !important;width:100% !important;max-width:none !important;" />
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php else: ?>

						<!-- Model B (image to the right) -->

						<tr>
							<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
									<tr summary="two-columns" style="font-family:'Open sans' !important;">
										<td class="inner-left inner-right" style="padding-top:0;padding-bottom:0;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;">
											<table width="100%" bgcolor="#ffffff" class="background-white bordered" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-width:1px !important;border-style:solid !important;border-color:#dddddd !important;">
												<tr>
													<td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;font-family:'Open sans' !important;">
														<!--[if (gte mso 9)|(IE)]>
														<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
														<tr>
														<td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td class="text" style="padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;padding-top:10px;">
																					<a class="post-title text-md" href="<?php print $article->link; ?>" style="font-family:'Open sans' !important;color:#333333;font-weight:800;text-decoration:none;font-size:16px !important;"><?php print $article->title; ?></a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																		<table bgcolor="#671013" class="background-red" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#671013;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;width: auto;">
																			<tr>
																				<td class="button" style="font-family:'Open sans' !important;padding-top:4px;padding-bottom:4px;padding-right:10px;padding-left:10px;">
																					<a class="text-sm no-decoration text-white" href="<?php print $article->link; ?>" style="font-family:'Open sans' !important;font-size:14px !important;color:#ffffff;text-decoration:none;font-weight:200;">Llegiu-ne més</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td><td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="lh-0" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;line-height:0px;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
																					<a href="<?php print $article->link; ?>">
																						<img src="<?php print $article->image; ?>" width="279" alt="" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																					</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
											</table>
											<table width="100%" class="box-shadow" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
												<tr>
													<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/shadow_bottom.jpg?token=<?php print time(); ?>" border="0" alt="" width="558" style="border-width:0;font-family:'Open sans' !important;width:100% !important;max-width:none !important;" />
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php endif; ?>
					<?php $i++; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<!-- Section: Crides de voluntariat -->

			<?php if (!empty($volunteerings)): ?>
				<tr>
					<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
									<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
										<tr>
										<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
												<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;">Crides de voluntariat</h2>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="inner-left inner-right inner-bottom contents" style="padding-top:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;padding-bottom:20px;text-align:left;">
									<ul class="list" style="font-family:'Open sans' !important;padding-left:20px;Margin:0px 0px 20px 0px;">
										<?php foreach ($volunteerings as $volunteering): ?>
											<li style="font-family:'Open sans' !important;color:#671013;Margin-left:0px;Margin-bottom:20px;">
												<h3 class="text-md regular" style="font-family:'Open sans' !important;font-size:16px !important;Margin:0 0 15px 0;">
													<a href="<?php print $volunteering->link; ?>" style="font-family:'Open sans' !important;color:#671013;text-decoration:none;"><?php print $volunteering->title; ?></a>
												</h3>
												<?php if ($volunteering->entity): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Entitat:</b> <?php print $volunteering->entity; ?></p>
												<?php endif; ?>
												<?php if ($volunteering->place): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Lloc:</b> <?php print $volunteering->place; ?></p>
												<?php endif; ?>
												<?php if ($volunteering->sector): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Dedicació:</b> <?php print $volunteering->sector; ?></p>
												<?php endif; ?>
												<?php if ($volunteering->profile): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Perfil:</b> <?php print $volunteering->profile; ?></p>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php endif; ?>

			<!-- Section: Pla de Formació del voluntariat de Catalunya -->

			<?php if (!empty($pfvcs)): ?>
				<tr>
					<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
									<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
										<tr>
											<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
												<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;">Pla de Formació del voluntariat de Catalunya</h2>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="inner-left inner-right inner-bottom contents" style="padding-top:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;padding-bottom:20px;text-align:left;">
									<ul class="list" style="font-family:'Open sans' !important;padding-left:20px;Margin:0px 0px 20px 0px;">
										<?php foreach ($pfvcs as $pfvc): ?>
											<li style="font-family:'Open sans' !important;color:#671013;Margin-left:0px;Margin-bottom:20px;">
												<h3 class="text-md regular" style="font-family:'Open sans' !important;font-size:16px !important;Margin:0 0 15px 0;">
													<a href="<?php print $pfvc->link; ?>" style="font-family:'Open sans' !important;color:#671013;text-decoration:none;"><?php print $pfvc->title; ?></a>
												</h3>
												<?php if ($pfvc->dates): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Data d'inici:</b> <?php print $pfvc->dates; ?></p>
												<?php endif; ?>
												<?php if ($pfvc->place): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Lloc:</b> <?php print $pfvc->place; ?></p>
												<?php endif; ?>
												<?php if ($pfvc->entity): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Entitat:</b> <?php print $pfvc->entity; ?></p>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php endif; ?>

			<!-- Section: "Altres formacions (Formacions Xarxanet)" -->

			<?php if (!empty($trainings)): ?>
				<tr>
					<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
									<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
										<tr>
											<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
												<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;">Altres formacions</h2>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="inner-left inner-right inner-bottom contents" style="padding-top:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;padding-bottom:20px;text-align:left;">
									<ul class="list" style="font-family:'Open sans' !important;padding-left:20px;Margin:0px 0px 20px 0px;">
										<?php foreach ($trainings as $training): ?>
											<li style="font-family:'Open sans' !important;color:#671013;Margin-left:0px;Margin-bottom:20px;">
												<h3 class="text-md regular" style="font-family:'Open sans' !important;font-size:16px !important;Margin:0 0 15px 0;">
													<a href="<?php print $training->link; ?>" style="font-family:'Open sans' !important;color:#671013;text-decoration:none;"><?php print $training->title; ?></a>
												</h3>
												<?php if ($training->date): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Data d'inici:</b> <?php print $training->date; ?></p>
												<?php endif; ?>
												<?php if ($training->place): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Lloc:</b> <?php print $training->place; ?></p>
												<?php endif; ?>
												<?php if ($training->entity): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Entitat:</b> <?php print $training->entity; ?></p>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php endif; ?>

			<!-- Section: "Agenda d'activitats" -->

			<?php if (!empty($activities)): ?>
				<tr>
					<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
									<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
										<tr>
											<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
												<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;">Agenda d'activitats</h2>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="inner-left inner-right inner-bottom contents" style="padding-top:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;padding-bottom:20px;text-align:left;">
									<ul class="list" style="font-family:'Open sans' !important;padding-left:20px;Margin:0px 0px 20px 0px;">
										<?php foreach ($activities as $activity): ?>
											<li style="font-family:'Open sans' !important;color:#671013;Margin-left:0px;Margin-bottom:20px;">
												<h3 class="text-md regular" style="font-family:'Open sans' !important;font-size:16px !important;Margin:0 0 15px 0;">
													<a href="<?php print $activity->link; ?>" style="font-family:'Open sans' !important;color:#671013;text-decoration:none;"><?php print $activity->title; ?></a>
												</h3>
												<?php if ($activity->date): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Data d'inici:</b> <?php print $activity->date; ?></p>
												<?php endif; ?>
												<?php if ($activity->place): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Lloc:</b> <?php print $activity->place; ?></p>
												<?php endif; ?>
												<?php if ($activity->entity): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Entitat:</b> <?php print $activity->entity; ?></p>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php endif; ?>

			<!-- Section: Finançaments -->

			<?php if (!empty($finances)): ?>
				<tr>
					<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
									<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
										<tr>
										<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
												<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;">Finançaments</h2>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="inner-left inner-right inner-bottom contents" style="padding-top:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;padding-bottom:20px;text-align:left;">
									<ul class="list" style="font-family:'Open sans' !important;padding-left:20px;Margin:0px 0px 20px 0px;">
										<?php foreach ($finances as $finance): ?>
											<li style="font-family:'Open sans' !important;color:#671013;Margin-left:0px;Margin-bottom:20px;">
												<h3 class="text-md regular" style="font-family:'Open sans' !important;font-size:16px !important;Margin:0 0 15px 0;">
													<a href="<?php print $finance->link; ?>" style="font-family:'Open sans' !important;color:#671013;text-decoration:none;"><?php print $finance->title; ?></a>
												</h3>
												<?php if ($finance->date): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Termini:</b> <?php print $finance->date; ?></p>
												<?php endif; ?>
												<?php if ($finance->entity): ?>
													<p class="text-sm" style="Margin:0;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><b>Convocant:</b> <?php print $finance->entity; ?></p>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php endif; ?>

			<!-- Section: "Flexible block" -->

			<?php if (!empty($flexibles)): ?>
				<?php foreach ($flexibles as $flexible): ?>
					<tr>
						<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
							<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
								<tr>
									<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
										<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
											<tr>
											<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
													<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;"><?php print $flexible['section_title']; ?></h2>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
							<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
								<tr>
									<td class="inner-left inner-right inner-bottom contents" style="padding-top:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;padding-bottom:20px;text-align:left;">
										<ul class="list" style="font-family:'Open sans' !important;padding-left:20px;Margin:0px 0px 20px 0px;">
											<?php foreach ($flexible['section_contents'] as $flexible_content): ?>
												<li style="font-family:'Open sans' !important;color:#671013;Margin-left:0px;Margin-bottom:20px;">
													<h3 class="text-md regular" style="font-family:'Open sans' !important;font-size:16px !important;Margin:0 0 15px 0;">
														<a href="<?php print $flexible_content->link; ?>" style="font-family:'Open sans' !important;color:#671013;text-decoration:none;"><?php print $flexible_content->title; ?></a>
													</h3>
													<?php if ($flexible_content->teaser): ?>
														<p class="text-sm" style="Margin:15px 0px 0px 0px;font-family:'Open sans' !important;font-size:14px !important;Margin-bottom:10px;color:#333333;"><?php print $flexible_content->teaser; ?></p>
													<?php endif; ?>
												</li>
											<?php endforeach; ?>
										</ul>
									</td>
								</tr>

								<tr>
									<td>
										<table align="center" bgcolor="#671013" border="0" cellspacing="0" cellpadding="0" style="display: table; margin: 15px auto 20px; width: auto; background-color: #671013; padding: 0px;">
											<tr style="padding: 0px;">
												<td align="center" style="padding: 10px; font-family: 'Open sans' !important; text-align: center; font-size: 14px; vertical-align: middle;">
													<a style="font-family:'Open sans' !important; color: #ffffff; text-decoration: none;" href="<?php print $flexible['bottom_link']->url; ?>" alt="<?php print $flexible['bottom_link']->title; ?>" target="_blank">
														<?php print $flexible['bottom_link']->title; ?>
													</a>
												</td>
											</tr>
										</table>
										<br />
										<br />
									</td>
								</tr>
							</table>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>

			<!-- Section: "Free block" -->

			<?php if (!empty($free_contents)): ?>
				<?php foreach ($free_contents as $free_content): ?>
					<?php if ($free_content->title): ?>
						<tr>
							<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
									<tr>
										<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
											<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
												<tr>
												<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
														<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;"><?php print $free_content->title; ?></h2>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php endif; ?>

					<?php if ($free_content->body): ?>
						<tr>
							<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<table width="100%" bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
									<tr>
										<td class="inner-left inner-right inner-bottom contents" style="padding-top:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;padding-bottom:20px;text-align:left;">
											<?php print $free_content->body; ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<!-- Section: Vídeo -->

			<?php if (!empty($video)): ?>
				<tr>
					<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
							<tr>
								<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
									<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
										<tr>
										<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
												<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;">Vídeo</h2>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
						<table width="100%" bgcolor="#ffffff" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
						<tr>
								<td class="inner-left inner-right contents" style="padding-top:0;padding-bottom:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;text-align:left;">
									<a href="<?php print $video->link; ?>" target="_blank" style="color:#ee6a56;text-decoration:underline;font-family:'Open sans' !important;">
										<img class="one-column-image" src="<?php print $video->image; ?>" alt="Vídeo - <?php print $video->title; ?>" width="558" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:558px;height:auto;" />
									</a>
								</td>
							</tr>
							<tr>
								<td class="inner-left inner-right inner-bottom contents" style="padding-top:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;padding-bottom:20px;text-align:left;">
									<p class="text-md regular text-center text-red" style="Margin:10px 0px 0px 0px;font-family:'Open sans' !important;font-weight:600;color:#671013 !important;text-align:center;font-size:16px !important;Margin-bottom:10px;">Vídeo - <?php print $video->title; ?></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php endif; ?>

			<!-- Section: "L'entrevista" -->

			<?php if (!empty($interviews)): ?>
				<?php if ($interview_section_title): ?>
					<tr>
						<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
							<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
								<tr>
									<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
										<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
											<tr>
												<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
													<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;"><?php print $interview_section_title; ?></h2>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				<?php endif; ?>

				<?php $i = 1; ?>
				<?php foreach ($interviews as $interview): ?>
					<?php if ($i % 2 != 0): ?>
						<tr>
							<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
									<tr summary="two-columns" style="font-family:'Open sans' !important;">
										<td class="inner-left inner-right" style="padding-top:0;padding-bottom:0;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;">
											<table width="100%" bgcolor="#ffffff" class="background-white bordered" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-width:1px !important;border-style:solid !important;border-color:#dddddd !important;">
												<tr>
													<td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;font-family:'Open sans' !important;">
														<!--[if (gte mso 9)|(IE)]>
														<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
														<tr>
														<td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="lh-0" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;line-height:0px;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
																					<img src="<?php print $interview->image; ?>" width="279" alt="" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td><td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="inner-top inner-left inner-right" style="padding-bottom:0;font-family:'Open sans' !important;padding-top:20px;padding-left:20px;padding-right:20px;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td class="text" style="padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;padding-top:10px;">
																					<a class="post-title text-red text-md" href="<?php print $interview->link; ?>" style="font-family:'Open sans' !important;font-weight:800;text-decoration:none;font-size:16px !important;color:#671013 !important;"><?php print $interview->title; ?></a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<?php if ($interview->quote): ?>
																	<tr>
																		<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																			<table bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
																				<tr>
																					<td class="quote-begin" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;vertical-align:top;">
																						<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/quote_begin.gif?token=<?php print time(); ?>" alt="cometes" width="20px" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																					</td>
																					<td class="quote text-sm" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;font-size:14px !important;vertical-align:center;font-style:italic;color:#333333;text-align:center;">
																						<?php print $interview->quote; ?>  
																					</td>
																					<td class="quote-end" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;vertical-align:bottom;">
																						<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/quote_end.gif?token=<?php print time(); ?>" alt="cometes" width="20px" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																					</td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																	<?php endif; ?>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
											</table>
											<table width="100%" class="box-shadow" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
												<tr>
													<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/shadow_bottom.jpg" border="0" alt="" width="558" style="border-width:0;font-family:'Open sans' !important;width:100% !important;max-width:none !important;" />
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php else: ?>
						<tr>
							<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
									<tr summary="two-columns" style="font-family:'Open sans' !important;">
										<td class="inner-left inner-right" style="padding-top:0;padding-bottom:0;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;">
											<table width="100%" bgcolor="#ffffff" class="background-white bordered" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-width:1px !important;border-style:solid !important;border-color:#dddddd !important;">
												<tr>
													<td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;font-family:'Open sans' !important;">
														<!--[if (gte mso 9)|(IE)]>
														<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
														<tr>
														<td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="inner-top inner-left inner-right" style="padding-bottom:0;font-family:'Open sans' !important;padding-top:20px;padding-left:20px;padding-right:20px;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td class="text" style="padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;padding-top:10px;">
																					<a class="post-title text-red text-md" href="<?php print $interview->link; ?>" style="font-family:'Open sans' !important;font-weight:800;text-decoration:none;font-size:16px !important;color:#671013 !important;"><?php print $interview->title; ?></a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<?php if ($interview->quote): ?>
																	<tr>
																		<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
																			<table bgcolor="#ffffff" class="background-white" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#ffffff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
																				<tr>
																					<td class="quote-begin" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;vertical-align:top;">
																						<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/quote_begin.gif?token=<?php print time(); ?>" alt="cometes" width="20px" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																					</td>
																					<td class="quote text-sm" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;font-size:14px !important;vertical-align:center;font-style:italic;color:#333333;text-align:center;">
																						<?php print $interview->quote; ?>  
																					</td>
																					<td class="quote-end" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;vertical-align:bottom;">
																						<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/quote_end.gif?token=<?php print time(); ?>" alt="cometes" width="20px" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																					</td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																	<?php endif; ?>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td><td width="50%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<![endif]-->
														<div class="column" summary="column" style="font-family:'Open sans' !important;width:100%;max-width:279px;display:inline-block;vertical-align:top;">
															<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
																<tr>
																	<td class="lh-0" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;line-height:0px;">
																		<table class="contents" style="border-spacing:0;color:#333333;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:left;">
																			<tr>
																				<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
																					<img src="<?php print $interview->image; ?>" width="279" alt="" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</div>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
											</table>
											<table width="100%" class="box-shadow" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
												<tr>
													<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/shadow_bottom.jpg?token=<?php print time(); ?>" border="0" alt="" width="558" style="border-width:0;font-family:'Open sans' !important;width:100% !important;max-width:none !important;" />
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<?php endif; ?>
					<?php $i++; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<!-- Section: "Directe a" -->

			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" class="content-news-text">
						<tbody>
							<tr>
								<td>
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="content-text">
													<table border="0" cellspacing="0" cellpadding="0">
														<tbody>
															<tr>
																<td vspace="0" style="padding: 20px 0px 0px 20px;">
																	<h2 style="font-family: Open Sans, sans-serif; color: #333; font-size: 20px; text-decoration: none; font-weight: 600; padding-bottom: 0; margin-bottom: 0;">Directe a </h2>
																</td>
															</tr>
															<tr>
																<td>
																	<table>
																		<tbody>
																			<tr>
																				<td>
																					<ul style="padding-left: 50px; padding-bottom: 15px;" class="download_pdf">
																						<li style="color: #671013; margin-top: 15px">
																							<!-- Auditoria Accesibilidad - Se inserta un "span" oculto en los enlaces que abren en una ventana nueva para que quede indicado -->
																							<a style="font-family: Open Sans, sans-serif; font-size: 16px; color: #671013; font-weight: 600; text-decoration: none;" href="https://voluntariat.gencat.cat" target="_blank">El nostre web</a>
																							<br>
																							<span style="font-family: Open Sans, sans-serif; font-size: 14px; color: #333; font-weight: 400">
																								<p>voluntariat.gencat.cat</p>
																							</span>
																						</li>
																						<li style="color: #671013; margin-top: 15px">
																							<!-- Auditoria Accesibilidad - Se inserta un "span" oculto en los enlaces que abren en una ventana nueva para que quede indicado -->
																							<a style="font-family: Open Sans, sans-serif; font-size: 16px; color: #671013; font-weight: 600; text-decoration: none;" href="https://voluntariat.gencat.cat/persones-voluntaries/" target="_blank">Persones voluntàries</a>
																							<br>
																							<span style="font-family: Open Sans, sans-serif; font-size: 14px; color: #333; font-weight: 400">
																								<p>Coneix els teus drets i deures</p>
																							</span>
																						</li>
																						<li style="color: #671013; margin-top: 15px">
																							<!-- Auditoria Accesibilidad - Se inserta un "span" oculto en los enlaces que abren en una ventana nueva para que quede indicado -->
																							<a style="font-family: Open Sans, sans-serif; font-size: 16px; color: #671013; font-weight: 600; text-decoration: none;" href="https://voluntariat.gencat.cat/entitats/" target="_blank">Entitats</a>
																							<br>
																							<span style="font-family: Open Sans, sans-serif; font-size: 14px; color: #333; font-weight: 400">
																								<p>Registra't al Cens d'entitats de voluntariat</p>
																							</span>
																						</li>
																						<li style="color: #671013; margin-top: 15px">
																							<!-- Auditoria Accesibilidad - Se inserta un "span" oculto en los enlaces que abren en una ventana nueva para que quede indicado -->
																							<a style="font-family: Open Sans, sans-serif; font-size: 16px; color: #671013; font-weight: 600; text-decoration: none;" href="https://voluntariat.gencat.cat/administracions-publiques/" target="_blank">Administracions</a>
																							<br>
																							<span style="font-family: Open Sans, sans-serif; font-size: 14px; color: #333; font-weight: 400">
																								<p>Suport i assessorament</p>
																							</span>
																						</li>
																						<li style="color: #671013; margin-top: 15px">
																							<!-- Auditoria Accesibilidad - Se inserta un "span" oculto en los enlaces que abren en una ventana nueva para que quede indicado -->
																							<a style="font-family: Open Sans, sans-serif; font-size: 16px; color: #671013; font-weight: 600; text-decoration: none;" href="https://voluntariat.gencat.cat/recursos-i-serveis/" target="_blank">Recursos i serveis</a>
																							<br>
																							<span style="font-family: Open Sans, sans-serif; font-size: 14px; color: #333; font-weight: 400">
																								<p>Serveis d'assessorament i acompanyament</p>
																							</span>
																						</li>
																					</ul>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>

			<!-- Bottom content (3 columns) -->
			
			<tr>
				<td class="inner-left inner-right" style="padding-top:0; padding-bottom:0; font-family:'Open sans' !important; padding-left:20px; padding-right:20px;">
					<table width="100%" bgcolor="#fff" border="0" cellspacing="0" cellpadding="0" style="padding-bottom: 20px; background-color: #fff; margin-bottom: 45px; margin-top: 45px;">
						<tbody>
							<tr style="vertical-align: top">
								<td class="images-bottom" align="top" style="margin-left: 10px" width="33%">
									<div style="position: relative; text-align:center">
											<a style="text-decoration: none;" href="https://connectat.voluntariat.gencat.cat/inici">
												<img style="max-width:100%" width="186" src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/bottom_banner_1.png">
												<div class="text-banners" style="font-family:'Open sans' !important; font-weight:800; line-height: 12px; color: #671013; font-size: 12px; text-decoration: none;">
													<p style="margin-bottom: 0.2em; vertical-align: top; text-align: center; font-weight: 600;" class="titol-banners">Connecta't al voluntariat</p>
												</div>
											</a>
									</div>
								</td>
								<td class="images-bottom" align="top" style="margin-left: 10px" width="33%">
									<div style="position: relative; text-align:center">
										<a style="text-decoration: none;" href="https://voluntariat.gencat.cat/persones-voluntaries/format-com-a-voluntari/pla-de-formacio/">
											<img style="max-width:100%" width="186" src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/bottom_banner_2.png">
											<div class="text-banners" style="font-family:'Open sans' !important; font-weight:800; line-height: 12px; color: #671013; font-size: 12px; text-decoration: none;">
												<p style="margin-bottom: 0.2em; vertical-align: top; text-align: center; font-weight: 600;" class="titol-banners">Pla de Formació</p>
											</div>
										</a>
									</div>
								</td>
								<td class="images-bottom" align="top" style="margin-left: 10px" width="33%">
									<div style="position: relative; text-align:center">
										<a style="text-decoration: none;" href="https://voluntariat.gencat.cat/administracions-publiques/punts-de-voluntariat-local/">
											<img style="max-width:100%" width="186" src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/bottom_banner_3.png">
											<div class="text-banners" style="font-family:'Open sans' !important; font-weight:800; line-height: 12px; color: #671013; font-size: 12px; text-decoration: none;">
												<p style="margin-bottom: 0.2em; vertical-align: top; text-align: center; font-weight: 600;" class="titol-banners">Punts de voluntariat</p>
											</div>
										</a>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>

			<!-- Footer -->

			<tr>
				<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
					<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
						<tr>
							<td class="left-sidebar" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;font-family:'Open sans' !important;">
								<!--[if (gte mso 9)|(IE)]>
								<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
								<tr>
								<td width="100" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<![endif]-->
								<table class="column left" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;width:100%;display:inline-block;vertical-align:middle;max-width:140px;">
									<tr>
										<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
											<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
												<tr>
													<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<a class="inline-icons" href="https://es-es.facebook.com/treballiaferssocialscat/" style="text-decoration:none;font-family:'Open sans' !important;color:#85ab70;">
															<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/facebook_icon.png?token=<?php print time(); ?>" width="32" alt="Visita la nostra pàgina a Facebook" style="border-width:0;font-family:'Open sans' !important;" />
														</a>
													</td>
													<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
														<a class="inline-icons" href="https://twitter.com/BDgacc" style="text-decoration:none;font-family:'Open sans' !important;color:#85ab70;">
															<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/twitter_icon.png?token=<?php print time(); ?>" width="32" alt="Segueix-nos a Twitter" style="border-width:0;font-family:'Open sans' !important;" />
														</a>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!--[if (gte mso 9)|(IE)]>
								</td><td width="500" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<![endif]-->
								<table class="column right" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;width:100%;display:inline-block;vertical-align:middle;max-width:460px;">
									<tr>
										<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;font-size:14px;text-align:center;">
											<span class="inline-links" style="font-family:'Open sans' !important;display:inline-block;Margin:0 5px;width:auto;">
												<a class="text-red no-decoration regular text-xs" href="<?php print $path_root; ?>/sites/default/files/subscripcions_abast/alta.html" style="font-family:'Open sans' !important;font-weight:600;font-size:12px !important;text-decoration:none;color:#671013 !important;">Alta butlletí</a>
											</span>
											<span class="inline-links" style="font-family:'Open sans' !important;display:inline-block;Margin:0 5px;width:auto;">
												<a class="text-red no-decoration regular text-xs" href="<?php print $path_root; ?>/sites/default/files/subscripcions_abast/baixa.html" style="font-family:'Open sans' !important;font-weight:600;font-size:12px !important;text-decoration:none;color:#671013 !important;">Baixa butlletí</a>
											</span>
											<span class="inline-links" style="font-family:'Open sans' !important;display:inline-block;Margin:0 5px;width:auto;">
												<a class="text-red no-decoration regular text-xs" href="<?php print $path_root; ?>/hemeroteca-butlleti-labast" style="font-family:'Open sans' !important;font-weight:600;font-size:12px !important;text-decoration:none;color:#671013 !important;">Butlletins anteriors</a>
											</span>
											<span class="inline-links" style="font-family:'Open sans' !important;display:inline-block;Margin:0 5px;width:auto;">
												<a class="text-red no-decoration regular text-xs" href="https://voluntariat.gencat.cat/contacte/" style="font-family:'Open sans' !important;font-weight:600;font-size:12px !important;text-decoration:none;color:#671013 !important;">Contacte</a>
											</span>
										</td>
									</tr>
								</table>
								<!--[if (gte mso 9)|(IE)]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>
      
						<tr>
							<td class="left-sidebar" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;font-family:'Open sans' !important;">
								<!--[if (gte mso 9)|(IE)]>
								<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
								<tr>
								<td width="100" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<![endif]-->
								<table class="column left" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;width:100%;display:inline-block;vertical-align:middle;max-width:140px;">
									<tr>
										<td class="inner" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;font-family:'Open sans' !important;">
											<a href="https://www.facebook.com/xarxanet" style="text-decoration:underline;font-family:'Open sans' !important;color:#85ab70;">
												<img src="<?php print $path_root; ?>/sites/all/themes/xn17/assets/images/butlleti_a_labast/logotip_generalitat_catalunya_footer.png?token=<?php print time(); ?>" width="101" alt="" style="border-width:0;font-family:'Open sans' !important;" />
											</a>
										</td>
									</tr>
								</table>
								<!--[if (gte mso 9)|(IE)]>
								</td><td width="500" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
								<![endif]-->
								<table class="column right" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;width:100%;display:inline-block;vertical-align:middle;max-width:460px;">
									<tr>
										<td class="inner-left inner-right inner-bottom contents" style="padding-top:0;width:100%;font-family:'Open sans' !important;padding-left:20px;padding-right:20px;padding-bottom:20px;font-size:14px;text-align:center;">
											<div class="text-xxs text-left" style="font-family:'Open sans' !important;font-size:10px !important;text-align:left;">
												<b><u>Avís legal</u></b>: D’acord amb l’article 17.1 de la Llei 19/2014, la Generalitat de Catalunya permet la reutilització dels continguts i de les dades sempre que se'n citi la font i la data d'actualització i que no es desnaturalitzi la informació (article 8 de la Llei 37/2007) i també que no es contradigui amb una llicència específica. Si l'adreça de correu que informeu al donar-vos d'alta deixa d'estar activa us donarem de baixa a la base de dades.
												Aquest butlletí és una iniciativa del Departament de Treball, Afers Socials i Famílies de la Generalitat de Catalunya, coeditat amb la Fundació Pere Tarrés. ISSN: 2385-4146.
											</div>
										</td>
									</tr>
								</table>
								<!--[if (gte mso 9)|(IE)]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>
					</table>
				</td>
			</tr>

		</table>
		<!--[if (gte mso 9)|(IE)]>
		</td>
		</tr>
		</table>
		<![endif]-->
	</div>
</center>
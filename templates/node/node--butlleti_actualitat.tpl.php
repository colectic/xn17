<?php
/**
* @file
* Default theme implementation to display a node.
*
* Available variables:
* - $title: the (sanitized) title of the node.
* - $content: An array of node items. Use render($content) to print them all,
* or print a subset such as render($content['field_example']). Use
* hide($content['field_example']) to temporarily suppress the printing of a
* given element.
* - $user_picture: The node author's picture from user-picture.tpl.php.
* - $date: Formatted creation date. Preprocess functions can reformat it by
* calling format_date() with the desired parameters on the $created variable.
* - $name: Themed username of node author output from theme_username().
* - $node_url: Direct URL of the current node.
* - $display_submitted: Whether submission information should be displayed.
* - $submitted: Submission information created from $name and $date during
* template_preprocess_node().
* - $classes: String of classes that can be used to style contextually through
* CSS. It can be manipulated through the variable $classes_array from
* preprocess functions. The default values can be one or more of the
* following:
* - node: The current template type; for example, "theming hook".
* - node-[type]: The current node type. For example, if the node is a
* "Blog entry" it would result in "node-blog". Note that the machine
* name will often be in a short form of the human readable label.
* - node-teaser: Nodes in teaser form.
* - node-preview: Nodes in preview mode.
* The following are controlled through the node publishing options.
* - node-promoted: Nodes promoted to the front page.
* - node-sticky: Nodes ordered above other non-sticky nodes in teaser
* listings.
* - node-unpublished: Unpublished nodes visible only to administrators.
* - $title_prefix (array): An array containing additional output populated by
* modules, intended to be displayed in front of the main title tag that
* appears in the template.
* - $title_suffix (array): An array containing additional output populated by
* modules, intended to be displayed after the main title tag that appears in
* the template.
*
* Other variables:
* - $node: Full node object. Contains data that may not be safe.
* - $type: Node type; for example, story, page, blog, etc.
* - $comment_count: Number of comments attached to the node.
* - $uid: User ID of the node author.
* - $created: Time the node was published formatted in Unix timestamp.
* - $classes_array: Array of html class attribute values. It is flattened
* into a string within the variable $classes.
* - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
* teaser listings.
* - $id: Position of the node. Increments each time it's output.
*
* Node status variables:
* - $view_mode: View mode; for example, "full", "teaser".
* - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
* - $page: Flag for the full page state.
* - $promote: Flag for front page promotion state.
* - $sticky: Flags for sticky post setting.
* - $status: Flag for published status.
* - $comment: State of comment settings for the node.
* - $readmore: Flags true if the teaser content of the node cannot hold the
* main body content.
* - $is_front: Flags true when presented in the front page.
* - $logged_in: Flags true when the current user is a logged-in member.
* - $is_admin: Flags true when the current user is an administrator.
*
* Field variables: for each field instance attached to the node a corresponding
* variable is defined; for example, $node->body becomes $body. When needing to
* access a field's raw values, developers/themers are strongly encouraged to
* use these variables. Otherwise they will have to explicitly specify the
* desired field language; for example, $node->body['en'], thus overriding any
* language negotiation rule that was previously applied.
*
* @see template_preprocess()
* @see template_preprocess_node()
* @see template_process()
*
* @ingroup themeable
*/

$pathroot = 'http://www.xarxanet.org';

// Data
$mesos = array('de gener', 'de febrer', 'de març', 'd\'abril', 'de maig', 'de juny', 'de juliol', 'd\'agost', 'de setembre', 'd\'octubre', 'de novembre', 'de desembre');
$dies = array('Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres', 'Dissabte', 'Diumenge');

?>
 <table class="butlleti"  style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 13px; border:1px solid #53544F; border-bottom: 0px; width:910px">
	<!-- CAPÇALERA -->
	<!--
	<tr><td colspan="2">
	<p style="padding: 2px; font-size: 11px; text-align:right"> Si no visualitzes correctament el butlletí clica aquest <a href="<?php echo $pathroot.'/node/'.$node->nid?>" style=" color: #B2290C; font-weight: bold;">enllaç</a></p>
	</td></tr>
	-->
	<tr style="background-color:#2f3031;"><td>
		<a href="http://www.xarxanet.org" style="text-decoration:none">
			<img src="/sites/all/themes/xn17/logo.png" alt="logotip xarxanet" style="margin-left:5px; margin-top:20px"/>
		</a>
	</td><td>
		<p style="font-size:38px; color:#FFFFFF; text-align:right; font-weight:bold; margin:10px 5px">Actualitat</p>
	</td></tr>
	<tr style="background-color:#2f3031; color:#878787; font-weight:bold;"><td style="padding: 5px 10px; border-top:3px solid #231f20; border-bottom: 15px solid white;">
		<?php
		$created = $node->created;
		echo $dies[date('N', $created)-1].', '.date('j', $created).' '.$mesos[date('n', $created)-1].' de '.date('Y', $created).' - Num. '.$title;
		?>
	</td><td style="text-align: right; padding: 5px 10px; border-top:3px solid #231f20; border-bottom: 15px solid white;">
		<a href="http://www.xarxanet.org/hemeroteca_actualitat" style=" color:#878787">Butlletins anteriors</a>
	</td></tr>

	<tr class='body'><td style="vertical-align: top; padding-left: 20px">
	<!-- DESTACAT PRINCIPAL -->
	 <table class="butlleti" style='background-color: #ededed; width: 580px;'>
		<?php
		if (($node->field_actualitat_dest_prin_noti['und'][0]['nid'] != '') || ($node->field_actualitat_dest_prin_ext['und'][0]['title'] != '')) {
			if ($node->field_actualitat_dest_prin_epigr['und'][0]['value'] !=  '') {?>
				<tr class='body'><td style="background-color: #BE1622; color: white; font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; font-size: 12pt; text-align: center; padding: 0px; height: 28px;"><?php echo $node->field_actualitat_dest_prin_epigr['und'][0]['value']; ?></td></tr>
			<?php }
			$title = '';
			$url = '';
			$teaser = '';
			if ($node->field_actualitat_dest_prin_noti['und'][0]['nid'] != '') {
				$news_node = node_load($node->field_actualitat_dest_prin_noti['und'][0]['nid']);
				$title = $news_node->title;
				$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
				$teaser = strip_tags($news_node->field_resum['und'][0]['value']);
			} else {
				$title = $node->field_actualitat_dest_prin_ext['und'][0]['title'];
				$url = $node->field_actualitat_dest_prin_ext['und'][0]['url'];
				$teaser = strip_tags($node->field_actualitat_dest_ext_teaser['und'][0]['value']);
			}
			$image = file_create_url($node->field_actualitat_dest_prin_foto['und'][0]['uri']);
			echo "	<tr class='body'><td style='padding: 0px !important;'>
						<a href='{$url}' style='text-decoration:none'>
							<img src='{$image}' alt='imatge destacat principal'/>
						</a>
					</td></tr><tr class='body'><td style='padding-bottom: 10px'>
						<a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-size: 18pt; font-weight: lighter; line-height: 24px; text-decoration: none;'>
							{$title}
						</a>
						<p style='padding-top: 5px; margin: 2px 0;'>{$teaser}</p>";
			if ($node->field_actualitat_dest_prin_rel['und'][0]['nid'] != '') {
				echo '<b>Altres informacions relacionades</b>
						<table class="butlleti">';
				foreach ($node->field_actualitat_dest_prin_rel['und'] as $rel) {
					$news_node = node_load($rel['nid']);
					$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
					$type = $news_node->type;
					if ($type == 'opinio'){
						$autor = $news_node->field_autor_a['und'][0]['nid'];
						$autor = node_load($autor);
						echo "<tr class='body'><td style='padding: 1px 5px 0 5px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_r.jpg' /></td>
							<td style='padding: 2px;'><a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 11pt'>Opinió - {$autor->title}: {$news_node->title}</a></td>
							</tr>";
					}else{
						echo "<tr class='body'><td style='padding: 1px 5px 0 5px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_r.jpg' /></td>
							<td style='padding: 2px;'><a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 11pt'>{$news_node->title}</a></td>
							</tr>";
					}
				}
				foreach ($node->field_actualitat_dest_prin_rel_e['und'] as $rel) {
					$title = $rel['title'];
					$url = $rel['url'];
					if ($url != ''){
						echo "<tr class='body'><td style='vertical-align: top;'><img style='vertical-align: top; margin-top:8px' src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_r.jpg' /></td>
						<td style='padding: 2px;'><a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 11pt'>{$title}</a></td>
						</tr>";
					}
				}
				echo '</table>';
			}
			echo "</tr></td>";
		} ?>
	</table>

	<!-- NOTÍCIES DESTACADES -->
	 <table class="butlleti" style='width: 580px; margin-top: 20px'><tr class='body'>
		<?php
		$i = 1;
		while ($i < 4) {
			$field = 'field_actualitat_noticies_dest_'.$i;
			$nid = $node->$field;
			$news_node = node_load($nid['und'][0]['nid']);
			$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
			$teaser = strip_tags($news_node->field_resum['und'][0]['value']);
			$type = $news_node->type;
			if ($type == 'opinio'){
				$autor = $news_node->field_autor_a['und'][0]['nid'];
				$autor = node_load($autor);
				$img = image_style_url('tag-petit',$autor->field_autor_foto_horitzontal["und"][0]["uri"]);
				$alt = $autor->field_autor_foto_horitzontal["und"][0]["uri"];
			}else{
				$img = image_style_url('tag-petit',$news_node->field_agenda_imatge['und'][0]['uri']);
				$alt = $news_node->field_agenda_imatge['und'][0]['alt'];
			}
			$paddingright = ($i < 3) ? 20 : 0;
			echo "<td style='vertical-align: top; padding: 0px; padding-right: {$paddingright}px'>
				<a href='{$url}' style='text-decoration:none'>
					<img src='{$img}' alt='{$alt}'/>
				</a>
				<a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-size: 12pt; line-height: 21px; text-decoration: none;'>
					{$news_node->title}
				</a>
				<p style='padding-top: 5px'; margin: 2px 0;>{$teaser}</p>
			</td>";
			$i++;
		}
		?>
	</tr></table>

	<!-- CURSOS I ACTES -->
	 <table class="butlleti" style='width: 580px; margin-top: 20px'><tr class='body'>
		<td style="background-color: #aeb22a; padding: 0px; height: 28px; width: 55px;">
			<img style='margin-top: 2px; margin-left: 10px;' src='<?php echo $pathroot;?>/sites/default/files/butlletins/actualitat/cursos.png' />
		</td>
		<td style="background-color: #aeb22a; color: white; font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; font-size: 12pt; padding: 0px; height: 28px; width: 65px;">
			Cursos
		</td>
		<td style="width: 160px; text-align: right;">
			<a href='<?php echo $pathroot; ?>/agenda/curs' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-size: 11pt; text-decoration: none;'>Tots els cursos</a>
		</td>
		<td style="width: 20px; padding:0px"></td>
		<td style="background-color: #a7a74d; padding: 0px; height: 28px; width: 60px;">
			<img style='margin-top: 2px; margin-left: 10px;' src='<?php echo $pathroot;?>/sites/default/files/butlletins/actualitat/actes.png' />
		</td>
		<td style="background-color: #a7a74d; color: white; font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; font-size: 12pt; padding: 0px; height: 28px; width: 60px; padding-left: 5px">
			Actes
		</td>
		<td style="width: 160px; text-align: right;">
			<a href='<?php echo $pathroot; ?>/agenda/acte' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-size: 11pt; text-decoration: none;'>Tots els actes</a>
		</td>
		</tr><tr class='body'>
		<td colspan="3" style="background-color: #f6f5e3; vertical-align: top;">
			<table class="butlleti">
			<?php
				$view = views_get_view_result('propers_cursos', 'block_1');
				foreach ($view as $elem) {
					$news_node = node_load($elem->nid);
					$date = $news_node->field_date_event['und'][0];
					$start = date('j',strtotime($date['value'])).' '.$mesos[date('n', strtotime($date['value']))-1];
					$end = date('j',strtotime($date['value2'])).' '.$mesos[date('n', strtotime($date['value2']))-1];
					$date = ($start == $end) ? $start : 'Del '.$start.' al '.$end;
					$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
					echo "	<tr class='body'>
							<td style='padding: 1px 5px 0 5px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_cursos.jpg' /></td>
							<td style='padding: 2px;' colspan='2'><a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 11pt'>{$news_node->title}</a></td>
							</tr><tr class='body'>
							<td></td>
							<td style='padding: 2px 5px 10px 0; width: 10px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/clock_cursos.png' /></td>
							<td style='padding: 2px 2px 10px 2px;'>{$date}</td>
							</tr>";
				}
			?>
			</table>
		</td>
		<td style="width: 20px; padding:0px"></td>
		<td colspan="3" style="background-color: #f1f2e4; vertical-align: top;">
			<table class="butlleti">
			<?php
				$view = views_get_view_result('propers_events', 'block_2');
				foreach ($view as $elem) {
					$news_node = node_load($elem->nid);
					$date = $news_node->field_date_event['und'][0];
					$start = date('j',strtotime($date['value'])).' '.$mesos[date('n', strtotime($date['value']))-1];
					$end = date('j',strtotime($date['value2'])).' '.$mesos[date('n', strtotime($date['value2']))-1];
					$date = ($start == $end) ? $start : 'Del '.$start.' al '.$end;
					$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
					echo "	<tr class='body'>
							<td style='padding: 1px 5px 0 5px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_actes.jpg' /></td>
							<td style='padding: 2px;' colspan='2'><a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 11pt'>{$news_node->title}</a></td>
							</tr><tr class='body'>
							<td></td>
							<td style='padding: 2px 5px 10px 0; width: 10px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/clock_actes.png' /></td>
							<td style='padding: 2px 2px 10px 2px;'>{$date}</td>
							</tr>";
				}
			?>
			</table>
		</td>
	</tr></table>

	<!-- RECULL DE NOTÍCIES DESTACAT -->
	<?php if ($node->field_actualitat_recull_epigraf['und'][0]['value'] != '') { ?>
	 <table class="butlleti" style='width: 580px; margin-top: 20px'><tr class='body'>
		<td style="background-color: #BE1622; color: white; font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; font-size: 12pt; padding: 0 8px; height: 28px; width: <?php echo (strlen(strip_tags($node->field_actualitat_recull_epigraf['und'][0]['value'])))*3;?>px"><?php echo $node->field_actualitat_recull_epigraf['und'][0]['value'];?></td>
		<td style="width: 160px; text-align: right;"><a href='<?php echo $node->field_actualitat_recull_enllac['und'][0]['url']; ?>' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-size: 11pt; text-decoration: none;'><?php echo $node->field_actualitat_recull_enllac['und'][0]['title']; ?></a></td></tr><tr class='body'>
		<td style="background-color: #ededed;" colspan="2">
			<table class="butlleti">
			<?php
			foreach ($node->field_actualitat_recull_noticia['und'] as $elem) {
				if ($elem['nid']) {
					$news_node = node_load($elem['nid']);
					$teaser = strip_tags($news_node->field_resum['und'][0]['value']);
					$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
					echo "	<tr class='body'>
						<td style='padding: 5px 5px 0 5px; vertical-align: top; width: 10px'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_r.jpg' /></td>
						<td style='padding: 2px;'><a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 12pt; line-height: 21px;'>{$news_node->title}</a></td>
						</tr><tr class='body'><td colspan='2' style='padding: 0 5px;'><p style='margin: 2px 0;'>{$teaser}</p></td></tr>";
					}
			}
			foreach ($node->field_actualitat_recull_ext['und'] as $i => $elem) {
				if (!empty($node->field_actualitat_recull_ext_entr['und'][$i]['value'])) {
					$teaser = strip_tags($node->field_actualitat_recull_ext_entr['und'][$i]['value']);
					echo "	<tr class='body'>
					<td style='padding: 5px 5px 0 5px; vertical-align: top; width: 10px'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_r.jpg' /></td>
					<td style='padding: 2px;'><a href='{$elem['url']}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 12pt; line-height: 21px;'>{$elem['title']}</a></td>
					</tr><tr class='body'><td colspan='2' style='padding: 0 5px;'><p style='margin: 2px 0;'>{$teaser}</p></td></tr>";
				}
			}
			?>
			</table>
		</td>
	</tr></table>
	<?php }?>

	<!-- NOTÍCIES PERSONALITZADES -->

	</td><td style="vertical-align: top; padding-right: 20px">

	<!-- ENQUESTA -->
	<?php if ($node->field_actualitat_enquesta['und'][0]['nid'] != '') {
		$news_node = node_load($node->field_actualitat_enquesta['und'][0]['nid']);
		$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
	?>
		 <table class="butlleti" style='width: 265px; margin-bottom: 20px;'><tr class='body'>
			<td style="background-color: #7b7b79; padding: 0px; height: 28px; width: 35px;" ><img src="<?php echo $pathroot;?>/sites/default/files/butlletins/actualitat/enquesta.png" alt="icona_enquesta" style="margin-top: 2px; margin-left: 10px;"/></td>
			<td style="background-color: #7b7b79; color: white; font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; font-size: 12pt; padding: 0px; height: 28px; padding-left: 5px">Enquesta</td>
			</tr><tr class='body'><td colspan="2">
				<a href='<?php echo $url; ?>' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 12pt; line-height: 21px;'><?php echo $news_node->title;?></a>
			</td></tr><tr class='body'><td colspan="2" style="padding-top:0px">
			<table class="butlleti">
				<?php
				foreach ($news_node->choice as $choice) {
					echo "<tr class='body'>
						<td style='padding: 1px 5px 0 5px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_r.jpg' /></td>
						<td style='padding: 2px;' colspan='2'>{$choice['chtext']}</td>
						</tr>";
				}
				?>
			</table>
			</td>
		</tr>
		</table>
	<?php }?>

	<!-- DESTACAT LATERAL SUPERIOR -->
	<?php
		if (($node->field_actualitat_lat_sup_noti['und'][0]['nid'] != '') || ($node->field_actualitat_lat_sup_noti_e['und'][0]['url'] != '')) {
			if ($node->field_actualitat_lat_sup_noti['und'][0]['nid'] != '') {
				$news_node = node_load($node->field_actualitat_lat_sup_noti['und'][0]['nid']);
				$title = $news_node->title;
				$teaser = strip_tags($news_node->field_resum['und'][0]['value']);
				$type = $news_node->type;
				if ($type == 'opinio'){
					$autor = $news_node->field_autor_a['und'][0]['nid'];
					$autor = node_load($autor);
					$img = image_style_url('financ-petit',$autor->field_autor_foto_horitzontal["und"][0]["uri"]);
					$alt = $autor->field_autor_foto_horitzontal["und"][0]["uri"];
				}else{
					$img = image_style_url('financ-petit',$news_node->field_agenda_imatge['und'][0]['uri']);
					$alt = $news_node->field_agenda_imatge['und'][0]['alt'];
				}
				$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
			} else {
				$title = $node->field_actualitat_lat_sup_noti_e['und'][0]['title'];
				$url = $node->field_actualitat_lat_sup_noti_e['und'][0]['url'];
				$teaser = $node->field_actualitat_lat_sup_teas_e['und'][0]['value'];
				$img = file_create_url($node->field_actualitat_lat_sup_img_e['und'][0]['uri']);
				$alt = $node->field_actualitat_lat_sup_img_e['und'][0]['alt'];
			}
			echo "<table class='butlleti' style='width: 265px; margin-bottom: 20px; background-color: #ededed;'><tr class='body'>";

			if ($node->field_actualitat_lat_sup_epigraf['und'][0]['value'] != '') {
				echo "<td style='background-color: #BE1622; color: white; font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; font-size: 12pt; padding: 0px 10px; height: 28px;'>{$node->field_actualitat_lat_sup_epigraf['und'][0]['value']}</td>";
			}
			echo "</tr><tr class='body'><td style='padding: 0;'>
				<a href='{$url}' style='text-decoration:none'>
					<img src='{$img}' alt='{$alt}'/>
				</a>
				</td></tr><tr class='body'><td style='padding-bottom: 10px'>
				<a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-size: 12pt; line-height: 21px; text-decoration: none;'>
					{$title}
				</a>
				<p style='padding-top: 5px; margin: 2px 0;'>{$teaser}</p>";

			if (($node->field_actualitat_lat_sup_rel['und'][0]['nid'] != '') || ($node->field_actualitat_lat_sup_rel_ex['und'][0]['url'] != '')) {
				echo '<b>Altres informacions relacionades</b>
				<table class="butlleti">';
				foreach ($node->field_actualitat_lat_sup_rel_ex['und'] as $rel) {
					$title = $rel['title'];
					$url = $rel['url'];
					echo "<tr class='body'><td style='padding: 1px 5px 0 5px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_r.jpg' /></td>
					<td style='padding: 2px;'><a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 11pt'>{$title}</a></td>
					</tr>";
				}
				foreach ($node->field_actualitat_lat_sup_rel['und'] as $rel) {
					$news_node = node_load($rel['nid']);
					$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
					echo "<tr class='body'><td style='padding: 1px 5px 0 5px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_r.jpg' /></td>
					<td style='padding: 2px;'><a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 11pt'>{$news_node->title}</a></td>
					</tr>";
				}
				echo '</table>';
			}
			echo "</td></tr></table>";
	 	}
	 ?>


	<!-- FINANÇAMENTS -->
	<table class="butlleti" style='width: 265px; margin-bottom: 20px; background-color: #fef1e8'><tr class='body'>
		<td style="background-color: #f37310; padding: 0px; height: 28px; width: 35px;" ><img src="<?php echo $pathroot;?>/sites/default/files/butlletins/actualitat/financaments.png" alt="icona_finançaments" style="margin-top: 2px; margin-left: 10px;"/></td>
		<td style="background-color: #f37310; color: white; font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; font-size: 12pt; padding: 0px; height: 28px; padding-left: 5px">Finançaments</td>
		</tr><tr class='body'><td colspan="2">
		<table class="butlleti">
			<?php
			$view = views_get_view_result('ultims_financaments');
			foreach ($view as $elem) {
				$news_node = node_load($elem->nid);
				$date = $news_node->field_date['und'][0];
				$start = date('j',strtotime($date['value'])).' '.$mesos[date('n', strtotime($date['value']))-1];
				$end = date('j',strtotime($date['value2'])).' '.$mesos[date('n', strtotime($date['value2']))-1];
				$date = ($start == $end) ? $start : 'Del '.$start.' al '.$end;
				$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
				echo "	<tr class='body'>
						<td style='padding: 1px 5px 0 5px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/bullet_financaments.jpg' /></td>
						<td style='padding: 2px;' colspan='2'><a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-weight: lighter; text-decoration: none; font-size: 11pt'>{$news_node->title}</a></td>
						</tr><tr class='body'>
						<td></td>
						<td style='padding: 2px 5px 10px 0; width: 10px; vertical-align: top;'><img src='{$pathroot}/sites/default/files/butlletins/actualitat/clock_financaments.png' /></td>
						<td style='padding: 2px 2px 10px 2px;'>{$date}</td>
						</tr>";
				}
			?>
		</table>
		</td></tr>
		<tr class='body'><td style='text-align: right; padding-bottom: 10px' colspan="2"><a href='<?php echo $pathroot; ?>/financaments' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-size: 11pt; text-decoration: none;'>Tots els finançaments</a></td></tr>
	</table>

	<!-- BANNERS -->
	 <table class="butlleti" style='width: 265px; margin-bottom: 20px;'><tr class='body'>
	<td style='padding: 10px 0 0 0'>
	<a href="http://voluntariat.org/" style='text-decoration:none'>
		<img src="<?php echo $pathroot; ?>/sites/default/files/butlletins/actualitat/banner_voluntariat.jpg" alt="banner voluntariat" />
	</a></td></tr><tr class='body'>
	<td style='padding: 10px 0 0 0'>
	<a href="http://www.xarxanet.org/formulari-dassessorament" style='text-decoration:none'>
		<img src="<?php echo $pathroot; ?>/sites/default/files/butlletins/actualitat/banner_assessorament.jpg" alt="banner voluntariat" style='border: 0 none;'/>
	</a></td></tr>
	<td style='padding: 10px 0 0 0'>
	<a style="text-decoration:none" href="http://nonprofit.xarxanet.org">
		<img src="<?php echo $pathroot?>/sites/default/files/butlletins/actualitat/banner_nonprofit.png" alt="Banner nonprofit" width="265px" style="margin:2px 0;"/>
	</a></td></tr>
	<?php
	foreach ($node->field_actualitat_banner['und'] as $banner) {
		$image = file_create_url($banner['uri']);
		echo "<tr class='body'>
			<td style='padding: 10px 0 0 0'><a href='{$banner['url']}' style='text-decoration:none'>
			<img src='{$image}' alt='{$banner['alt']}' />
			</a></td></tr>";
	}
	?>
	</table>

	<!-- DESTACAT LATERAL INFERIOR -->
	<?php
		if (($node->field_actualitat_lat_inf_noticia['und'][0]['nid'] != '') || ($node->field_actualitat_lat_inf_noti_e['und'][0]['url'] != '')) {
			if ($node->field_actualitat_lat_inf_noticia['und'][0]['nid'] != '') {
				$news_node = node_load($node->field_actualitat_lat_inf_noticia['und'][0]['nid']);
				$title = $news_node->title;
				$teaser = strip_tags($news_node->field_resum['und'][0]['value']);
				$type = $news_node->type;
				if ($type == 'opinio'){
					$autor = $news_node->field_autor_a['und'][0]['nid'];
					$autor = node_load($autor);
					$img = image_style_url('financ-petit',$autor->field_autor_foto_horitzontal["und"][0]["uri"]);
					$alt = $autor->field_autor_foto_horitzontal["und"][0]["uri"];
				}else{
					$img = image_style_url('financ-petit',$news_node->field_agenda_imatge['und'][0]['uri']);
					$alt = $news_node->field_agenda_imatge['und'][0]['alt'];
				}
				$url = url('node/' . $news_node->nid, array('absolute' => TRUE));
			} else {
				$title = $node->field_actualitat_lat_inf_noti_e['und'][0]['title'];
				$url = $node->field_actualitat_lat_inf_noti_e['und'][0]['url'];
				$teaser = $node->field_actualitat_lat_inf_teas_e['und'][0]['value'];
				$img = file_create_url($node->field_actualitat_lat_inf_img_e['und'][0]['uri']);
				$alt = $node->field_actualitat_lat_inf_img_e['und'][0]['alt'];
			}
			echo "<table class='butlleti' style='width: 265px; margin-bottom: 20px;'><tr class='body'>";

			if ($node->field_actualitat_lat_inf_epigraf['und'][0]['value'] != '') {
				echo "<td style='background-color: #BE1622; color: white; font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; font-size: 12pt; padding: 0px 10px; height: 28px;'>{$node->field_actualitat_lat_inf_epigraf['und'][0]['value']}</td>";
			}
			echo "</tr><tr class='body'><td style='padding: 0;'>
				<a href='{$url}' style='text-decoration:none'>
					<img src='{$img}' alt='{$alt}'/>
				</a>
				</td></tr><tr class='body'><td style='padding-bottom: 10px'>
				<a href='{$url}' style='font-family: Fira Sans SemiBold,Helvetica,Arial,sans-serif; color: #2f3031; font-size: 12pt; line-height: 21px; text-decoration: none;'>
					{$title}
				</a>
				<p style='padding-top: 5px; margin: 2px 0;'>{$teaser}</p>";
			echo "</td></tr></table>";
		 }
	 ?>

	</td></tr>
	<!-- PEU -->
	<tr style="background-color:#2f3031; border-top:3px solid #231f20;">
	<td colspan="2" style="border-top: 3px solid #53544F; padding: 4px;">
		 <table class="butlleti"  style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 13px; color:white;">
			<tr class='body'><td colspan="2" style="padding-left:10px;">
				<b>Xarxanet.org és un projecte de</b>
			</td><td colspan="2" style="padding-left:50px;">
				<b>Entitats promotores</b>
			</td></tr>
			<tr class='body'><td style="vertical-align:top; padding-left:10px; padding-top:15px">
				<table class="butlleti"><tr class='body'><td>
					<a href="http://benestar.gencat.cat" style="text-decoration:none">
						<img alt="logo generalitat" src="<?php echo $pathroot?>/sites/default/files/butlletins/financament/logo_generalitat.png">
					</a>
				</td></tr><tr class='body'><td style="height: 55px; vertical-align: bottom;">
					<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/es/deed.ca" rel="license">
						<img style="border:0 none;" src="http://i.creativecommons.org/l/by-nc-sa/3.0/es/80x15.png" alt="Licencia de Creative Commons">
					</a>
				</td></tr></table>
			</td><td style="vertical-align:top; padding-top:15px">
				<!-- <a href="http://www.voluntariat.org" style="text-decoration:none">
					<img alt="logo voluntariat" src="<?php echo $pathroot?>/sites/default/files/butlletins/financament/logo_scv.png">
				</a> -->
			</td><td style="padding-left:50px;">
				<p>
                                        <a href="https://fundesplai.org/ca/" style="color:white;  font-weight:normal">Fundació Catalana de l'Esplai</a><br />
					<a href="http://www.peretarres.org" style="color:white;  font-weight:normal">Fundació Pere Tarrés</a><br />
					<a href="http://www.ateneus.cat" style="color:white;  font-weight:normal">Federació d'Ateneus de Catalunya</a><br />
					<a href="http://www.xvac.cat" style="color:white;  font-weight:normal">Xarxa de Voluntariat Ambiental de Catalunya</a><br />
					<a href="http://www.iwith.org/ca/" style="color:white;  font-weight:normal">I-with.org</a><br />
				</p>
			</td><td style="padding-left:15px">
				<p>
					<a href="http://colectic.coop" style="color:white;  font-weight:normal">Colectic</a><br />
					<a href="http://www.ravalnet.org" style="color:white;  font-weight:normal">Associació ciutadana Ravalnet</a><br />
					<a href="http://www.federacio.net/ca" style="color:white;  font-weight:normal">Federació Catalana del Voluntariat Social</a><br />
					<a href="http://magno.uab.es/fas" style="color:white;  font-weight:normal">Fundació Autònoma Solidària</a><br />
					<a href="http://www.escoltesiguies.cat" style="color:white;  font-weight:normal">Minyons Escoltes i Guies de Catalunya (MEG)</a><br />
				</p>
			</td></tr>
		</table>
	<tr class='body'><td colspan="2" style="background-color:#231f20; color:white; text-align:right; padding:5px 10px;">
		<a style=" color:white" href="http://www.xarxanet.org/alta_actualitat">Alta</a> |
		<a style=" color:white;" href="http://www.xarxanet.org/baixa_actualitat">Baixa</a> |
		<a style=" color:white;" href="mailto:butlleti@xarxanet.org?Subject=Consulta%20butlletí">Contacte</a> |
		<a style=" color:white;" href="http://web.gencat.cat/ca/menu-ajuda/ajuda/avis_legal/">Avís legal</a>
	</td></tr>
	<tr><td colspan="2" style="background-color:black; color:white; text-align:right; padding:5px 10px; font-size: 0.75em;">
	 	<p><a style="text-decoration: underline; color:white;" href="http://web.gencat.cat/ca/menu-ajuda/ajuda/avis_legal/">Avís legal</a>: D’acord amb l’article 17.1 de la Llei 19/2014, la &copy;Generalitat de Catalunya permet la reutilització dels continguts i de les dades sempre que se'n citi la font i la data d'actualització i que no es desnaturalitzi la informació (article 8 de la Llei 37/2007) i també que no es contradigui amb una llicència específica. Si l'adreça de correu que informeu al donar-vos d'alta deixa d'estar activa us donarem de baixa a la base de dades.
		<br/>Aquest butlletí és una iniciativa del Departament de Treball, Afers Socials i Famílies de la Generalitat de Catalunya, coeditat amb la Fundació Pere Tarrés.</p> 
	 </td></tr>
</table>

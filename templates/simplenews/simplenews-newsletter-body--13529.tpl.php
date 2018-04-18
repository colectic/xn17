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

// Data
$mesos = array('de gener', 'de febrer', 'de març', 'd\'abril', 'de maig', 'de juny', 'de juliol', 'd\'agost', 'de setembre', 'd\'octubre', 'de novembre', 'de desembre');
$dies = array('Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres', 'Dissabte', 'Diumenge');
$pathroot = 'http://www.xarxanet.org';
$node = $build['#node'];

// Banners fixes
$banners_fixes = array(	'Banner PNAV' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_pnav.jpg', 
													'http://pnav.voluntariat.org/'),
						'Banner PFVC' 	=> 	array (	$pathroot.'/sites/default/files/butlletins/abast/banner_PFVC.gif', 
													'https://voluntariat.gencat.cat/persones-voluntaries/format-com-a-voluntari/pla-de-formacio/'),
						'Banner opinió' => 	array (	$pathroot.'/sites/default/files/butlletins/abast/banner_opinio.png', 
													'http://bloc.xarxanet.org/'),
						'Banner nonprofit' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_nonprofit.png', 
													'http://nonprofit.xarxanet.org/'),
						'Banner subs. butlletí' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_subsButlleti.png', 
															$pathroot.'/user/register'),
						'Banner fes-te voluntari' => array ($pathroot.'/sites/default/files/butlletins/abast/banner_festeVoluntari.gif', 
															$pathroot.'/fes-voluntariat'),
						'Banner assessorament' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_assessorament.gif', 
															$pathroot.'/formulari-dassessorament'),
						'Banner xarxes socials' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_xarxes.gif', 
															$pathroot.'/segueix-nos'),
						'Banner voluntariat' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_voluntariat.gif', 
															'http://www.voluntariat.org/'),
						'Banner xarxanet' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_xarxanet.gif', 
														'http://www.xarxanet.org/'),
						'Banner verso' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_verso.gif', 
													'http://benestar.gencat.cat/ca/ambits_tematics/accio_comunitaria_i_voluntariat/voluntariat/verso'),
						'Banner masclisme' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_masclisme.gif', 
														'http://dones.gencat.cat/ca/ambits/violencia_masclista/recursos_atencio/telefon_900/'),
						'Banner blocs xarxanet' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_blocs.gif', 
															'http://blocs.xarxanet.org/'),
						'Banner omnia' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_omnia.gif', 
													'http://xarxa-omnia.org/'),
						'Banner dixit' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_dixit.gif', 
													'http://dixit.gencat.cat/ca/'),
						'Banner butlletins' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_butlletins.gif', 
													'http://benestar.gencat.cat/ca/actualitat/butlletins_electronics'),
						'Banner INTERREG IVC' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_interreg.gif', 
													'http://verso.au.dk'),
						'Banner CEV' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_evc2014.jpg', 
											'http://www.cev.be'),
						'Banner Subscribre me' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_subscribe.jpg', 
													'http://www.xarxanet.org/especial/barcelona-ecv/subscribe'),						
						'Banner Barcelona CEV' => 	array  ($pathroot.'/sites/default/files/butlletins/abast/banner_bcev.png', 
													'http://www.xarxanet.org/especial/barcelona-ecv'));

// Notícies destacades
$num_destacades = 3;
$destacades = array();
$wrapper = entity_metadata_wrapper('node', $node);
foreach ($wrapper->field_abast_destacades as $destacada){
	$noticia = $destacada->field_abast_destacades_xarxanet->value();
	$titular = $destacada->field_abast_destacades_titular->value();
	$img = $destacada->field_abast_crop->value();
	$type = $noticia->type;
	
	if ($num_destacades != 0 && (($noticia) || ($titular))){
		if ($img){
			$imatge = file_create_url($img[0]['uri']);
			$alt = $img[0]['alt'];
		}elseif($type == 'opinio'){
			//extreure autor de la opinio i imatge
			$autor = $noticia->field_autor_a['und'][0]['nid'];
			$autor = node_load($autor);
			$imatge = image_style_url('abast-gran',$autor->field_autor_foto_horitzontal['und'][0]['uri']);
			$alt = $autor->field_autor_foto_horitzontal['und'][0]['alt'];
		}elseif (!empty($noticia->field_agenda_imatge['und'])){
			$imatge = image_style_url('abast-gran',$noticia->field_agenda_imatge['und'][0]['uri']);
			$alt = $noticia->field_agenda_imatge['und'][0]['alt'];
		}else{
			$imatge = image_style_url('abast-gran',$noticia->field_imatges['und'][0]['uri']);
			$alt = $noticia->field_imatges['und'][0]['alt'];
		}
		if ($titular) {
			$tit = $titular['title'];
			$link = $titular['display_url'];
		} elseif ($noticia) {
			$tit = $noticia->title;
			$link = url('node/' . $noticia->nid, array('absolute' => TRUE));
		}
		$destacades[] = array(	
				'titular' => $tit,
				'link' => $link,
				'imatge' => $imatge,
				'alt' => $alt);
		$num_destacades--;
	}
}

// Notícies
$noticia_curta = 130; //Caràcters
$noticia_llarga = 900; //Caràcters
$noticies = array();
foreach ($wrapper->field_abast_noticies as $noticia){
	$noti_xn = $noticia->field_abast_noticies_xarxanet->value();
	
	if($noti_xn->nid) {
		$tit = $noti_xn->title;
		$link = url('node/' . $noti_xn->nid, array('absolute' => TRUE));
		$resum = $noti_xn->field_resum['und'][0]['value'];
		$type = $noti_xn->type;
		if ($type == 'opinio'){
			//extreure autor de la opinio i imatge
			$autor = $noti_xn->field_autor_a['und'][0]['nid'];
			$autor = node_load($autor);
			$imatge = image_style_url('abast-gran',$autor->field_autor_foto_horitzontal['und'][0]['uri']);
			$alt = $autor->field_autor_foto_horitzontal['und'][0]['alt'];
		}elseif (!empty($noti_xn->field_agenda_imatge['und'])){
			$imatge = image_style_url('abast-gran',$noti_xn->field_agenda_imatge['und'][0]['uri']);
			$alt = $noti_xn->field_agenda_imatge['und'][0]['alt'];
		}else{
			$imatge = image_style_url('abast-gran',$noti_xn->field_imatges['und'][0]['uri']);
			$alt = $noti_xn->field_imatges['und'][0]['alt'];
		}
	} else {
		$titular = $noticia->field_abast_noticies_titular->value();
		$tit = $titular['title'];
		$link = $titular['display_url'];
		$resum = $noticia->field_abast_noticies_resum->value();
		$img = $noticia->field_abast_crop1->value();
		$imatge = file_create_url($img['uri']);
		$alt = $img['alt'];
	}
	
	$noticies[] = array('titular' => $tit,
						'link' => $link,
						'imatge' => $imatge,
						'alt' => $alt,
						'teaser' => strip_tags($resum));
}
?>

<table style="font-family: Verdana; font-size: 11px;" width="970px" style="margin:auto" cellspacing="8px">

	<!-- CAPÇALERA -->	
	<tr><td colspan="2">		
		<a href="http://www.gencat.cat" style="text-decoration:none">
			<img src="http://www.gencat.cat/img/logo.gif" alt="logo Generalitat" style="border:0 none;"/>
		</a>
		<p style="text-align:right; vertical-align:bottom; margin-bottom:0px; margin-top:-10px">
		Si no veieu correctament aquest butlletí, cliqueu <a style="font-weight:bold; color:#7b1b1c; text-decoration:none" href="<?php echo url('node/' . $node->nid, array('absolute' => TRUE));?>">aquí</a></p>	
		<table cellspacing="0" cellpadding="0" style="border-top: solid 3px #800000; width:100%">
			<tr><?php 
				if (is_numeric($title))	{
					echo '<td width="57" style="background-color: black; color: white; font-weight: bold; vertical-align: top; padding: 5px; font-size: 16px">#'.$title.'</td>';
				}	
				?>
			<td style="background-color: #7b1b1c" width="100%">
				<table style="width:100%">
					<tr><td style="font-family:Arial; font-weight:bold; color:white; vertical-align:top;">
						<?php if (empty($node->field_abast_titol_monografic['und'][0]['value'])) {
							echo '<p style="font-size:30px; margin:5px">Butlletí</p>';	
						} else {
							echo '<p style="font-size:30px; margin:5px">'.$node->field_abast_titol_monografic['und'][0]['value'].'</p>';
							echo '<p style="font-size:18px; margin:5px">Monogràfic del Butlletí A l’Abast</p>';
						}?>
						<p style="font-size:16px; margin:5px">El butlletí del voluntariat català</p>
					</td>
					<td style="text-align:right"><img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/capçalera_blanc_sol.png" alt="Capçalera butlleti Abast" style="margin:10px"/></td></tr>				
				</table>
			</td></tr>
		</table>		
	</tr></td>
	<tr>	
		<td colspan="2">
			<a name="inici"></a>
			<table style="width:100%; font-size:11px;">
				<tr><td style="font-weight:bold">
					<?php
					$created = time(); 
					echo $dies[date('N', $created)-1].', '.date('j', $created).' '.$mesos[date('n', $created)-1].' de '.date('Y', $created);
					?>
				</td>
				<td style="text-align: right; font-weight:bold">
					<a style="color:#4D4D4D; text-decoration:none" href="http://xarxanet.org/hemeroteca-butlleti-labast">Butlletins anteriors</a>
				</td></tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="2" height="3px" style="background-color: #800000;"></td></tr>
	<tr><td colspan="2" height="3px" style="background-color: #CCCCCC; padding: 4px; font-weight: bold">
	<?php
		$array_flex = array('', '_2', '_3');
		if (!empty($destacades)){ echo '<a style="color:#000001; text-decoration:none" href="#destacats">Destacats</a>';}
		if (!empty($noticies)){ echo ' | <a style="color:#000001; text-decoration:none" href="#noticies">Notícies</a>';} 
		if ($wrapper->field_voluntariat->count()){ echo ' | <a style="color:#000001; text-decoration:none" href="#voluntariat">Crides de voluntariat</a>';}
		if ($wrapper->field_abast_pfvc->count()){ echo ' | <a style="color:#000001; text-decoration:none" href="#pfvc">Cursos PFVC</a>';}
		if ($wrapper->field_abast_formacions_xn->count()){echo ' | <a style="color:#000001; text-decoration:none" href="#formacio">Altres formacions</a>';}
		if ($wrapper->field_abast_activitats->count()){echo ' | <a style="color:#000001; text-decoration:none" href="#activitats">Agenda</a>';}
		if ($wrapper->field_abast_financament->count()){echo ' | <a style="color:#000001; text-decoration:none" href="#financaments">Finançaments</a>';}
		foreach ($wrapper->field_abast_flexible as $flex) {
			$titol = $flex->field_abast_flexible_titol->value();
			if ($titol)	echo ' | <a style="color:#000001; text-decoration:none" href="#flexible">'.$titol.'</a>';
		}
		foreach ($wrapper->field_abast_lliure as $lliure) {
			$titol = $lliure->field_monografic_titol_1->value();
			if($titol) echo ' | <a style="color:#000001; text-decoration:none" href="#bloc_lliure_'.$i.'">'.$titol.'</a>';
		}
		if (!empty($node->field_abast_entrevista_titol[0]['value']) || !empty($node->field_abast_entrevista_externa[0]['title'])){echo ' | <a style="color:#000001; text-decoration:none" href="#entrevista">'.$node->field_abast_entrevista_titol_sec[0]['value'].'</a>';}
		if ($node->field_abast_activat['und'][0]["value"] !== '0'){ echo ' | <a style="color:#000001; text-decoration:none" href="#activat">Activa\'t</a>';}
	?>
	</td></tr>


	<!-- NOTÍCIES DESTACADES -->
	<?php if (!empty($destacades)){?>
		<tr><td colspan="2"><a name="destacats"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: Destacats</h1></td></tr>
		<tr><td colspan="2" style="border: 1px dashed #4C0000;">
			<table cellspacing="8">
				<?php
				$titulars = '<tr>';
				$imatges = '<tr>';
				foreach ($destacades as $destacada){
					$alt = empty($destacada['alt']) ? 'Imatge de la notícia '.$destacada['titular'] : $destacada['alt'];
					$titulars .= '<td width="33%" style="vertical-align: top;">';
					$titulars .= '<a href="'.$destacada['link'].'" style="font-weight: bold; color: #800000; font-size: 15px; text-decoration: none; font-family:Arial">'.$destacada['titular'].'</a></td>';
					$imatges .= '<td><a href="'.$destacada['link'].'" style="text-decoration: none"><img src="'.$destacada['imatge'].'" alt="'.$alt.'" height="194px" width="300px" style="border:0 none;"/></a></td>';
				}
				$titulars .= '</tr>';
				$imatges .= '</tr>';
				echo $titulars;
				echo $imatges;
				?>
			</table>
		</td></tr>
		<tr><td colspan="2" style="text-align: right;"><a href="#inici" style="text-decoration: none"><img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a></td></tr>
	<?php }?>
		
		
	<!-- NOTÍCIES -->
	<?php if (!empty($noticies)){?>
		<tr><td colspan="2"><a name="noticies"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: Notícies</h1></td></tr>
		<?php
		$curta = true;
		foreach ($noticies as $noticia){
			$alt = empty($destacada['alt']) ? 'Imatge de la notícia '.$noticia['titular'] : $noticia['alt'];
			$cont = '<table cellspacing="5" width="100%"><tr><td colspan="2" height="40px" style="vertical-align: top"><a href="'.$noticia['link'].'" style="font-weight: bold; color: #800000; font-size: 15px; text-decoration: none; font-family:Arial">'.$noticia['titular'].'</a></td></tr>';
			$cont .= '<tr><td style="vertical-align: top; width: 130px"><a href="'.$noticia['link'].'" style="text-decoration: none"><img src="'.$noticia['imatge'].'" alt="'.$alt.'" height="115" width="185" style="border:0 none;"/></a>';
			$cont .= '</td><td style="vertical-align: top"><p style="font-size: 12px; text-align: justify; margin: 0">';
			if ($curta){			
				$cont .= substr($noticia['teaser'], 0, strrpos(substr($noticia['teaser'], 0, $noticia_curta)," ")).' ...</p></td></tr></table></td>';
				echo '<tr><td width="33%" style="vertical-align: top">'.$cont.'</td>';
			}else{
				if (strlen($noticia['teaser'])>$noticia_llarga){
					$cont .= substr($noticia['teaser'], 0, strrpos(substr($noticia['teaser'], 0, $noticia_llarga)," ")).' ...</p></td></tr></table></td>';
				}else{
					$cont .= $noticia['teaser'].'</p></td></tr></table></td>';
				}
				echo '<td width="67%" style="vertical-align: top">'.$cont.'</td></tr>';			
			}
			$curta = !$curta;
		}
		if (!$curta) echo '<td width="67%" style="vertical-align: top"></td></tr>';	
		?>
		<tr><td colspan="2" style="text-align: right;">
			<a style="font-weight: bold; color: #000001; text-decoration: none" href="<?php echo $node->field_abast_noticies_enllac['und'][0]['url']; ?>">
				<?php echo $node->field_abast_noticies_enllac['und'][0]['title']; ?>
			</a>
			<a href="#inici" style="text-decoration: none">  <img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a>
		</td></tr>
	<?php } ?>
	
	
	<tr><td style="vertical-align: top">	
	<!-- VÍDEO -->
		<?php
			if ($node->field_abast_video['und'][0]['fid']){
				$video_title = (isset($node->field_abast_video_titol['und'][0]['value'])) ? $node->field_abast_video_titol['und'][0]['value'] : "El vídeo de la quinzena";
				echo '<div style="border: 1px dashed #818181; margin-right: 8px; padding: 0 15px;">';
				echo '<p style="font-weight: bold; color: #800000; font-size: 14px; font-family:Arial; text-align:center">'.$video_title.'</p>';
				echo '<a href="'.$node->field_abast_video['und'][0]['url'].'" style="text-decoration: none">';
				$img = file_create_url($node->field_abast_video['und'][0]['uri']);
				echo '<img src="'.$img.'" alt="'.$node->field_abast_video['und'][0]['alt'].'" width="268" style="margin-bottom: 15px; border:0 none;"/></a>';
				echo '</div>';
			}
		?>


	<!-- BANNERS -->
		<!-- BANNERS FIXES -->
		<?php
			foreach ($node->field_abast_banner_fixe['und'] as $banner){
				echo '<br/><a href="'.$banners_fixes[$banner['value']][1].'" style="text-decoration:none">';
				echo '<img src="'.$banners_fixes[$banner['value']][0].'" alt="'.$banner['value'].'" style="margin: 10px 0; border:0 none;"/></a>';
			}
		?>
		
		<!-- BANNERS NOUS -->
		<?php
			foreach ($node->field_abast_banner_nou['und'] as $banner){
				if(isset($banner['uri'])){
					$img = file_create_url($banner['uri']);
					echo '<br/><a href="'.$banner['url'].'" style="text-decoration:none">';
					echo '<img src="'.$img.'" alt="'.$banner['alt'].'" style="margin: 10px 0; border:0 none;"/></a>';
				}
			} 
		?>
			
	</td><td style="vertical-align:top">


	<!-- VOLUNTARIAT -->
	<?php 
		if($wrapper->field_voluntariat->count()){?>
		<a name="voluntariat"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: Crides de voluntariat</h1>
		<?php 
		foreach ($wrapper->field_voluntariat as $voluntariat) {
			$vol_xn = $voluntariat->field_abast_voluntariat_xarxanet->value();
			if ($vol_xn->nid) {
				$title = $vol_xn->title;
				$url = url('node/' . $vol_xn->nid, array('absolute' => TRUE));
			} else {
				$ext = $voluntariat->field_abast_voluntariat_titol->value();
				$title = $ext['title'];
				$url = $ext['url'];
			}
			echo '<a href="'.$url.'" style="font-weight: bold; color: #800000; font-size: 14px; font-family:Arial; text-decoration: none">'.$title.'</a>';
			echo '<p style="font-size: 12px; margin: 0; vertical-align: top; margin: 5px 0 10px;">
			<b>Entitat: </b>'.$voluntariat->field_abast_voluntariat_entitat->value().'<br/>
			<b>Lloc: </b>'.$voluntariat->field_abast_voluntariat_lloc->value().'<br/>
			<b>Dedicació: </b>'.$voluntariat->field_abast_voluntariat_dedicaci->value().'<br/>
			<b>Perfil: </b>'.str_replace(array('<p>', '</p>'), '', $voluntariat->field_abast_voluntariat_perfil->value()).'
			</p>';
		}
		?>	
		<p style="text-align: right">
			<a style="font-weight: bold; color: #000001; text-decoration: none" href="http://www.voluntariat.org/Promoci%C3%B3delvoluntariat/Volsfervoluntariat.aspx">
				Més crides a voluntariat
			</a>
			<a href="#inici" style="text-decoration: none">  <img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a>
		</p>
	<?php }?>


	<!-- FORMACIÓ PFVC -->
	<?php if($wrapper->field_abast_pfvc->count()){?>
		<a name="pfvc"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: Cursos del Pla de Formació del voluntariat de Catalunya (PFVC)</h1>
		<?php
		foreach ($wrapper->field_abast_pfvc as $pfvc){
			if ($title = $pfvc->field_abast_pfvc_titol->value()){
				echo '<a href="'.$title['url'].'" style="font-weight: bold; color: #800000; font-size: 14px; font-family:Arial; text-decoration: none">'.$title['title'].'</a>';
				echo '	<p style="font-size: 12px; margin: 0; vertical-align: top; margin: 5px 0 10px;">
						<b>Data d\'inici: </b>'.$pfvc->field_abast_pfvc_dates->value().'<br/>
						<b>Lloc: </b>'.$pfvc->field_abast_pfvc_lloc->value().'<br/>
						<b>Entitat: </b>'.$pfvc->field_abast_pfvc_entitat->value().'</p>';
			}
		}
		?>
		<p style="text-align: right">
			<a style="font-weight: bold; color: #000001; text-decoration: none" href="http://www.voluntariat.org/Formaci%C3%B3">
				Més formacions
			</a>
			<a href="#inici" style="text-decoration: none">  <img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a>
		</p>
	<?php }?>
	
	
	<!-- ALTRES FORMACIONS -->
	<?php if($wrapper->field_abast_formacions_xn->count()){?>
		<a name="formacio"><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: Altres formacions</h1>
		<?php
		foreach ($wrapper->field_abast_formacions_xn as $form){
			$form_xn = $form->field_abast_formacions_xarxanet->value();
			$location = '';
			if ($form_xn->nid){
				$title = $form_xn->title;
				$url = url('node/' . $form_xn->nid, array('absolute' => TRUE));
				if($form->field_abast_formacions_dates->value()){
					$data = $form->field_abast_formacions_dates->value();
				}else{
					$data = strtotime($form_xn->field_date_event['und'][0]['value']);
					$data = $dies[date('N', $data)-1].', '.date('j', $data).' '.$mesos[date('n', $data)-1].' de '.date('Y', $data);
				}
				if ($form_xn->location['name'] || $form_xn->location['street'] || $form_xn->location['city']) {
					if ($form_xn->location['name']) $location .= $form_xn->location['name'].'. ';
					if ($form_xn->location['street']) $location .= $form_xn->location['street'].'. ';
					if ($form_xn->location['city']) $location .= $form_xn->location['city'];
				} 							
				$lloc = $form->field_abast_formacions_lloc->value();
				if (!$lloc && $location) $lloc = $location;
				if (!$lloc && $form_xn->field_esdeveniment_en_linia['und'][0]['value']) $lloc='Esdeveniment en línia';
				$entitat = ($form->field_abast_formacions_entitat->value()) ? $form->field_abast_formacions_entitat->value() : $form_xn->field_organizer['und'][0]['value'];				
				echo '<a href="'.$url.'" style="font-weight: bold; color: #800000; font-size: 14px; font-family:Arial; text-decoration: none">'.$title.'</a>';
				echo '	<p style="font-size: 12px; margin: 0; vertical-align: top; margin: 5px 0 10px;">
						<b>Data d\'inici: </b>'.$data.'<br/>
						<b>Lloc: </b>'.$lloc.'<br/>
						<b>Entitat: </b>'.$entitat.'</p>';
			}
		}
		?>
		<p style="text-align: right">
			<a style="font-weight: bold; color: #000001; text-decoration: none" href="<?php echo $pathroot;?>/agenda/curs">
				Més formacions
			</a>
			<a href="#inici" style="text-decoration: none">  <img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a>
		</p>
	<?php }?>


	<!-- ACTIVITATS -->
	<?php if($wrapper->field_abast_activitats->count()){?>
		<a name="activitats"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: Agenda d'activitats</h1>
		<?php
		/*foreach ($node->field_abast_activitats_xarxanet as $key => $activitat){
			if (!empty($activitat['safe']['nid'])){
				$node_ = node_load($activitat['safe']['nid']);
				$data = (isset($node->field_abast_activitats_dates[$key]['value'])) ? $node->field_abast_activitats_dates[$key]['value'] : date('d/m/y', strtotime($node_->field_date_event[0]['value']));
				echo '<p><a href="'.$pathroot.'/'.$node_->path.'" style="color: #000001; font-size: 12px; text-decoration: none">'.$node_->title.'</a>';
				echo ' - '.$data.'</p>';
			}
		}*/		
		foreach ($wrapper->field_abast_activitats as $activitat){
			$act_xn = $activitat->field_abast_activitats_xarxanet->value();
			if ($act_xn->nid){
				$title = $act_xn->title;
				$url = url('node/' . $act_xn->nid, array('absolute' => TRUE));
				if($activitat->field_abast_activitats_dates->value()){
					$data = $activitat->field_abast_activitats_dates->value();
				}else{
					$data = strtotime($act_xn->field_date_event['und'][0]['value']);
					$data = $dies[date('N', $data)-1].', '.date('j', $data).' '.$mesos[date('n', $data)-1].' de '.date('Y', $data);
				}
				$location = $act_xn->location['city'];
				if ($act_xn->location['name']) $location = $act_xn->location['name'].', '.$location;
				$lloc = ($activitat->field_abast_activitats_lloc->value()) ? $activitat->field_abast_activitats_lloc->value() : $location;
				$entitat = ($activitat->field_abast_activitats_entitat->value()) ? $activitat->field_abast_activitats_entitat->value() : $act_xn->field_organizer['und'][0]['value'];				
				echo '<a href="'.$url.'" style="font-weight: bold; color: #800000; font-size: 14px; font-family:Arial; text-decoration: none">'.$title.'</a>';
				echo '	<p style="font-size: 12px; margin: 0; vertical-align: top; margin: 5px 0 10px;">
						<b>Data d\'inici: </b>'.$data.'<br/>
						<b>Lloc: </b>'.$lloc.'<br/>
						<b>Entitat: </b>'.$entitat.'</p>';
			}
		}
		?>
		<p style="text-align: right">
			<a style="font-weight: bold; color: #000001; text-decoration: none" href="<?php echo $pathroot;?>/agenda">
				Més agenda
			</a>
			<a href="#inici" style="text-decoration: none">  <img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a>
		</p>
	<?php }?>
	
	
	<!-- FINANÇAMENTS -->
	<?php if($wrapper->field_abast_financament->count()){?>
		<a name="financaments"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: Finançaments</h1>
		<?php
		foreach ($wrapper->field_abast_financament as $financament){
			$fin_xn = $financament->field_abast_financament_xarxanet->value();
			if ($fin_xn->nid) {
				$title = $fin_xn->title;
				$url = url('node/' . $fin_xn->nid, array('absolute' => TRUE));
				
				if ($financament->field_abast_financament_termini->value()){
					$termini = $financament->field_abast_financament_termini->value();
				}else{
					$time1 = strtotime($fin_xn->field_date['und'][0]['value']);
					$time2 = strtotime($fin_xn->field_date['und'][0]['value2']);
					$termini =	'Del '.date('j', $time1).' '.$mesos[date('n', $time1)-1].' de '.date('Y', $time1).' al '.date('j', $time2).' '.$mesos[date('n', $time2)-1].' de '.date('Y', $time2);
				}
				$convocant = ($financament->field_abast_financament_convocan->value()) ? $financament->field_abast_financament_convocan->value() : strip_tags($fin_xn->field_convocant['und'][0]['value']);
				echo '<a href="'.$url.'" style="font-weight: bold; color: #800000; font-size: 14px; font-family:Arial; text-decoration: none">'.$title.'</a>';
				echo '<p style="font-size: 12px; margin: 0; vertical-align: top; margin: 5px 0 10px;"><b>Termini: </b>'.$termini.'<br/><b>Convocant: </b>'.$convocant.'</p>';
			}
		}
		?>
		<p style="text-align: right">
			<a style="font-weight: bold; color: #000001; text-decoration: none" href="<?php echo $pathroot;?>/financaments">
				Més finançaments
			</a>
			<a href="#inici" style="text-decoration: none">  <img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a>
		</p>
	<?php }?>
	
	
	<!-- BLOC FLEXIBLE -->
		<?php
		foreach ($wrapper->field_abast_flexible as $flex) {
			$titol = $flex->field_abast_flexible_titol->value();
			$cont_xn = $flex->field_abast_flexible_contingut->value();
			$cont_ex = $flex->field_abast_extern->value();
			
			if ($titol){
				echo '<a name="flexible"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: '.$titol.'</h1>';
				//Continguts Xarxanet
				foreach ($cont_xn as $xn){
					if ($xn->nid){
						$title = $xn->title;
						$url = url('node/' . $xn->nid, array('absolute' => TRUE));
						$type = $xn->type;
						if($type == 'opinio'){
							//extreure autor de la opinio i imatge
							$autor = $xn->field_autor_a['und'][0]['nid'];
							$autor = node_load($autor);
							$imatge = image_style_url('abast-petit',$autor->field_autor_foto_horitzontal['und'][0]['uri']);
							$alt = $autor->field_autor_foto_horitzontal['und'][0]['alt'];
						}elseif (isset($xn->field_agenda_imatge['und'][0]['uri'])){
							$imatge = image_style_url('abast-petit',$xn->field_agenda_imatge['und'][0]['uri']);
							$alt = $xn->field_agenda_imatge['und'][0]['alt'];
						}else{
							$imatge = image_style_url('abast-petit',$xn->field_imatges['und'][0]['uri']);
							$alt = $xn->field_imatges['und'][0]['alt'];
						}
						echo '<a href="'.$url.'" style="font-weight: bold; color: #800000; font-size: 14px; font-family:Arial; text-decoration: none">'.$title.'</a>';
						echo '<table cellspacing="5" style="margin-bottom: 10px"><tr><td style="vertical-align: top">';
						echo '<a href="'.$url.'" style="text-decoration: none"><img src="'.$imatge.'" alt="'.$alt.'" height="115" width="185" style="border:0 none;"/></a></td><td style="vertical-align: top">';
						echo '<p style="font-size: 12px; text-align: justify; margin: 0; vertical-align: top">'.strip_tags($xn->field_resum['und'][0]['value']).'</p></td></tr></table>';
					}
				}
				
				//Continguts externs
				$externs = $flex->field_abast_extern->value();
				foreach ($externs as $extern) {
					$title = $extern->field_abast_flexible_extern;
					$imatge = file_create_url($extern->field_abast_flexible_imatge['und'][0]['uri']);
					$alt = $extern->field_abast_flexible_imatge['und'][0]['alt'];
					echo '<a href="'.$title['und'][0]['url'].'" style="font-weight: bold; color: #800000; font-size: 14px; font-family:Arial; text-decoration: none">'.$title['und'][0]['title'].'</a>';
					echo '<table cellspacing="5" style="margin-bottom: 10px"><tr><td style="vertical-align: top">';
					echo '<a href="'.$title['und'][0]['url'].'" style="text-decoration: none"><img src="'.$imatge.'" alt="'.$alt.'" height="115" width="185" style="border:0 none;"/></a></td><td style="vertical-align: top">';
					echo '<p style="font-size: 12px; text-align: justify; margin: 0; vertical-align: top">'.strip_tags($extern->field_abast_flexible_resum['und'][0]['value'],'<a>').'</p></td></tr></table>';
				}				
				
				echo '<p style="text-align: right">';
				$enllac = $flex->field_abast_flexible_enllac->value();
				if (!empty($enllac['title'])){
					echo '<a href="'.$enllac['url'].'" style="font-weight: bold; color: #000001; text-decoration: none">'.$enllac['title'].'</a>';
				}	
				echo '<a href="#inici" style="text-decoration: none">  <img src="'.$pathroot.'/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a></p>';
			}
		}
		?>
	
	<!-- BLOC LLIURE -->
		<?php
		$i = 0;
		foreach ($wrapper->field_abast_lliure as $lliure) {
			$titol = $lliure->field_monografic_titol_1->value();
			$cos = $lliure->field_monografic_cos_1->value();
			if($titol) echo '<a name="bloc_lliure_'.$i.'"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: '.$titol.'</h1>';
			if($cos) echo $cos['value'];
			if($cos) echo '<p style="text-align:right"><a href="#inici" style="text-decoration: none">  <img src="'.$pathroot.'/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a></p>';
			$i++;
		}
		?>
	
	<!-- ENTREVISTA -->
		<?php
		$i = 0;
		if ($wrapper->field_abast_entrevista_coll->count()) {
			echo '<a name="entrevista"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 10px 0 5px;">:: '.$node->field_abast_entrevista_titol_sec['und'][0]['value'].'</h1>';
		}
		
		foreach ($wrapper->field_abast_entrevista_coll as $entr) {
			$entr_xn = $entr->field_abast_entrevista->value();
			if ($entr_xn->nid) {
				if (isset($entr_xn->field_agenda_imatge['und'][0]['uri'])){
					$imatge = image_style_url('abast-petit',$entr_xn->field_agenda_imatge['und'][0]['uri']);
					$alt = $entr_xn->field_agenda_imatge['und'][0]['alt'];
				}else{
					$imatge = image_style_url('abast-petit',$entr_xn->field_imatges['und'][0]['uri']);
					$alt = $entr_xn->field_imatges['und'][0]['alt'];
				}
				$titol = ($entr->field_abast_entrevista_titol->value()) ? $entr->field_abast_entrevista_titol->value() : $entr_xn->title;
				$link = url('node/' . $entr_xn->nid, array('absolute' => TRUE));
			} else {
				$url = $entr->field_abast_entrevista_externa->value();
				$titol = $url['title'];
				$link = $url['url'];
				$img = $entr->field_abast_entrevista_imatge->value();
				$alt = $img['alt'];
				$imatge = file_create_url($img['uri']);;
			}			
			echo '<table cellspacing="5" style="margin-bottom: 10px"><tr><td style="vertical-align: top">';
			echo '<a href="'.$link.'" style="text-decoration: none"><img src="'.$imatge.'" alt="'.$alt.'" height="115" width="185" style="border:0 none;"/></a></td><td style="vertical-align: top">';
			echo '<a href="'.$link.'" style="font-weight: bold; color: #800000; font-size: 15px; text-decoration: none; font-family:Arial">'.$titol.'</a>';
			echo '	<table style="margin-left:85px; margin-top:5px; width:auto"><tr><td style="vertical-align:top"><img src="'.$pathroot.'/sites/default/files/butlletins/abast/cometes1.gif" alt="cometes" width="15px"/></td>
					<td style="font-size: 12px; text-align:center; padding:5px 0; width:180px">'.strip_tags($entr->field_abast_entrevista_cita->value()).'</td>
					<td style="vertical-align:bottom"><img src="'.$pathroot.'/sites/default/files/butlletins/abast/cometes2.gif" alt="cometes" width="15px"/></td></tr></table>';	
			echo '</td></tr></table>';			
			$i++;
		}
		if ($wrapper->field_abast_entrevista_coll->count()) {
			echo '<p style="text-align:right"><a href="#inici" style="text-decoration: none">  <img src="'.$pathroot.'/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a></p>';
		}
		?>
	
		
	<!-- ACTIVA'T -->
	<?php if ($node->field_abast_activat['und'][0]["value"] !== '0') { ?>
		<a name="activat"></a><h1 style="font-family:Arial; font-size:17px; font-weight:bold; color:#818181; margin: 15px 0 5px;">:: Activa't</h1>
		<a style="font-weight: bold; color: #800000; font-size: 14px; font-family:Arial; text-decoration: none" href="<?php echo $pathroot;?>/noticies/he-danar-informar-me-i-fer-voluntariat">
			On he d'anar per informar-me i fer voluntariat?
		</a>
		<table cellspacing="5">
			<tr><td>
				<a href="<?php echo $pathroot;?>/noticies/he-danar-informar-me-i-fer-voluntariat" style="text-decoration:none">
					<img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/mapa_activat_2.jpg" alt="mapa dels centres de voluntariat a Catalunya" style="border:0 none;"/>
				</a>
			</td><td>
				<p style="font-size: 12px; text-align: justify; margin: 0;">
					No saps a on has d’anar per informar-te sobre el voluntariat? T’oferim un mapa de les principals oficines de voluntariat municipal arreu de Catalunya. També queden recollides les principals entitats de referència en l’àmbit del voluntariat als diferents pobles i ciutats. 
				</p>
				<p style="text-align: right">
					<a href="#inici" style="text-decoration: none">  <img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/fletxeta.gif" alt="torna a dalt" style="border:0 none;"/></a>
				</p>
			</td></tr>
		</table>
	<?php } ?>
	</td>
</tr><tr>	
	<!-- PEU -->	
	<td colspan="2" style="border-top: dotted 2px #800000; border-bottom: dotted 2px #800000; font-size:1px">&nbsp;</td>
</tr><tr>
	<td td colspan="2">
		<table cellspacing="10">
			<tr><td>	
				<a href="http://benestar.gencat.cat" style="text-decoration:none"><img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/logo_benestarSocial.jpg" alt="logo benestar i familia" height="32" style="display: inline; border:0 none;"/></a>
			</td><td>
				<a href="http://www.peretarres.org" style="text-decoration:none"><img src="<?php echo $pathroot;?>/sites/default/files/butlletins/abast/logo_FPT.jpg" alt="logo fundacio pere tarres" height="32" style="display: inline; border:0 none;"/></a>
			</td><td>
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/es/deed.ca"><img alt="Licencia de Creative Commons" src="http://i.creativecommons.org/l/by-nc-sa/3.0/es/88x31.png" style="border:0 none;"/></a>
			</td></tr>
		</table>	
		<p style="font-size: 10px; text-align: justify; margin: 0"><a href="http://web.gencat.cat/ca/menu-ajuda/ajuda/avis_legal/">Avís legal</a>: D’acord amb l’article 17.1 de la Llei 19/2014, la &copy;Generalitat de Catalunya permet la reutilització dels continguts i de les dades sempre que se'n citi la font i la data d'actualització i que no es desnaturalitzi la informació (article 8 de la Llei 37/2007) i també que no es contradigui amb una llicència específica. Si l'adreça de correu que informeu al donar-vos d'alta deixa d'estar activa us donarem de baixa a la base de dades.
		<br/>Aquest butlletí és una iniciativa del Departament de Treball, Afers Socials i Famílies de la Generalitat de Catalunya, coeditat amb la Fundació Pere Tarrés. ISSN: 2385-4146</p> 
	</td>
</tr><tr>
	<td colspan="2" style="border-top: dotted 2px #800000; border-bottom: dotted 2px #800000; font-size:1px">&nbsp;</td>
</tr><tr>
	<td colspan="2">
		<p style="font-size: 11px; margin: 0"> 
			<a style="color: #800000; text-decoration: none" href="http://xarxanet.org/sites/default/files/subscripcions_abast/alta.html">alta</a> ::  
			<a style="color: #800000; text-decoration: none" href="http://xarxanet.org/sites/default/files/subscripcions_abast/baixa.html">baixa</a> ::   
			<a style="color: #800000; text-decoration: none" href="mailto:alabast@voluntariat.org?Subject=Consulta%20butlletí">contacte</a> ::  
			<a style="color: #800000; text-decoration: none" href="http://xarxanet.org/hemeroteca-butlleti-labast">butlletins anteriors</a>
		</p>
	</td>
</tr>
<tr>
	<td colspan="2" style="text-align:right; font-size 11px;">
		<a style="text-decoration:none; color:#4D4D4D;" href="http://www.gencat.cat/web/cat/copyright.htm">© Generalitat de Catalunya</a>  
	</td>
</tr>
</table>

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

// Data Preprocessing


//$Monographic Section
$monographicSectTitle = $node->field__actualitat21_mono_epigraf['und'][0]['value'];
$monographicImage = image_style_url('large', $node->field_actualitat21_mono_imatge['und'][0]['uri']);
$monographicImageAlt = $node->field_actualitat21_mono_imatge['und'][0]['field_file_image_alt_text']['und'][0]['value'];
$monographicText = $node->field_actualitat21_mono_cos['und'][0]['value'];
$monographicLink = "https://www.xarxanet.org";

//$entity Section
$entityID = $node->field_actualitat21_entitat['und'][0]['nid'];
$entityNode = node_load($entityID);
$entityTitle = $entityNode->title;
$entityImage = image_style_url('butlleti_quadrada', $entityNode->field_imatges['und'][0]['uri']);
$entityImageAlt = $entityNode->field_imatges['und'][0]['field_file_image_alt_text']['und'][0]['value'];
$entityText = strip_tags($entityNode->field_resum['und'][0]['value']);
$entityLink = url('node/' . $entityNode->nid, array('absolute' => TRUE));

//$highlight Section
$highlightID = $node->field_actualitat21_destaquem['und'][0]['nid'];
$highlightNode = node_load($highlightID);
$highlightTitle = $highlightNode->title;
$highlightImage = image_style_url('butlleti_quadrada', $highlightNode->field_imatges['und'][0]['uri']);
$highlightImageAlt = $highlightNode->field_imatges['und'][0]['field_file_image_alt_text']['und'][0]['value'];
$highlightText = strip_tags($highlightNode->field_resum['und'][0]['value']);
$highlightLink = url('node/' . $highlightNode->nid, array('absolute' => TRUE));

//Resource Section
$resourceID = $node->field_actualitat21_recurs['und'][0]['nid'];
$resourceNode = node_load($resourceID);
$resourceTitle = $resourceNode->title;
$resourceImage = image_style_url('butlleti_quadrada', $resourceNode->field_imatges['und'][0]['uri']);
$resourceImageAlt = $resourceNode->field_imatges['und'][0]['field_file_image_alt_text']['und'][0]['value'];
$resourceText = strip_tags($resourceNode->field_resum['und'][0]['value']);
$resourceLink = url('node/' . $resourceNode->nid, array('absolute' => TRUE));

//contrast1 Section
$contrast1ID = $node->field_actualitat21_noticontrast1['und'][0]['nid'];
$contrast1Node = node_load($contrast1ID);
$contrast1Title = $contrast1Node->title;
$contrast1Image = image_style_url('butlleti_quadrada', $contrast1Node->field_imatges['und'][0]['uri']);
$contrast1ImageAlt = $contrast1Node->field_imatges['und'][0]['field_file_image_alt_text']['und'][0]['value'];
$contrast1Text = $contrast1Node->field_resum['und'][0]['value'];
$contrast1Link = url('node/' . $contrast1Node->nid, array('absolute' => TRUE));

//contrast2 Section
$contrast2ID = $node->field_actualitat21_noticontrast2['und'][0]['nid'];
$contrast2Node = node_load($contrast2ID);
$contrast2Title = $contrast2Node->title;
$contrast2Image = image_style_url('butlleti_quadrada', $contrast2Node->field_imatges['und'][0]['uri']);
$contrast2ImageAlt = $contrast2Node->field_imatges['und'][0]['field_file_image_alt_text']['und'][0]['value'];
$contrast2Text = $contrast2Node->field_resum['und'][0]['value'];
$contrast2Link = url('node/' . $contrast2Node->nid, array('absolute' => TRUE));


?>

<!-- CSS Styles from TOTHOMweb -->
<style type="text/css">
	#main #content {
		background-color: #ffffff;
	}

	tbody {
		border: 0px;
	}

	table,
	table td,
	table tr {
		border-spacing: 0px !important;
		border-collapse: collapse !important;
		padding: 0px;
	}

	table td {
		border-top: 0px;
	}
</style>
<!-- @END CSS Styles from TOTHOMweb -->
<!-- @END CSS Styles from TOTHOMweb -->
<center id="newsletter" class="wrapper" style="background-color:#f6f6f6; width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
	<div class="webkit" style="max-width:602px;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;">
		<table class="butlleti" style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 13px; border:1px solid #d3d3d2; border-bottom: 0px; width:100%; background-color:#ffffff;">
			<!-- CAPÇALERA -->
			<tr style="background-color:#2f3031;">
				<td style="padding: 0 0 0 5px;">
					<a href="http://www.xarxanet.org" style="text-decoration:none">
						<img src="/sites/all/themes/xn17/logo.png" alt="logotip xarxanet" style="margin-left:5px; margin-top:20px" />
					</a>
				</td>
				<td>
					<p style="font-size:38px; color:#FFFFFF; text-align:right; font-weight:bold; margin:10px 5px">Actualitat</p>
				</td>
			</tr>
			<tr style="background-color:#2f3031; color:#878787; font-weight:bold;">
				<td style="padding: 5px 10px; border-top:3px solid #231f20; border-bottom: 15px solid white;">
					<?php
					$created = $node->created;
					echo $dies[date('N', $created) - 1] . ', ' . date('j', $created) . ' ' . $mesos[date('n', $created) - 1] . ' de ' . date('Y', $created) . ' - Num. ' . $title;
					?>
				</td>
				<td style="text-align: right; padding: 5px 10px; border-top:3px solid #231f20; border-bottom: 15px solid white;">
					<a href="http://www.xarxanet.org/hemeroteca_actualitat" style=" color:#878787">Butlletins anteriors</a>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding:0 10px;vertical-align: top; text-align:right">
					<p style="margin:0;font-size:14px;color:#2f3031;;">ISSN 2696-9750</p>
				</td>
			</tr>
			<?php if (!empty($monographicSectTitle)) : ?>
				<tr>
					<td colspan="2" style="padding:0 15px;">
						<table style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 16px; width:100%;">
							<tbody>
								<tr>
									<td>
										<h2 class="section-title" style="font-family:Fira Sans, Helvetica, Arial !important;font-weight:600;font-size:1.875em !important;color:#333333;margin-top:20px; margin-bottom:25px; "><?php echo $monographicSectTitle; ?></h2>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding:0 15px 20px 15px;">
						<table style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 16px; width:100%; background-color:#EDEDED; border-radius:15px;">
							<tbody>
								<tr>
									<td colspan="2" style="padding:10px;">
										<a href="<?php print $monographicLink; ?>">
											<img src="<?php print $monographicImage; ?>" width="600" alt="<?php print $monographicImageAlt; ?>" style="border-width:0;font-family:Fira Sans, Helvetica, Arial !important;width:100%;max-width:600px;height:auto; border-radius:15px;" />
										</a>
									</td>
								</tr>
								<tr>

									<td style="padding:10px 20px 20px 20px; width: 73%;">
										<p style="font-size: .874em; line-height: 1.22em; margin-bottom:0;"><span><?php echo $monographicText; ?></span></p>
									</td>
									<td style="padding: 17px 15px 20px 0; vertical-align:bottom;">
										<a href="<?php echo $monographicLink; ?>" style="background-color:#BE1622; color:#ffffff; font-size:.93em; padding:14px 16px; float: right; border-radius: 5px; text-decoration:none;">
											Llegiu-ne més
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>

			<?php endif; ?>
			<!-- SECTION  || L'entitat protagonista -->
			<?php if (!empty($entityNode)) : ?>
			<tr>
				<td colspan="2" style="padding: 0 15px;">
					<table style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 16px; width:100%;">
						<tbody>
							<tr>
								<td>
									<h2 class="section-title" style="font-family:Fira Sans, Helvetica, Arial !important;font-weight:600;font-size:1.875em !important;color:#333333; margin-top:20px; margin-bottom:25px;">L'entitat protagonista</h2>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 0 15px 20px 15px; vertical-align: top; ">
					<table style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 16px; width:100%;  background-color:#EDEDED; border-radius:15px;">
						<tbody>
							<tr>
								<td style="width: 55%;">
									<table colspan="2">
										<tr>
											<td style="padding:20px 15px 0 20px;">
												<h3 style="font-size:1.25em; font-weight:600; margin-top: 0; margin-bottom:17px;"><?php echo $entityTitle; ?></h3>
												<p style="font-size: .874em; line-height: 1.22em;  margin-bottom:0;"><?php echo $entityText; ?></p>
											</td>
										</tr>
										<tr>
											<td style="padding:17px 0 20px 20px;">
												<a href="<?php echo $entityLink; ?>" style="background-color:#BE1622; color:#ffffff; font-size:.93em; padding:14px 16px;float: left; border-radius: 5px; text-decoration:none;">
													Llegiu-ne més
												</a>
											</td>
										</tr>
									</table>
								</td>
								<td style="padding:20px 20px 20px 10px; border-radius: 10px; vertical-align:top;">
									<a href="<?php print $entityLink; ?>">
										<img src="<?php print $entityImage; ?>" width="600" alt="<?php print $entityImageAlt; ?>" style="border-width:0;font-family:Fira Sans, Helvetica, Arial !important;width:100%;max-width:600px;height:auto; border-radius:15px;" />
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<?php endif; ?>
			<!-- SECTION  || Destaquem-->
			<?php if (!empty($highlightNode)) : ?>
			<tr>
				<td colspan="2" style="padding: 0 15px;">
					<table style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 16px; width:100%;">
						<tbody>
							<tr>
								<td>
									<h2 class="section-title" style="font-family:Fira Sans, Helvetica, Arial !important;font-weight:600;font-size:1.875em !important;Margin:0px;color:#333333; margin-top:20px; margin-bottom:25px;">Destaquem</h2>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding:0 15px 20px 15px; vertical-align: top;">
					<table style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 16px; width:100%;  background-color:#EDEDED; border-radius:15px;">
						<tbody>
							<tr>
								<td style="padding:20px 10px 20px 20px; border-radius: 10px; vertical-align:top;">
									<a href="<?php print $highlightLink; ?>">
										<img src="<?php print $highlightImage; ?>" width="600" alt="<?php print $highlightImageAlt; ?>" style="border-width:0;font-family:Fira Sans, Helvetica, Arial !important;width:100%;max-width:600px;height:auto; border-radius:15px;" />
									</a>
								</td>
								<td style="width: 55%;">
									<table colspan="2">
										<tr>
											<td style="padding-right: 20px; padding-left: 15px; padding-top: 20px;">
												<h3 style="font-size:1.25em; font-weight:600; margin-top: 0; margin-bottom:17px;"><?php echo $highlightTitle; ?></h3>
												<p style="font-size: .874em; line-height: 1.22em;  margin-bottom:0;"><?php echo $highlightText; ?></p>
											</td>
										</tr>
										<tr>
											<td style="padding:17px 0 20px 20px;">
												<a href="<?php echo $highlightLink; ?>" style="background-color:#BE1622; color:#ffffff; font-size:.93em; padding:14px 16px;float: left; border-radius: 5px; text-decoration:none;">
													Llegiu-ne més
												</a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<?php endif; ?>
			<!-- SECTION  || El recurs de la setmana -->
			<?php if (!empty($resourceNode)) : ?>
			<tr>
				<td colspan="2" style="padding:0 15px;">
					<table style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 16px; width:100%;">
						<tbody>
							<tr>
								<td>
									<h2 class="section-title" style="font-family:Fira Sans, Helvetica, Arial !important;font-weight:600;font-size:1.875em !important;color:#333333; margin-top:20px; margin-bottom:25px;">El recurs de la setmana</h2>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 0 15px 20px 15px; vertical-align: top;">
					<table style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 16px; width:100%;  background-color:#EDEDED; border-radius:15px;">
						<tbody>
							<tr>
								<td style="width: 55%;">
									<table colspan="2">
										<tr>
											<td style="padding: 20px 15px 0 20px;">
												<h3 style="font-size:1.25em; font-weight:600; margin-top: 0; margin-bottom:17px;"><?php echo $resourceTitle; ?></h3>
												<p style="font-size: .874em; line-height: 1.22em;  margin-bottom:0;"><?php echo $resourceText; ?></p>
											</td>
										</tr>
										<tr>
											<td style="padding:17px 0 20px 20px;">
												<a href="<?php echo $resourceLink; ?>" style="background-color:#BE1622; color:#ffffff; font-size:.93em; padding:14px 16px;float: left; border-radius: 5px; text-decoration:none;">
													Llegiu-ne més
												</a>
											</td>
										</tr>
									</table>
								</td>
								<td style="padding:20px 20px 20px 10px;border-radius: 10px; vertical-align:top;">
									<a href="<?php print $resourceLink; ?>">
										<img src="<?php print $resourceImage; ?>" width="600" alt="<?php print $resourceImageAlt; ?>" style="border-width:0;font-family:Fira Sans, Helvetica, Arial !important;width:100%;max-width:600px;height:auto; border-radius:15px;" />
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<?php endif; ?>
			<!-- SECTION  || Contrastos -->
			<?php if (!empty($contrast1Node)) : ?>
			<tr>
				<td colspan="2" style="padding: 0 15px;">
					<table style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 16px; width:100%;">
						<tbody>
							<tr>
								<td>
									<h2 class="section-title" style="font-family:Fira Sans, Helvetica, Arial !important;font-weight:600;font-size:1.875em !important;color:#333333; margin-top:20px; margin-bottom:25px;">Contrastos</h2>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style="width:50%; padding:0 8px 40px 15px;">
					<table style="font-size:16px; background-color:#ADF08F; border-radius:15px; min-height: 430px;">
						<tr style="height:40%;">
							<td colspan="2" style="padding:10px;">
								<a href="<?php print $contrast1Link; ?>" style="display:block;">
									<img src="<?php print $contrast1Image; ?>" width="600" alt="<?php print $contrast1ImageAlt; ?>" style="border-width:0;font-family:Fira Sans, Helvetica, Arial !important;width:100%;max-width:600px;height:auto; border-radius:15px;" />
								</a>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding: 0px 10px; vertical-align:top;">
								<a href="<?php print $contrast1Link; ?>" style="text-decoration:none; color:#333333;">			
									<h3 style="font-size:1.25em; line-height:1.25em; font-weight:600; margin-top: 0; margin-bottom:17px;color:#333333;"><?php echo $contrast1Title; ?></h3>
								</a>
							</td>
						</tr>
					</table>
				</td>
				<?php if (!empty($contrast2Node)) : ?>
				<td style="width:50%; padding:0 15px 15px 8px;">
					<table style="font-size:16px; background-color:#FF5561; border-radius:15px; min-height: 430px;">
						<tr style="height:40%;">
							<td colspan="2" style="padding:10px;">
								<a href="<?php print $contrast2Link; ?>" style="display:block;">
									<img src="<?php print $contrast2Image; ?>" width="600" alt="<?php print $contrast2ImageAlt; ?>" style="border-width:0;font-family:Fira Sans, Helvetica, Arial !important;width:100%;max-width:600px;height:auto; border-radius:15px;" />
								</a>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding-left: 10px; padding-right: 10px; vertical-align:top;">
								<a href="<?php print $contrast2Link; ?>" style="text-decoration:none; color:#333333;">			
									<h3 style="font-size:1.25em; line-height:1.25em; font-weight:600; margin-top: 0; margin-bottom:17px;color:#333333;"><?php echo $contrast2Title; ?></h3>
								</a>
							</td>
						</tr>
					</table>
				</td>
				<?php endif; ?>
				
			</tr>
			<?php endif; ?>
			<!-- END CONTENT -->
			<!-- PEU -->
			<tr style="background-color:#2f3031;">
				<td colspan="2" style="padding: 4px;">
					<table class="butlleti" style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 13px; color:white;">
						<tr class='body'>
							<td colspan="2" style="padding: 10px 0 0 10px;">
								<strong>Xarxanet.org és un projecte de</strong>
							</td>
							<td colspan="2" style="padding: 10px 0 0 10px;">
								<strong>Entitats promotores</strong>
							</td>
						</tr>
						<tr class='body'>
							<td style="vertical-align:top; padding-left:10px; padding-top:15px">
								<table class="butlleti">
									<tr class='body'>
										<td>
											<a href="http://benestar.gencat.cat" style="text-decoration:none">
												<img alt="logo generalitat" src="<?php echo $pathroot ?>/sites/default/files/butlletins/financament/logo_generalitat.png">
											</a>
										</td>
									</tr>
									<tr class='body'>
										<td style="height: 55px; vertical-align: bottom;">
											<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/es/deed.ca" rel="license">
												<img style="border:0 none;" src="http://i.creativecommons.org/l/by-nc-sa/3.0/es/80x15.png" alt="Licencia de Creative Commons">
											</a>
										</td>
									</tr>
								</table>
							</td>
							<td style="vertical-align:top; padding-top:15px">
								<!-- <a href="http://www.voluntariat.org" style="text-decoration:none">
										<img alt="logo voluntariat" src="<?php echo $pathroot ?>/sites/default/files/butlletins/financament/logo_scv.png">
									</a> -->
							</td>
							<td style="padding-left:10px;">
								<p>
									<a href="https://suport.fundesplai.org/" style="color:white;  font-weight:normal">Suport Tercer Sector – Fundesplai</a><br />
									<a href="http://www.peretarres.org" style="color:white;  font-weight:normal">Fundació Pere Tarrés</a><br />
									<a href="https://www.lavinianext.com/ca/" style="color:white;  font-weight:normal">LaviniaNext</a><br />
									<a href="http://colectic.coop/" style="color:white;  font-weight:normal">Colectic</a><br />
									<a href="https://www.xadica.cat/" style="color:white;  font-weight:normal">Xarxa Digital Catalana</a><br />
								</p>
							</td>
							<td style="padding-left:15px">
								<p>
									<a href="https://www.escoltesiguies.cat/" style="color:white;  font-weight:normal">Minyons Escoltes i Guies de Catalunya</a><br />
									<a href="https://www.tothomweb.com/" style="color:white;  font-weight:normal">TOTHOMweb</a><br />
									<a href="https://www.kiwop.com/" style="color:white;  font-weight:normal">Kiwop</a><br />
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class='body'>
				<td colspan="2" style="background-color:#231f20; color:white; text-align:right; padding:5px 10px;">
					<a style=" color:white" href="http://www.xarxanet.org/alta_actualitat">Alta</a> |
					<a style=" color:white;" href="http://www.xarxanet.org/baixa_actualitat">Baixa</a> |
					<a style=" color:white;" href="mailto:butlleti@xarxanet.org?Subject=Consulta%20butlletí">Contacte</a> |
					<a style=" color:white;" href="http://web.gencat.cat/ca/menu-ajuda/ajuda/avis_legal/">Avís legal</a>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="background-color:black; color:white; text-align:right; padding:5px 10px; font-size: 0.75em;">
					<p>
						<a style="text-decoration: underline; color:white;" href="http://web.gencat.cat/ca/menu-ajuda/ajuda/avis_legal/">Avís legal</a>: D’acord amb l’article 17.1 de la Llei 19/2014, la &copy;Generalitat de Catalunya permet la reutilització dels continguts i de les dades sempre que se'n citi la font i la data d'actualització i que no es desnaturalitzi la informació (article 8 de la Llei 37/2007) i també que no es contradigui amb una llicència específica. Si l'adreça de correu que informeu al donar-vos d'alta deixa d'estar activa us donarem de baixa a la base de dades. <br />Aquest butlletí és una iniciativa del Departament de Drets Socials de la Generalitat de Catalunya, coeditat amb la Fundació Pere Tarrés.
					</p>
				</td>
			</tr>
		</table>
	</div>
</center>
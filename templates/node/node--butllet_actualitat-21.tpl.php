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
$monographicSectTitle = $node->field_actualitat21_mono_epigraf['und'][0]['value'];
$monographicID = $node->field_actualitat21_noti_monograf['und'][0]['nid'];
$monographicNode = node_load($monographicID);
$monographicTitle = $monographicNode->title;
$monographicImage = image_style_url('large',$monographicNode->field_imatges['und'][0]['uri']);
$monographicImageAlt = $monographicNode->field_imatges['und'][0]['field_file_image_alt_text']['und'][0]['value'];
$monographicText = $monographicNode->field_resum['und'][0]['value'];
$monographicLink = url('node/' . $monographicNode->nid, array('absolute' => TRUE));


// echo '<pre>';
// echo var_dump($monographicNode);
// echo '</pre>';


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

<table class="butlleti" style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 13px; border:1px solid #53544F; border-bottom: 0px; width:100%;">
	<!-- CAPÇALERA -->
	<!--
	<tr><td colspan="2">
	<p style="padding: 2px; font-size: 11px; text-align:right"> Si no visualitzes correctament el butlletí clica aquest <a href="<?php echo $pathroot.'/node/'.$node->nid?>" style=" color: #B2290C; font-weight: bold;">enllaç</a></p>
	</td></tr>
	-->
	<tr style="background-color:#2f3031;">
		<td>
			<a href="http://www.xarxanet.org" style="text-decoration:none">
				<img src="/sites/all/themes/xn17/logo.png" alt="logotip xarxanet" style="margin-left:5px; margin-top:20px"/>
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
			echo $dies[date('N', $created)-1].', '.date('j', $created).' '.$mesos[date('n', $created)-1].' de '.date('Y', $created).' - Num. '.$title;
			?>
		</td>
		<td style="text-align: right; padding: 5px 10px; border-top:3px solid #231f20; border-bottom: 15px solid white;">
			<a href="http://www.xarxanet.org/hemeroteca_actualitat" style=" color:#878787">Butlletins anteriors</a>
		</td>
	</tr>
	<tr class='body'>
		<td style="vertical-align: top; padding-left: 0px">
		<!-- CONTENT -->
			<table class="butlleti" style='background-color: #ededed; width: 100%;'>
				<tr>
					<td>
						<table>
							<tr>
								<td>
									<a href="<?php print $monographicLink; ?>">
										<img src="<?php print $monographicImage; ?>" width="600" alt="<?php print $monographicImageAlt; ?>" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:600px;height:auto;" />
									</a>
								</td>
							</tr>
							<tr>
								<td>
									<h2><?php echo $monographicTitle; ?></h2>
									<p><?php echo $monographicText; ?></p>	
									<p><?php echo "prova"; ?></p>	
								</td>
								<td>
									<a href="<?php echo $monographicLink; ?>">
										Llegiu-ne més
									</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?php if (!empty($monographicNode)): ?>
					<tr>
						<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
							<table width="100%" bgcolor="#eeeeee" class="background-gray" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;background-color:#eeeeee;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;">
								<tr>
									<td class="one-column" summary="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;font-family:'Open sans' !important;">
										<table width="100%" style="border-spacing:0;color:#333333;font-family:'Open sans' !important;">
											<tr>
												<td class="inner contents" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;width:100%;font-family:'Open sans' !important;text-align:left;">
													<h2 class="section-title" style="font-family:'Open sans' !important;font-weight:800;font-size:22px !important;Margin:0px;color:#333333;"><?php echo $monographicSectTitle; ?></h2>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
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
																				<a href="<?php print $monographicLink; ?>">
																					<img src="<?php print $monographicImage; ?>" width="279" alt="<?php print $monographicImageAlt; ?>" style="border-width:0;font-family:'Open sans' !important;width:100%;max-width:279px;height:auto;" />
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
																				<a class="post-title text-md" href="<?php print $monographicLink ?>" style="font-family:'Open sans' !important;color:#333333;font-weight:800;text-decoration:none;font-size:16px !important;"><?php print $monographicTitle ?></a>
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
																				<a class="text-sm no-decoration text-white" href="<?php print $monographicLink ?>" style="font-family:'Open sans' !important;font-size:14px !important;color:#ffffff;text-decoration:none;font-weight:200;">Llegiu-ne més</a>
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
			</table>
		<!-- END CONTENT -->
		</td>
	</tr>
	<!-- PEU -->
	<tr style="background-color:#2f3031; border-top:3px solid #231f20;">
		<td colspan="2" style="border-top: 3px solid #53544F; padding: 4px;">
			<table class="butlleti"  style="font-family: Fira Sans,Helvetica,Arial,sans-serif; font-size: 13px; color:white;">
				<tr class='body'>
					<td colspan="2" style="padding-left:10px;">
						<strong>Xarxanet.org és un projecte de</strong>
					</td>
					<td colspan="2" style="padding-left:50px;">
						<strong>Entitats promotores</strong>
					</td>
				</tr>
				<tr class='body'>
					<td style="vertical-align:top; padding-left:10px; padding-top:15px">
						<table class="butlleti">
							<tr class='body'>
								<td>
									<a href="http://benestar.gencat.cat" style="text-decoration:none">
										<img alt="logo generalitat" src="<?php echo $pathroot?>/sites/default/files/butlletins/financament/logo_generalitat.png">
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
							<img alt="logo voluntariat" src="<?php echo $pathroot?>/sites/default/files/butlletins/financament/logo_scv.png">
						</a> -->
					</td>
					<td style="padding-left:50px;">
						<p>
							<a href="https://suport.fundesplai.org/" style="color:white;  font-weight:normal">Suport Tercer Sector – Fundesplai</a><br />
							<a href="http://www.peretarres.org" style="color:white;  font-weight:normal">Fundació Pere Tarrés</a><br />
							<a href="https://www.lavinianext.com/ca/" style="color:white;  font-weight:normal">LaviniaNext</a><br />
							<a href="http://colectic.coop/" style="color:white;  font-weight:normal">Colectic</a><br />
							<a href="http://voluntaris.cat/" style="color:white;  font-weight:normal">Federació Catalana del Voluntariat Social</a><br />
						</p>
					</td>
					<td style="padding-left:15px">
						<p>
							<a href="https://www.escoltesiguies.cat/" style="color:white;  font-weight:normal">Minyons Escoltes i Guies de Catalunya</a><br />
							<a href="http://www.tothomweb.com/" style="color:white;  font-weight:normal">TOTHOMweb</a><br />
						</p>
					</td>
				</tr>
			</table>
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
						<a style="text-decoration: underline; color:white;" href="http://web.gencat.cat/ca/menu-ajuda/ajuda/avis_legal/">Avís legal</a>: D’acord amb l’article 17.1 de la Llei 19/2014, la &copy;Generalitat de Catalunya permet la reutilització dels continguts i de les dades sempre que se'n citi la font i la data d'actualització i que no es desnaturalitzi la informació (article 8 de la Llei 37/2007) i també que no es contradigui amb una llicència específica. Si l'adreça de correu que informeu al donar-vos d'alta deixa d'estar activa us donarem de baixa a la base de dades. <br/>Aquest butlletí és una iniciativa del Departament de Drets Socials de la Generalitat de Catalunya, coeditat amb la Fundació Pere Tarrés.
					</p>
	 			</td>
			</tr>
		</table>

<?php echo '<pre>';
echo var_dump($node);
echo '</pre>';
?>
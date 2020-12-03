<?php
/**
 * @file
 * Theme functions
 */

/**
 * Implements hook_form_alter()
 */

function xn17_form_alter(&$form, &$form_state, $form_id) {
  
  // Adding an extra field to avoid spam in the comments forms

  if ($form_id == 'comment_node_opinio_form' || $form_id == 'comment_node_noticia_general_form') {

    $description  = t('Escriu l\'any actual, amb quatre xifres.') . '<br>';
    $description .= t('Aquesta pregunta es per veure si realment ets una persona i no un generador de spam.');
    
    $form['anti_spam'] = array(
      '#type' => 'textfield',
      '#title' => t('Control anti-spam'),
      '#description' => $description,
      '#size' => '15',
      '#maxlength' => '15',
      '#weight' => '1',
      '#required' => TRUE,
    );

    $form['#validate'][] = 'xn17_custom_comments_form_validate';
  }

  // Overrides on Views' Exposed forms

  if ($form_id == 'views_exposed_form') {
    $view = $form_state['view'];

    // 'Financament' Exposed Form
    
    if ($view->name == 'xn17_financament' && $view->current_display == 'page') {
      $form['combine']['#title'] = '<span class="sr-only">' . t('Cercar per') . '</span>';
    }

    // 'Biblioteca' Exposed Form

    if ($view->name == 'xn17_biblioteca' && $view->current_display == 'page') {
      $form['combine']['#title'] = '<span class="sr-only">' . t('Cercar per') . '</span>';
    }
  }

  // Adding autocomplete attributes to Contact Form

  if ($form_id == 'webform_client_form_216') {
    $form['#attributes']['autocomplete'] = 'on';
    $form['submitted']['nom']['#attributes']['autocomplete'] = 'given-name';
    $form['submitted']['cognoms']['#attributes']['autocomplete'] = 'family-name';
    $form['submitted']['correu']['#attributes']['autocomplete'] = 'email';
    $form['submitted']['telefon']['#attributes']['autocomplete'] = 'tel';
    $form['submitted']['entitat']['#attributes']['autocomplete'] = 'organization';
  }

  // Adding autocomplete attributes to Login Form

  if ($form_id == 'user_login') {
    $form['#attributes']['autocomplete'] = 'on';
    $form['name']['#attributes']['autocomplete'] = 'email';
    $form['pass']['#attributes']['autocomplete'] = 'current-password';
  }
}

/**
 * Implements a custom validation rules for the comment's forms
 */

function xn17_custom_comments_form_validate(&$form, &$form_state) {

  // Validate the anti-spam question

  $current_year = date('Y');
  $anti_spam = $form_state['values']['anti_spam'];

  if ($current_year !== $anti_spam) {
    form_set_error('anti_spam', t('La resposta a la pregunta formulada al control anti-spam no és correcta.'));
  }

  // Validating some forbidden words in the comment's body

  $comment_body = $form_state['values']['comment_body']['und'][0]['value'];
  $forbidden_words = array('Meronem', 'LesIdobre', 'Levitra', 'Matbova', 'Cialis', 'KelTraice', 'EllKinend', 'Viagra', 'Lesjecins', 'KelTraice', 'Wellbutrin', 'MatToog', 'Propecia', 'Acticin', 'Amoxicillin', 'Kamagra');

  $i = 0;
  foreach ($forbidden_words as $forbidden_word) {
    if (stripos($comment_body, $forbidden_word) !== FALSE) {
      $i++;
    }
  }
  
  if ($i > 0) {
    form_set_error('comment_body', t('El cos del comentari conté paraules que no estan permeses pel nostre filtre anti-spam.'));
  }
}

/**
 * Implements form_comment_form_alter()
 */

function xn17_form_comment_form_alter(&$form, &$form_state, &$form_id) {

  // Adding autocomplete attributes to Comments Form

  $form['#attributes']['autocomplete'] = 'on';
  $form['author']['name']['#attributes']['autocomplete'] = 'name';
  $form['author']['mail']['#attributes']['autocomplete'] = 'email';
  
  // Additional overrides

  $form['comment_body']['#after_build'][] = 'xn17_customize_comment_form';  
}

/**
 * Implements a custom function to remove the guidelines and the help block
 * from the comment's form
 */

function xn17_customize_comment_form(&$form) {
  
  // Hide guideliness

  $form['und'][0]['format']['guidelines']['#access'] = FALSE;
  
  // Hide Filter Tips

  $form['und'][0]['format']['help']['#access'] = FALSE;

  return $form;  
}

/**
 * Include all files from the includes directory
 */

$includes_path = dirname(__FILE__) . '/includes/*.inc';
foreach (glob($includes_path) as $filename) {
  require_once dirname(__FILE__) . '/includes/' . basename($filename);
}

/**
 * Implements template_preprocess_node()
 */

function xn17_preprocess_node(&$variables) {

  /**
   * A custom snippet to decide when to use the old or the new template 
   * of the "A l'Abast newsletter", from a given release date
   */

  $release_on = '03-05-2020';

  if (isset($variables['node']) && $variables['node']->type == 'butlleti_abast_nou') {
    $node = $variables['node'];
    $created_date = $node->created;

    if (isset($_GET['date'])) {
      $release_date = strtotime(date($_GET['date'])); // A date in dd-mm-yyyy format, for test purposes only
    }
    else {
      $release_date = strtotime(date($release_on)); // Default release date
    }
    
    if ($created_date >= $release_date) {
      // Use the NEW version template
      array_unshift($variables['theme_hook_suggestions'], 'node__butlleti_abast_new');
    }
    else {
      // Use the OLD version template
      array_unshift($variables['theme_hook_suggestions'], 'node__butlleti_abast_old');
    }
  }
}

/**
 * Implements template_preprocess_page()
 */

function xn17_preprocess_page(&$variables) {
  // Add copyright to theme.
  
  if ($copyright = theme_get_setting('copyright')) {
    $variables['copyright'] = check_markup($copyright['value'], $copyright['format']);
  }

  //Main menu
  
  $variables['main_menu_rendered'] = render(_xn17_main_menu_tree(variable_get('menu_main_links_source', 'main-menu')));

  // Add secondary menu
  
  $variables['secondary_menu'] = _radix_dropdown_menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
  theme_get_setting('toggle_secondary_menu') ? menu_secondary_menu() : array();
}

/**
 * Implements theme_preprocess_html()
 */

function xn17_preprocess_html(&$variables) {
  // Pass global $base_url variables to the template
  
  global $base_url;
  $variables['base_url'] = $base_url;

  // Custom overrides in Panels
  
  if ($node = menu_get_object()) {
    
    // Add special-panel class
    
    if ($node->type == "panel") {
      $special = field_get_items('node', $node, 'field_secci_especial');
      
      if ($special[0]['value'] == "si") {
        $variables['classes_array'][] = 'seccio-especial';
      }
    }
  }

  // The following adds a custom class to the body, for the event "Dia Mundial de la Dona 2019"
  
  $begin_date = strtotime(date('07-03-2019 22:00:00'));
  $end_date = strtotime(date('08-03-2019 23:59:59'));
  $now = strtotime(date('d-m-Y H:i:s'));
  
  if ($now >= $begin_date && $now <= $end_date ) {
    $variables['classes_array'][] = 'woman-day';
  }
  else if (isset($_GET['skin']) && $_GET['skin'] == 'woman-day') {
    $variables['classes_array'][] = 'woman-day';
  }
}

/**
 * Implements theme_menu_link()
 */

function xn17_menu_link__main($variables) {
  $element = $variables['element'];
  $sub_menu = '';

  // Add a unique class using the title.
  
  $title = strip_tags($element['#title']);
  $element['#attributes']['class'][] = 'menu-link-' . drupal_html_class($title);
  $element['#attributes']['class'][] = 'menu-item';

  // Depth
  
  $depth = $element['#original_link']['depth'];
  $element['#attributes']['class'][] = 'depth-' . $depth;
  $element['#localized_options']['attributes']['class'][] = 'depth-' . $depth;
  $element['#localized_options']['attributes']['class'][] = 'closed';

  // Columns
  
  if($depth == 1) $element['#attributes']['class'] = array_merge($element['#attributes']['class'],
    array('col-lg-6', 'col-md-6', 'col-sm-6', 'col-xs-12'));

  if (!empty($element['#below'])) {
    
    // Wrap in dropdown-menu.
    
    unset($element['#below']['#theme_wrappers']);

    $sub_menu_depth = $depth+1;
    $sub_menu = '<div class="submenu depth-' . $sub_menu_depth . '">' . drupal_render($element['#below']) . '</div>';
  }

  $output = '<div class="menu-link depth-' . $depth .'">' . l($element['#title'], $element['#href'], $element['#localized_options']) . '</div>';
  
  return '<div' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</div>\n";
}

/**
 * Overrides default's theme_file_icon() field rendering function.
 * Basically, this function adds a custom alt text for uploaded PDF files,
 * and, in the other hand, a default one for the other mime types.
 *
 * @see  modules/file/file.module
 */
function xn17_file_icon($variables) {
  if ($variables['file']->filemime === 'application/pdf') {
    $variables['alt'] = 'Icona d\'un arxiu PDF';
  }
  else {
    $variables['alt'] = 'Icona d\'arxiu';
  }
  $file = $variables['file'];
  $alt = $variables['alt'];
  $icon_directory = $variables['icon_directory'];

  $mime = check_plain($file->filemime);
  $icon_url = file_icon_url($file, $icon_directory);
  return '<img class="file-icon" alt="' . check_plain($alt) . '" title="' . $mime . '" src="' . $icon_url . '" />';
}

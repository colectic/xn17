<?php
/**
 * @file
 * Theme functions
 */

// Include all files from the includes directory.
$includes_path = dirname(__FILE__) . '/includes/*.inc';
foreach (glob($includes_path) as $filename) {
  require_once dirname(__FILE__) . '/includes/' . basename($filename);
}

/**
 * Implements template_preprocess_page().
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
 * Implements theme_preprocess_html(&$variables).
 */
function xn17_preprocess_html(&$variables) {
  if ($node = menu_get_object()) {
    // Add special-panel class
    if ($node->type == "panel") {
      $special = field_get_items('node', $node, 'field_secci_especial');
      if ($special[0]['value'] == "si") {
        $variables['classes_array'][] = 'seccio-especial';
      }
    }
  }

  // Afegint una custom class al <body> pel Dia Mundial de la Dona 2019
  
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
 * Implements theme_menu_link().
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

  //Columns
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

<?php
/**
 * @file
 * Helper functions for the Radix theme.
 */

/**
 * Returns a menu built for rendering as a dropdown menu.
 */
function _xn17_main_menu_tree($menu_name, $options = array()) {
  $menu_tree = menu_build_tree($menu_name, $options);
  $element = menu_tree_output($menu_tree);
  $element['#theme_wrappers'] = array();
  foreach (element_children($element) as $mlid) {
    _xn17_main_menu_link_process($element[$mlid]);
  }
  return $element;
}

/**
 * Suggest the the menu link to render with a dropdown.
 */
function _xn17_main_menu_link_process(&$element) {
  //$element['theme_hook_suggestion'] = 'menu_link__dropdown';
  $element['#theme'] = 'menu_link__main';
  if (!empty($element['#below'])) {
    foreach (element_children($element['#below']) as $mlid) {
      _xn17_main_menu_link_process($element['#below'][$mlid]);
    }
  }
}

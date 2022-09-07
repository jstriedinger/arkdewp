<?php
/**
 * Bulma-Navwalker
 *
 * @package Bulma-Navwalker
 */

/**
 * Class Name: Navwalker
 * Plugin Name: Bulma Navwalker
 * Plugin URI:  https://github.com/Poruno/Bulma-Navwalker
 * Description: An extended Wordpress Navwalker object that displays Bulma framework's Navbar https://bulma.io/ in Wordpress.
 * Author: Carlo Operio - https://www.linkedin.com/in/carlooperio/, Bulma-Framework
 * Author URI: https://github.com/wp-bootstrap
 * License: GPL-3.0+
 * License URI: https://github.com/Poruno/Bulma-Navwalker/blob/master/LICENSE
 */

class Bulmawalker extends Walker_Nav_Menu {


	public function start_lvl( &$output, $depth = 0, $args = array() ) {
			
			$output .= "<div class='navbar-dropdown'>";
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {


			$liClasses = 'navbar-item ';

			$hasChildren = $args->walker->has_children;
			$liClasses .= $hasChildren? " has-dropdown": "";

			if($hasChildren){
					if($dropdownID == 0)
						$dropdownID = rand();
					$output .= "<div class='".$liClasses."'>";
					$output .= "\n<button class='navbar-link' aria-expanded=false >".$item->title."</button>";
			}
			else {
					$output .= "<a class='".$liClasses."' href='".$item->url."'>".$item->title;
			}

			// Adds has_children class to the item so end_el can determine if the current element has children
			if ( $hasChildren ) {
					$item->classes[] = 'has_children';
			}
	}
	
	public function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ){

			if(in_array("has_children", $item->classes)) {

					$output .= "</div>";
			}
			$output .= "</a>";
	}

	public function end_lvl (&$output, $depth = 0, $args = array()) {

			$output .= "</div>";
	}
}

/**
 * Add filter to add classes to li in nav menu
 *
 * @param [type] $classes
 * @param [type] $item
 * @param [type] $args
 * @return void
 */
function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);
?>
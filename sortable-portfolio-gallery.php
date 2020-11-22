<?php

/**
 * Plugin Name:       Sortable Portfolio Gallery
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Prappo Prince
 * Author URI:        https://prappo.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sortable-portfolio-gallery
 */

require_once 'inc/cpt.php';
require_once 'inc/cleanup.php';
require_once 'inc/shortcode.php';
require_once 'template/init.php';



(new SPG_CPT())->init();
(new SPG_Sortcode())->init();

add_action('wp_enqueue_scripts','spg_scripts');

function spg_scripts(){
	wp_enqueue_style('spg-style',plugin_dir_url(__FILE__) . '/assets/css/style.css');
	wp_enqueue_script('spg-script',plugin_dir_url(__FILE__) . '/assets/js/script.js',[],null,true);
	wp_enqueue_script('image-shadow',plugin_dir_url(__FILE__) . '/assets/js/shadow/image-shadow.js',[],null,true);
	if(is_singular(['spg_portfolio'])){
//		wp_enqueue_style('spg-bulma',plugin_dir_url(__FILE__) . '/assets/css/bulma.min.css');

	}
}


function get_custom_post_type_template( $single_template ) {
	global $post;

	if ( 'spg_portfolio' === $post->post_type ) {
//		$single_template = dirname( __FILE__ ) . '/single-spg_portfolio.php';
		$single_template = dirname( __FILE__ ) . '/template/portfolio/template1.php';
	}

	return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template' );



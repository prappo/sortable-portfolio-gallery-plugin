<?php

add_filter( 'single_template', 'load_my_custom_template', 50, 1 );
function load_my_custom_template( $template ) {

	if ( is_singular( 'spg_template' ) ) {
		$template = plugins_url( 'portfolio/template1.php', __FILE__ );
	}

	return $template;
}
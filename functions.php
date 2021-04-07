<?php 
//attach all needed stylesheets
function mmc_styles(){
	//					nickname 		src of file
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'mmc_styles' );
//no close PHP
<?php
/**
 * Activate sleeping features 
 */
add_theme_support('post-thumbnails');

add_theme_support('custom-background');

//custom header arguments
$args = array(
 	'width'     => 2500,
    'height'    => 600,
);
add_theme_support('custom-header', $args);

//custom logo
$args = array(
    'height'      => 150,
    'width'       => 150,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description' ),
);
add_theme_support('custom-logo', $args);

add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

//make seo-friendly <title>s for every screen
add_theme_support( 'title-tag' );

//add more sizes than just thumbnail, medium, large
add_image_size('wide-featured', 800, 200, true);
add_image_size('tiny', 60, 60, true);


/**
 * Load all styles and scripts
 */
function mmc_styles(){
	//					nickname 		src of file
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'mmc_styles' );

/**
 * Filter Hook example - change the excerpt length
 */
function mmc_ex_length(){
	return 10; //words
}
add_filter( 'excerpt_length', 'mmc_ex_length' );

/**
 * Change [...] to read more button
 */
add_filter('excerpt_more', 'mmc_readmore');
function mmc_readmore($more){
	return '&hellip; <a href="' . get_permalink() . '" class="button readmore">Read More</a>';
}



/* example of using simply show hooks */
//add_action( 'loop_start', 'mmc_breadcrumb', 1 );
function mmc_breadcrumb(){
	if( ! is_front_page() ){
		echo '<b>these are not actually breadcrumbs</b>';
	}
}

/**
 * Example of filtering stuff in the admin panel
 */
add_filter('admin_footer_text', 'mmc_admin_footer');
function mmc_admin_footer(){
	return 'New footer text';
}










//no close PHP
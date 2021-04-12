<?php
/**
 * Activate sleeping features 
 */
add_theme_support( 'jetpack-social-menu' );

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
function mmc_scripts(){
	//					nickname 		src of file
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );

	//improve comment replies (thiss script is built-in)
	if( is_singular() AND comments_open() AND get_option('thread_comments') ){
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mmc_scripts' );

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

/**
 * Activate any menu areas we need
 */
add_action('init', 'mmc_menu_areas');
function mmc_menu_areas(){
	register_nav_menus( array(
		'main_menu' => 'Main Navigation',
		'social_menu' => 'Social Menu',
		'footer_menu' => 'Footer Menu',
	) );
}

/**
 * Display pagination on any template
 * detects mobile devices and shows simplified next/previous pagination
 */
function mmc_pagination(){
	echo '<div class="pagination">';
	if( is_singular() ){
		//singular next/prev post
		previous_post_link('%link', '&larr; Previously: %title');
		next_post_link('%link', 'Next: %title &rarr;');

	}elseif( wp_is_mobile() ){
		//archive next/prev
		previous_posts_link();
		next_posts_link();

	}else{
		//numbered pagination for desktop
		the_posts_pagination();
	}
	echo '</div>';
}


/**
 * Register any needed widget areas (dynamic sidebars)
 */
add_action( 'widgets_init', 'mmc_widget_areas' );
function mmc_widget_areas(){
	register_sidebar( array(
		'name' 			=> 'Blog Sidebar',
		'id' 			=> 'blog-sidebar',
		'description' 	=> 'Appears on screens that show blog posts',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget' 	=> '</section>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	) );
	register_sidebar( array(
		'name' 			=> 'Page Sidebar',
		'id' 			=> 'page-sidebar',
		'description' 	=> 'Appears on 2-column pages',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget' 	=> '</section>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	) );
	register_sidebar( array(
		'name' 			=> 'Footer Area',
		'id' 			=> 'footer-area',
		'description' 	=> 'Appears at the bottom of every screen',
		'before_widget' => '<section class="widget %2$s" id="%1$s">',
		'after_widget' 	=> '</section>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title'	=> '</h3>',
	) );
}//end widget areas function

/**
 * Fix the default comment count so it excludes pingbacks and trackbacks
 */
add_filter( 'get_comments_number', 'mmc_comment_count' );
function mmc_comment_count(){
	//post_id
	global $id;
	$comments = get_approved_comments( $id );
	$count = 0;
	foreach( $comments as $comment ){
		//if it's a real comment, count it
		if( $comment->comment_type == 'comment' ){
			$count ++;
		}
	}
	return $count;
}

/**
 * Count the number of pingbacks and trackbacks on any post
 */
function mmc_pings_count(){
	global $id;
	$comments = get_approved_comments( $id );
	$count = 0;
	foreach( $comments as $comment ){
		//if it's not a real comment, count it
		if( $comment->comment_type != 'comment' ){
			$count ++;
		}
	}
	return $count;
}

/**
 * Remove the "website" field from the comment form
 * @source https://www.wpbeginner.com/plugins/how-to-remove-website-url-field-from-wordpress-comment-form/
 */
add_filter('comment_form_default_fields', 'mmc_unset_url_field');
function mmc_unset_url_field($fields){
    if(isset($fields['url']))
       unset($fields['url']);
       return $fields;
}



//no close PHP
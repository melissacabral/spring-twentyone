<?php
if ( ! isset( $content_width ) ) $content_width = 700;
/**
 * Activate sleeping features 
 */
add_theme_support( 'jetpack-social-menu' );

add_theme_support('post-thumbnails');

add_theme_support('custom-background');

add_theme_support( 'automatic-feed-links' );

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
		'name' 			=> 'Shop Sidebar',
		'id' 			=> 'shop-sidebar',
		'description' 	=> 'Appears on shop and single product pages',
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

/**
 * WooCommerce theme support
 */
add_action('after_setup_theme', 'mmc_woo_support');
function mmc_woo_support(){
	add_theme_support('woocommerce');
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

//Fix the content wrappers (<main class="content">)
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'mmc_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'mmc_wrapper_end', 10);

function mmc_wrapper_start() {
  echo '<main class="content">';
}

function mmc_wrapper_end() {
  echo '</main>';
}


/**
 * Add Ajax to the cart total in our header.php
 * Show cart contents / total Ajax
 * @source  https://docs.woocommerce.com/document/show-cart-contents-total/ 
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'spring-twentyone'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'spring-twentyone'), $woocommerce->cart->cart_contents_count);?> – <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}

//remove all woocommerce
//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
//
/**
 * Set WooCommerce image dimensions upon theme activation
 */
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'mmc_dequeue_styles' );
function mmc_dequeue_styles( $enqueue_styles ) {
	//unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	//unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	//unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}

/**
 * Example of controlling Woo output with hooks
 */
add_action('after_setup_theme', 'mmc_remove_hooks');
function mmc_remove_hooks(){
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
}

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 1);
//no close PHP

/**
 * Customization API Examples
 */
add_action('customize_register', 'mmc_customize');
function mmc_customize( $wp_customize ){
	//header background color - use the existing 'colors' section
	$wp_customize->add_setting( 'mmc_header_bg_color', array(
		'default' => '#DDDDDD',
		'sanitize_callback' => 'wp_strip_all_tags',
	) );
	//user interface for header color
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mmc_header_bg_color_ui', array(
		'label' => 'Header Background Color',
		'section' => 'colors', //built-in
		'settings' => 'mmc_header_bg_color', //the setting from above
	) ) );

	//Typography section - google font choices
	$wp_customize->add_section( 'mmc_typography', array(
		'title' 		=> 'Typography',
		'capability'	=> 'edit_theme_options',
		'priority'		=> 50,
	) );

	//heading font option
	$wp_customize->add_setting( 'mmc_heading_font', array(
		'default' => 'Roboto Slab',
		'sanitize_callback' => 'wp_strip_all_tags',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mmc_heading_font_ui', array(
		'label'		=> 'Heading Font',
		'section'	=> 'mmc_typography',
		'settings'	=> 'mmc_heading_font',
		'type' 		=> 'radio',
		'choices'	=> array(
							// data 		=> admin panel label
							'Roboto Slab' 	=> 'Roboto Slab - Default Medium Serif',
							'Orelega One'	=> 'Orelega One - Chunky Serifs',
							'Zen Dots'		=> 'Zen Dots - Extended futuristic sans-serif',
							'Langar'		=> 'Langar - Handwriting-ish',
						),
	) ) );

	//Color Schemes example
	$wp_customize->add_setting( 'mmc_color_scheme', array(
		'default' => 'light',
		'sanitize_callback' => 'wp_strip_all_tags',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'mmc_color_scheme_ui', array(
		'label' 	=> 'Color Scheme',
		'section' 	=> 'colors',
		'settings'	=> 'mmc_color_scheme',
		'type' 		=> 'radio',
		'priority' 	=>	5,
		'choices'	=> array(
			'light' 	=> 'Light Color Scheme',
			'dark' 		=> 'Dark Color Scheme',
		),
	) ) );
}

/**
 * Customizer CSS
 */
add_action('wp_head', 'mmc_customize_css');
function mmc_customize_css(){
	?>
	<style>
		.header{
			background-color:<?php echo esc_html(get_theme_mod('mmc_header_bg_color')); ?>;
		}

		h1{
			font-family: <?php echo esc_html(get_theme_mod('mmc_heading_font')); ?>, Arial, sans-serif;
		}
	</style>
	<?php
}

/**
 * Enqueue the chosen google font stylesheet
 */
add_action('wp_enqueue_scripts', 'mmc_custom_stylesheets');
function mmc_custom_stylesheets(){
	//Google Font Stuff
	$font = urlencode( get_theme_mod('mmc_heading_font') );
	$font_url = "https://fonts.googleapis.com/css2?family=$font&display=swap";

	wp_enqueue_style('custom_header_font', $font_url);

	//Color Scheme Stuff
	$filename = get_theme_mod('mmc_color_scheme');
	$colors_url = get_template_directory_uri() . "/color-schemes/$filename.css";

	wp_enqueue_style( 'custom_color_scheme', $colors_url );
}
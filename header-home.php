<!DOCTYPE html>
<html lang="en-us">
<head>
  <?php wp_head(); //HOOK. required for the admin bar and plugins to work ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		.header{
			background-image:url(<?php header_image(); ?>);
			background-size: cover;
			background-position: center center;
		}
		.header, .header a{
			color:#<?php header_textcolor(); ?>;
		}
		/* hide header text based on the setting in customize > site identity */
		<?php if( ! display_header_text() ){ ?>

			.branding h1, .branding h2{
				border: 0;
			    clip: rect(1px, 1px, 1px, 1px);
			    clip-path: inset(50%);
			    height: 1px;
			    margin: -1px;
			    overflow: hidden;
			    padding: 0;
			    position: absolute !important;
			    width: 1px;
			    word-wrap: normal !important;
			}

		<?php } ?>
	</style>
</head>
<body <?php body_class(); ?>>
	<div class="site">
		<header class="header hero">
			<div class="branding">
				<?php 
				//custom logo activated in functions.php
				the_custom_logo(); ?>


				<h1 class="site-title">
					<a href="<?php echo home_url(); ?>">
						<?php bloginfo( 'name' ); ?>
					</a>
				</h1>
				<h2><?php bloginfo( 'description' ); ?></h2>
			</div>
			<div class="navigation">
				<?php 
				//display a menu area we registered in functions.php
				wp_nav_menu( array(
					'theme_location' 	=> 'main_menu',
					'container' 		=> 'nav',
					'container_class' 	=> 'menu',
					'menu_class' 		=> '',
					'menu_id' 			=> 'main-navigation-menu',
				) ); ?>
			</div>
			<div class="utilities">
				<?php if ( function_exists( 'jetpack_social_menu' ) ) jetpack_social_menu(); ?>
			</div>
			
			
		</header>
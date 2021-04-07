<!DOCTYPE html>
<html lang="en-us">
<head>
  <?php wp_head(); //HOOK. required for the admin bar and plugins to work ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php bloginfo('name'); ?> - <?php bloginfo( 'description' ); ?></title>	
</head>
<body <?php body_class(); ?>>
	<div class="site">
		<header class="header">
			<div class="branding">
				<h1 class="site-title">
					<a href="<?php echo home_url(); ?>">
						<?php bloginfo( 'name' ); ?>
					</a>
				</h1>
				<h2><?php bloginfo( 'description' ); ?></h2>
			</div>
			<div class="navigation">
				<nav class="main-menu">
					<ul>
						<?php 
						wp_list_pages( array(
							'title_li' => '',
						) ); 
						?>
					</ul>
				</nav>
			</div>
			<div class="utilities">
				<!-- Utility menu will go here -->
			</div>
			<?php get_search_form(); ?>

			
		</header>
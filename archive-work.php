<?php get_header(); //requires header.php ?>
		<main class="content">

			<h1 class="page-heading">
				<?php 
				//learn more about i18n: 
				//https://codex.wordpress.org/I18n_for_WordPress_Developers
				_e('My Work', 'spring-twentyone'); ?>
			</h1>

			<ul class="portfolio-subnav">
				<?php //show all terms in our custom taxonomy
				wp_list_categories( array(
					'title_li' 	=> '',
					'taxonomy' 	=> 'work_category',
					'orderby'  	=> 'count',
					'order'		=> 'DESC',
				) );
				 ?>
			</ul>

			<?php //The Loop
			if( have_posts() ){	
				while( have_posts() ){	
					the_post();
			?>

			<article <?php post_class('clearfix'); ?> >
				<div class="overlay">
					<?php the_post_thumbnail('wide-featured'); ?>

					<div class="info">
						<a href="<?php the_permalink(); ?>">
							<h2 class="entry-title">
								<?php the_title(); ?>
							</h2>
							<h3><?php the_field('role'); ?></h3>							
						</a>
						<?php the_terms( $id, 'work_category', '<h4>', ', ', '</h4>' ); ?>
					</div>
				</div>
				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div>
				
			</article>
			<!-- end .post -->
		

			<?php 
				} //end while

				mmc_pagination();

			}else{ ?>

				<h2>No Posts to show</h2>

			<?php } //end of The Loop ?>
			
		</main>
		<!-- end .content -->
	
<?php get_footer();  //require footer.php ?>
<?php get_header(); //requires header.php ?>
		<main class="content">

			<?php //The Loop
			if( have_posts() ){	
				while( have_posts() ){	
					the_post();
			?>

			<article <?php post_class('clearfix'); ?> >
				<div class="overlay">
					<?php the_post_thumbnail('wide-featured'); ?>

					<div class="info">
						<h2 class="entry-title">
							<?php the_title(); ?>
						</h2>
						<h3><?php the_field('role'); ?> - <?php the_field('year'); ?></h3>

						<?php the_terms( $id, 'work_category', '<h4>', ', ', '</h4>' ); ?>
					</div>
				</div>
				<div class="entry-content">
					<?php 
					//conditional tag example
					if( is_singular() ){
						the_content();
						//for 'paged' posts
						wp_link_pages( array(
							'before' => '<div class="paged-post-nav">Keep reading this post:<br>',
							'after' => '</div>',
							'next_or_number' => 'next,'
						) );
					}else{
						//not a single post or page (archive)
						the_excerpt();
					} ?>
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
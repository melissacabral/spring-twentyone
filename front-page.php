<?php get_header( 'home' ); //requires header-home.php ?>
		<main class="content">
			<?php //The Loop
			if( have_posts() ){	
				while( have_posts() ){	
					the_post();
			?>

			<article <?php post_class('clearfix'); ?>>
				<h2 class="entry-title">					
					<?php the_title(); ?>					
				</h2>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<!-- end .post -->


			<?php 
				} //end while
			}else{ ?>

				<h2>Welcome</h2>

			<?php } //end of The Main Loop ?>


			<?php //Show one featured portfolio piece ("work") 
			$featured_work = new WP_Query( array(
				'post_type' => 'work',
				'posts_per_page' => 1,  //limit
				//only in the identity category
				'tax_query' => array(
									'relation' => 'OR',
									array(
										'taxonomy' 	=> 'work_category',
										'field' 	=> 'slug',
										'terms' 	=> 'identity'
									),
									array(
										'taxonomy' 	=> 'work_category',
										'field' 	=> 'slug',
										'terms' 	=> 'product-design'
									),
								),
			) );

			//custom loop
			if( $featured_work->have_posts() ){
			?>
			
			<section class="featured-work">
				<h2>Featured Work</h2>

				<?php 
				while( $featured_work->have_posts() ){ 
					$featured_work->the_post(); 
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
				<?php } //end while ?>

			</section> <!-- end featured work -->

			<?php } //end if (custom loop)

			//clean up after custom query
			wp_reset_postdata(); ?>	
			
		</main>
		<!-- end .content -->
			
<?php get_footer();  //require footer.php ?>
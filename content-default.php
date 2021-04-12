<article <?php post_class('clearfix'); ?> >
				<?php the_post_thumbnail('wide-featured'); ?>

				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</h2>
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
				<div class="postmeta">
					<span class="author">by: <?php the_author_posts_link(); ?> </span>
					<span class="date"> <?php the_time('F j, Y'); ?> </span>
					<span class="num-comments"><?php comments_number(); ?></span>
					<span class="categories"><?php the_category(); ?></span>
					<?php the_tags('<span class="tags">', ', ', '</span>'); ?>
				</div>
				<!-- end .postmeta -->
			</article>
			<!-- end .post -->
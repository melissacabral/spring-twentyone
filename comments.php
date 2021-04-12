<?php 
//exit this file if the post is password protected
if( post_password_required() ){
	return;
} 
?>
<section class="comments">
	<h3><?php comments_number(); ?> on this post</h3>

	<ol class="comment-list">
		<?php wp_list_comments( array(
			'type' 		=> 'comment', //hide trackbacks and pingbacks
		) ); ?>
	</ol>
</section>

<?php if( get_option( 'page_comments' ) ){ ?>
<section class="pagination">
	<?php previous_comments_link(); ?>
	<?php next_comments_link(); ?>
</section>
<?php } ?>

<section class="comment-form">
	<?php comment_form(); ?>
</section>

<?php 
$pings_count = mmc_pings_count();
//if there are pings or trackbacks, show them
if( $pings_count ){ ?>
<section class="mentions">
	<h3>
		<?php echo $pings_count == 1 ? '1 Site mentions this post' : "$pings_count Sites mention this post"; ?>
	</h3>

	<ol class="trackback-list">
		<?php wp_list_comments( array(
			'type' 			=> 'pings', // or ping, or trackback
			'short_ping' 	=> true,
		) ); ?>
	</ol>
</section>
<?php } ?>
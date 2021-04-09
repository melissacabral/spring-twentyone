		<footer class="footer">
			<?php wp_nav_menu( array(
				'theme_location' 	=> 'footer_menu',
				'fallback_cb' 		=> false,
			) ); ?>
			<div class="widget">Footer content goes here</div>
		</footer>
	</div>

<?php wp_footer(); //HOOK. required for admin bar and plugins to work. ?>
</body>
</html>
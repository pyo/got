<?php if ( $wp_query->max_num_pages > 1 ) : ?>
		<div class="group" id="paging">
			<p class="alignleft" id="next-post-link"><?php next_posts_link( __( 'Older posts' ) ); ?></p>
			<p class="alignright" id="previous-post-link"><?php previous_posts_link( __( 'Newer posts' ) ); ?></p>
		</div>		
<?php endif; ?>
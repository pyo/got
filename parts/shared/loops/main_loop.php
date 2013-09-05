<?php if ( have_posts() ): ?>
	<ol class="no-list">
		<?php $i = 1; ?>
		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php 
			
			$link = get_permalink();
			$featured_image = get_first_image();
			$format = wp_get_post_terms($post->ID, 'got_format');
			
			if ($format) $format = $format[0]->slug;

			
			?>
			<li>
				<article data-post-id="<?php echo $post->ID; ?>" data-permalink="<?php echo $link; ?>" class="post-box">
					<div class="top">
						<div class="imgwrap">
							<?php // echo return_make_pinned_tag(); ?>
							<a class="thumb-wrapper" href="<?php echo esc_url( $link ); ?>"><?php if($format == 'video-format') echo '<img class="thumbnail-play-button" src="' . get_template_directory_uri() . '/img/icons/thumbnail_play_button.png">'; ?><img data-original="<?php echo tim_thumb_image(remove_http($featured_image), 202, 140, 75); ?>" class="lazy" height="140" width="202" src="<?php echo get_template_directory_uri(). '/img/grey.gif'; ?>"></a>
						</div>
						<div class="details">
							<?php echo get_time_since_posted(get_the_time('U', $post->ID)); ?><?php if(current_user_can('edit_post')): ?><?php edit_post_link( 'Edit', ' (', ') '); ?> <?php if (function_exists('wpp_get_views')) echo '| Views: ' . number_format( wpp_get_views( get_the_ID() ) ); ?><?php endif; ?>

							<a href="<?php echo esc_url( $link ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
							<?php //the_excerpt(); ?>
						</div>
					</div>
					<div class="social">
						<?php social_count(); ?>
					</div>
				</article>
			</li>
			<?php if ($i == 10) {
				get_template_part('/parts/shared/ads/archive_10_post_ad');
			} ?>
			<?php $i++; ?>
		<?php endwhile; ?>
	</ol>
	<?php get_template_part('/parts/shared/paging'); ?>
	<?php else: ?>
	<h3>No posts to display</h3>
<?php endif; ?>
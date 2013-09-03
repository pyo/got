<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<?php make_hero_section(); ?>
<div class="row" id="bg_wrapper">
	<div class="sixteen columns" id="primary">
		<div class="banner-wrapper">
			<h3 class="header-banner no-margin-top"><span class="latest_icon"></span> Search Results for '<?php echo get_search_query(); ?>'</h3>
		</div>
		<div class="row">
			<div class="six columns">
				<?php get_template_part('/parts/shared/ads/skyscraper_ad'); ?>
			</div>
			<div class="eighteen columns pad-top pad-left">
			<?php if ( have_posts() ): ?>
				<ol class="no-list">
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
										<?php echo return_make_pinned_tag(); ?>
										<a class="thumb-wrapper" href="<?php echo esc_url( $link ); ?>"><?php if($format == 'video-format') echo '<img class="thumbnail-play-button" src="' . get_template_directory_uri() . '/img/icons/thumbnail_play_button.png">'; ?><img data-original="<?php echo tim_thumb_image(remove_http($featured_image), 202, 140, 75); ?>" class="lazy" height="140" width="202" src="<?php echo get_template_directory_uri(). '/img/grey.gif'; ?>"></a>
									</div>
									<div class="details">
										<?php echo get_time_since_posted(get_the_time('U', $post->ID)); ?>
										<a href="<?php echo esc_url( $link ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
										<?php //the_excerpt(); ?>
									</div>
								</div>
								<div class="social">
									<?php social_count(); ?>
								</div>
							</article>
						</li>
					<?php endwhile; ?>
				</ol>
				<?php get_template_part('/parts/shared/paging'); ?>
				<?php else: ?>
				<h3>No results found for '<?php echo get_search_query(); ?>'</h3>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>
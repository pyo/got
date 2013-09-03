<div class="twentyfour columns">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php $exclude = $post->ID; ?>
		<div class="row">
			<div class="twentyfour columns">
				<?php the_content(); ?>
			</div>
		</div>
	<?php endwhile; ?>
	<div class="row">
		<div class="sixteen columns" id="primary">
			<div class="row">
				<div class="twentyfour columns">
					<div class="banner-wrapper">
						<h3 class="header-banner no-margin-top"><span class="latest_icon"></span> Other Popular Media</h3>
					</div>
				</div>
			</div>
			<div class="row" id="article-row">
				<div class="six columns">
					<?php get_template_part('/parts/shared/ads/skyscraper_ad'); ?>
				</div>
				<div class="eighteen columns pad-top pad-left" style="padding-left:10px">
					<ol class="no-list">
					<?php 
					// The Query
					$args = array(
						'tag' 				=> 'photo-gallery',
						'posts_per_page'	=> 10,
						'post__not_in'		=> array($exclude)
					);

					$the_query = new WP_Query( $args );

					// The Loop
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						?>
						
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


						<?php
					}

					/* Restore original Post Data 
					 * NB: Because we are using new WP_Query we aren't stomping on the 
					 * original $wp_query and it does not need to be reset.
					*/
					wp_reset_postdata();

					?>
					</ol>
				</div>
			</div>
			<?php $links = get_page(41240); ?>
			<?php if ( $links ) : ?>
				<?php preg_match_all("/<img .*?(?=src)src=\"([^\"]+)\"/si", $links->post_content, $img); ?>
				<?php //print_r($img[1][0]); ?>
				<aside id="partnerLinks">
					<div class="row">
						<div class="twentyfour columns">
							<div class="banner-wrapper">
								<h3 class="header-banner no-margin-top">Links From Our Partners in Crime</h3>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="eight columns">
							<?php if ( $img[1][0] && !empty($img) ) echo '<img src="' . $img[1][0] . '">'; ?>
						</div>
						<div class="sixteen columns">
							<?php echo strip_tags($links->post_content, '<p><li><ul><a>'); ?>
						</div>
					</div>
				</aside>
			<?php endif; ?>
			<div class="row">
				<div class="twentyfour columns comment_column" style="border-top:1px solid #eaeaea;padding-top:14px;">
					<?php comments_template(); ?>
				</div>
			</div>
			
			<?php //comments_template(); ?>
		</div>
		<?php get_sidebar('nextgen'); ?>
	</div>
</div>
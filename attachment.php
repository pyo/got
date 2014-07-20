<?php
/*** 
 * Gallery Post Format
 */
?>


<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<?php get_template_part('parts/shared/article_slider'); ?>
<div class="row" id="bg_wrapper">
	<div class="sixteen columns" id="primary">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div class="row">
				<div class="twentyfour columns">
					<?php 
						// begin post loop 
						// load up posts obj 
						$title = get_the_title();
						$content = get_the_content(); 
						$post->featured_image = get_first_image();
						$link = get_permalink();
						$link_file = wp_get_attachment_url($post->ID);
						$author = get_the_author();
						$date = get_the_date();
						$post_type = wp_get_post_terms($post->ID, 'got_format');
					?>

					<div class="cf">
						<div class="alignleft"><?php echo return_make_pinned_tag(); ?></div>
						<?php if(current_user_can('edit_post')): ?>
							
							<div class="alignright">
								<ul class="inline-block">
									<li><?php edit_post_link( 'Edit Post', '<div class="edit-button">', '</div>'); ?></li>
									<li><?php if (function_exists('wpp_get_views')) echo '| Post Views: ' . number_format( wpp_get_views( get_the_ID() ) ); ?></li>
								</ul>
							</div>
						
						<?php endif; ?>
					</div>

					<h2><?php echo $title; ?></h2>
					
					<div class="s-link">
					<p><strong>Go Back To: <a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?> &raquo;</a></strong></p>
					</div>
					
					<div class="banner-wrapper">
						<div class="header-banner no-margin-top cf">
							
							<?php social_count(); ?>
							
							<p id="article-author"><?php // echo $date . ' by ' . $author; ?></p>

							<?php next_post_link('%link', 'Next', false); ?>

						</div>
					</div>

					<?php if ( empty($post_type) ): ?>

					<?php // nothing happens if there is no post type defined // ?>
					
					<?php elseif ( !empty( $post_type ) && $post_type && $post->featured_image ): ?>
						
						<?php /* there is a GoT post type */ ?>
						
						<?php if ( $post_type[0]->slug == 'video-format' ): ?>
						
							<?php get_template_part('/parts/format/video'); ?>
						
						<?php elseif ( $post->featured_image && $post_type[0]->slug == 'standard-format' ): ?>
							
							<img id="featuredImage" src="<?php echo tim_thumb_image(remove_http($post->featured_image[0]), 660, 406, 70); ?>">
				
						<?php endif; ?>

					<?php else: ?>
					
					<?php // nothing happens if there is no featured image // ?>	

					<?php endif; ?>
				</div>
			</div>
			<div class="row" id="article-row">
				<div class="six columns">
					<?php get_template_part('/parts/shared/ads/skyscraper_ad'); ?>
				</div>
				<div class="eighteen columns pad-top <?php if(!empty($post_type)) echo $post_type[0]->slug; ?>  pad-left" style="padding-left:10px">
					<div id="paging" class="group">
								<p class="alignleft" id="next-post-link"><?php previous_image_link( false, 'Previous Picture' ); ?></p>
								<p class="alignright" id="previous-post-link"><?php next_image_link( false, 'Next Picture' ); ?></p>
							</div>
					<?php 
						if ( $post->guid ) {
							
							echo '<a target="_blank" href="' . $link_file . '">' . '<img src="' . $post->guid . '">' . '</a>';
						
							if ( $post->post_excerpt )
								echo '<p>' . $post->post_excerpt . '</p>';
						
						}


						// echo '<hr />';

						?>
						
						<div id="paging" class="group">
									<p class="alignleft" id="next-post-link"><?php previous_image_link( false, 'Previous Picture' ); ?></p>
									<p class="alignright" id="previous-post-link"><?php next_image_link( false, 'Next Picture' ); ?></p>
								</div>
								
								<div class="s-link" style="clear:both;">
								<p><strong>Go Back To: <a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?> &raquo;</a></strong></p>
								</div>

						<div class="navigation row cf">
							<ul class="block-grid two-up">
								<li><?php //previous_posts_link('%link', 'Previous Post', false); ?></li>
								<li><?php //next_post_link('%link', 'Next', false); ?></li>
							</ul>
						</div>

						<?php edit_post_link( 'Edit Post', '<div class="edit-button">', '</div>'); ?>
					
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
			

			<?php if( $term ): ?>
				
				<?php $args = array(
					'post_type'	 	=> array('post','page'),
					'tag_id'		=> $term->term_id,
					'posts_per_page'=> 6,
					'post__not_in'	=> array($post->ID)
				); 

				$the_query = new WP_Query( $args );

				if($the_query->have_posts()):
				
			?>
					<section id="related-posts">
						<div class="row">
							<div class="twentyfour columns">
								<div class="banner-wrapper">
									<h3 class="header-banner no-margin-top">More Posts From <?php echo $term->name; ?></h3>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="twentyfour columns">
								<ul class="block-grid two-up">
									<?php while ( $the_query->have_posts() ): ?>
									<?php $the_query->the_post(); ?>
									<?php 
										$featured_image = tim_thumb_image(get_first_image($post->ID, $post->post_content), 338, 140);
									?>
										<li>
											<a class="blue-overlay" href="<?php echo get_permalink($post->ID); ?>">
												<span class="details">
													<span class="title"><?php echo get_the_title($post->ID); ?></span>
												</span>
												<img src="<?php echo $featured_image; ?>">
											</a>
										</li>
									<?php endwhile; ?>
									<?php wp_reset_postdata(); ?>
								</ul>
							</div>
						</div>
					</section>
				<?php endif; ?>

			<?php endif; ?>

		<?php endwhile; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
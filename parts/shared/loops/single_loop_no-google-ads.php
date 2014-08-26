<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="row">
		<div class="twentyfour columns">
			<?php 
				// begin post loop 
				// load up posts obj 
				$title = get_the_title();
				$content = get_the_content(); 
				$link = get_permalink();
				$author = get_the_author();
				$date = get_the_date();
				$post_type = wp_get_post_terms($post->ID, 'got_format');

				//
				//	just get the first image if its not a modal gallery
				//	otherwise if it is explicitly only accept the set featured image
				//
				if ($post_type[0]->slug == 'modal-gallery-format') {
					$post->featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
					if ($post->featured_image)
						$post->featured_image = $post->featured_image[0];
				} else {
					$post->featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'article_feature');
					if($post->featured_image[1] != '660')
						$post->featured_image = get_first_image();					
				}	

			?>

			<div class="cf">
				<div class="alignleft"><?php echo return_make_vertical(); ?> <?php echo return_make_pinned_tag(); ?></div>
				<?php if(current_user_can('edit_post')): ?>
					
					<div class="alignright">
						<ul class="inline-block">
							<li><?php edit_post_link( 'Edit Post', '<div class="edit-button">', '</div>'); ?></li>
							<li><?php if (function_exists('wpp_get_views')) echo '&nbsp;| Views:&nbsp;' . number_format( wpp_get_views( get_the_ID() ) ); ?></li>
						</ul>
					</div>
				
				<?php endif; ?>
			</div>

			<h1><?php // echo '<a href="' . $link . '">' . $title . '</a>'; ?><?php echo $title; ?></h1>
			
			<div class="banner-wrapper">
				<div class="header-banner no-margin-top cf">
					
					<?php social_count(); ?>
					
					<p id="article-author"><?php echo $date // .' by ' . $author; ?> by <?php coauthors(); ?></p>

					<div class="next-link"><?php next_post_link('%link', 'Next', false); ?></div>

				</div>
			</div>
			
			<div class="fb-like" data-href="<?php echo $link; ?>" data-width="660" data-show-faces="false" data-send="false"></div>

			<?php if ( empty($post_type) ): ?>

			<?php // nothing happens if there is no post type defined // ?>
			
			<?php elseif ( !empty( $post_type ) && $post_type && $post->featured_image ): ?>
				
				<?php /* there is a GoT post type */ ?>
				
				<?php if ( $post_type[0]->slug == 'video-format' ): ?>
				
					<?php get_template_part('/parts/format/video'); ?>
				
				<?php elseif ( $post->featured_image && ( $post_type[0]->slug == 'standard-format' || $post_type[0]->slug == 'modal-gallery-format') ): ?>
					
					<?php if($post->featured_image[1] == '660'): ?>
					
						<img id="featuredImage" src="<?php echo $post->featured_image[0]; ?>">

					<?php else: ?>

						<img id="featuredImage" src="<?php echo tim_thumb_image(remove_http($post->featured_image), 660, null, 100); ?>">

					<?php endif; ?>	
		
				<?php endif; ?>

			<?php else: ?>
			
			<?php // nothing happens if there is no featured image // ?>	

			<?php endif; ?>
		</div>
	</div>
	<div class="row" id="article-row">
		<!-- <div class="six columns">
			<?php // get_template_part('/parts/shared/ads/skyscraper_ad'); ?>
		</div> -->
		<div class="eighteen columns pad-top <?php if(!empty($post_type)) echo $post_type[0]->slug; ?>  pad-left single-page-loop">
			<?php 
				if ( empty( $post_type ) || $post_type[0]->slug == 'standard-format' ) {
					//
					//	The GoT Format is "standard" or a format was not selected
					//
					the_content();
					
					custom_wp_link_pages();
				
				} else {
					//
					// 	The format is something other than standard
					//
					if( $post_type[0]->slug == 'modal-gallery-format' ){
						//
						//	its a modal gallery
						//
						get_template_part('parts/format/modal-gallery');

					} elseif ( $post_type[0]->slug == 'video-format' ){
						
						the_content();

					} elseif ( $post_type[0]->slug == 'list-format' ){
						//
						//	its a list
						//
						get_template_part('/parts/format/list');

					} else {
						the_content();
					
					}
				}
				
				echo '<div class="fb-like" data-href="' . $link . '" data-width="480" data-layout="button_count" data-show-faces="false" data-send="false"></div>';
				
				edit_post_link( 'Edit Post', '<div class="edit-button">', '</div>');
				
				echo '<hr />';
				
				get_template_part('/parts/shared/taboola_below_articles');

				//tags

				if(!is_page()) {

					$post_terms = wp_get_post_terms($post->ID, array('post_tag', 'category', 'vertical'));
					
					if ($post_terms) {
						
						echo '<hr />';
						
						$dont_repeat 	= array();
						$count 			= count($post_terms);
						$i 				= 1;

						echo '<ul id="tag-list" class="inline-block">';
						
						echo '<li><span class="uppercase"><strong>Follow:</strong>&nbsp;</span></li>';
							
							foreach ($post_terms as $term) {
								if (!in_array($term->term_id, $dont_repeat)) {
									echo '<li><a href="' . get_term_link($term) . '">' . $term->name . '</a>';
								
									if($i != $count) 
										echo ',&nbsp;';
								
									echo '</li>';
								}
								$dont_repeat[] = $term->term_id;
								$i++;
							}
						
						echo '</ul>';
					}
				}

				?>		
		</div>
	</div>
	<div class="single-navigation row collapse cf">
		<div class="twelve columns" id="previous"><?php previous_post_link('%link', '<span>Previous Post</span> %title'); ?></div>
		<div class="twelve columns" id="next"><?php next_post_link('%link', '<span>Next Post</span> %title'); ?></div>
	</div>
	<?php $links = get_page(41240); ?>
	<?php if ( $links ) : ?>
		<?php preg_match_all("/<img .*?(?=src)src=\"([^\"]+)\"/si", $links->post_content, $img); ?>
		<?php //print_r($img[1][0]); ?>
		<aside id="partnerLinks">
			<div class="row">
				<div class="twentyfour columns">
					<div class="banner-wrapper">
						<h3 class="header-banner no-margin-top">More from Our Partners</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="eight columns">
					<?php if ( $img[1][0] && !empty($img) ) echo '<img src="' . $img[1][0] . '">'; ?>
				</div>
				<div class="sixteen columns partner-links">
					<?php echo strip_tags($links->post_content, '<p><li><ul><a>'); ?>
				</div>
			</div>
		</aside>
	<?php endif; ?>
	<section class="related-posts">
		<div class="row">
			<div class="twentyfour columns">
				<div class="banner-wrapper">
					<h3 class="header-banner no-margin-top">You Might Also Like...</h3>
				</div>
			</div>
		</div>
		<div class="row">
			<script type='text/javascript'>
			var _CI = _CI || {};
			(function() {
			var script = document.createElement('script');
			ref = document.getElementsByTagName('script')[0];
			_CI.counter = (_CI.counter) ? _CI.counter + 1 : 1;
			document.write('<div id="_CI_widget_');
			document.write(_CI.counter+'"></div>');
			script.type = 'text/javascript';
			script.src = 'http://widget.crowdignite.com/widgets/32369?v=2&_ci_wid=_CI_widget_'+_CI.counter;
			script.async = true;
			ref.parentNode.insertBefore(script, ref);
			})(); </script>
			<style>
			#_ci_widget_div_32369 ul{list-style-type:none;margin:0;padding:0;min-height:160px;width:680px;}
			#_ci_widget_div_32369 ul li{display:inline-block;min-height:150px;vertical-align:top;width:120px;line-height:normal;margin:4px 8px 2px;}
			#_ci_widget_div_32369 ul li a > img{margin-bottom:0;}
			#_ci_widget_div_32369 .ci_text{display:block;margin-top:2px;}
			#_ci_widget_div_32369 .ci_text > a{font-family:Helvetica;font-size:14px;line-height:normal;text-decoration:underline;font-weight:700;color:#000;}
			</style>
			<!-- BEGIN ZERGNET WIDGET -->
			<div id="zergnet-widget-21615"></div>

			<script language="javascript" type="text/javascript">
				(function() {
					var zergnet = document.createElement('script'); 
					zergnet.type = 'text/javascript'; zergnet.async = true;
					zergnet.src = 'http://www.zergnet.com/zerg.js?id=21615';
					var znscr = document.getElementsByTagName('script')[0]; 
					znscr.parentNode.insertBefore(zergnet, znscr);
				})();
			</script>
			<!-- /END ZERGNET WIDGET -->
		</div>
	</section>
	<div style="margin-top:10px;margin-bottom:10px;" align="center">
	<script type="text/javascript"><!--
		e9 = new Object();
	    e9.size = "336x280,300x250,300x600";
	//--></script>
	<script type="text/javascript" src="http://tags.expo9.exponential.com/tags/GossipOnThis/httpgossiponthiscom/tags.js"></script>
	</div>
	<div class="row">
		<div class="twentyfour columns comment_column" style="border-top:1px solid #eaeaea;padding-top:14px;">
			<?php comments_template(); ?>
			<?php get_template_part('/parts/shared/ads/archive_bottom_post_ad'); ?>
		</div>
	</div>
	
	<?php 

	$pinned_tag = get_post_meta($post->ID, 'pinned_tag', true);

    if ($pinned_tag) $term = get_term( $pinned_tag, 'post_tag' );

    ?>

	<?php if( $term ): ?>
		
		<?php $args = array(
			'post_type'	 	=> array('post'),
			'tag_id'		=> $term->term_id,
			'posts_per_page'=> 8,
			'post__not_in'	=> array($post->ID)
		); 

		$the_query = new WP_Query( $args );

		if($the_query->have_posts()):
		
	?>
			<section class="related-posts">
				<div class="row">
					<div class="twentyfour columns">
						<div class="banner-wrapper">
							<h3 class="header-banner no-margin-top">More From: <a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a></h3>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="twentyfour columns">
						<ul class="block-grid two-up">
							<?php while ( $the_query->have_posts() ): ?>
							<?php $the_query->the_post(); ?>
							<?php 
								$featured_image = tim_thumb_image(remove_http(get_first_image()), 338, 140, 100, 1, 't');
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
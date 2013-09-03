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

			<h1><?php echo '<a href="' . $link . '">' . $title . '</a>'; ?></h1>
			
			<div class="banner-wrapper">
				<div class="header-banner no-margin-top cf">
					
					<?php social_count(); ?>
					
					<p id="article-author"><?php echo $date . ' by ' . $author; ?></p>

					<div class="next-link"><?php next_post_link('%link', 'Next', false); ?></div>

				</div>
			</div>

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

						<img id="featuredImage" src="<?php echo tim_thumb_image(remove_http($post->featured_image), 660, null, 70); ?>">

					<?php endif; ?>	
		
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
			<?php 
				if ( empty( $post_type ) || $post_type[0]->slug == 'standard-format' ) {
					//
					//	The GoT Format is "standard" or a format was not selected
					//
					the_content();
				
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
				
				edit_post_link( 'Edit Post', '<div class="edit-button">', '</div>');

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
      <!-- MGID News Widget Start -->
      <div id="MarketGid10053" class="news-block-magick"><center><a style="display:none;" id="mg_add10053" href="http://usr.mgid.com/demo/goods/?utm_source=widget&utm_medium=text&utm_campaign=add" target="_blank">Place your ad here</a><br><a style="display:none;" href="http://mgid.com/" target="_blank">Loading...</a>
      </center></div>
      <!-- MGID News Widget End -->

      <!-- Elastic limiter Start-->
      <span id="MGDW10053"></span>
      <!-- Elastic limiter End-->

      <script type="text/javascript">
      var MarketGidDate = new Date();
      document.write('<scr'+'ipt type="text/javascript" '
      +'src="http://jsn.dt07.net/g/o/gossiponthis.com.10053.js?t='+MarketGidDate.getYear()+MarketGidDate.getMonth()+MarketGidDate.getDay()+MarketGidDate.getHours()
      + '" charset="utf-8" ></scr'+'ipt>');
      </script>

<!--      <div style="margin-top:10px;">
      <iframe class="scribol" height="310" width="566" id="scribol_3125029" scrolling="no" frameborder="0"></iframe>
      <script>
      var Scribol;
      if(typeof Scribol=='undefined'){Scribol={};  Scribol.frames=[];Scribol.site='http://scribol.com/';Scribol.is_preview=false;}
      Scribol.frames.push('3125029');</script>
      <script async="async" defer="defer" src="http://scribol.com/txwidget1.2.js"></script>
      </div> -->
		</div>
	</section>
	<div style="margin-bottom:10px;" align="center">
    <script type="text/javascript" src="http://ap.lijit.com/www/delivery/fpi.js?z=204961&u=gossiponthis&width=300&height=250"></script>
	</div>
	<div class="row">
		<div class="twentyfour columns comment_column" style="border-top:1px solid #eaeaea;padding-top:14px;">
			<?php comments_template(); ?>
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
			'posts_per_page'=> 6,
			'post__not_in'	=> array($post->ID)
		); 

		$the_query = new WP_Query( $args );

		if($the_query->have_posts()):
		
	?>
			<section class="related-posts">
				<div class="row">
					<div class="twentyfour columns">
						<div class="banner-wrapper">
							<h3 class="header-banner no-margin-top">More <a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a> Posts</h3>
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
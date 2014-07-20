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
			
			<!-- <div class="banner-wrapper">
				<div class="header-banner no-margin-top cf">
					
					<?php // social_count(); ?>
					
					<p id="article-author"><?php // echo $date // .' by ' . $author; ?> by <?php // coauthors(); ?></p>

					<div class="next-link"><?php // next_post_link('%link', 'Next', false); ?></div>

				</div>
			</div> -->
			

		</div>
	</div>
	<div class="row" id="article-row">
		<div class="six columns">
			<?php get_template_part('/parts/shared/ads/skyscraper_ad'); ?>
		</div>
		<div class="eighteen columns pad-top <?php if(!empty($post_type)) echo $post_type[0]->slug; ?>  pad-left" style="padding-left:15px;">
			<?php the_content(); ?>		
		</div>
	</div>

	<div style="margin-top:10px;margin-bottom:10px;" align="center">
    <script type="text/javascript" src="http://ap.lijit.com/www/delivery/fpi.js?z=204961&u=gossiponthis&width=300&height=250"></script>
    <div style="display:none;"><script type="text/javascript"><!--
google_ad_client = "ca-pub-2727072243882391";
/* 300x250, created 3/15/10 */
google_ad_slot = "7204750745";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
	</div>
	<div class="row">
		<div class="twentyfour columns comment_column" style="border-top:1px solid #eaeaea;padding-top:14px;">
			<?php comments_template(); ?>
		</div>
	</div>

<?php endwhile; ?>
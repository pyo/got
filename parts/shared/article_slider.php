<?php 

if ( false === ( $article_slider = get_transient( 'article_slider' ) ) ) {
	//
	// It wasn't there, so regenerate the data and save the transient
	//
	$article_slider = new WP_Query( array('posts_per_page'=>32, 'post_type'=>array('post') ) );
	
	//
	// recache transient
	//
	set_transient( 'article_slider', $article_slider, 60*60*2 );
} 

?>

<?php if ( $article_slider->have_posts() ) : ?>
	<div id="carousel-wrapper">
		<section class="carousel" data-carousel-slider>
			<ul class="slides">
				<?php while ( $article_slider->have_posts() ) : $article_slider->the_post(); ?>
				
					<?php 
					//
					// get featured image or steal the first image from the post if there is no featured image
					//
					$featured_image = get_first_image();
					$title = get_post_meta($post->ID,'short_title',true);
					$title = ( !empty($title) ) ? $title : get_the_title();

					?>
				
					<?php echo '<li><a href="' . get_permalink() . '?utm_ref=slider"><img src="' . tim_thumb_image(remove_http($featured_image), 116, 72) . '" /><span class="hide description">' . $title . '</span></a></li>'; ?>
				
				<?php endwhile; ?>
			</ul>
		</section>
	</div>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
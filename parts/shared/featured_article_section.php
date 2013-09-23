<?php

	if ( false === ( $query = get_transient( 'featured_articles_section' ) ) ) {
		//
		// It wasn't there, so regenerate the data and save the transient
		//
		$args = array(
			'posts_per_page' 	=> 10,
			'post_type' 		=> 'post',
			'meta_key' 			=> 'got_featured_select',
			'order' 			=> 'DESC',
			'meta_query' 		=> array(
				array(
					'key' 		=> 'got_featured_select',
					'value' 	=> 'featured',
					'compare' 	=> 'IN',
				)
			),
		);
		// The Query
		$query = new WP_Query( $args );
		
		//
		// recache transient
		//
		set_transient( 'featured_articles_section', $query, 60*60*2 );
	} 
	
	$i = 1;
	$count = count($query->posts);

	// The Loop
	if ( $query->have_posts() ) {
		echo '<section id="featured-articles-section">';
			echo '<ul class="no-list">';
				while ( $query->have_posts() ) {
					$query->the_post();
					if ($i == $count) { 
						$class = ' class="last"'; 
					} else { 
						$class = ''; 
					}
					$term = wp_get_post_terms($post->ID, 'vertical');
					
					if($term) {
						$term['term_link']	= get_term_link($term[0]);
					}

					echo '<li' . $class . '>';
					if ($term['term_link']) echo '<a class="term_link" href="' . $term['term_link'] . '">' . $term[0]->name . '</a>';
					echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
					$i++;
				}
			echo '</ul>';
		echo '</section>';
	} 
	/* Restore original Post Data */
	wp_reset_postdata();
?>
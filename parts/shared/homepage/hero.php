<?php 
	//
	// get the home page ID
	//
	$home_id 	= get_page_by_path('home');
	
	//
	// get the hero image layout
	//
	$num_hero 	= get_post_meta($home_id->ID, 'got_hero_layout', true);

	//if ( false === ( $header_menu_results = get_transient( 'header_menu_results' ) ) ) {

	$i 			= 1;
	$ids		= array();
	//
	// loop through the posts and load up an array
	//
	while ( $i <= $num_hero ) {
		//
		// get the post ID
		//
		$ids[$i]['hero_id'] = get_post_meta($home_id->ID, 'got_hero_layout_' . $i, true);
		
		//
		// get the term ID, nice name and slug if its available
		//
		if ($term_id = get_post_meta($ids[$i]['hero_id'][0], 'pinned_tag', true)) {
			$ids[$i]['term'] = get_term($term_id, 'post_tag', ARRAY_A);
			
			if($ids[$i]['term']) 
				$ids[$i]['term']['url'] = get_term_link($ids[$i]['term']['slug'], 'post_tag');
		
		}

		//print_r($ids[$i]);

		//
		//	get the featured image or the first image if there is no featured image
		//
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $ids[$i]['hero_id'][0] ), 'large');

		if ( $image ) {
			$ids[$i]['featured_image'] 	= $image[0];
		} else {
			$ids[$i]['featured_image'] 	= get_first_image($ids[$i]['hero_id'][0]);
		}

		$i++;

	}
	//set_transient( 'header_menu_results', $header_menu_results, 60*2*1 );

?>
<section id="hero">
	<div class="row">
		<div class="twentyfour columns">
			<ul class="no-list cf <?php echo 'hero_layout_' . $num_hero; ?>">
				<?php include( locate_template('/parts/shared/homepage/hero/hero_' . $num_hero . '.php', false, false ) ); ?>
			</ul>
		</div>
	</div>
</section>
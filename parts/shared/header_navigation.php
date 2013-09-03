<?php
	
if ( false === ( $header_menu_results = get_transient( 'header_menu_results' ) ) ) {
	    
	$header_menu_results = array();

	$terms = get_terms('vertical', 
		//
		// exclude the higher level verticals
		//
		array(
			// local
			//'exclude' => array(7093,2977,7094,7092),
			'exclude' => array(7768,2977,7775,7778),
			'hide_empty' => true
		) 
	);

	foreach ($terms as $term) {
		$args = array(
			'post_type' => array('post','page'),
			'tax_query' => array(
				array(
					'taxonomy'			=> 'vertical',
					'field' 			=> 'id',
					'terms' 			=> $term->term_id,
				)
			),
			'posts_per_page'			=> 4,
			'order' 					=> 'DESC',
			'orderby'					=> 'date',
			'post_status' 				=> 'publish'
		);

		switch ($term->parent) {
			case 7768:
				$parent = 'Celebs';
				$header_menu_results[$parent]['parent_link'] = get_term_link(intval(7768), 'vertical');
				break;
			case 2977:
				$parent = 'Entertainment';
				$header_menu_results[$parent]['parent_link'] = get_term_link(intval(2977), 'vertical');
				break;
			case 7775:
				$parent = 'More';
				$header_menu_results[$parent]['parent_link'] = get_term_link(intval(7775), 'vertical');
				break;
			case 7778:
				$parent = 'News';
				$header_menu_results[$parent]['parent_link'] = get_term_link(intval(7778), 'vertical');
				break;
		}

		$header_menu_results[$parent]['children'][$term->name]['term_id'] = $term->term_id;

		$the_query = new WP_Query( $args ); 

		while ( $the_query->have_posts() ) : $the_query->the_post();
			
			$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail');

			$header_menu_results[$parent]['children'][$term->name]['posts'][$post->ID][] = $post->ID;
	        $header_menu_results[$parent]['children'][$term->name]['posts'][$post->ID][] = $post->post_title;
	        $header_menu_results[$parent]['children'][$term->name]['posts'][$post->ID][] = get_permalink($post->ID);
	        $header_menu_results[$parent]['children'][$term->name]['posts'][$post->ID][] = ($img) ? $img[0] : get_first_image($post->ID, $post->post_content);

	    endwhile;

	    wp_reset_postdata();
	
	}
  	set_transient( 'header_menu_results', $header_menu_results, 60*60*1 );
}


	?>
<?php if($header_menu_results): ?>	
	<?php if(!empty($header_menu_results)): ?>
		<?php // build navigation ?>
		<ul class="no-list alignleft">
			<?php foreach (array_keys($header_menu_results) as $key): ?><li class="has-dropdown"><a href="<?php if($header_menu_results[$key]['parent_link']) echo $header_menu_results[$key]['parent_link']; ?>" class="menu-header"><?php echo $key; ?></a>
				<div class="dropdown cf">
					
					<?php $menu 	= '<ul class="post-list-nav no-list alignleft">'; ?>
					<?php $postlist = '<div class="post-list-wrapper alignright">'; ?>

						<?php foreach (array_keys($header_menu_results[$key]['children']) as $sub): ?>

							<?php $term_link = get_term_link(intval($header_menu_results[$key]['children'][$sub]['term_id']),'vertical'); ?>

							<?php $menu 	.= '<li class="has-sub-menu"><a href="' . $term_link . '" data-toggle-postlist="' . str_replace(' ', '-', str_replace('&', 'and', htmlspecialchars_decode($sub))) . '">' . $sub . '</a></li>'; ?>
							<?php $postlist .= '<ul data-postlist="' . str_replace(' ', '-', str_replace('&', 'and', htmlspecialchars_decode($sub))) . '" class="no-list menu-post-list">'; ?>
							
								<?php foreach($header_menu_results[$key]['children'][$sub]['posts'] as $post): ?>
									<?php $postlist .= '<li><a href="' . $post[2] . '"><img src="' . tim_thumb_image(remove_http($post[3]), 59, 59, 100, 1) . '"><span>' . $post[1] . '</span></a></li>'; ?>
								<?php endforeach; ?>

								<?php if( $term_link ): ?>									
									<?php $postlist .= '<li><a class="last" href="' . $term_link . '">More ' . $sub . '</a></li>'; ?>
								<?php endif; ?>

							<?php $postlist .= '</ul>'; ?>

						<?php endforeach; ?>
					
					<?php $menu 	.= '</ul>'; ?>
					<?php $postlist .= '</div>'; ?>

					<?php echo $menu; ?>
					<?php echo $postlist; ?>

				</div>
			</li><?php endforeach; ?>
		</ul>
		<?php // end build navigation ?>
	<?php endif; ?>
<?php endif; ?>
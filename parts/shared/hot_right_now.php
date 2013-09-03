<aside id="hot-right-now">
		<div class="banner-wrapper">
			<h3 class="header-banner no-margin"><span class="fire_icon"></span> Hot Right Now</h3>
		</div>
		<ul class="inline-block no-list whitebox" id="hrn-selector">
			<li>
				<a data-hot="daily" class="active" href="#">Today</a></li><li>
				<a data-hot="weekly" href="#">This Week</a></li><li>
				<a data-hot="monthly" href="#">This Month</a></li>
		</ul>
		<?php
		//
		//	check cache to see if popular posts are stored already
		//
		if ( false === ( $most_popular_posts = get_transient( 'most_popular_posts' ) ) ){
		   	//
			//	Make sure the WordpressPopularPosts class is available 
			//
			if (class_exists('WordpressPopularPosts')){
				
				//
				//	instantiate the class
				//
				$popular_posts = new WordpressPopularPosts();
				
				//
				//	set all ranges
				//
				$most_popular_posts['daily'] 	= array();
				$most_popular_posts['weekly'] 	= array();
				$most_popular_posts['monthly'] 	= array();
				
				//
				//	build up query variables
				//	requried for this format ( important )
				//	missing some variables will cause errors or notices
				//
				$instance['order_by'] 					 = 'views';
				$instance['thumbnail']['width'] 		 = 122;
				$instance['thumbnail']['height'] 		 = 89;
				$instance['thumbnail']['active'] 		 = true;
				$instance['stats_tag']['comment_count']  = false;
				$instance['stats_tag']['author'] 		 = false;
				$instance['stats_tag']['date']['active'] = false;
				$instance['stats_tag']['views']			 = false;
				$instance['stats_tag']['date']['format'] = 'F j, Y';
				$instance['limit']						 = 5;

				//
				//	set "no image" default
				//
				$popular_posts->default_thumbnail = get_template_directory_uri() . '/img/got_small_most_popular.jpg';

				//
				//	run query on each date range
				//
				foreach (array_keys($most_popular_posts) as $range) {
					$instance['range'] 			= $range;
					$most_popular_posts[$range] = $popular_posts->get_popular_posts($instance, true);

					//
					//	iterate over each added range adding tag
					//	probably short title also
					//
					if (!empty($most_popular_posts[$range]) && $most_popular_posts[$range] !== 'Sorry. No data so far.') {
						for ($i=0; $i < count($most_popular_posts[$range]); $i++) {

							//
							//	add tag html & link
							//
							if ($var = get_post_meta($most_popular_posts[$range][$i]['id'], 'pinned_tag', true)) {
								$term = get_term( $var, 'post_tag' );
								if ($term) { 
									$most_popular_posts[$range][$i]['tag_html'] = '<a class="cat" href="' . get_term_link( intval($term->term_id), 'post_tag' ) . '">' . $term->name . '</a>';
								} else {
									$no_term = true;
								}
							} else {
								$no_term = true;
							}

							//
							//	get the short title if its available
							//
							if ($var = get_post_meta($most_popular_posts[$range][$i]['id'], 'short_title', true)){
								$link = explode('>',$most_popular_posts[$range][$i]['title']);
								if($no_term === true) {
									$most_popular_posts[$range][$i]['title'] = $link[0] . '>' . $var . '</a>';
								} else {
									$most_popular_posts[$range][$i]['title'] = $link[0] . '>' . $var . '</a>';
								}

							}	
						}
					}	
				}

				//
				//	cache the results for half a day
				//
				set_transient( 'most_popular_posts', $most_popular_posts, 60 * 60 * 4 );

			}
		}

		//
		//	make sure popular posts are set and filled
		//
		if ( $most_popular_posts && !empty($most_popular_posts) ) {
			echo '<script> var most_popular = ' . json_encode($most_popular_posts) . '</script>';
			echo '<div id="popularpoststarget"></div>';
		}
		
		?>
		</aside>	
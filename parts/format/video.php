<?php $vid 		= get_post_meta($post->ID, 'got_video_embed_code', true); ?>
<?php $oneliner = get_post_meta($post->ID, 'got_video_one_liner', true); ?>
<?php $type 	= get_post_meta($post->ID, 'got_video_type', true); ?>
<?php $featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'article_feature' ); ?>

<?php 



	//
	// check to make sure our value exists
	//
	if ($vid) {

		if (is_array($featured_img) && !empty($featured_img)) {
			if($featured_img[1] == '660'){ 
				$featured_img = $featured_img[0];
			} else {
				$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$featured_img = tim_thumb_image(remove_http($featured_img[0]), 660, 371, 100 );
			}
		}



		wp_enqueue_script( 'got_video' );

		echo '<div data-video-wrapper><div data-video="vevo" data-video-width="" data-video-height="" class="video featured-video" style="position:relative;"><img src="' . get_template_directory_uri() . '/img/got_vid_logo.png" style="position:absolute;right:1.5em; bottom:2.5em;margin:0;"><a href="#" onclick="return false;" class="play_button"></a>';
		
		if ($oneliner)
			echo '<h4 style="position:absolute;background-color:rgba(27,137,165,0.8);font-weight:800;color:#fff;top:0;left:0;padding:10px;">' . $oneliner. '</h4>';

		echo '<img src="' . $featured_img . '"></div><div style="display:none;" data-vide-container>' . $vid . '</div></div>';

		// if()

		// switch ($type) {
		// 	case 'youtube':
		// 			//	split URL on slashes
		// 			$vid = explode('/', $vid);
					
		// 			// grab the ID
		// 			$vid = $vid[4];

		// 			if (!$featured_img) {
		// 				$vid_src = wp_remote_get('http://gdata.youtube.com/feeds/api/videos/' . $vid . '?v=2&alt=jsonc');

		// 				if (!is_wp_error($vid_src) && !empty($vid_src['body'])) {
		// 					//	decode json body
		// 					$vid_src = json_decode($vid_src['body']);
		// 					//	Our Value exists
		// 					if ($vid_src->data->thumbnail->hqDefault) $featured_img = $vid_src->data->thumbnail->hqDefault;
							
		// 				}
		// 			} 

		// 			wp_enqueue_script( 'got_video' );

		// 			echo '<div data-video="youtube" data-src="' . $vid . '" data-video-width="" data-video-height="" class="video featured-video" style="position:relative;"><img src="' . get_template_directory_uri() . '/img/got_vid_logo.png" style="position:absolute;left:1.4em; bottom:1.4em;margin:0;"><a href="#" onclick="return false;" class="play_button"></a>';
					
		// 			if ($oneliner)
		// 				echo '<h4 style="position:absolute;background-color:rgba(27,137,165,0.8);font-weight:800;color:#fff;top:0;left:0;padding:10px;">' . $oneliner. '</h4>';

		// 			echo '<img src="' . tim_thumb_image( $featured_img, 660, 372, 100 ) . '"></div>';
					

		// 		break;

		// 	case 'worldstar':

		// 			wp_enqueue_script( 'got_video' );

		// 			echo '<div data-video="worldstar" data-src="' . $vid . '" data-video-width="" data-video-height="" class="video featured-video" style="position:relative;"><img src="' . get_template_directory_uri() . '/img/got_vid_logo.png" style="position:absolute;left:1.4em; bottom:1.4em;margin:0;"><a href="#" onclick="return false;" class="play_button"></a>';
					
		// 			if ($oneliner)
		// 				echo '<h4 style="position:absolute;background-color:rgba(27,137,165,0.8);font-weight:800;color:#fff;top:0;left:0;padding:10px;">' . $oneliner. '</h4>';

		// 			echo '<img src="' . tim_thumb_image( $featured_img, 660, 372, 100 ) . '"></div>';


		// 		break;

		// 	case 'vevo':

		// 			wp_enqueue_script( 'got_video' );

		// 			echo '<div data-video-wrapper><div data-video="vevo" data-video-width="" data-video-height="" class="video featured-video" style="position:relative;"><img src="' . get_template_directory_uri() . '/img/got_vid_logo.png" style="position:absolute;left:1.4em; bottom:1.4em;margin:0;"><a href="#" onclick="return false;" class="play_button"></a>';
					
		// 			if ($oneliner)
		// 				echo '<h4 style="position:absolute;background-color:rgba(27,137,165,0.8);font-weight:800;color:#fff;top:0;left:0;padding:10px;">' . $oneliner. '</h4>';

		// 			echo '<img src="' . tim_thumb_image( $featured_img, 660, 372, 100 ) . '"></div><div style="display:none;" data-vide-container>' . $vid . '</div></div>';


		// 		break;	

		// 	case 'dailymotion':
			
		// 			wp_enqueue_script( 'got_video' );

		// 			echo '<div data-video="dailymotion" data-src="' . $vid . '" data-video-width="" data-video-height="" class="video featured-video" style="position:relative;"><img src="' . get_template_directory_uri() . '/img/got_vid_logo.png" style="position:absolute;left:1.4em; bottom:1.4em;margin:0;"><a href="#" onclick="return false;" class="play_button"></a>';
					
		// 			if ($oneliner)
		// 				echo '<h4 style="position:absolute;background-color:rgba(27,137,165,0.8);font-weight:800;color:#fff;top:0;left:0;padding:10px;">' . $oneliner. '</h4>';

		// 			echo '<img src="' . tim_thumb_image( $featured_img, 660, 372, 100 ) . '"></div>';

		// 		break;	

		// 	case 'other':
					
		// 			echo '<div class="fit-vid">' . $vid . '</div>';
				
		// 		break;	

		// } // end type switch

 	} 

 ?>



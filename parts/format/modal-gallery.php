<?php
// get gallery code
$image_IDs = get_post_meta($post->ID, 'got_modal_gallery', true);

if( $image_IDs ){
	// format is [gallery ids="1,2,3"]
	// explode quotes
	$image_IDs = explode('"', $image_IDs);

	$index = array_search(' ids=', $image_IDs);

	if (!$index) 
		$index = array_search('[gallery ids=', $image_IDs);
	
	if ($index || $index == 0) 
		$index++;
	
	// explode commas
	$image_IDs = explode(',', $image_IDs[$index]);

	if ($image_IDs) {
		$images = get_posts(array(
			'posts_per_page' 	=> -1,
			'include' 			=> $image_IDs,
			'post_type'			=> 'attachment'
		));
	}

}

the_content();

$link = wp_get_post_terms($post->ID, 'post_tag');
for ($i=0; $i < count($link); $i++) { 
	if ($link[$i]->slug == 'photo-gallery') {
		$term_link = get_term_link($link[$i]);
		break; 
	}
}
if(!$term_link)
	$term_link = '';



if ( !empty($images) && $images ) {
	echo '<ul class="no-list" id="modal-list" data-term-link="' . $term_link . '">';
	foreach($images as $image) {
		//tim_thumb_image($image['full'][0], 900, 690, 80, 3) 
		$small_image = wp_get_attachment_image_src($image->ID, 'large');
		$large_image = wp_get_attachment_image_src($image->ID, 'gallery_dimension');
		//echo '<a class="modal-image" data-fancybox-type="image" href="' . tim_thumb_image($large_image[0], 900, 600, 100, 2) . '" rel="gallery"><img title="' . $image->post_title . '" src="' . $small_image[0] . '"></a>';
		echo '<li><a title="' . $image->post_title . '" height="' . $small_image[2] . '" width="' . $small_image[1] . '" class="auto-center modal-image" data-fancybox-type="image" href="' . $large_image[0] . '" rel="gallery"><img title="' . $image->post_title . '" src="' . get_template_directory_uri() . '/img/grey.gif" class="lazy" height="' . $small_image[2] . '" width="' . $small_image[1] . '" data-original="' . $small_image[0] . '"></a>';
		echo '<h5>' . $image->post_title . '</h5>';
		echo '</li>';

	}
	echo '</ul>';
}

?>
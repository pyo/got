<?php
if ( false === ( $trending_topics = get_transient( 'trending_topics' ) ) ) {
	
	$topic_count = get_post_meta(181890, 'got_trending_topic_count', true);

	$i = 1;

	$trending_topics = array();

	while ($i <= $topic_count) {
		
		$trending_topics[$i]['tag_id'] = get_post_meta(181890, 'got_trending_topic_' . $i, true);
		
		if ( $trending_topics[$i]['tag_id'] ) {
			
			$trending_topics[$i]['tag_link'] = get_term_link(intval($trending_topics[$i]['tag_id']), 'post_tag');
			$trending_topics[$i]['tag_name'] = get_term($trending_topics[$i]['tag_id'], 'post_tag', ARRAY_A);
			$trending_topics[$i]['tag_name'] = $trending_topics[$i]['tag_name']['name'];
		
		}

		$i++;
	}

	set_transient( 'trending_topics', $trending_topics, 60*60*4 );
}

if($trending_topics) {
	echo '<ul class="no-list trend-list inline-block">'; 
	echo '<li><span id="trending-title" class="trend">What\'s Trending</span></li>';
	foreach ($trending_topics as $topic) {
		if ($topic['tag_link'] && $topic['tag_name'])
			echo '<li><a class="trend" href="' . $topic['tag_link'] . '">' . $topic['tag_name'] . '</a></li>';
	}
	echo '</ul>';
}


?>
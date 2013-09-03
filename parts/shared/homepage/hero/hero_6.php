<?php for ($i=1; $i <= count($ids) ; $i++) :?>
<li class="third small <?php if ( $i == 3 || $i == 6 ) echo 'nmr'; ?>">
	<?php if(array_key_exists('term', $ids[$i])): ?>
		<a class="banner pinned-article" href="<?php echo $ids[$i]['term']['url']; ?>"><?php echo $ids[$i]['term']['name']; ?></a>
	<?php endif; ?>
	<a class="blue-overlay" href="<?php echo get_permalink($ids[$i]['hero_id'][0]); ?>?utm_ref=hero">
		<span class="details">
			<span class="title"><?php echo get_the_title($ids[$i]['hero_id'][0]); ?></span>
		</span>
		<img src="<?php echo tim_thumb_image(remove_http($ids[$i]['featured_image']), 320, 155, 75); ?>">
	</a></li>
<?php endfor;  ?>


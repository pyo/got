<?php for ($i=1; $i <= count($ids) ; $i++) :?>
<li class="half <?php if($i == 2) echo 'nmr'; ?>">
	<?php if(array_key_exists('term', $ids[$i])): ?>
		<a class="banner pinned-article" href="<?php echo $ids[$i]['term']['url']; ?>"><?php echo $ids[$i]['term']['name']; ?></a>
	<?php endif; ?>
	<a title="Permalink to <?php echo get_the_title($ids[$i]['hero_id'][0]); ?>" class="blue-overlay" href="<?php echo get_permalink($ids[$i]['hero_id']); ?>?utm_ref=hero">
		<span class="details">
			<h2 class="title"><?php echo get_the_title($ids[$i]['hero_id'][0]); ?></h2>
		</span>
		<img alt="<?php echo get_the_title($ids[$i]['hero_id'][0]); ?>" src="<?php echo tim_thumb_image(remove_http($ids[$i]['featured_image']), 490, 450, 100); ?>">
	</a></li>
<?php endfor; ?>
<?php $list = get_post_meta($post->ID, 'got_list', false); ?>

<?php the_content(); ?>

<?php if ( !empty( $list ) && $list && 1 == count( $list ) ): ?>
	<ol class="list-post-type no-list">
		<?php $i = 1; ?>
		<?php foreach ( $list[0] as $list_item ) : ?>
			<li class="cf list-item">
				<?php if ( $list_item['list_image_title'] ): ?>
					<h4><?php echo $list_item['list_image_title']; ?></h4>
				<?php endif; ?>
				<?php if ( $list_item['list_image'] ) : ?>
					<div>
						<?php $var = wp_get_attachment_image_src($list_item['list_image'],'large'); ?>
						<img src="<?php echo $var[0]; ?>">
					</div>
				<?php endif; ?>
				<?php if ( $list_item['list_image_description'] ) : ?>
					<div>
						<p><?php echo $list_item['list_image_description']; ?></p>
					</div>
				<?php endif; ?>
				<?php if ( $list_item['list_image_src_text'] && $list_item['list_image_src_link'] ): ?>
					<div>
						<span>Source: <a href="<?php echo $list_item['list_image_src_link']; ?>" target="_blank"><?php echo $list_item['list_image_src_text']; ?></a></span>
					</div>	
				<?php endif; ?>
			</li>
			<?php $i++; ?>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>
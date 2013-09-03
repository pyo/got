<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<?php get_template_part('parts/shared/article_slider'); ?>
<div class="row" id="bg_wrapper">
	<?php if (is_next_gen(get_the_content($wp_query->query_vars['page_id']))): ?>
		<?php // test to see if the page content has nextgen shortcode // ?>
		<?php // if it does run a simplified loop for the gallery // ?>
			<?php get_template_part('/parts/shared/next-gen-template'); ?>
		<?php // end of nextgen format // ?>
	<?php else: ?>
		<?php // it isnt nextgen so load the standard page template // ?>
		<?php get_template_part('/parts/shared/page-template'); ?>
	<?php endif; ?>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
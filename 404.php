<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<?php get_template_part('parts/shared/article_slider'); ?>
<div class="row" id="bg_wrapper">
	<div class="sixteen columns" id="primary">
			<div class="row">
				<div class="twentyfour columns">
					<h2>404: Sorry, wrong URL!</h2>
					<h4><a href="http://gossiponthis.com">CHECK OUT OUR HOMEPAGE FOR SOMETHING ELSE</a></h4>
				</div>
			</div>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
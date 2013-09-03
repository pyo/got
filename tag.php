<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<?php make_hero_section(); ?>
<div class="row" id="bg_wrapper">
	<div class="sixteen columns" id="primary">
		<div class="banner-wrapper">
			<h3 class="header-banner no-margin-top"><span class="latest_icon"></span> <?php echo single_tag_title( '', false ); ?></h3>
		</div>
		<div class="row">
			<div class="six columns">
				<?php get_template_part('/parts/shared/ads/skyscraper_ad'); ?>
				<?php get_template_part('/parts/shared/featured_article_section'); ?>
			</div>
			<div class="eighteen columns pad-top pad-left">
				<?php get_template_part('/parts/shared/loops/main_loop'); ?>
			</div>
		</div>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>
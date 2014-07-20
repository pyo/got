<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<?php get_template_part('parts/shared/article_slider'); ?>
<div class="row" id="bg_wrapper">
<?php get_template_part('/parts/shared/blank-page-template'); ?>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
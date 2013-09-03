<?php 
/**
Template Page for the gallery overview

Follow variables are useable :

	$gallery     : Contain all about the gallery
	$images      : Contain all images, path, title
	$pagination  : Contain the pagination content

 You can check the content when you insert the tag <?php var_dump($variable) ?>
 If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
**/
?>
<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php if (!empty ($gallery)) : ?>
	<section class="row black-background gallery" id="nextGen">
		<div class="sixteen columns">
			<h1><?php if ( $title = get_the_title() ) echo $title; ?></h1>
			<div class="slider" data-nexGen-slider>
				<ul class="slides">
					<?php foreach ( $images as $image ) : ?>
 						<?php //print_r($image); ?>
					    <li>
					        <?php if ( !$image->hidden ) { ?>
					        <?php
					        //$w, $h, $q = null, $zc = null
					        //tim_thumb_image($large_image[0], 900, 600, 100, 2)
					        ?>
					        	<img src="<?php echo tim_thumb_image(remove_http($image->imageURL), 660, 428, 100, 3); ?>" alt="<?php echo $image->alttext ?>" />
					        	<div class="hide"><div data-slide-title><?php echo $image->alttext; ?></div><div data-slide-caption><?php echo $image->description; ?></div></div>
					        <?php } ?>
					    </li>
					 
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="eight columns" data-nexGen-controls>
			
			<div class="gallery-controls cf">
				<p class="slide-counter">
					<span data-slide-number></span>
					<span>of</span>
					<span data-total-slides></span>
				</p>
			</div>

			<h3 class="slide-title"></h3>
			<div class="slide-caption nano"><div class="content"></div></div>
			
			<div class="ad">
				<?php get_template_part('/parts/shared/sidebar_ad'); ?>
			</div>
		</div>
	</section>
<?php endif; ?>
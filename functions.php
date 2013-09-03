<?php

	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */
	/*** 
	 * misc
	 */
	remove_action('wp_head', 'wp_generator');

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	//add_theme_support('post-thumbnails');
	
	// register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */


	/*** 
	 * Theme Support
	 */
	if ( function_exists( 'add_theme_support' ) ) { 
		/*** 
		 * Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		//add_theme_support( 'menus' );
		
		set_post_thumbnail_size( 116, 65, true ); // default Post Thumbnail dimensions (cropped)

		// delete the next line if you do not need additional image sizes
		add_image_size( 'article_feature', 660, 9999 ); //300 pixels wide (and unlimited height)
		add_image_size( 'gallery_dimension', 660, 495 ); //300 pixels wide (and unlimited height)
		// add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
	
	}


	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function script_enqueuer() {
		/*** 
		 * Header scripts
		 */
		wp_register_script( 'modernizr', get_template_directory_uri().'/javascripts/vendor/custom.modernizr.js', NULL, '1.0', false );
		wp_enqueue_script( 'modernizr' );

		/*** 
		 * Footer Scripts
		 */
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', NULL, '1.9.1', false );
		wp_enqueue_script( 'jquery' );

		wp_register_script( 'jquery_cookie', get_template_directory_uri() . '/javascripts/foundation/jquery.cookie.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'jquery_cookie' );

		wp_register_script( 'mustache', get_template_directory_uri() . '/javascripts/mustache.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'mustache' );

		// Register Socialite
    	wp_register_script( 'socialite', get_template_directory_uri() . '/javascripts/socialite.min.js', array('jquery'), '', true );	
	    wp_enqueue_script( 'socialite' );

	    wp_register_script( 'lazyload', get_template_directory_uri() . '/javascripts/lazyload.min.js', array('jquery'), '', true );	
	    wp_enqueue_script( 'lazyload' );

	    wp_register_script( 'flexslider', get_template_directory_uri() . '/javascripts/vendor/flexslider/jquery.flexslider-min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'flexslider' );

		wp_register_script( 'fitvids', get_template_directory_uri() . '/javascripts/fitvids.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'fitvids' );

	    wp_register_script( 'fancy_box_js', get_template_directory_uri() . '/javascripts/vendor/fancybox/source/jquery.fancybox.pack.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'fancy_box_js' );

		wp_register_style( 'fancy_box_css', get_stylesheet_directory_uri() . '/javascripts/vendor/fancybox/source/jquery.fancybox.css', '', '', 'screen' );
		wp_enqueue_style( 'fancy_box_css' );	

		wp_register_script( 'got_video', get_template_directory_uri() . '/javascripts/got_video.js', array( 'jquery','site' ), '1.0', true );

		wp_register_script( 'site', get_template_directory_uri() . '/javascripts/site.js', array( 'jquery', 'fitvids', 'mustache','socialite','lazyload', 'jquery_cookie' ), '1.0', true );
		wp_enqueue_script( 'site' );

		/************
		 * Styles
		 *************
		 */
		wp_register_style( 'screen', get_stylesheet_directory_uri() . '/stylesheets/app.css', '', null, 'screen' );
        wp_enqueue_style( 'screen' );
	}	

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	
	require_once 'metaboxes/meta_box.php';


	$prefix = 'got_';

	$fields = array(
		array( // Repeatable & Sortable Text inputs
			'label'	=> 'List Generator', // <label>
			'desc'	=> '', // description
			'id'	=> $prefix.'list', // field id and name
			'type'	=> 'repeatable', // type of field
			'sanitizer' => array( // array of sanitizers with matching kets to next array
				'featured' => 'meta_box_santitize_boolean',
				'title' => 'sanitize_text_field',
				'desc' => 'wp_kses_data'
			),
			'repeatable_fields' => array ( 
				array(
					'label' => 'Image Title',
					'id' => 'list_image_title',
					'type' => 'text'
				),
				array( // Image ID field
					'label'	=> 'Image', // <label>
					'id'	=> 'list_image', // field id and name
					'type'	=> 'image' // type of field
				),
				array(
					'label' => 'Image Description',
					'id' => 'list_image_description',
					'type' => 'textarea'
				),
				array(
					'label' => 'Source Name',
					'id' => 'list_image_src_text',
					'type' => 'text'
				),
				array(
					'label' => 'Source Link',
					'id' => 'list_image_src_link',
					'type' => 'text'
				)
			)
		)
	);

	/**
	 * Instantiate the class with all variables to create a meta box
	 * var $id string meta box id
	 * var $title string title
	 * var $fields array fields
	 * var $page string|array post type to add meta box to
	 * var $js bool including javascript or not
	 */
	$list_field_meta_box = new custom_add_meta_box( 'list_field', 'List', $fields, array('post','page'), true );	

	$fields = array(
		array( // Select box
			'label'	=> 'Video Source', // <label>
			'desc'	=> 'Source of video embed code.', // description
			'id'	=> $prefix . 'video_type', // field id and name
			'type'	=> 'select', // type of field
			'options' => array ( // array of options
				'one' => array ( // array key needs to be the same as the option value
					'label' => 'Youtube.com', // text displayed as the option
					'value'	=> 'youtube' // value stored for the option
				),
				'two' => array (
					'label' => 'Worldstar HipHop',
					'value'	=> 'worldstar'
				),
				'three' => array (
					'label' => 'Vevo',
					'value'	=> 'vevo'
				),
				'four' => array (
					'label' => 'Dailymotion',
					'value'	=> 'dailymotion'
				),
				'four' => array (
					'label' => 'Vimeo',
					'value'	=> 'vimeo'
				),
				'five' => array (
					'label'	=> 'Other',
					'value' => 'other'
				)
			)
		),
		array( // Text Input
			'label'	=> 'Video One Liner', // <label>
			'desc'	=> 'A short one liner to be overlayed on the video.', // description
			'id'	=> $prefix . 'video_one_liner', // field id and name
			'type'	=> 'text' // type of field
		),
		array( // Textarea
			'label'	=> 'Video Embed Code', // <label>
			'desc'	=> 'The Video Embed.', // description
			'id'	=> $prefix . 'video_embed_code', // field id and name
			'type'	=> 'textarea' // type of field
		),
	);

	/**
	 * Instantiate the class with all variables to create a meta box
	 * var $id string meta box id
	 * var $title string title
	 * var $fields array fields
	 * var $page string|array post type to add meta box to
	 * var $js bool including javascript or not
	 */
	$video_meta_box = new custom_add_meta_box( 'video_field', 'Video', $fields, array('post','page'), true );	

	$fields = array(
		array( // Text Input
			'label'	=> 'Article Short Title', // <label>
			'desc'	=> 'An abbreviated title.', // description
			'id'	=> 'short_title', // field id and name
			'type'	=> 'text' // type of field
		),
		array( // Select box
			'label'	=> 'Featured?', // <label>
			'desc'	=> '', // description
			'id'	=> $prefix . 'featured_select', // field id and name
			'type'	=> 'select', // type of field
			'options' => array ( // array of options
				'one' => array ( // array key needs to be the same as the option value
					'label' => 'Not Featured', // text displayed as the option
					'value'	=> 'not_featured' // value stored for the option
				),
				'two' => array (
					'label' => 'Featured',
					'value'	=> 'featured'
				),
				'three' => array (
					'label' => 'Super Feature',
					'value'	=> 'super_feature'
				)
			)
		),
		array( // Taxonomy Select box
			'label'	=> 'Post Format', // <label>
			// the description is created in the callback function with a link to Manage the taxonomy terms
			'id'	=> 'got_format', // field id and name, needs to be the exact name of the taxonomy
			'type'	=> 'tax_select' // type of field
		),
		array( // Taxonomy Select box
			'label'	=> 'Vertical', // <label>
			// the description is created in the callback function with a link to Manage the taxonomy terms
			'id'	=> 'vertical', // field id and name, needs to be the exact name of the taxonomy
			'type'	=> 'tax_select' // type of field
		),
		array( // Taxonomy Select box
			'label'	=> 'Pinned Tag', // <label>
			// the description is created in the callback function with a link to Manage the taxonomy terms
			'id'	=> 'pinned_tag', // field id and name, needs to be the exact name of the taxonomy
			'type'	=> 'tag_select' // type of field
		),
	);

	// include_once('/advanced-custom-fields/advanced-custom-fields/acf.php');

	// // //define( 'ACF_LITE', true );

	// add_action('acf/register_fields', function(){
	// 	include_once('add-ons/acf-tax/taxonomy-field.php' );
	// });

	// register_field_group(array (
	// 	'id' => 'acf_pinned-tag',
	// 	'title' => 'Pinned Tag',
	// 	'fields' => array (
	// 		array (
	// 			'taxonomy' => 'post_tag',
	// 			'field_type' => 'select',
	// 			'allow_null' => 0,
	// 			'load_save_terms' => 1,
	// 			'multiple' => 0,
	// 			'return_format' => 'id',
	// 			'key' => 'field_51af835d1ee94',
	// 			'label' => 'Pinned Tag',
	// 			'name' => 'pinned_tag',
	// 			'type' => 'taxonomy',
	// 		),
	// 	),
	// 	'location' => array (
	// 		array (
	// 			array (
	// 				'param' => 'post_type',
	// 				'operator' => '==',
	// 				'value' => 'post',
	// 				'order_no' => 0,
	// 				'group_no' => 0,
	// 			),
	// 		),
	// 		array (
	// 			array (
	// 				'param' => 'post_type',
	// 				'operator' => '==',
	// 				'value' => 'page',
	// 				'order_no' => 0,
	// 				'group_no' => 1,
	// 			),
	// 			array (
	// 				'param' => 'page',
	// 				'operator' => '==',
	// 				'value' => '23',
	// 				'order_no' => 1,
	// 				'group_no' => 1,
	// 			),
	// 		),
	// 	),
	// 	'options' => array (
	// 		'position' => 'side',
	// 		'layout' => 'default',
	// 		'hide_on_screen' => array (
	// 		),
	// 	),
	// 	'menu_order' => 0,
	// ));

	/**
	 * Instantiate the class with all variables to create a meta box
	 * var $id string meta box id
	 * var $title string title
	 * var $fields array fields
	 * var $page string|array post type to add meta box to
	 * var $js bool including javascript or not
	 */
	$post_meta_box = new custom_add_meta_box( 'post_meta_box', 'Post Meta', $fields, array('post','page'), true );	

	$fields = array(
		array( // Text Input
			'label'	=> 'Modal Gallery Code', // <label>
			'desc'	=> 'Paste wordpress gallery code here.	Example: [gallery ids="170942,170941,170938,170936"]', // description
			'id'	=> $prefix . 'modal_gallery', // field id and name
			'type'	=> 'text' // type of field
		),
	);

	/**
	 * Instantiate the class with all variables to create a meta box
	 * var $id string meta box id
	 * var $title string title
	 * var $fields array fields
	 * var $page string|array post type to add meta box to
	 * var $js bool including javascript or not
	 */
	$modal_gallery_box = new custom_add_meta_box( 'modal_gallery_field', 'Modal Gallery', $fields, array('post','page'), true );	

	//
	//	home
	//
	$fields = array(
		// array( // Select box
		// 	'label'	=> 'Hero Layout', // <label>
		// 	'desc'	=> '', // description
		// 	'id'	=> $prefix.'hero_layout', // field id and name
		// 	'type'	=> 'select', // type of field
		// 	'options' => array ( // array of options
		// 		'one' => array ( // array key needs to be the same as the option value
		// 			'label' => '1', // text displayed as the option
		// 			'value'	=> '1' // value stored for the option
		// 		),
		// 		'two' => array (
		// 			'label' => '2',
		// 			'value'	=> '2'
		// 		),
		// 		'three' => array (
		// 			'label' => '3',
		// 			'value'	=> '3'
		// 		),
		// 		'four' => array ( // array key needs to be the same as the option value
		// 			'label' => '4', // text displayed as the option
		// 			'value'	=> '4' // value stored for the option
		// 		),
		// 		'five' => array (
		// 			'label' => '5',
		// 			'value'	=> '5'
		// 		),
		// 		'six' => array (
		// 			'label' => '6',
		// 			'value'	=> '6'
		// 		)
		// 	)
		// ),
		// array( // Post ID select box
		// 	'label'	=> 'Hero Post 1', // <label>
		// 	'desc'	=> '', // description
		// 	'id'	=>  $prefix.'hero_layout_1', // field id and name
		// 	'type'	=> 'post_select', // type of field
		// 	'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		// ),
		// array( // Post ID select box
		// 	'label'	=> 'Hero Post 2', // <label>
		// 	'desc'	=> '', // description
		// 	'id'	=>  $prefix.'hero_layout_2', // field id and name
		// 	'type'	=> 'post_select', // type of field
		// 	'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		// ),
		// array( // Post ID select box
		// 	'label'	=> 'Hero Post 3', // <label>
		// 	'desc'	=> '', // description
		// 	'id'	=>  $prefix.'hero_layout_3', // field id and name
		// 	'type'	=> 'post_select', // type of field
		// 	'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		// ),
		// array( // Post ID select box
		// 	'label'	=> 'Hero Post 4', // <label>
		// 	'desc'	=> '', // description
		// 	'id'	=>  $prefix.'hero_layout_4', // field id and name
		// 	'type'	=> 'post_select', // type of field
		// 	'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		// ),
		// array( // Post ID select box
		// 	'label'	=> 'Hero Post 5', // <label>
		// 	'desc'	=> '', // description
		// 	'id'	=>  $prefix.'hero_layout_5', // field id and name
		// 	'type'	=> 'post_select', // type of field
		// 	'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		// ),
		// array( // Post ID select box
		// 	'label'	=> 'Hero Post 6', // <label>
		// 	'desc'	=> '', // description
		// 	'id'	=>  $prefix.'hero_layout_6', // field id and name
		// 	'type'	=> 'post_select', // type of field
		// 	'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		// ),
		array( // Select box
			'label'	=> 'Trending Topic Count', // <label>
			'desc'	=> '', // description
			'id'	=> $prefix.'trending_topic_count', // field id and name
			'type'	=> 'select', // type of field
			'options' => array ( // array of options
				'one' => array ( // array key needs to be the same as the option value
					'label' => '1', // text displayed as the option
					'value'	=> '1' // value stored for the option
				),
				'two' => array (
					'label' => '2',
					'value'	=> '2'
				),
				'three' => array (
					'label' => '3',
					'value'	=> '3'
				),
				'four' => array ( // array key needs to be the same as the option value
					'label' => '4', // text displayed as the option
					'value'	=> '4' // value stored for the option
				),
				'five' => array (
					'label' => '5',
					'value'	=> '5'
				),
				'six' => array (
					'label' => '6',
					'value'	=> '6'
				),
				'seven' => array ( // array key needs to be the same as the option value
					'label' => '7', // text displayed as the option
					'value'	=> '7' // value stored for the option
				),
				'eight' => array (
					'label' => '8',
					'value'	=> '8'
				),
				'nine' => array (
					'label' => '9',
					'value'	=> '9'
				),
				'ten' => array ( // array key needs to be the same as the option value
					'label' => '10', // text displayed as the option
					'value'	=> '10' // value stored for the option
				),
				'eleven' => array (
					'label' => '11',
					'value'	=> '11'
				),
				'twelve' => array (
					'label' => '12',
					'value'	=> '12'
				),
				'thirteen' => array ( // array key needs to be the same as the option value
					'label' => '13', // text displayed as the option
					'value'	=> '13' // value stored for the option
				),
				'fourteen' => array (
					'label' => '14',
					'value'	=> '14'
				),
				'fifteen' => array (
					'label' => '15',
					'value'	=> '15'
				),
			)
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 1', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_1', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 2', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_2', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 3', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_3', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 4', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_4', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 5', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_5', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 6', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_6', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 7', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_7', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 8', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_8', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 9', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_9', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 10', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_10', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 11', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_11', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 12', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_12', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 13', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_13', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 14', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_14', // field id and name
			'type'	=> 'tag_select', // type of field
		),
		array( // Post ID select box
			'label'	=> 'Trending Topic 15', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'trending_topic_15', // field id and name
			'type'	=> 'tag_select', // type of field
		),
	);
	
	$home_page_layout = new custom_add_meta_box( 'home_page_trending_topics', 'Trending Topics', $fields, array('page'), true, array('181890') );	

	$fields = array(
		array( // Select box
			'label'	=> 'Hero Layout', // <label>
			'desc'	=> '', // description
			'id'	=> $prefix.'hero_layout', // field id and name
			'type'	=> 'select', // type of field
			'options' => array ( // array of options
				'one' => array ( // array key needs to be the same as the option value
					'label' => '1', // text displayed as the option
					'value'	=> '1' // value stored for the option
				),
				'two' => array (
					'label' => '2',
					'value'	=> '2'
				),
				'three' => array (
					'label' => '3',
					'value'	=> '3'
				),
				'four' => array ( // array key needs to be the same as the option value
					'label' => '4', // text displayed as the option
					'value'	=> '4' // value stored for the option
				),
				'five' => array (
					'label' => '5',
					'value'	=> '5'
				),
				'six' => array (
					'label' => '6',
					'value'	=> '6'
				)
			)
		),
		array( // Post ID select box
			'label'	=> 'Hero Post 1', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'hero_layout_1', // field id and name
			'type'	=> 'post_select', // type of field
			'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		),
		array( // Post ID select box
			'label'	=> 'Hero Post 2', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'hero_layout_2', // field id and name
			'type'	=> 'post_select', // type of field
			'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		),
		array( // Post ID select box
			'label'	=> 'Hero Post 3', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'hero_layout_3', // field id and name
			'type'	=> 'post_select', // type of field
			'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		),
		array( // Post ID select box
			'label'	=> 'Hero Post 4', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'hero_layout_4', // field id and name
			'type'	=> 'post_select', // type of field
			'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		),
		array( // Post ID select box
			'label'	=> 'Hero Post 5', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'hero_layout_5', // field id and name
			'type'	=> 'post_select', // type of field
			'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		),
		array( // Post ID select box
			'label'	=> 'Hero Post 6', // <label>
			'desc'	=> '', // description
			'id'	=>  $prefix.'hero_layout_6', // field id and name
			'type'	=> 'post_select', // type of field
			'post_type' => array('post','page') // post types to display, options are prefixed with their post type
		)
	);	

	$hero_section = new custom_add_meta_box( 'hero_section_layout', 'Hero Section', $fields, array('page'), true, array('181890', '181891', '181893', '181896', '181897', '181898', '181899') );

	/**** 
	 *  Admin 
	 */
	function admin_script($hook) {
	    if( 'edit.php' == $hook || 'post-new.php' == $hook || 'post.php' == $hook )
		    wp_enqueue_script( 'admin_scripts', get_template_directory_uri(). '/javascripts/admin_script.js', array('jquery'), '1.0', true );
	}
	add_action( 'admin_enqueue_scripts', 'admin_script' );

	function admin_styles() {
		//#verticaldiv, #list_field, #video_field, #modal_gallery_field
	   echo '<style type="text/css">
	           	#verticaldiv, #tagsdiv-got_format{
	   				display:none;
				}

	         </style>';
	}
	add_action('admin_head', 'admin_styles');

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}

	function get_first_image_src( $postID ) {
		$args = array(
			'numberposts' => 1,
			'order'=> 'DESC',
			'post_mime_type' => 'image',
			'post_parent' => $postID,
			'post_type' => 'attachment'
		);

		$get_children_array = get_children( $args, ARRAY_A );  //returns Array ( [$image_ID]... 
		
		$rekeyed_array = array_values( $get_children_array );
		
		if ( $rekeyed_array ) {
			// if there are child images
			$child_image = $rekeyed_array[0];  
			$child_image = wp_get_attachment_image_src( $child_image['ID'], 'thumbnail' );
			
			return $child_image[0];	
		
		} else {
			// return a GoT Logo
			return get_template_directory_uri() . '/img/thumbs/carousel_thumb.jpg';
		}
		

	}

	/***
	 * Post Links
	 */
	//add_filter('next_posts_link_attributes', 'next_post_link_attr');

	// function add_class_next_post_link( $html ){
	//     if (is_single() || is_page() || is_singular())
	//     	$html = str_replace('<a', '<a class="next-article paging alignright"', $html);
	    
	//     return $html;
	// }
	// add_filter('next_post_link','add_class_next_post_link',10,1);
	
	function is_next_gen($content) {
		$match = '.*?(nggallery)';	# Variable Name 1

		if ( $c = preg_match_all('/' . $match . '/is', $content, $matches) ) {
			return true;
		}
	}

	// hook into the init action and call create_book_taxonomies when it fires
	add_action( 'init', 'create_taxonomies', 0 );

	//create two taxonomies, genres and writers for the post type "book"
	function create_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Formats', 'taxonomy general name' ),
			'singular_name'     => _x( 'Format', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Formats' ),
			'all_items'         => __( 'All Formats' ),
			'parent_item'       => __( 'Parent Format' ),
			'parent_item_colon' => __( 'Parent Format:' ),
			'edit_item'         => __( 'Edit Format' ),
			'update_item'       => __( 'Update Format' ),
			'add_new_item'      => __( 'Add New Format' ),
			'new_item_name'     => __( 'New Format Name' ),
			'menu_name'         => __( 'Format' ),
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => false,
			'public'			=> false,
		);

		register_taxonomy( 'got_format', array( 'post', 'page' ), $args );

		$labels = array(
			'name'              => _x( 'Vertical', 'taxonomy general name' ),
			'singular_name'     => _x( 'Vertical', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Verticals' ),
			'all_items'         => __( 'All Verticals' ),
			'parent_item'       => __( 'Parent Vertical' ),
			'parent_item_colon' => __( 'Parent Vertical:' ),
			'edit_item'         => __( 'Edit Vertical' ),
			'update_item'       => __( 'Update Vertical' ),
			'add_new_item'      => __( 'Add New Vertical' ),
			'new_item_name'     => __( 'New Vertical Name' ),
			'menu_name'         => __( 'Vertical' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'public'			=> true,
			'show_in_nav_menus'	=> true,
			'rewrite'           => true,
		);

		register_taxonomy( 'vertical', array( 'post', 'page' ), $args );

	}

	function tags_support_all() {
		register_taxonomy_for_object_type('post_tag', 'page');
	}
	add_action('init', 'tags_support_all');

	function got_pre_get_posts($wp_query) {
		// home 181890
		// celebs 181891
		// crime news 181893
		// hip hop 181896
		// news 181897
		// sports 181898
		// tv 181899
		$exclude_ids = array(181890, 181891, 181893, 181896, 181897, 181898, 181899);

		if($wp_query->get('category')) 
			$wp_query->set('post_type', 'any');

		// if($wp_query->is_main_query() && ( is_tax('vertical', 'celebs') || is_tax('vertical', 'entertainment') || is_tax('vertical', 'news') || is_tax('vertical', 'more') ) ) {
		// 	$tax = $wp_query->queried_object->term_id;
		// 	if ($tax) 
		// 		$tax = get_term_children($tax, 'vertical');

		// 	//print_r($tax);

		// 	//$wp_query->set('')
		// 	print_r($wp_query);

		// }

		if($wp_query->is_main_query() && !is_singular() && !is_admin())
			$wp_query->set('posts_per_page', 20);

		//if (is_tax('vertical', array('news','celebs','entertainment','tv','hip-hop','sports','politics','tech'))) print_r($wp_query); 

		//
		// verticals
		//
		// if(is_tax('vertical') && !is_admin() && !is_singular()){
		// 	//
		// 	//	get current tax term
		// 	//
		// 	$current_term = $wp_query->get('term');

		// 	//print_r($wp_query->get('term'));
		// 	//
		// 	//	make sure we got the vertical name
		// 	//		
		// 	// if ($current_term) {
		// 	// 	//
		// 	// 	// 	check for cached results
		// 	// 	//
		// 	// 	if (false === ($results = get_transient($current_term . '_super_featured'))) {
					
		// 	// 		$args = array(
		// 	// 				'posts_per_page' 	=> 1,
		// 	// 				'post_type' 		=> array('post','page'),
		// 	// 				'meta_key' 			=> 'got_featured_select',
		// 	// 				'order' 			=> 'ASC',
		// 	// 				'meta_query' 		=> array(
		// 	// 					array(
		// 	// 						'key' 		=> 'got_featured_select',
		// 	// 						'value' 	=> 'super_feature',
		// 	// 						'compare' 	=> 'IN',
		// 	// 					)
		// 	// 				),
		// 	// 				'tax_query' 		=> array(
		// 	// 					array(
		// 	// 						'taxonomy' 	=> 'vertical',
		// 	// 						'field' 	=> 'slug',
		// 	// 						'terms' 	=> $current_term
		// 	// 					)
		// 	// 				)
		// 	// 			);

		// 	// 		//
		// 	// 		// run query
		// 	// 		//
		// 	// 		 	$results['super_featured'] = new WP_Query($args);

		// 	// 		// 	//
		// 	// 		// 	// args for standard featured post
		// 	// 		// 	//
		// 	// 			$args = array(
		// 	// 				'posts_per_page' 	=> 4,
		// 	// 				'post_type' 		=> array('post','page'),
		// 	// 				'meta_key' 			=> 'got_featured_select',
		// 	// 				'order' 			=> 'ASC',
		// 	// 				'meta_query' 		=> array(
		// 	// 					array(
		// 	// 						'key' 		=> 'got_featured_select',
		// 	// 						'value' 	=> 'featured',
		// 	// 						'compare' 	=> 'IN',
		// 	// 					)
		// 	// 				),
		// 	// 				'tax_query' => array(
		// 	// 					array(
		// 	// 						'taxonomy' 	=> 'vertical',
		// 	// 						'field' 	=> 'slug',
		// 	// 						'terms' 	=> $current_term
		// 	// 					)
		// 	// 				)
		// 	// 			);

		// 	// 		// 	//
		// 	// 		// 	//
		// 	// 		// 	//
		// 	// 			$results['featured'] = new WP_Query($args);

		// 	// 		//
		// 	// 		//	cache results
		// 	// 		//
		// 	// 		set_transient( $current_term . '_super_featured', $results, 60*1*1 );
				
		// 	// 	}

		// 	// 	//
		// 	// 	//	iterate over posts to get all ID's
		// 	// 	//
		// 	// 	if (!empty($results)) {
		// 	// 		foreach ($results as $result) {
		// 	// 			for ($i=0; $i < count($result->posts); $i++) { 
		// 	// 				$exclude_ids[] = $result->posts[$i]->ID;
		// 	// 			}
		// 	// 		}
		// 	// 	}

		// 	// 	//
		// 	// 	//	since we're on an taxonomy page and we already have the results just add it to the object
		// 	// 	//
		// 	// 	$wp_query->featured_vertical_posts = $results;
					
		// 	// }	

		// }

		//
		// if it isnt empty return the array full of bad id's to exclude
		//
		if(!empty($exclude_ids) && !is_admin()) 
			$wp_query->set('post__not_in', $exclude_ids);

		//
		//	return wp_query
		//
		return $wp_query;
	
	}
	add_action('pre_get_posts', 'got_pre_get_posts');

	function get_ID_by_slug($page_slug) {
	    $page = get_page_by_path($page_slug);
	    if ( $page ) {
	        return $page->ID;
	    } else {
	        return null;
	    }
	}
		
	add_action('save_post', 'got_save_posts');
	
	function got_save_posts( $post_id ) {

		if ( 'page' == $_REQUEST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
		}

		//if saving in a custom table, get post_ID
		$post_ID = $_POST['post_ID'];

		if( $post_ID == 178764 ){
			// delete trending topics transient if the homepage is updated
			delete_transient( 'trending_topics' );
		}


	}


	/**
	 * Display time since post was published
	 *
	 * @uses	human_time_diff()  Return time difference in easy to read format
	 * @uses	get_the_time()  Get the time the post was published
	 * @uses	current_time()  Get the current time
	 *
	 * @return	string  Timestamp since post was published
	 *
	 * @author c.bavota
	 */
	function get_time_since_posted($time = null) {
		if ( $time ) {
			$time_since = human_time_diff( $time, current_time( 'timestamp' ) );
			
			if ($time_since == '1 day') {
				return 'Added yesterday';
			} else {
				$time_since_posted =  $time_since . ' ago';
				return 'Added ' . $time_since_posted;
			}			
		}

	}

	function tim_thumb_image($img, $w, $h = null, $q = null, $zc = null, $a = null){
		// $tim = '';
		// $q = ( $q == null ) ? '&q=76' : '&q=' . $q;
		// $zc = ( $zc == null ) ? '1' : $zc;

		// if( $img ) {
		// 	$tim .= get_template_directory_uri() . '/external/timthumb.php?';
		// 	$tim .= $q . '&src=' . $img . '&a=c&zc=' . $zc;	

		// 	if ( $w )
		// 		$tim .= '&w=' . $w;
		// 	if ( $h ) 
		// 		$tim .= '&h=' . $h;
			
		// 	return $tim;	 
		// } else {
		// 	return false;
		// }

		///resizer/250x150/r/your-image-url.jpg

		if(is_null($zc)){
			$zc = '1';
		} 

		if (is_null($a)) {
			$a = 't';
		}

		if(is_null($h)){
			$h = '';
		} else {
			$h = '&h=' . $h;
		}

		if ( $img ) {
			//return get_site_url() . '/media/resizer/' . $w . 'x' . $h . '/r/' . $img . '/c/' . $zc;
			return get_template_directory_uri() . '/external/thumb/thumb.php?w=' . $w . $h . '&src=http://' . $img . '&q=100&a=' . $a . '&zc=' . $zc;
		}

	}

	function filter_where( $where = '' ) {
		// posts in the last 30 days
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
		return $where;

	}

	function social_count(){
		do_action('social_count');
	}

	add_action('social_count', 'do_social_count', 1);

	function returnSocialWorth($url, $postID){

		if ( false === ( $count = get_transient( $postID . '_like_count' ) ) ) {
		
			$count = wp_remote_get( 'http://rest.sharethis.com/reach/getUrlInfo.php?url=' . $url . '&pub_key=c610b095-49cf-42d9-a8ab-2821cffd6859&access_key=ceaeaded8d5b0a5ea639c5226f84ed25' );

			if( is_wp_error( $count ) ) {
				return false;
			
			} else {
				$count = json_decode($count['body']);

				if(is_object($count)) {
					$count = $count->total->inbound;
				
				} else {
					return false;

				}
				set_transient( $postID . '_like_count', $count, 60*60*2 );
			}
		} 

		return $count;
	}

	function do_social_count(){
		global $post;

		$link = get_permalink($post->ID);

		$count = returnSocialWorth($link, $post->ID);
		$count = (is_numeric($count)) ? $count : false;

		//
		//	covert count to pretty formatting
		//
		if($count) {
			$count = strval($count);
			$count = str_split($count);
			if (count($count) == 4) {
				$count = $count[0] . '.' . $count[1] . 'k';
			} elseif (count($count) == 5){
				$count = $count[0] . $count[1] . '.' . $count[2] . 'k';
			} else {
				$count = implode($count);
			}
		}

		$template  = '';

		if (is_single($post->ID) || is_page($post->ID)) {
			$template .= '<div class="social_media_dropdown">';
			$template .= '<span data-open="single-social-dropdown" class="open-share"><strong>';
			if($count > 1 ) {
				$template .= $count . ' Shares</strong></span>';
			} else {
				$template .= 'Share!</strong></span>';
			}
			$template .= '<div id="single-social-dropdown" data-social-media-dropdown class="dropdown">';
		}

		//print_r($count);
		if(!is_single($post->ID) && !is_page($post->ID) && $count != false) {
			$template .= '<span data-share-count class="open-share"><strong>' . $count . ' share';
			if($count > 1) $template .= 's';
			$template .= '</strong></span>';
		} elseif (!is_single($post->ID) && !is_page($post->ID) && $count == 0) {
			$template .= '<span data-share-count class="open-share"><strong>Be the first to share!</strong></span>';
		} elseif (!is_single($post->ID) && !is_page($post->ID) && $count == 0) {
			$template .= '<span data-share-count class="open-share"><strong>Share!</strong></span>';
		} 

		$template .= '<div class="share">';
		$template .= '<ul class="no-list inline-block cf">';
		$template .= '<li><span st_url="' . $link . '" st_title="' . get_the_title($post->ID) . '" class="st_fblike_hcount" displayText="Facebook"></span></li>';
		
		if(is_single($post->ID)  || is_page($post->ID)) {
			$template .= '<li><span st_url="' . $link . '" st_title="' . get_the_title($post->ID) . '" class="st_facebook_hcount" displayText="Facebook"></span></li>';
		}
		
		$template .= '<li><span st_via="GossipOnThis" st_username="GossipOnThis" st_url="' . $link . '" st_title="' . get_the_title($post->ID) . '" class="st_twitter_hcount" displayText="Tweet"></span></li>';
		$template .= '<li><span st_url="' . $link . '" st_title="' . get_the_title($post->ID) . '" class="st_plusone_hcount" displayText="Google +"></span></li>';
		$template .= '<li><span st_url="' . $link . '" st_title="' . get_the_title($post->ID) . '" class="st_linkedin_hcount" displayText="LinkedIn"></span></li>';

		if( is_single($post->ID)  || is_page($post->ID) ) {
			$template .= '<li><span class="st_pinterest_hcount" displayText="Pinterest"></span></li>';
			$template .= '<li><span class="st_email_hcount" displayText="Email"></span></li>';
		}


		$template .= '</ul>';
		$template .= '</div>';

		if (is_single($post->ID) || is_page($post->ID)) {
			$template .= '</div></div>';
		}

		echo $template;

	}

	function remove_http($url = ''){
        if ($url == 'http://' || $url == 'https://'){
                return $url;
        }

        $matches = substr($url, 0, 7);

        if ($matches=='http://'){
            $url = substr($url, 7);         
        
        } else {
            $matches = substr($url, 0, 8);
            if ($matches=='https://') 
        	    $url = substr($url, 8);

        }
        return $url;
    }


    function return_make_pinned_tag() {
    	global $post;
    	global $wp_query;

    	$pinned_tag = get_post_meta($post->ID, 'pinned_tag', true);

    	if ($pinned_tag) {
    		$term = get_term( $pinned_tag, 'post_tag' );
			
			if ($term) {
				if($wp_query->is_page || $wp_query->is_single() || $wp_query->is_singular) {
					$class = 'pinned_tag';
				} else {
					$class = 'banner';
				}
				return '<a class="' . $class . '" href="' . get_term_link( intval($term->term_id), 'post_tag' ) . '">' . $term->name . '</a>';
			}
    	}
    }

    function display_views(){
    	$view_count = '';
    	
    	if ( current_user_can( 'edit_post' ) ) { 
    		if (function_exists('wpp_get_views')) {
				$view_count .= number_format( wpp_get_views( get_the_ID() ) );
			} 
	
			$view_count .= 'Views';
			return $view_count;
	
		}
    }

	function get_first_image($post_id = null, $post_content = null){
		global $post;

		$first_img = '';

		$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

		if ($featured_image) {
		 	return $featured_image[0];
		
		} else {

			if($post->post_content)
				$post_content = $post->post_content;

			if(is_null($post_content) && !$post->post_content){
				$post_obj = get_post($post_id);
				$post_content = $post_obj->post_content;
			}

			if ($post_content) {
				ob_start();
				ob_end_clean();
				$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
				$first_img = $matches[1][0];
				
				if(!empty($first_img)){
					$related_thumbnail = $first_img;
				
				} else {
					$related_thumbnail = get_template_directory_uri() . '/img/carousel_got.jpg';							//define default thumbnail, you can use full url here.
				
				}

			}else{
				$related_thumbnail = get_template_directory_uri() . '/img/carousel_got.jpg';
			}
		 
			return $related_thumbnail;
		}
		
	}	

	function make_hero_section() {
		// home 181890
		// celebs 181891
		// crime news 181893
		// hip hop 181896
		// news 181897
		// sports 181898
		// tv 181899
		global $wp_query;

		$tax = 'vertical';

		// $celebs = get_term_children(7652, $tax);
		// $celebs[] = 7652;

		// $news = get_term_children(7654, $tax);
		// $news[] = 7654;

		// if (is_tax($tax, 'celebs')) {
		// 	$page_id = 181891;
		// 	$part = 'celebs';

		// } elseif(is_tax($tax, 'hip-hop')) {
		// 	$page_id = 181896;
		// 	$part = 'sports';

		// } elseif (is_tax($tax, 'crime-news')) {
		// 	$page_id = 181893;
		// 	$part = 'crime-news';

		// } elseif (is_tax($tax, 'sports')) {
		// 	$page_id = 181898;
		// 	$part = 'sports';

		// } elseif (is_tax($tax, 'news')) {
		// 	$page_id = 181897;
		// 	$part = 'news';

		// } elseif (is_tax($tax, 'TV')){
		// 	$page_id = 181899;
		// 	$part = 'TV';
		// } else {
			$page_id = 181890;
			$part = 'home';

		//}

		//
		// get the hero image layout
		//
		$num_hero 	= get_post_meta($page_id, 'got_hero_layout', true);

		if ( false === ( $header_menu_results = get_transient( $part . '_header_menu_results' ) ) ) {

			$i 			= 1;
			
			//
			// loop through the posts and load up an array
			//
			while ( $i <= $num_hero ) {
				//
				// get the post ID
				//
				$ids[$i]['hero_id'] = get_post_meta($page_id, 'got_hero_layout_' . $i, true);
				
				//
				// get the term ID, nice name and slug if its available
				//
				if ($term_id = get_post_meta($ids[$i]['hero_id'][0], 'pinned_tag', true)) {
					$ids[$i]['term'] = get_term($term_id, 'post_tag', ARRAY_A);
					
					if($ids[$i]['term']) 
						$ids[$i]['term']['url'] = get_term_link($ids[$i]['term']['slug'], 'post_tag');
				
				}

				//print_r($ids[$i]);

				//
				//	get the featured image or the first image if there is no featured image
				//
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $ids[$i]['hero_id'][0] ), 'full');

				if ( $image ) {
					$ids[$i]['featured_image'] 	= $image[0];
				} else {
					$ids[$i]['featured_image'] 	= get_first_image($ids[$i]['hero_id'][0]);
				}

				$i++;
			}

			set_transient( $part . '_header_menu_results', $header_menu_results, 60*60*1 );

		}	

		echo '<section id="hero">';
			echo '<div class="row">';
				echo '<div class="twentyfour columns">';
					echo '<ul class="no-list cf hero_layout_' . $num_hero .'">';
						include( locate_template('/parts/shared/homepage/hero/hero_' . $num_hero . '.php', false, false ) ); 
					echo '</ul>';
				echo '</div>';
			echo '</div>';
		echo '</section>';

	}

	//facebook
	add_action('wp_head', 'add_fb_open_graph_tags');

	function add_fb_open_graph_tags() {
		if (is_single()) {
			global $post;
			if(get_the_post_thumbnail($post->ID, 'thumbnail')) {
				$thumbnail_id = get_post_thumbnail_id($post->ID);
				$thumbnail_object = get_post($thumbnail_id);
				$image = $thumbnail_object->guid;
			} else {	
				$image = ''; // Change this to the URL of the logo you want beside your links shown on Facebook
			}
			//$description = get_bloginfo('description');
			$description = my_excerpt( $post->post_content, $post->post_excerpt );
			$description = strip_tags($description);
			$description = str_replace("\"", "'", $description);
	?>
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo $image; ?>" />
	<meta property="og:url" content="<?php the_permalink(); ?>" />
	<meta property="og:description" content="<?php echo $description ?>" />
	<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />

	<?php 	
		}
	}

	function my_excerpt($text, $excerpt){
	
	    if ($excerpt) return $excerpt;

	    $text = strip_shortcodes( $text );

	    $text = apply_filters('the_content', $text);
	    $text = str_replace(']]>', ']]&gt;', $text);
	    $text = strip_tags($text);
	    $excerpt_length = apply_filters('excerpt_length', 55);
	    $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	    $words = preg_split("/[\n
		 ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	    if ( count($words) > $excerpt_length ) {
	            array_pop($words);
	            $text = implode(' ', $words);
	            $text = $text . $excerpt_more;
	    } else {
	            $text = implode(' ', $words);
	    }

	    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
	}

	// function return_tags_cats_and_verticals() {
	// 	global $post;

	// }
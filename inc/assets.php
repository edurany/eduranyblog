<?php
	
	/*  Add support for the multiple Post Formats  */
	add_theme_support( 'post-formats', array('gallery', 'link', 'quote', 'audio', 'video', 'status')); 


	/*  Widgets  */
	include_once 'widgets/widgets.php';   // Register widget
	include_once "widgets/bl_tabs.php"; // Tabs: (Recent posts, Recent comments, Tags)
	include_once "widgets/bl_socialbox.php"; // Social network links
	include_once "widgets/bl_tweets.php"; // Display recent tweets
	include_once "widgets/bl_google_ads.php"; // Display ads
	include_once "widgets/bl_googlebadge.php"; // Display recent tweets
	include_once "widgets/bl_instagram.php"; // Display recent instagram images
	include_once "widgets/bl_newsletter.php"; // Display recent instagram images
	include_once "widgets/bl_likebox.php"; // Display a facebook likebox
	include_once "widgets/bl_flickr.php"; // Display a recent flickr images
	include_once "widgets/bl_html.php"; // Display HTML
	include_once "widgets/bl_author.php"; // Display Author Badge
	include_once "widgets/bl_featured_post.php"; // Display Featured Post
	include_once "widgets/bl_social_counter.php"; // Display Featured Post
	include_once "widgets/bl_imagebox.php"; // Display Image Box
	include_once "widgets/bl_category.php"; // Display Categories

	include_once 'theme-options.php'; // Load Theme Options Panel
	include_once 'custom-css.php'; // Load Theme Options Panel
	include_once 'meta-box.php'; // Load Meta Boxes

	/* Bootstrap type menu  */
	require_once 'bootstrap-walker.php';


	/* Enqueue Styles and Scripts  */
	if(!function_exists('breeze_assets')){
		function breeze_assets()  { 

			$protocol 			= is_ssl() ? 'https' : 'http';
			$enable_rtl 		= of_get_option('enable_rtl', false);

			// add theme css
			wp_enqueue_style( 'bluth-style', get_stylesheet_uri() );
			// if RTL enabled
			if($enable_rtl){ wp_enqueue_style( 'bluth-rtl', get_template_directory_uri() . '/assets/css/style-rtl.css' ); }

			// add theme scripts
			wp_enqueue_script( 'blu-theme', get_template_directory_uri() . '/assets/js/theme.min.js', array('jquery'), BREEZE_VERSION, true );
			wp_enqueue_script( 'bluth-plugins', get_template_directory_uri() . '/assets/js/plugins.js', array('jquery'), BREEZE_VERSION, true );

			// Assets
			add_action( 'wp_head', 'blu_add_open_graph_tags',99); 

			// Localize Script
			wp_localize_script( 'blu-theme', 'blu', array( 
				// Variable
				'site_url' => get_site_url(),
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'menuhover' => of_get_option('menu_hover'),
				'disable_fixed_header' => of_get_option('disable_fixed_header'),
				// Locale
				'locale' => array(
			    	'no_search_results' => __( 'No results match your search.', 'bluth' ),
			    	'searching' => __( 'Searching...', 'bluth'),
			    	'search_results' => __( 'Search Results', 'bluth'),
			    	'see_all' => __( 'see all', 'bluth'),
			    	'loading' => __( 'Loading...', 'bluth'),
			    	'no_more_posts' => __( 'No more posts', 'bluth'),
			    	'subscribe' => __( 'Subscribe!', 'bluth'),
			    	'see_more_articles' => __( 'See more articles', 'bluth'),
			    	'no_email_provided' => __( 'No email provided', 'bluth'),
			    	'thank_you_for_subscribing' => __( 'Thank you for subscribing!', 'bluth'),
				)
			));

			$fonts = array();
			$fonts['heading_font'] 	= of_get_option('heading_font', false);
			$fonts['text_font'] 	= of_get_option('text_font', false);
			$fonts['menu_font'] 	= of_get_option('menu_font', false);
			$fonts['brand_font'] 	= of_get_option('brand_font', false);

			// defaults
			$heading_font 	= 'Crete+Round:400,400italic';
			$text_font 		= 'Lato:400,700,400italic';

			// empty font array
			$font_names 	= array();
			$font_subset 	= array();
			$subset_array 	= array();

			foreach ($fonts as $key => $value) {
				if($value){
					$selected_font = explode('&subset=', $value);
					$font_names[] = str_replace(' ', '+', $selected_font[0]);
					if(count($selected_font) > 1){
						$font_subset = explode(',', $selected_font[1]);
						array_fill_keys($font_subset, $font_subset);
						$subset_array = array_merge($subset_array, $font_subset);
					}
				}
			}
			$subset_array = array_unique($subset_array);

			wp_enqueue_style( 'bluth-googlefonts', $protocol.'://fonts.googleapis.com/css?family='.(!empty($font_names) ? implode('|', $font_names) : $text_font.'|'.$heading_font) . (!empty($subset_array) ? '&subset='.implode(',', $subset_array) : '')  );	

		    if ( is_singular() && get_option( 'thread_comments' ) )
		        wp_enqueue_script( 'comment-reply' );			
		}
	}
	function breeze_admin_assets(){
		wp_enqueue_style( 'cdlayout-style', get_template_directory_uri() . '/assets/css/style-admin.css', array(), NULL, 'all' );   
		wp_enqueue_script('hrw',  get_template_directory_uri() . '/assets/js/admin-script.js', array( 'jquery' ), BREEZE_VERSION, true);

		// Localize Script
		wp_localize_script( 'hrw', 'blu', array( 
			// Variable
			'site_url' => get_site_url(),
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		));
	}
	add_action( 'wp_enqueue_scripts', 'breeze_assets' ); 			// Register this fxn and allow Wordpress to call it automatcally in the header
	add_action( 'admin_enqueue_scripts', 'breeze_admin_assets' ); 	// Register this fxn and allow Wordpress to call it automatcally in the admin header

	// load language
	load_theme_textdomain( 'bluth', get_template_directory() . '/inc/lang' );
	/*  Add Rss feed support to Head section  */
	add_theme_support( 'automatic-feed-links' );

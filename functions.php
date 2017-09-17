<?php
	// Define the version so we can easily replace it throughout the theme
	define( 'BREEZE_VERSION', 1.5 );
	define( 'BLUTHEMES', true );	

	// Error reporting ON
	// ini_set('display_errors', '1'); 
	// error_reporting(E_ALL | E_STRICT);
	/*  Set the content width based on the theme's design and stylesheet  */
	if ( !isset( $content_width ) ){ $content_width = 750; }

			
	/*  Register main menu for Wordpress use  */
	if(!function_exists('bluth_register_nav_menu')){
		function bluth_register_nav_menu() {
			register_nav_menus(  array( 'primary'	=>	'Primary Menu' ) ); // Register the Primary menu  
		}
	}
	add_action( 'after_setup_theme', 'bluth_register_nav_menu' );

	/* Bluthcodes */
	// only load if there isn't a plugin already loaded
	if(!function_exists('bluth_pullquote')){
		include_once 'assets/plugins/bluthcodes/codes.php'; 
	}
	/* Custom bluth assets  */
	require_once('inc/assets.php');
	/* Custom bluth functions  */
	require_once('inc/custom-functions.php');
	/* Blu Portfolio */
	include_once 'assets/plugins/blu_portfolio/blu-portfolio.php'; 
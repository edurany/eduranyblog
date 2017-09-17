<!DOCTYPE html>
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" /><?php
// check if SEO plugin support is active
if ( of_get_option('seo_plugin') ){ ?>
	<title><?php wp_title( '|', true, 'right' ); ?></title><?php
}

/* Apple touch icon */
echo of_get_option('apple_touch_icon') ? '<link rel="apple-touch-icon" href="' . of_get_option('apple_touch_icon') . '" />' : ''; ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php
//render google tracking code if present
$google_analytics = of_get_option('google_analytics', false);
if($google_analytics){
	echo (strpos($google_analytics, '<script') === false) ? '<script>'.of_get_option('google_analytics').'</script>' : of_get_option('google_analytics');
}

// get the layout of the page
$layout = of_get_option('side_bar', 'right_side');

global $blu_css_options;
wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="bl_search_overlay"></div> <?php 
	// Facebook Javascript SDK
	if(of_get_option('facebook_app_id')){ ?>
		<div id="fb-root"></div>
		<script>
		function get_facebook_sdk(){
			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=<?php echo of_get_option('facebook_app_id'); ?>";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		}
		jQuery(function(){
			get_facebook_sdk();
		});
		</script>
	<?php }	 

	// background image or pattern
	switch (of_get_option('background_mode')) {
		case 'image':
			if(of_get_option('background_image')){
				// echo '<div class="bl_background">'.(of_get_option('show_stripe') ? '<div id="stripe"></div>' : ''). '<img src="'.of_get_option('background_image').'"></div>';
				echo (of_get_option('show_stripe') ? '<div id="stripe"></div>' : '');
				echo '<div style="background-image: url(\''.of_get_option('background_image').'\')" id="background_image"></div>';
			}
		break;
		case 'pattern':
			if( of_get_option('background_pattern_custom') ){
				echo '<div style="background-image: url(\''.of_get_option('background_pattern_custom').'\')" id="background_pattern"></div>';
			
			}elseif (of_get_option('background_pattern')) {
				echo '<div style="background-image: url(\''.get_template_directory_uri() . '/assets/img/pattern/large/'.of_get_option('background_pattern').'\')" id="background_pattern"></div>';
			}
		break;
	}
?>
<?php
	// Advert above header
	$ad_header_mode = of_get_option('ad_header_mode', 'none');

	if($ad_header_mode != 'none'){
		echo '<div class="above_header">';
			if($ad_header_mode == 'image'){
				echo '<a href="'.of_get_option('ad_header_image_link').'" target="_blank"><img src="'.of_get_option('ad_header_image').'"></a>';
			}elseif($ad_header_mode == 'html'){
				echo apply_filters('the_content',do_shortcode(of_get_option('ad_header_code')));
			}
		echo '</div>';
	}
?>

<div id="page" class="site">
	<?php do_action( 'before' ); 
	$header_class = of_get_option( 'header_type', 'header_normal' );
	$masthead_group_class = '';
	if(of_get_option( 'header_type' ) == 'header_normal'){
		$header_class .= ' container';
	}else if( of_get_option( 'header_type' ) == 'header_background_full_width' ){
		$masthead_group_class = 'container';
	}
	$header_class .= ' header_background_' . of_get_option( 'header_background', 'header_normal' );
	$masthead_container_class = '';
	$masthead_class = '';
	$masthead_background_style = '';
/*	// add classes if the header style is image
	if( of_get_option( 'header_background' ) == 'image' ) {
		$masthead_class .= 'header-style-'.of_get_option( 'header_background', 'color' );
		$masthead_background_style .= "background-image:url('".of_get_option( 'header_background_image' )."')";
		$masthead_group_class .= ' ';
	}else{
		$masthead_group_class .= ' ';
	} 
	// if the header layout is full_background_width or full_width (no container) 
	if( of_get_option( 'header_type' ) == 'header_background_full_width' ){
		// remove the container from the original one
		$masthead_container_class = '';
		$masthead_group_class = ' container';
	}
	else if( of_get_option( 'header_type' ) == 'header_full_width' ){
		// remove the container
		$masthead_container_class = '';
	}*/
	?>
	<div id="masthead" class="masthead-container <?php echo $header_class; ?>">
		<header role="banner" class="<?php echo $masthead_class; ?>">
			<div class="masthead-background box clearfix" style="<?php echo $masthead_background_style; ?>"></div>
			<div class="masthead-group clearfix <?php echo $masthead_group_class; ?>">
			    	<!-- Brand and toggle get grouped for better mobile display -->
			        <div class="navbar-header">
			            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			                <span class="sr-only">Toggle navigation</span>
			                <i class="icon-menu-1"></i>
			            </button> <?php 
						$logo = of_get_option('logo', '' );
						if ( !empty( $logo ) ) { ?>
							<a class="navbar-brand brand-image" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo $logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><h1><?php if(!of_get_option('disable_description')){ ?><small><?php bloginfo( 'description' ); ?></small><?php } ?></h1></a><?php 
						}else{ ?>
							<a class="navbar-brand brand-text" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><h1><?php bloginfo( 'name' ); ?><?php if(!of_get_option('disable_description')){ ?><small><?php bloginfo( 'description' ); ?></small><?php } ?></h1></a> <?php 
						}  ?>
			        </div>  <?php
			        if(!of_get_option('disable_search')){ ?>
				        <div class="blu_search pull-right hidden-sm hidden-xs">
							<?php echo get_search_form(); ?>
						</div><?php 
					} ?>
					<nav class="pull-right" role="navigation"> <?php
				            wp_nav_menu( array(
				                // 'menu'              => 'primary',
				                'theme_location'    => 'primary',
				                'depth'             => 4,
				                'container'         => 'div',
				                'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
				                'menu_class'        => 'nav navbar-nav',
				                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
				                'walker'            => new wp_bootstrap_navwalker())
				            ); ?>
						
					</nav>

				<!-- 	This file is part of a WordPress theme for sale at ThemeForest.net.
						See: http://themeforest.net/item/breeze-personal-minimalist-wordpress-blog-theme/5423780
						Copyright 2013 Bluthemes 	-->
			
			</div>
		</header><!-- #masthead .site-header -->
	</div>
	<div id="main" class="container">
		<div id="primary" class="row <?php echo $layout; ?>">


<?php
function bluth_custom_css() {
global $blu_css_options;

	$blu_css_options = array(
		'custom_color_picker'				=> of_get_option('custom_color_picker'),
		'disable_link_background' 	=> of_get_option('disable_link_background'),
		'predefined_theme'					=> of_get_option('predefined_theme'),
		'text_font_size'						=> of_get_option('text_font_size'),
		'text_font_spacing'					=> of_get_option('text_font_spacing'),
		'theme_color' 							=> of_get_option('theme_color'),
		'background_mode' 					=> of_get_option('background_mode'),
		'background_color' 					=> of_get_option('background_color'),
		'header_color' 							=> of_get_option('header_color'),
		'header_font_color' 				=> of_get_option('header_font_color'),
		'header_background' 				=> of_get_option('header_background'),
		'header_background_image' 			=> of_get_option('header_background_image'),
		'post_header_color' 				=> of_get_option('post_header_color'),
		'widget_header_color' 			=> of_get_option('widget_header_color'),
		'widget_header_font_color' 	=> of_get_option('widget_header_font_color'),
		'footer_color' 							=> of_get_option('footer_color'),
		'footer_header_color' 			=> of_get_option('footer_header_color'),
		'footer_font_color' 				=> of_get_option('footer_font_color'),
		'standard_post_color' 			=> of_get_option('standard_post_color'),
		'gallery_post_color' 				=> of_get_option('gallery_post_color'),
		'image_post_color' 					=> of_get_option('image_post_color'),
		'link_post_color' 					=> of_get_option('link_post_color'),
		'quote_post_color' 					=> of_get_option('quote_post_color'),
		'audio_post_color' 					=> of_get_option('audio_post_color'),
		'video_post_color' 					=> of_get_option('video_post_color'),
		'status_post_color' 				=> of_get_option('status_post_color'),
		'sticky_post_color' 				=> of_get_option('sticky_post_color'),
		'anchor_anim' 							=> of_get_option('anchor_anim'),
		'custom_container_width' 			=> of_get_option('custom_container_width'),
		'custom_css' 								=> html_entity_decode(of_get_option('custom_css')),
		);

// predefined color themes
if(!$blu_css_options['custom_color_picker'])
{
	switch($blu_css_options['predefined_theme']){
		case 'default';	
			$blu_css_options['theme_color'] 				= '#f35353';
			// if the user hasn't specified a color himself, then put in a predefined color, else let the user decide
			if($blu_css_options['background_mode'] != 'color'){
				$blu_css_options['background_color'] 		= '#EDEDED';
			}
			$blu_css_options['header_color'] 				= '#FFFFFF';
			$blu_css_options['header_font_color'] 			= '#555555';
			$blu_css_options['post_header_color'] 			= '#333333';
			$blu_css_options['widget_header_color'] 		= '#FFFFFF';
			$blu_css_options['widget_header_font_color'] 	= '#333333';
			$blu_css_options['footer_color'] 				= '#333333';
			$blu_css_options['footer_header_color'] 		= '#FFFFFF';
			$blu_css_options['footer_font_color'] 			= '#FFFFFF';
		break;
	}
}

if(!empty($blu_css_options)){ ?>
<style type="text/css">
	<?php 

	if(!empty($blu_css_options['text_font_size'])){ ?>
	 	.entry-content p, 
	 	.entry-content ul li, 
	 	.entry-content p, 
	 	.entry-content ol li{ 
	 		font-size: <?php echo $blu_css_options['text_font_size'] ?>; 
	 	}<?php
	}
	if(!empty($blu_css_options['text_font_spacing'])){ ?>
	 	.entry-content p, 
	 	.entry-content ul li, 
	 	.entry-content p, 
	 	.entry-content ol li{ 
	 		line-height:<?php echo $blu_css_options['text_font_spacing']; ?>;
	 	} <?php
	}

	if(!empty($blu_css_options['theme_color'])){ ?>
	 	.nav > li.open > a, 
	 	.nav > li > a:hover, 
	 	.nav > li.open > a:hover, 
	 	.nav > li > a:focus, 
	 	.nav > li.open > a:focus, 
	 	.nav > li.open > a:focus, 
	 	.nav > li.open > a span, 
	 	.dropdown-menu > li > a:hover, 
	 	.dropdown-menu > li > a:focus { 
	 		color:<?php echo $blu_css_options['theme_color'] ?>!important;
	 	} 
	 	.nav li a:hover .caret, 
	 	.nav li.open a .caret, 
	 	.nav li.open a:hover .caret, 
	 	.nav li.open a:focus .caret{ 
	 		border-bottom-color:<?php echo $blu_css_options['theme_color']; ?>;
	 		border-top-color:<?php echo $blu_css_options['theme_color']; ?>;
	 	}
	 	.top-color, 
	 	.top-line, 
	 	.nav-line,
	 	.widget_tag_cloud .tagcloud a:hover,
	 	.gallery-item a:after,
	 	article.type-portfolio .moretag:hover, 
	 	article.type-portfolio .more-tag:hover{ 
	 		background-color:<?php echo $blu_css_options['theme_color']; ?>;
	 	} 
	 	.site-footer #footer-body .widget_nav_menu a:hover, 
	 	.site-footer #footer-body .widget_archive a:hover, 
	 	.site-footer #footer-body .widget_tag_cloud a:hover, 
	 	.site-footer #footer-body .widget_recent_entries a:hover, 
	 	.site-footer #footer-body .widget_recent_comments li a + a:hover,
	 	.site-footer #footer-body .widget_meta a:hover, 
	 	.site-footer #footer-body .widget_categories a:hover, 
	 	.site-footer #footer-body .widget_pages a:hover, 
	 	#bl_side_tags .bl_tab_tag:hover,
	 	.pagination > a:hover{ 
	 		background-color:<?php echo  $blu_css_options['theme_color']; ?>;
	 	} 
	 	.dropdown-menu{ 
	 		border-top: 2px solid <?php echo $blu_css_options['theme_color']; ?>;
	 	} 
	 	.pagination > a{ 
	 		border-color: <?php echo $blu_css_options['theme_color']; ?>;
	 	} 
	 	.bl_tabs ul li .tab_text a span, 
	 	a, 
	 	a:hover, 
	 	a:focus{ 
	 		color: <?php echo $blu_css_options['theme_color']; ?>;
	 	} <?php
	}
	if(!empty($blu_css_options['background_color'])){ ?>
	 	body{  background:<?php echo $blu_css_options['background_color']; ?>; }<?php
	}
	if(!empty($blu_css_options['post_header_color'])){ ?>
	 	.entry-title a{ color:<?php echo $blu_css_options['post_header_color']; ?>; }  <?php
	}
	if(!empty($blu_css_options['header_color'])){ ?>
	 	.masthead-background, 
	 	.navbar-inverse .navbar-inner,
	 	.dropdown-menu,
	 	.widget-head{ 
	 		background-color:<?php echo $blu_css_options['header_color']; ?>; 
	 	}  <?php
	}
	if(!empty($blu_css_options['header_font_color'])){ ?>
	 	#masthead .nav a, 
	 	#masthead h1, 
	 	#masthead h1 small{
	 		color:<?php echo $blu_css_options['header_font_color']; ?>; 
	 	} 
	 	.nav a .caret{ 
	 		border-bottom-color:<?php echo $blu_css_options['header_font_color']; ?>; 
	 		border-top-color:<?php echo $blu_css_options['header_font_color']; ?>; 
	 	}  <?php
	}
	if(!empty($blu_css_options['widget_header_color'])){ ?>
	 	.widget-head{ background: <?php echo $blu_css_options['widget_header_color']; ?>; }  <?php
	}
	if(!empty($blu_css_options['widget_header_font_color'])){ ?>
	 	.widget-head{color:<?php echo $blu_css_options['widget_header_font_color']; ?>; }  <?php
	}
	if(!empty($blu_css_options['footer_color'])){ ?>
	 	footer.site-footer{ background:<?php echo $blu_css_options['footer_color']; ?> } <?php
	}
	if(!empty($blu_css_options['footer_header_color'])){ ?>
		#footer-body .widget-head{color:<?php echo $blu_css_options['footer_header_color']; ?>; } <?php
	}
	if(!empty($blu_css_options['footer_font_color'])){ ?>
	 	#footer-body > div ul li a, 
	 	footer.site-footer > * { 
	 		color:<?php echo $blu_css_options['footer_font_color']; ?>; } <?php
	}

	$post_format_color['standard'] 	= $blu_css_options['standard_post_color'];
	$post_format_color['gallery'] 	= $blu_css_options['gallery_post_color'];
	$post_format_color['image'] 	= $blu_css_options['image_post_color'];
	$post_format_color['quote'] 	= $blu_css_options['quote_post_color'];
	$post_format_color['link'] 		= $blu_css_options['link_post_color'];
	$post_format_color['audio'] 	= $blu_css_options['audio_post_color'];
	$post_format_color['video'] 	= $blu_css_options['video_post_color'];
	$post_format_color['status'] 	= $blu_css_options['status_post_color'];

	foreach($post_format_color as $name => $color){ ?>

		.post-format-<?php echo $name ?>,
		.format-<?php echo $name ?> .post-meta ~ * a, 
		.format-<?php echo $name ?> .post-meta a:hover, 
		.format-<?php echo $name ?> .entry-title a:hover,
		.format-<?php echo $name ?> a.moretag,
		.format-<?php echo $name ?> a.more-link{
			color: <?php echo $color ?>;
		}
		.tab_<?php echo $name ?>,  
		.format-<?php echo $name ?> a.moretag:hover,
		.format-<?php echo $name ?> a.more-link:hover, 
		.format-<?php echo $name ?> .entry-image .entry-category a,
		.format-<?php echo $name ?> .entry-image > a:after{
			background-color: <?php echo $color ?>;
		}
		.format-<?php echo $name ?> *::selection{
			color: #FFFFFF;
			background-color: <?php echo $color ?>;
		}
		.format-<?php echo $name ?> *::-moz-selection{
			color: #FFFFFF;
			background-color: <?php echo $color ?>;
		}
		.format-<?php echo $name ?> a.moretag,
		.format-<?php echo $name ?> a.more-link{
			border-color: <?php echo $color; ?>;
		} 
		.format-<?php echo $name ?> footer.entry-meta .post-tags li a:hover,
		.post-format-badge.post-format-<?php echo $name; ?>{
			color: <?php echo $color ?>; 
		}<?php
		if(empty($blu_css_options['disable_link_background'])) { ?>
			.format-<?php echo $name ?> p a, 
			.format-<?php echo $name ?> p a:hover span:before, 
			.format-<?php echo $name ?> p a:focus span:before, 
			.widget_tag_cloud .tagcloud a:hover{ 
				background-color: <?php echo $color ?>; 
				color: #FFFFFF;
			}<?php
		}
		else{ ?>
			article.type-post.format-<?php echo $name ?> p a, 
			article.type-post.format-<?php echo $name ?> p a:hover span:before, 
			article.type-post.format-<?php echo $name ?> p a:focus span:before{
				color: <?php echo $color ?>; 
			}<?php
		}
		if(empty($blu_css_options['disable_link_animation'])) { ?>
			article.type-post p a{
				margin:0;
				padding:0;
				display:inline;
				font-weight: bold;
			}
			article.type-post p a,
			footer.entry-meta .post-tags li a:hover{
			  transform: none;
			  -ms-transform: none;
			  -webkit-transform: none;
			}<?php
		}
	} ?>
	/* sticky post */
	article.sticky:before{
		border-color: <?php echo $blu_css_options['sticky_post_color']; ?> <?php echo $blu_css_options['sticky_post_color']; ?> transparent;
	} <?php
	if(!empty($blu_css_options['header_background']) && $blu_css_options['header_background'] == 'image'){ ?>
		.masthead-background{
			background-image:url('<?php echo $blu_css_options["header_background_image"]; ?>');
		} <?php
	}

	if(!empty($blu_css_options['sticky_post_color'])){
		echo '.sticky .post-format-badge{color: '.$blu_css_options['sticky_post_color'].'};';
		echo '.sticky .post-meta ~ * a, .sticky .post-meta a:hover, .sticky .entry-title a:hover{color: '.$blu_css_options['sticky_post_color'].';}';
	}

	echo (!empty($blu_css_options['custom_container_width'])) ? '.container{ width:' . $blu_css_options['custom_container_width'] . 'px; }' : '';

	echo (!empty($blu_css_options['custom_css'])) ? $blu_css_options['custom_css'] : '';

	?>
</style>
<?php }
}
add_action( 'wp_head', 'bluth_custom_css', 100 );
?>
<?php

if (function_exists('register_sidebar')) {
	
	/* Home Sidebar */
	register_sidebar(
		array(				
			'id' => 'home_sidebar', 					
			'name' => 'Home Sidebar',				
			'description' => 'Sidebar that displays on your home/blog/front-page', 
			'before_widget' => '<div id="%1$s" class="box row %2$s">',	
			'after_widget' => '</div>',	
			'before_title' => '<h3 class="widget-head">',	
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);
	/* Home Sidebar (Sticky) */
	register_sidebar(
		array(				
			'id' => 'home_sidebar_sticky', 					
			'name' => 'Home Sidebar (Sticky)',				
			'description' => 'Sidebar that displays on your home/blog/front-page, Elements in here will stick to the top when scrolled to', 
			'before_widget' => '<div id="%1$s" class="box row %2$s">',	
			'after_widget' => '</div>',	
			'before_title' => '<h3 class="widget-head">',	
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);
	/* Post Sidebar */
	register_sidebar(
		array(				
			'id' => 'post_sidebar', 					
			'name' => 'Post Sidebar',				
			'description' => 'Sidebar that displays with a single post', 
			'before_widget' => '<div id="%1$s" class="box row %2$s">',	
			'after_widget' => '</div>',	
			'before_title' => '<h3 class="widget-head">',	
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);
	/* Post Sidebar (Sticky) */
	register_sidebar(
		array(				
			'id' => 'post_sidebar_sticky', 					
			'name' => 'Post Sidebar (Sticky)',				
			'description' => 'Sidebar that displays with a single post, Elements in here will stick to the top when scrolled to', 
			'before_widget' => '<div id="%1$s" class="box row %2$s">',	
			'after_widget' => '</div>',	
			'before_title' => '<h3 class="widget-head">',	
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);
	/* Page Sidebar */
	register_sidebar(
		array(				
			'id' => 'page_sidebar', 					
			'name' => 'Page Sidebar',				
			'description' => 'Sidebar that displays on a single page', 
			'before_widget' => '<div id="%1$s" class="box row %2$s">',	
			'after_widget' => '</div>',	
			'before_title' => '<h3 class="widget-head">',	
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);
	/* Page Sidebar (Sticky) */
	register_sidebar(
		array(				
			'id' => 'page_sidebar_sticky', 					
			'name' => 'Page Sidebar (Sticky)',				
			'description' => 'Sidebar that displays on a single page, Elements in here will stick to the top when scrolled to', 
			'before_widget' => '<div id="%1$s" class="box row %2$s">',	
			'after_widget' => '</div>',	
			'before_title' => '<h3 class="widget-head">',	
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);
	/* Portfolio Sidebar */
	register_sidebar(
		array(				
			'id' => 'portfolio_sidebar', 					
			'name' => 'Portfolio Sidebar',				
			'description' => 'Sidebar that displays on a single portfolio item', 
			'before_widget' => '<div id="%1$s" class="box row %2$s">',	
			'after_widget' => '</div>',	
			'before_title' => '<h3 class="widget-head">',	
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);
	/* Portfolio Sidebar (Sticky) */
	register_sidebar(
		array(				
			'id' => 'portfolio_sidebar_sticky', 					
			'name' => 'Portfolio Sidebar (Sticky)',				
			'description' => 'Sidebar that displays on a single portfolio item, Elements in here will stick to the top when scrolled to', 
			'before_widget' => '<div id="%1$s" class="box row %2$s">',	
			'after_widget' => '</div>',	
			'before_title' => '<h3 class="widget-head">',	
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);

	/* Footer Widgets */
	$footer_widgets_num = wp_get_sidebars_widgets();
	$footer_widgets_num = (isset($footer_widgets_num['footer-widgets'])) ? count( $footer_widgets_num['footer-widgets']) : 0;

	switch ($footer_widgets_num) {
		case 1:
			$footer_widgets_num = '12';
		break;
		case 2:
			$footer_widgets_num = '6';
		break;
		case 3:
			$footer_widgets_num = '4';
		break;
		case 4:
			$footer_widgets_num = '3';
		break;
		case 5:
			$footer_widgets_num = '2 offset1';
		break;
		case 6:
			$footer_widgets_num = '2';
		break;
		case 7:
			$footer_widgets_num = '1';
		break;
		case 8:
			$footer_widgets_num = '1 offset2';
		break;
		case 11:
			$footer_widgets_num = '1';
		break;
		case 12:
			$footer_widgets_num = '1';
		break;
		default:
			$footer_widgets_num = '1';
		break;
	}

	register_sidebar(array(
	   'name' => __('Footer Widgets','bluth_admin' ),
	   'id'   => 'footer-widgets',
		'description'   => __( 'There are 4 slots available in the footer','bluth_admin' ),
		'before_widget' => '<div id="%1$s" class="col-md-'.$footer_widgets_num.' col-lg-'.$footer_widgets_num.' pad-md-10 pad-lg-10 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-head">',
		'after_title'   => '</h3>'
   	));
}
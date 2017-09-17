<?php
	/* Template Name: Portfolio */

	/*
	*	PAGE LAYOUT
	*/
	$layout_class = ' col-xs-12 col-sm-12 col-md-12 col-lg-12';
	$page_layout = !get_post_meta( $post->ID, 'bluth_page_layout', true ) ? of_get_option('post_page_layout') : get_post_meta( $post->ID, 'bluth_page_layout', true );
	if($page_layout == 'left_side'){
		$layout_class = ' pull-right col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}elseif($page_layout == 'right_side'){
		$layout_class = ' col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}
	get_header(); 

	$hide_title = get_post_meta( $post->ID, 'bluth_page_hide_title', 'off' );
	$post_subtitle = get_post_meta( $post->ID, 'bluth_page_subtitle', 'off' );
 
	/*
	*	ADVERTISING ABOVE CONTENT
	*/
		$ad_content_placement 	= of_get_option('ad_content_placement', array('home' => true,'pages' => true,'posts' => true));
		$ad_content_mode 		= of_get_option('ad_content_mode', 'none');
		$ad_content_box 		= of_get_option('ad_content_box', true);	
		$ad_content_padding 	= of_get_option('ad_content_padding', true);	

		if($ad_content_mode != 'none' and $ad_content_placement['pages'] == true){
			echo '<div class="above_content'.(($ad_content_box) ? ' box' : '').(($ad_content_padding) ? ' pad15' : '').'">';
				if($ad_content_mode == 'image'){
					echo '<a href="'.of_get_option('ad_content_image_link').'" target="_blank"><img src="'.of_get_option('ad_content_image').'"></a>';
				}elseif($ad_content_mode == 'html'){
					echo apply_filters('the_content',do_shortcode(of_get_option('ad_content_code')));
				}
			echo '</div>';
		} 


	$the_query = new WP_Query(array('posts_per_page' => 15, 'post_type' => 'blu-portfolio'));
	?>
		<div id="content" class="<?php echo of_get_option('portfolio_style'); ?>  portfolio portfolio-page <?php echo $layout_class; ?>" role="main">
			<?php if(!$hide_title){ ?> <h1 class="portfolio-title box pad35"><?php the_title(); ?></h1> <?php } ?>
			<div class="columns"><?php
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) { 
						$the_query->the_post(); 

						/*
						*	PORTFOLIO SETTINGS
						*/
						$portfolio_display_excerpt 		= of_get_option('portfolio_display_excerpt', true);	
						$project_link = get_post_custom_values('blu_portfolio_link');
						$client_name = get_post_custom_values('blu_portfolio_client');
						$client_link = get_post_custom_values('blu_portfolio_client_link');

						$category = get_the_terms( get_the_ID(), 'project-type' ); ?>
						<article class="type-page type-portfolio">
							<div class="portfolio-image" href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('featured_post'); ?>

								<div class="portfolio-buttons">
									<a href="<?php echo get_post_image(get_the_ID(), 'original', false); ?>" class="btn btn-mini bluth white portfolio-button lightbox"><?php _e('View Image', 'bluth'); ?></a>
									<a href="<?php echo the_permalink(); ?>" class="btn btn-mini bluth white portfolio-button"><?php _e('Details','bluth'); ?></a>
								</div>
							</div>
							<div class="portfolio-content box pad15">
								<h3>
									<a href="<?php the_permalink(); ?>" class="entry-title"><?php the_title(); ?> </a><?php 
									if($category){ 
										$category = current($category); ?>
										<small><a href="<?php echo get_term_link( $category->term_id, 'project-type' ); ?>"> <?php echo $category->name; ?> </a></small><?php
									} ?> 
								</h3><?php
								if($portfolio_display_excerpt){ ?>
									<p><?php the_excerpt(); ?></p><?php
								}
								if(!empty($project_link[0]) || !empty($client_name[0])){ ?>
									<ul><?php
										if(!empty($project_link[0])){ ?>
											<li><h5><?php _e('Project', 'bluth'); ?>:</h5> <a href="<?php echo $project_link[0]; ?>" target="_blank"><?php the_title(); ?></a></li><?php
										}
										if(!empty($client_name[0])){ ?>
											<li><h5><?php _e('Client', 'bluth'); ?>:</h5> <a href="<?php echo $client_link[0]; ?>" target="_blank"><?php echo $client_name[0]; ?></a></li><?php
										} ?>
									</ul><?php
								} ?>
							</div>
						</article><?php 
					} // while 
				}else{ 
		 			get_template_part( 'inc/posts/post-404' );
		 		} ?>
	 		</div> <!-- columns -->

		</div><!-- #content .site-content --><?php

		if($page_layout == 'right_side' || $page_layout == 'left_side'){ ?>
			<aside id="side-bar" class="post-sidebar col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="clearfix">
					<?php dynamic_sidebar( 'page_sidebar'); ?>
					<div id="page_sidebar_sticky" class="sticky_sidebar">
						<?php dynamic_sidebar( 'page_sidebar_sticky' ); ?>
					</div>
				</div>
			</aside> <?php
		}

get_footer(); ?>
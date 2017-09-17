<?php
	/**
	 * The template for displaying any single page.
	 *
	 */

	// Get the page layout
	$layout_class = ' col-xs-12 col-sm-12 col-md-12 col-lg-12';
	$page_layout = !get_post_meta( $post->ID, 'bluth_page_layout', true ) ? of_get_option('post_page_layout') : get_post_meta( $post->ID, 'bluth_page_layout', true );
	if($page_layout == 'left_side'){
		$layout_class = ' pull-right col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}elseif($page_layout == 'right_side'){
		$layout_class = ' col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}
	$hide_title = get_post_meta( $post->ID, 'bluth_page_hide_title', 'off' );
	$post_subtitle = get_post_meta( $post->ID, 'bluth_page_subtitle', 'off' );
	get_header(); 
 
	// Advert above content
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
?>
		<div id="content" class="<?php echo $layout_class; ?>" role="main">
			<?php if(have_posts()){ 
			
				while ( have_posts() ) : the_post(); 
				?>
				<article class="type-page "><?php
					get_template_part( 'inc/posts/post-thumbnail' ); ?>
					<div class="entry-container box">
						<div class="entry-content"><?php

						if($hide_title != 'on'){ ?>
							<h1 class="post-title"><?php the_title(); echo '<small>'.$post_subtitle.'</small>'; ?></h1><?php
					 	} ?>
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
							<footer class="entry-meta clearfix">
								<?php get_template_part( 'inc/meta-bottom' ); ?>
							</footer><!-- .entry-meta -->	
						</div><!-- the-content -->
					</div>
				</article>

				<?php endwhile; ?>

			<?php }else{ 
	 
	 				get_template_part( 'inc/posts/post-404' );
	
	 			} 
				// If comments are open or we have at least one comment, load up the default comment template provided by Wordpress
				if ( of_get_option('enable_page_comments') && (comments_open() || '0' != get_comments_number()) )
					comments_template( '', true );
			?>

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
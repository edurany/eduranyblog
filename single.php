<?php
	/**
	 * The template for displaying any single post.
	 *
	 */

	// Count view
	wpb_set_post_views(get_the_ID());
	// Get the page layout
	$layout_class = ' col-xs-12 col-sm-12 col-md-12 col-lg-12';
	$post_layout = !get_post_meta( $post->ID, 'bluth_post_layout', true ) ? of_get_option('post_page_layout') : get_post_meta( $post->ID, 'bluth_post_layout', true );
	if($post_layout == 'left_side'){
		$layout_class = ' pull-right col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}elseif($post_layout == 'right_side'){
		$layout_class = ' col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}

	// Advert above content
	$ad_content_placement 	= of_get_option('ad_content_placement', array('home' => true,'pages' => true,'posts' => true));
	$ad_content_mode 		= of_get_option('ad_content_mode', 'none');
	$ad_content_box 		= of_get_option('ad_content_box', true);	
	$ad_content_padding 	= of_get_option('ad_content_padding', true);

	get_header();	

	// check if the fromnext variable is there, if it is then add a class to the page for next post animation
	$extra_class = '';
	if (isset($wp_query->query_vars['fromnext'])){
		$extra_class = 'fromnext';
	}
	/* ADSPACE 01
	/***************/
	if($ad_content_mode != 'none' and $ad_content_placement['posts'] == true and is_single()){
		echo '<div class="above_content col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			echo '<div class="'.(($ad_content_box) ? ' box' : '').(($ad_content_padding) ? ' pad15' : '').'">';
				if($ad_content_mode == 'image'){
					echo '<a href="'.of_get_option('ad_content_image_link').'" target="_blank"><img src="'.of_get_option('ad_content_image').'"></a>';
				}elseif($ad_content_mode == 'html'){
					echo apply_filters('the_content',do_shortcode(of_get_option('ad_content_code')));
				}
			echo '</div>';
		echo '</div>';
	}

	$image_comment_class = of_get_option('disable_image_comments') ? '' : 'image-comment-on'; ?>
		<div id="content" class="<?php echo $image_comment_class.$layout_class; ?> " role="main"> <?php 
			if ( have_posts() ){
		 		while ( have_posts() ) : the_post();  ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class($extra_class); ?>><?php
						get_template_part( 'inc/posts/post-thumbnail' ); ?>
						<div class="entry-container box clearfix <?php echo $margin_class . ' ' . $layout; ?>">

							<div class="entry-content">
								<div class="post-title">
									<h1 class="entry-title"><?php the_title(); ?></h1>
									<div class="post-meta">
										<?php get_template_part( 'inc/meta-top' ); ?>
									</div>
								</div> <?php 
								if(get_post_format() == 'audio'){
									$audio_url = get_post_meta( $post->ID, 'blu_audio_url', true );
									if(strpos($audio_url,'.mp3') !== false){ echo do_shortcode('[audio mp3="'.$audio_url.'"][/audio]'); }
									else{ echo apply_filters( 'the_content', $audio_url); }
								}
								the_content(); 
								wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'bluth' ), 'after' => '</div>' ) ); ?>
								<footer class="entry-meta clearfix">
									<?php get_template_part( 'inc/meta-bottom' ); ?>
								</footer><!-- .entry-meta -->
								
							</div><!-- .entry-content -->

						</div><!-- .entry-container --> <?php 

				 	if(of_get_option('author_box')){ 
				 		$author_ID = get_the_author_meta('ID');
						if( of_get_option('author_box_image_'.$author_ID) ){ $author_image = 'background-image:url(' . of_get_option("author_box_image_".$author_ID) . '); background-size:cover;'; }else{ $author_image = 'background-image:none;'; } ?>
						<div class="author-meta box">
							<div class="author-image">
								<?php 
									if(!of_get_option('author_box_avatar_'.$author_ID)){
										echo '<img src="' . blu_get_avatar_url(get_avatar( get_the_author_meta( 'ID' ) , 120 ) ) . '">'; 
									}else{
										echo '<img src="' . of_get_option('author_box_avatar_'.$author_ID) . '">'; 
									}

								?>
							</div>
							<div class="author-body" style="<?php echo $author_image; ?>">

								<h2 class="vcard author"><span class="fn"><?php the_author_posts_link(); ?></span></h2>
								<p><?php the_author_meta('description'); ?></p>
							</div>
						</div> <?php 
					} ?>
					</article><!-- #post-<?php the_ID(); ?> -->
					<?php

					// show related posts by tag
					if(!of_get_option('disable_related_posts')){ 
					 	get_template_part( 'inc/related-posts' );
					}
				endwhile;

				comments_template( '', true );
				
				$next_post = get_adjacent_post( false, '', false ); 

				if( $next_post && !of_get_option('disable_pagination') ): 
					$next_post_url = $next_post->permalink; 
					$animate_class = '';
					if( get_post_format($next_post->ID) != 'video' and get_post_format($next_post->ID) != 'status' and get_post_format($next_post->ID) != 'gallery' and has_post_thumbnail($next_post->ID) ){
						$params = array('fromnext' => true);
						$animate_class = 'animate';
						$next_post_url = add_query_arg( $params, $next_post_url ); 
					}else{ $params = array(); } ?>
					<a href="<?php echo get_permalink( $next_post->ID ); ?>" class="single-pagination <?php echo $animate_class; ?> box" style="position: relative; z-index: 100; background-image: url('<?php echo get_post_image( $next_post->ID, 'sidebar-large', false ); ?>');">
						<h3><small><?php _e('Next Article', 'bluth'); ?></small><?php echo $next_post->post_title; ?></h3>
					</a> <?php 
				endif;
			}else{

				get_template_part( 'inc/posts/post-404' );

			} ?>
		</div><!-- #content .site-content --> <?php
		if($post_layout == 'right_side' || $post_layout == 'left_side'){ ?>
			<aside id="side-bar" class="post-sidebar col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="clearfix">
					<?php dynamic_sidebar( 'post_sidebar'); ?>
					<div id="post_sidebar_sticky" class="sticky_sidebar">
						<?php dynamic_sidebar( 'post_sidebar_sticky' ); ?>
					</div>
				</div>
			</aside> <?php
		}
get_footer(); // This fxn gets the footer.php file and renders it ?>

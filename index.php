<?php
/**
 * The template for displaying the home/index page.
 * This template will also be called in any case where the Wordpress engine 
 * doesn't know which template to use (e.g. 404 error)
 */

// Get the page layout
$layout_class = ' col-xs-12 col-sm-12 col-md-12 col-lg-12';
$layout = of_get_option('blog_layout');
if($layout == 'left_side'){
	$layout_class = ' pull-right col-xs-12 col-sm-12 col-md-8 col-lg-8';
}elseif($layout == 'right_side'){
	$layout_class = ' col-xs-12 col-sm-12 col-md-8 col-lg-8';
}

// $layout = of_get_option('blog_layout', 'right_side');
// $layout_class = ($layout == 'single') ? 'col-xs-12 col-sm-12 col-md-12 col-lg-12' : 'col-xs-12 col-sm-12 col-md-8 col-lg-8';
// Advert above content
$ad_posts_mode 			= of_get_option('ad_posts_mode', 'none');
$ad_posts_frequency 	= of_get_option('ad_posts_frequency', 'none');
$ad_posts_box 			= of_get_option('ad_posts_box', true);
$ad_content_placement 	= of_get_option('ad_content_placement', array('home' => true,'pages' => true,'posts' => true));
$ad_content_mode 		= of_get_option('ad_content_mode', 'none');
$ad_content_box 		= of_get_option('ad_content_box', true);
$ad_content_padding 	= of_get_option('ad_content_padding', true);

get_header(); 

	/* ADSPACE 03
	/***************/
	if( $ad_content_mode != 'none' and $ad_content_placement['home'] == true and ( is_home() or is_category() or is_tag() or is_front_page() )){
		echo '<div class="above_content col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			echo '<div class="'.(($ad_content_box) ? ' box' : '').(($ad_content_padding) ? ' pad15' : '').'">';
				if($ad_content_mode == 'image'){
					echo '<a href="'.of_get_option('ad_content_image_link').'" target="_blank"><img src="'.of_get_option('ad_content_image').'"></a>';
				}elseif($ad_content_mode == 'html'){
					echo apply_filters('the_content', do_shortcode(of_get_option('ad_content_code')));
				}
			echo '</div>';
		echo '</div>';
	} 
	if(is_category()){ ?>
		<div class="col-md-12">
			<div class="category-title box">
				<h1><?php single_cat_title(); ?></h1>
				<h5><?php echo category_description(); ?></h5>
			</div>
		</div><?php
	}
	?>
		<div id="content" class="<?php echo of_get_option('blog_style'); ?> <?php echo $layout_class ?>" role="main">
		<div class="columns"><?php 
			if( have_posts() ){ 
				$x = 1;
				while ( have_posts() ){
					the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php
						$post_format = get_post_format() == '' ? 'standard' : get_post_format(); ?>
						<!-- The Post Badge -->
						<!-- <div class="post-format-badge post-format-<?php echo $post_format; ?>"><i class="<?php echo of_get_option($post_format.'_icon'); ?>"></i></div> -->
						<?php

						get_template_part( 'inc/posts/post-thumbnail' ); ?>

						<div class="entry-container box">
							<div class="post-title <?php echo of_get_option('show_author_front') ? 'author-image-on' : ''; ?>">
								<!-- The Author -->
								<div class="post-author"><?php 
									if(of_get_option('show_author_front')){
										$author_ID = get_the_author_meta('ID');
										$author_name = get_the_author_meta('display_name');
										if(!of_get_option('author_box_avatar_'.$author_ID)){
											echo '<img src="' . blu_get_avatar_url(get_avatar( get_the_author_meta( 'ID' ) , 120 ) ) . '">';
										}else{
											echo '<img src="' . of_get_option('author_box_avatar_'.$author_ID) . '">'; 
										}
									} ?>
								</div>	
								<!-- The Title -->
								<h1 class="entry-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<div class="post-format-badge post-format-<?php echo $post_format; ?>"><i class="<?php echo of_get_option($post_format.'_icon'); ?>"></i></div>
								</h1>
								<!-- The Meta -->
								<div class="post-meta"><?php get_template_part( 'inc/meta-top' ); ?></div>
							</div>	
							<div class="entry-content"> <?php 
								if(get_post_format() == 'audio'){
									$audio_url = get_post_meta( $post->ID, 'blu_audio_url', true );
									if(strpos($audio_url,'.mp3') !== false){ echo do_shortcode('[audio mp3="'.$audio_url.'"][/audio]'); }
									else{ echo apply_filters( 'the_content', $audio_url); }
								}
								if(of_get_option('enable_excerpt')){
									the_excerpt();
								}else{
									the_content(__('Continue reading...', 'bluth')); 
								}
								wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'bluth' ), 'after' => '</div>' ) ); ?>
								<footer class="entry-meta clearfix">
									<?php get_template_part( 'inc/meta-bottom' ); ?>
								</footer><!-- .entry-meta -->
							</div><!-- .entry-content -->
						</div><!-- .entry-container -->
					</article><!-- #post-<?php the_ID(); ?> --><?php
					/* ADSPACE 02
					/***************/
					if($ad_posts_mode != 'none'){
						// take into account ad frequency
						if (($x % $ad_posts_frequency) == 0){
							switch ($ad_posts_mode) {
								case 'image':
									echo '<div class="'.(($ad_posts_box) ? 'box' : '').' between_posts"><a target="_blank" href="'.of_get_option('ad_posts_image_link').'"><img src="'.of_get_option('ad_posts_image').'"></a></div>';
								break;
								case 'html':
									echo '<div class="'.(($ad_posts_box) ? 'box' : '').' between_posts">'.apply_filters('shortcode_filter',do_shortcode(of_get_option('ad_posts_code'))).'</div>';
								break;
							}
						}
					}
					$x++;
				}

			}else{ 
				get_template_part( 'inc/posts/post-404' );
 			}  ?> 
			</div><!-- .columns -->
			<?php kriesi_pagination(); ?>
		</div><!-- #content --> <?php 

		if($layout == 'left_side' || $layout == 'right_side'){ ?>
			<aside id="side-bar" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="clearfix">
					<?php dynamic_sidebar( 'home_sidebar'); ?>
					<div id="home_sidebar_sticky" class="sticky_sidebar visible-lg visible-md">
						<?php dynamic_sidebar( 'home_sidebar_sticky'); ?>
					</div>
				</div>
			</aside> <?php 
		} ?>	
<?php get_footer(); ?>
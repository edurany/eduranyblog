<?php
	$options = array(
		'disable_icons' => of_get_option('disable_icons', false),
		'disable_post_header' => of_get_option('disable_post_header', false),
		'standard_icon' => of_get_option('standard_icon', false),
		);
	
	$layout = get_post_meta( get_the_ID(), 'bluth_post_layout', true );
	$layout = empty($layout) ? of_get_option('side_bar', 'right_side') : $layout;

	if ( has_post_thumbnail() ) { $margin_class = ''; }else{ $margin_class = 'noimg'; }

	if(is_sticky()){
		$post_icon = of_get_option('post_icon_edit', 'icon-pin');
	}else{
		$post_icon = of_get_option('standard_icon', 'icon-calendar-3');
	}	

	$featured_image_size = of_get_option('disable_crop') ? 'large' : 'gallery-large';
	$max_height = $featured_image_size == 'large' ? 'max-height:none;' : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('image-comment-on'); ?>> <?php 
	if ( has_post_thumbnail() ) { ?>
		<div class="entry-image" style="<?php echo $max_height; ?>"><?php
			$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large', false, '' ); ?>
			<a href="<?php echo $src[0]; ?>" class="image-comment" title="<?php the_title(); ?>" rel="bookmark">
				<?php the_post_thumbnail( $featured_image_size ); ?>
			</a>
		</div><?php 
	} ?>
	<div class="entry-container box clearfix <?php echo $margin_class . ' ' . $layout; ?>">
		<div class="entry-content col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="post-title">
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<div class="post-meta">
					<?php get_template_part( 'inc/meta-top' ); ?>
				</div>
				<div class="post-format-badge post-format-standard">
					<i class="<?php echo $post_icon; ?>"></i>
				</div>
			</div>
			<?php 
				the_content(); 
			?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'bluth' ), 'after' => '</div>' ) ); ?>
			<footer class="entry-meta clearfix">
				<?php get_template_part( 'inc/meta-bottom' ); ?>
			</footer><!-- .entry-meta -->
		</div><!-- .entry-content -->
		<aside id="side-bar" class="post-sidebar nopadding col-xs-12 col-sm-12 col-md-4 col-lg-4">
			<div class="clearfix">
				<?php dynamic_sidebar( 'post_sidebar'); ?>
			</div>
		</aside> 
	</div><!-- .entry-container -->
</article><!-- #post-<?php the_ID(); ?> -->




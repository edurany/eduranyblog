<?php
	$options = array(
		'disable_icons' => of_get_option('disable_icons', false),
		'disable_post_header' => of_get_option('disable_post_header', false),
		'header_art' => of_get_option('header_art', false),
		);

	if(is_sticky()){
		$post_icon = of_get_option('post_icon_edit', 'icon-pin');
	}else{
		$post_icon = of_get_option('gallery_icon', 'icon-picture');
	}

	$featured_image_size = of_get_option('disable_crop') ? 'large' : 'gallery-large';
	$max_height = $featured_image_size == 'large' ? 'max-height:none;' : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-title box">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<div class="post-meta">
			<?php get_template_part( 'inc/meta-top' ); ?>
		</div>
		<div class="post-format-badge post-format-gallery">
			<i class="<?php echo $post_icon; ?>"></i>
		</div>
	</div><?php
	if ( $images = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image' ))){ ?>
		<div class="entry-image entry-slider" style="<?php echo $max_height; ?>">
			<div class="entry-slides<?php echo ((count($images) > 1) ? ' nivo-slider' : '') ?>">
			   <?php 
			   $i = 1;
			   foreach( $images as $image ){ 			   			
			   	$src = wp_get_attachment_image_src( $image->ID, 'large', false, '' );  ?>
			    	<a href="<?php echo $src[0]; ?>"<?php echo ($i !== 1) ? ' style="display:none"' : '' ?> title="<?php the_title(); ?>" class="lightbox" rel="bookmark"><?php echo wp_get_attachment_image($image->ID,  $featured_image_size ); ?></a>
			   <?php $i++; } ?>
			</div>
		</div><?php
	}  ?>
	<div class="entry-container">
		<div class="entry-content">		
			<?php the_content('Continue reading...'); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><h4>' . __( 'Pages:', 'bluth' ).'</h4>', 'after' => '</div>', 'pagelink' => '<span>%</span>', )); ?>
			<footer class="entry-meta clearfix">
				<?php get_template_part( 'inc/meta-bottom' ); ?>
			</footer><!-- .entry-meta -->
		</div><!-- .entry-content -->
	</div><!-- .entry-container -->

</article><!-- #post-<?php the_ID(); ?> -->
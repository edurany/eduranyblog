<?php
	$options = array(
		'disable_icons' => of_get_option('disable_icons', false),
		'disable_post_header' => of_get_option('disable_post_header', false),
		'header_art' => of_get_option('header_art', false),
		);

	if(is_sticky()){
		$post_icon = of_get_option('post_icon_edit', 'icon-pin');
	}else{
		$post_icon = of_get_option('link_icon', 'icon-link');
	}	

	$featured_image_size = of_get_option('disable_crop') ? 'large' : 'gallery-large';
	$max_height = $featured_image_size == 'large' ? 'max-height:none;' : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-title box"><?php
		if( of_get_option( 'author_front' ) ){ ?>
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author-image bl_popover clearfix pull-left" data-trigger="hover" data-placement="top" data-content="<?php the_author(); ?>" title="<?php echo __('Author Name', 'bluth') ?>">
				<?php echo '<img src="' . blu_get_avatar_url(get_avatar( get_the_author_meta( 'ID' ) , 100 ) ) . '">'; ?>
			</a><?php
		} ?>
		<h1 class="entry-title"><a href="<?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?>" target="_blank" rel="nofollow"><?php the_title(); ?></a></h1>
		<div class="post-meta">
			<?php get_template_part( 'inc/meta-top' ); ?>
		</div><?php
		if ( has_post_thumbnail() ){ ?>
			<a href="<?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?>">
				<div class="post-format-badge post-format-link">
						<i class="<?php echo $post_icon; ?>"></i>
					
				</div> 
			</a><?php
		} ?>
	</div>
	<a href="<?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?>">
		<div class="entry-image" style="<?php echo $max_height; ?>"><?php 
			if ( has_post_thumbnail() ) { ?>
					<?php the_post_thumbnail( $featured_image_size );
			}else{ ?>
				<div class="post-format-badge post-format-link">
					<i class="background-link <?php echo $post_icon; ?>"></i>
					<div>
						<i class="<?php echo $post_icon; ?>"></i>
						<span><?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?></span>
					</div>
				</div><?php
			} ?>
		</div>
	</a>
	<div class="entry-container">
		<div class="entry-content"><?php 
			the_content(__('Continue reading...', 'bluth')); 
			wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'bluth' ), 'after' => '</div>' ) ); ?>
			<footer class="entry-meta clearfix">
				<?php get_template_part( 'inc/meta-bottom' ); ?>
			</footer><!-- .entry-meta -->
		</div><!-- .entry-content -->
	</div><!-- .entry-container -->
</article><!-- #post-<?php the_ID(); ?> -->
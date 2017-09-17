<?php
	$options = array(
		'disable_icons' => of_get_option('disable_icons', false),
		'disable_post_header' => of_get_option('disable_post_header', false),
		'header_art' => of_get_option('header_art', false),
		);

	if(is_sticky()){
		$post_icon = of_get_option('post_icon_edit', 'icon-pin');
	}else{
		$post_icon = of_get_option('quote_icon', 'icon-quote-left');
	}	
	$quote_class = '';
	if(!has_post_thumbnail()){ $quote_class = ' relative '; }else{ $quote_class = ' bgimg '; }

	$featured_image_size = of_get_option('disable_crop') ? 'large' : 'gallery-large';
	$max_height = $featured_image_size == 'large' ? 'max-height:none;' : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-image" style="<?php echo $max_height; ?>">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
			<?php the_post_thumbnail( $featured_image_size ); ?>
		</a>
	</div>
	<div class="entry-container <?php echo $quote_class; ?>">
		<div class="entry-content">
			<h1 class="entry-title"><i class="post-format-quote <?php echo $post_icon; ?>"></i><a><?php echo get_the_content() ?></a></h1>
			<a href="<?php echo get_post_meta($post->ID, '_format_quote_source_url', true); ?>" target="_blank">- <?php echo get_post_meta($post->ID, '_format_quote_source_name', true); ?></a>
		</div><!-- .entry-content -->
	</div><!-- .entry-container -->
	<footer class="entry-meta clearfix box" style="padding:25px 50px; border-radius:0 0 2px 2px;">
		<?php get_template_part( 'inc/meta-bottom' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->

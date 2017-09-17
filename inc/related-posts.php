<?php
$orig_post = $post;
global $post;
	$tags = wp_get_post_tags($post->ID);

if($tags){
	$tag_ids = array();
	foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

	$my_query = new wp_query( array(
	    'tag__in' => $tag_ids,
	    'post__not_in' => array($post->ID),
	    'posts_per_page'=>4,
			'tax_query' => array(
	        array(
	            'taxonomy' => 'post_format',
	            'field' => 'slug',
	            'terms' => array( 'post-format-link','post-format-quote' ),
	            'operator' => 'NOT IN'
	        )
	    	)
    ));

	if($my_query->have_posts()){ ?>
	    <div id="related-posts" class="pad35 box">
	    	<h3><?php echo __('You might also like', 'bluth'); ?></h3> <?php 
	    	while($my_query->have_posts()){
			    $my_query->the_post(); 
			    $post_format = get_post_format();
			    $post_format = ($post_format) ? $post_format : 'standard';   ?>
				<a href="<?php echo get_permalink( $post->ID ); ?>" class="nav-previous">
					<?php $post_format = (get_post_format( $post->ID )) ? get_post_format( $post->ID ) : 'standard';  ?>
					<div class="bgfallback">&nbsp;</div>
					<?php if( $post ){ ?>
						<span>&nbsp;</span>
						<div class="tab_icon" style="background-image: url('<?php echo get_post_image( $post->ID, 'thumbnail' ); ?>');"></div>
						<h5><?php echo get_the_title( $post->ID ); ?></h5>
						<?php the_excerpt(); ?>
					<?php } ?>
				</a> <?php
			} ?>
	    </div><?php
	}
}
$post = $orig_post;
wp_reset_query();
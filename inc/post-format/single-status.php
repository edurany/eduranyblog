<?php
	$options = array(
		'disable_icons' => of_get_option('disable_icons', false),
		'disable_post_header' => of_get_option('disable_post_header', false),
		'status_icon' => of_get_option('status_icon', false),
		'header_art' => of_get_option('header_art', false),
		);

	if(is_sticky()){
		$post_icon = of_get_option('post_icon_edit', 'icon-pin');
	}else{
		$post_icon = of_get_option('status_icon', 'icon-book-1');
	}	
	$post_icon_color = '';

	// if it's a facebook status
	if( get_post_meta( $post->ID, 'bluth_facebook_status', true ) ){
		$status_class = 'bl_facebook';
		$post_icon = of_get_option('facebook_status_icon', 'icon-facebook-1');
		$post_icon_color = ' color: #3B5998; opacity: 1;';
	}
	else if( get_post_meta( $post->ID, 'bluth_twitter_status', true ) ){
		$status_class = 'bl_twitter';
		$post_icon = of_get_option('twitter_status_icon', 'icon-twitter-1');
		$post_icon_color = ' color: #1DCAFF; opacity: 1;';
	}
	else if( get_post_meta( $post->ID, 'bluth_google_status', true ) ){
		$status_class = 'bl_google';
		$post_icon = of_get_option('google_status_icon', 'icon-gplus-2');
		$post_icon_color = ' color: #CD3C2A; opacity: 1;';
	}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-title box">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<div class="post-format-badge post-format-status">
			<i class="<?php echo $post_icon; ?>" style="<?php echo $post_icon_color; ?>"></i>
		</div>
		<div class="post-meta">
			<?php get_template_part( 'inc/meta-top' ); ?>
		</div>
	</div> 
	<div class="entry-container <?php echo $status_class; ?>">

		<div class="entry-content" style="border-bottom:1px solid #DDDDDD; "><?php
			if( get_post_meta( $post->ID, 'bluth_facebook_status', true ) ){
				echo html_entity_decode( get_post_meta( $post->ID, 'bluth_facebook_status', true ) );
			}
			else if( get_post_meta( $post->ID, 'bluth_twitter_status', true ) ){
				echo html_entity_decode( get_post_meta( $post->ID, 'bluth_twitter_status', true ) );
			}
			else if( get_post_meta( $post->ID, 'bluth_google_status', true ) ){
				echo html_entity_decode( get_post_meta( $post->ID, 'bluth_google_status', true ) );
			}else{

			} ?>
		</div><!-- .entry-content -->
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'bluth' ), 'after' => '</div>' ) ); ?>
		<footer class="entry-meta clearfix" style="padding:25px 50px;">
			<?php get_template_part( 'inc/meta-bottom' ); ?>
		</footer><!-- .entry-meta -->
	</div><!-- .entry-container -->
</article><!-- #post-<?php the_ID(); ?> -->
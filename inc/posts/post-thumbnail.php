<?php
$disable_crop = of_get_option('disable_crop');
$featured_image_size = 'original';
$max_height = '';

// echo the sticky icon if it's a sticky
if(is_sticky() && (is_home() || is_front_page())){ ?> <a href="#" class="sticky-icon" title="<?php _e('Sticky Post', 'bluth'); ?>"><i class="<?php echo of_get_option('sticky_icon'); ?>"></i></a> <?php }

// if positioned on the front page
if(!is_single() and !is_page()){	
	// if cropping is not disabled
	if(!$disable_crop['blog']){
		// if it's a full width page
 		if(of_get_option('blog_layout') == 'single'){
 			$featured_image_size = 'single-large';	
 		}
 		else{
 			$featured_image_size = 'sidebar-large';	
 		}
 	}
 		
}elseif(is_single()){
	$layout = !get_post_meta( $post->ID, 'bluth_post_layout', true ) ? of_get_option('post_page_layout') : get_post_meta( $post->ID, 'bluth_post_layout', true );
	
	if(!$disable_crop['single']){
 		if($layout == 'single'){
 			$featured_image_size = 'single-large';	
 		}else{
 			$featured_image_size = 'sidebar-large';	
 		}
 	}
}elseif(is_page()){
	$layout = !get_post_meta( $post->ID, 'bluth_page_layout', true ) ? of_get_option('post_page_layout') : get_post_meta( $post->ID, 'bluth_page_layout', true );
	if(!$disable_crop['pages']){
 		if($layout == 'single'){
 			$featured_image_size = 'single-large';	
 		}else{
 			$featured_image_size = 'sidebar-large';	
 		}
 	}
}
if(is_page() && has_post_thumbnail() && get_post_format() == ''){ ?>
	<div class="entry-image">
		<?php the_post_thumbnail( $featured_image_size ); ?>
	</div><?php
}
elseif ( has_post_thumbnail() || get_post_format() == 'video' || get_post_format() == 'gallery' || get_post_format() == 'status' || get_post_format() == 'link' || get_post_format() == 'quote' ) {  

	if(get_post_format() == 'video' and $video_url = get_post_meta( $post->ID, 'blu_video_url', true )){ ?>
		<div class="entry-video"><?php
			global $wp_embed;
			$video_url = html_entity_decode($video_url);
			if($video_url != strip_tags($video_url)){
				$content = preg_replace('#\<iframe(.*?)\ssrc\=\"(.*?)\"(.*?)\>#i', '<iframe$1 src="$2?wmode=opaque"$3>', $video_url);
				$content = preg_replace('#\<iframe(.*?)\ssrc\=\"(.*?)\?(.*?)\?(.*?)\"(.*?)\>#i', '<iframe$1 src="$2?$3&$4"$5>', $video_url);
				echo $content;
			}else{ 
				$content = $wp_embed->run_shortcode('[embed]' . $video_url . '[/embed]' ); 
				echo do_shortcode($content);
			}
			?>
		</div><?php	
	}elseif(get_post_format() == 'gallery' and $images = get_post_meta( $post->ID, 'blu_gallery', true )){  ?>
			<div class="swiper-container swiper-gallery" data-postid="<?php echo $post->ID; ?>">
			    <a class="arrow-left" href="#"></a>
    			<a class="arrow-right" href="#"></a>
	    		<div class="swiper-pagination" id="pagination-<?php echo $post->ID; ?>"></div>
				<div class="swiper-wrapper"><?php 
					foreach( $images as $image ){ ?> 
						<div class="swiper-slide swiper-slide-large" style="width:763px;"> 
							<div class="entry-head image-comment" data-original="<?php echo $image['gallery_src']; ?>" data-href="<?php echo $image['gallery_src']; ?>"> <?php 
								if(is_single()){ $featured_image_size = 'original'; }
								$gallery_image = get_post_image( get_the_ID(), $featured_image_size, false, $image['gallery_id']);  ?>
								<img class="img-responsive" src="<?php echo $gallery_image[0]; ?>">
							</div>
						</div><?php 
					} ?>
				</div> <!-- swiper-wrapper -->
			</div> <!-- swiper-container --> <?php
	}elseif(get_post_format() == 'quote'){ ?>
		<div class="entry-image <?php echo has_post_thumbnail() ? '' : 'no-thumbnail'; ?>" style="<?php echo $max_height; ?>"><?php
			$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large', false, '' ); 
			$quote_text = get_post_meta( $post->ID, 'blu_quote_text', true );
			$quote_author = get_post_meta( $post->ID, 'blu_quote_author', true );
			$quote_url = get_post_meta( $post->ID, 'blu_quote_src', true ); ?>
			
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
				<div class="quote-area">
					<h1 class="quote-text"><?php echo $quote_text; ?></h1>
					<div class="quote-author"><a href="<?php echo $quote_url; ?>"><?php echo $quote_author; ?></a></div>
				</div>
				<?php the_post_thumbnail( $featured_image_size ); ?>
			</a>

		</div><?php
	}elseif(get_post_format() == 'status'){
		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large', false, '' ); 
		if(empty($src)){ $status_class = ''; }else{ $status_class = ' background '; }

		// if it's a facebook status
		if( get_post_meta( $post->ID, 'bluth_facebook_status', true ) ){
			$status_class .= 'bl_facebook';
			$post_icon = of_get_option('facebook_status_icon', 'icon-facebook-1');
			$post_icon_color = ' color: #3B5998; opacity: 1;';
		}
		else if( get_post_meta( $post->ID, 'bluth_twitter_status', true ) ){
			$status_class .= 'bl_twitter';
			$post_icon = of_get_option('twitter_status_icon', 'icon-twitter-1');
			$post_icon_color = ' color: #1DCAFF; opacity: 1;';
		}
		else if( get_post_meta( $post->ID, 'bluth_google_status', true ) ){
			$status_class .= 'bl_google';
			$post_icon = of_get_option('google_status_icon', 'icon-gplus-2');
			$post_icon_color = ' color: #CD3C2A; opacity: 1;';
		} ?>

		<div class="entry-image <?php echo $status_class; ?>" style="<?php echo $max_height; ?> background-image:url('<?php echo $src[0]; ?>'); background-size: cover;"> <?php 
			if( get_post_meta( $post->ID, 'bluth_facebook_status', true ) ){
				if(is_single()){
					echo str_replace( '&#039;', '\'', html_entity_decode( get_post_meta( $post->ID, 'bluth_facebook_status', true ) ) );
				}else{
					$facebook_store = str_replace( '&#039;', '\'', html_entity_decode( get_post_meta( $post->ID, 'bluth_facebook_status', true ) ) );
					$facebook_store = htmlentities($facebook_store);
					echo '<div class="facebook-store" data-code="' . $facebook_store . '"></div>';
				}
			}
			else if( get_post_meta( $post->ID, 'bluth_twitter_status', true ) ){
				if(is_single()){
					echo html_entity_decode( get_post_meta( $post->ID, 'bluth_twitter_status', true ) );
				}else{
					$twitter_store = html_entity_decode( get_post_meta( $post->ID, 'bluth_twitter_status', true ) );
					$twitter_store = htmlentities($twitter_store);
					echo '<div class="twitter-store" data-code="' . $twitter_store . '"></div>';
				}
			}
			else if( get_post_meta( $post->ID, 'bluth_google_status', true ) ){
				if(is_single()){
					echo html_entity_decode( get_post_meta( $post->ID, 'bluth_google_status', true ) );
				}else{
					$google_store = html_entity_decode( get_post_meta( $post->ID, 'bluth_google_status', true ) );
					$google_store = htmlentities($google_store);
					echo '<div class="google-store" data-code="' . $google_store . '"></div>';
				}
			}?>
		</div><?php
	}elseif(get_post_format() == 'link'){ 
		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large', false, '' );
		if(empty($src)){ $link_class = ''; }else{ $link_class = 'background'; }
		$post_icon = of_get_option('link_icon', 'icon-link');
		$link_url = html_entity_decode( get_post_meta($post->ID, 'blu_link_url', true ) ); ?>

		<div class="entry-image <?php echo $link_class; ?>" style="<?php echo $max_height; ?> background-image:url('<?php echo $src[0]; ?>'); background-size: cover;">
			<a href="<?php echo $link_url; ?>" title="<?php the_title(); ?>" rel="bookmark" target="_blank">
				<h1><?php echo '<i class="'. $post_icon . '"></i> '; the_title(); ?></h1>
			</a>
		</div><?php
	} else{ ?>
		<div class="entry-image" style="<?php echo $max_height; ?>"><?php
			$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'original', false, '' ); 
			// if it's a single page then don't make the image a link
			
			if(is_single()){ ?>
				<div class="image-comment" rel="bookmark" data-href="<?php echo $src[0]; ?>">
					<?php the_post_thumbnail( $featured_image_size ); ?>
				</div><?php
			}else{ 
				if(of_get_option('post_image_lightbox')){ ?>
					<a href="<?php echo $src[0]; ?>" class="lightbox" title="<?php the_title(); ?>" rel="bookmark">
						<?php the_post_thumbnail( $featured_image_size ); ?>
					</a><?php
				}else{ ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
						<?php the_post_thumbnail( $featured_image_size ); ?>
					</a><?php
				}
			} ?>
		</div><?php
	} 
} ?>
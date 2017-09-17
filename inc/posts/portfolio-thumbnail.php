<?php
$featured_image_size = 'original';
$images = get_post_meta( $post->ID, 'blu_portfolio_gallery', true );

if(!empty($images[0]['gallery_src'])){  ?>
	<div class="swiper-container swiper-gallery" data-postid="<?php echo $post->ID; ?>">
	    <a class="arrow-left" href="#"></a>
		<a class="arrow-right" href="#"></a>
		<div class="swiper-pagination" id="pagination-<?php echo $post->ID; ?>"></div>
		<div class="swiper-wrapper"><?php 
			foreach( $images as $image ){ ?> 
				<div class="swiper-slide swiper-slide-large" style="width:763px;"> 
					<div class="entry-head image-comment" data-original="<?php echo $image['gallery_src']; ?>"> <?php 
						if(is_single()){ $featured_image_size = 'original'; }
						$gallery_image = get_post_image( get_the_ID(), $featured_image_size, false, $image['gallery_id']);  ?>
						<img class="img-responsive" src="<?php echo $gallery_image[0]; ?>">
					</div>
				</div><?php 
			} ?>
		</div> <!-- swiper-wrapper -->
	</div> <!-- swiper-container --> <?php
}else{ ?>
	<div class="entry-image">
		<div class="image-comment" data-href="<?php echo get_post_image($post->ID, 'original'); ?>">
			<?php the_post_thumbnail( $featured_image_size ); ?>
		</div>
	</div><?php
}
 ?>
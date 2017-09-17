

<ul class="post-tags clearfix">
	<?php if(has_tag() && !of_get_option('disable_footer_post')){ the_tags('<li>',' ','</li>'); } ?>
</ul>
<?php 
	if(!of_get_option('disable_share_story')){
		$share_buttons_disabled = of_get_option('share_buttons_disabled');
		$share_buttons_position = of_get_option('share_buttons_position');
		if( ( is_single() && !empty( $share_buttons_position['single'] ) ) || ( is_home() && !empty( $share_buttons_position['blog'] ) ) || ( is_page() && !empty( $share_buttons_position['pages'] ) ) ){
			$share_title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));
			$share_url = urlencode(get_permalink()); 
			$share_image = urlencode(get_post_image(get_the_ID(), 'medium', false )); 
			?>
			<div class="share-story-container">
				<h4 class="muted"><?php _e('Share story', 'bluth'); ?></h4>
				<ul class="share-story">
					<?php if(!$share_buttons_disabled['facebook']){ ?><li><a class="tips" data-title="Facebook" href="javascript:void(0);" onClick="social_share('http://www.facebook.com/sharer.php?u=<?php echo $share_url; ?>&t=<?php echo $share_title; ?>');"><i class="icon-facebook-1"></i></a></li><?php } ?>
					<?php if(!$share_buttons_disabled['googleplus']){ ?><li><a class="tips" data-title="Google+" href="javascript:void(0);" onClick="social_share('https://plus.google.com/share?url=<?php echo $share_url; ?>');"><i class="icon-gplus-1"></i></a></li><?php } ?>
					<?php if(!$share_buttons_disabled['twitter']){ ?><li><a class="tips" data-title="Twitter" href="javascript:void(0);" onClick="social_share('http://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php the_title(); ?>');"><i class="icon-twitter-1"></i></a></li><?php } ?>
					<?php if(!$share_buttons_disabled['pinterest']){ ?><li><a class="tips" data-title="Pinterest" href="javascript:void(0);" onClick="social_share('http://www.pinterest.com/pin/create/button/?url=<?php echo $share_url; ?>&media=<?php echo $share_image; ?>');" data-pin-do="buttonPin" data-pin-config="above"><i class="icon-pinterest-1"></i></a></li><?php } ?>
					<?php if(!$share_buttons_disabled['reddit']){ ?><li><a class="tips" data-title="Reddit" href="javascript:void(0);" onClick="social_share('http://www.reddit.com/submit?url=<?php echo $share_url; ?>&amp;title=<?php echo $share_title ?>');"><i class="icon-reddit"></i></a></li><?php } ?>
					<?php if(!$share_buttons_disabled['linkedin']){ ?><li><a class="tips" data-title="Linkedin" href="javascript:void(0);" onClick="social_share('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url; ?>&title=<?php echo $share_title; ?>');"><i class="icon-linkedin-1"></i></a></li><?php } ?>
					<?php if(!$share_buttons_disabled['delicious']){ ?><li><a class="tips" data-title="Delicious" href="javascript:void(0);" onClick="social_share('http://www.delicious.com/post?v=2&amp;url=<?php echo $share_url; ?>&amp;notes=&amp;tags=&amp;title=<?php echo $share_title; ?>');"><i class="icon-delicious"></i></a></li><?php } ?>
					<?php if(!$share_buttons_disabled['email']){ ?><li><a class="tips" data-title="Email" href="javascript:void(0);" onClick="social_share('mailto:?subject=<?php echo $share_title;?>&amp;body=<?php echo $share_url ?>');"><i class="icon-mail-1"></i></a></li><?php } ?>
				</ul>
			</div><?php
		} 
	} ?>

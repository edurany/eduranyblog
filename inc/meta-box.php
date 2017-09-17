<?php


	// Meta box
	add_action( 'add_meta_boxes', 'cd_layout_meta' );  
	function cd_layout_meta()  
	{  
	    add_meta_box( 'blu_format_status', 'Status Settings', 'blu_format_status', 'post', 'normal', 'high' );   
	    add_meta_box( 'blu_format_gallery', 'Gallery Settings', 'blu_format_gallery', 'post', 'normal', 'high' );   
	    add_meta_box( 'blu_format_video', 'Video Settings', 'blu_format_video', 'post', 'normal', 'high' );   
	    add_meta_box( 'blu_format_audio', 'Audio Settings', 'blu_format_audio', 'post', 'normal', 'high' );   
	    add_meta_box( 'blu_format_link', 'Link Settings', 'blu_format_link', 'post', 'normal', 'high' );   
	    add_meta_box( 'blu_format_quote', 'Quote Settings', 'blu_format_quote', 'post', 'normal', 'high' );   

	    add_meta_box( 'bluth_post_meta', 'Post Options', 'bluth_post_meta', 'post', 'normal', 'high' );   
	    add_meta_box( 'bluth_page_meta', 'Page Options', 'bluth_page_meta', 'page', 'normal', 'high' );    
	    add_meta_box( 'bluth_portfolio_meta', 'Page Options', 'bluth_portfolio_meta', 'blu-portfolio', 'normal', 'high' );    
	}  
  
	function blu_format_status( $post )  {  
	    $facebook_status = get_post_meta( $post->ID, 'bluth_facebook_status', true );  
	    $twitter_status = get_post_meta( $post->ID, 'bluth_twitter_status', true );  
	    $google_status = get_post_meta( $post->ID, 'bluth_google_status', true );  
	
	    wp_nonce_field( 'save_format_status', 'format_status_nonce' );  ?>

	    <fieldset class="clearfix blu_format blu_format_status"> 
		    <div class="cd-layout" style="width:33%;"> 
		        <label for="facebook-status"> 
		            <h4 style="border-bottom:1px solid #cccccc; margin:25px 0; padding-bottom:10px; width:95%;">Facebook embedded status ( <a href="https://developers.facebook.com/docs/plugins/embedded-posts/" target="_blank">How do I do this?</a> )</h4>  
		        </label> 
		    	<textarea id="facebook-status" name="bluth_facebook_status" value="" style="width:95%"><?php echo $facebook_status; ?></textarea>
		    </div>
		    <div class="cd-layout" style="width:33%;"> 
		        <label for="twitter-status"> 
		            <h4 style="border-bottom:1px solid #cccccc; margin:25px 0; padding-bottom:10px; width:95%;">Twitter embedded status ( <a href="https://dev.twitter.com/docs/embedded-tweets" target="_blank">How do I do this?</a> )</h4>
		        </label> 
		    	<textarea id="twitter-status" name="bluth_twitter_status" value="" style="width:95%"><?php echo $twitter_status; ?></textarea>
		    </div>
		    <div class="cd-layout" style="width:33%;"> 
		        <label for="google-status"> 
		            <h4 style="border-bottom:1px solid #cccccc; margin:25px 0; padding-bottom:10px; width:95%;">Google+ embedded status ( <a href="https://developers.google.com/+/web/embedded-post/" target="_blank">How do I do this?</a> )</h4>
		        </label> 
		    	<textarea id="google-status" name="bluth_google_status" value="" style="width:95%"><?php echo $google_status; ?></textarea>
		    </div>
		</fieldset>
		<?php
	}
	function blu_format_gallery( $post )  {  
		$blu_gallery 	= get_post_meta( $post->ID, 'blu_gallery', false );  
		$blu_gallery 	= empty($blu_gallery) ? array(array(array('gallery_src' => '', 'gallery_id' => ''))) : $blu_gallery;  
	   	
	   	wp_nonce_field( 'save_format_status', 'format_status_nonce' );  ?>

	    <fieldset class="full">
		    <h4>Gallery Images: <a href="javascript:void(0);" class="bl_add_field">Add image</a></h4><?php
		    foreach( $blu_gallery as $key => $item ){ 
		    	foreach( $item as $key2 => $array_item ){ ?>
			      	<div class="cd-layout array_item blu_image_upload" data-key="<?php echo $key2; ?>" style="width: 12%; margin-right: 0.5%;" data-name="blu_gallery">
						<input data-arrayname="gallery_src" type="hidden" name="blu_gallery[<?php echo $key2; ?>][gallery_src]" class="blu_gallery blu_item source" value="<?php echo $item[$key2]['gallery_src']; ?>" />
						<input data-arrayname="gallery_id" type="hidden" name="blu_gallery[<?php echo $key2; ?>][gallery_id]" class="blu_gallery blu_item image_id" value="<?php echo $item[$key2]['gallery_id']; ?>" />
			      		<a class="blu_add_image" href="#"><img class="blu_gallery" data-placeholder="<?php echo $fallback_image; ?>" src="<?php echo $item[$key2]['gallery_src']; ?>"></a>
						<button type="button" class="close">&times;</button>
			      	</div> <?php 
				}
			} ?>
	    </fieldset><?php
	}
	function blu_format_video( $post )  {  
	    $video_url = get_post_meta( $post->ID, 'blu_video_url', true );  
	
	   	wp_nonce_field( 'save_format_status', 'format_status_nonce' );  ?>

	    <fieldset class="clearfix blu_format blu_format_video"> 
		    <div class="cd-layout" style="width: 100%;"> 
		    	<input type="text" id="video-url" name="blu_video_url" value="<?php echo $video_url; ?>" placeholder="<?php _e('Video URL..', 'bluth_admin'); ?>" style="margin: 10px 0; width:100%; font-size: 22px;">
		    </div>
		</fieldset>
		<?php
	}
	function blu_format_audio( $post )  {  
	    $audio_url = get_post_meta( $post->ID, 'blu_audio_url', true );  
	
	   	wp_nonce_field( 'save_format_status', 'format_status_nonce' );  ?>

	    <fieldset class="clearfix blu_format blu_format_audio"> 
		    <div class="cd-layout" style="width: 100%;"> 
		    	<input type="text" id="audio-url" name="blu_audio_url" value="<?php echo $audio_url; ?>" placeholder="<?php _e('Audio URL..', 'bluth_admin'); ?>" style="margin: 10px 0; width:100%; font-size: 22px;">
		    </div>
		</fieldset>
		<?php
	}
	function blu_format_link( $post )  {  
	    $link_url = get_post_meta( $post->ID, 'blu_link_url', true );  
	
	   	wp_nonce_field( 'save_format_status', 'format_status_nonce' );  ?>

	    <fieldset class="clearfix blu_format blu_format_link"> 
		    <div class="cd-layout" style="width: 100%;"> 
		    	<input type="text" id="link-url" name="blu_link_url" value="<?php echo $link_url; ?>" placeholder="<?php _e('Link URL..', 'bluth_admin'); ?>" style="margin: 10px 0; width:100%; font-size: 22px;">
		    </div>
		</fieldset>
		<?php
	}
	function blu_format_quote( $post )  {  
	    $quote_text = get_post_meta( $post->ID, 'blu_quote_text', true );  
	    $quote_author = get_post_meta( $post->ID, 'blu_quote_author', true );  
	    $quote_src = get_post_meta( $post->ID, 'blu_quote_src', true );  
		
		$fallback_image = 'http://placehold.it/100/100';
		$image 	= get_post_meta( $post->ID, 'blu_review_image', true );  
		$image 	= empty($image) ? $fallback_image : $image;
	   	
	   	wp_nonce_field( 'save_format_status', 'format_status_nonce' );  ?>

	    <fieldset class="clearfix blu_format blu_format_quote"> 
		    <div class="cd-layout" style="width: 100%;"> 
		    	<input type="text" id="quote-author" name="blu_quote_author" value="<?php echo $quote_author; ?>" placeholder="<?php _e('Quote Author Name..', 'bluth_admin'); ?>" style="margin: 10px 0; width:100%; font-size: 16px;">
		    </div>
		    <div class="cd-layout" style="width: 100%;"> 
		    	<input type="text" id="quote-src" name="blu_quote_src" value="<?php echo $quote_src; ?>" placeholder="<?php _e('Quote Source (URL)..', 'bluth_admin'); ?>" style="margin: 10px 0; width:100%; font-size: 16px;">
		    </div>
		    <div class="cd-layout" style="width: 100%;"> 
		    	<textarea id="quote-text" name="blu_quote_text" value="" placeholder="<?php _e('Quote Text..', 'bluth_admin'); ?>" style="margin: 10px 0; width:100%; font-size: 16px;"><?php echo $quote_text; ?></textarea>
		    </div>
		</fieldset>
		<?php
	}
	function bluth_post_meta( $post )  {  
	    $layout = get_post_meta( $post->ID, 'bluth_post_layout', true );  
	    $custom_thumbnail = get_post_meta( $post->ID, 'bluth_custom_thumbnail', true );  
	    $fallback_image = '';
	    $right_sidebar = get_post_meta( $post->ID, 'bluth_post_right_sidebar', true );  
	    $left_sidebar = get_post_meta( $post->ID, 'bluth_post_left_sidebar', true );  
	      
	    if( empty( $layout ) ) $layout = 'right_side';  
	    if( empty( $right_sidebar ) ) $right_sidebar = 'sidebar_right';  
	    if( empty( $left_sidebar ) ) $left_sidebar = 'sidebar_left';  

	    $dir = get_template_directory_uri().'/assets/img/';  
	    wp_nonce_field( 'save_post_layout', 'layout_nonce' );  
	    ?>  
	    <div class="clearfix">
		    <fieldset class="pull-left one-four pad15_side"> 
			    <h2 style="display:block; border-bottom:1px solid #cccccc; margin:15px 0; padding: 5px 0;">
			    	<?php _e('Custom Thumbnail Image', 'bluth_admin'); ?>
			    	<small style="display: block; font-size: 11px; line-height: 1.4; opacity: 0.7;">Custom image for the thumbnail (in Bluth tabs, recent posts etc.)</small>
			    </h2> 
				<div class="blu_image_upload full">
					<input type="hidden" name="bluth_custom_thumbnail[gallery_src]" class="source" value="<?php echo (!empty($custom_thumbnail['gallery_src']) ? $custom_thumbnail['gallery_src'] : '') ; ?>" />
					<input type="hidden" name="bluth_custom_thumbnail[gallery_id]" class="image_id" value="<?php echo (!empty($custom_thumbnail['gallery_id']) ? $custom_thumbnail['gallery_id'] : '') ; ?>" />
		      		<a class="blu_add_image" href="#" style="height:auto; min-height: 100px;"><img class="blu_gallery" data-placeholder="<?php echo $fallback_image; ?>" src="<?php echo $custom_thumbnail['gallery_src']; ?>"></a>
					<button type="button" class="close">Remove</button>
		      	</div>
		    </fieldset> 
		    <fieldset class="pull-left half pad15_side"> 
			    <h2 style="display:block; border-bottom:1px solid #cccccc; margin:15px 0; padding: 5px 0;">
			    	<?php _e('Sidebar Position', 'bluth_admin'); ?>
			    	<small style="display: block; font-size: 11px; line-height: 1.4; opacity: 0.7;">Positioning of the sidebar for this particular post</small>
			    </h2> 
			    <div class="cd-layout"> 
			        <input type="radio" id="sidebar-left" name="bluth_post_layout" value="left_side" <?php checked( $layout, 'left_side' ); ?> /> 
			        <label for="sidebar-left"> 
			            <img src="<?php echo $dir; ?>sidebar-layout-left.jpg" alt="sidebar then content" /> 
			            <span><?php _e('Sidebar on the left', 'bluth_admin'); ?></span> 
			        </label> 
			    </div> 
			    <div class="cd-layout"> 
			        <input type="radio" id="sidebar-default" name="bluth_post_layout" value="single" <?php checked( $layout, 'single' ); ?> /> 
			        <label for="sidebar-default"> 
			            <img src="<?php echo $dir; ?>sidebar-layout-single.jpg" alt="Use the Default Sidebar" /> 
			            <span><?php _e('Single column', 'bluth_admin'); ?></span> 
			        </label> 
			    </div> 
			    <div class="cd-layout"> 
			        <input type="radio" id="sidebar-right" name="bluth_post_layout" value="right_side" <?php checked( $layout, 'right_side' ); ?> /> 
			        <label for="sidebar-right"> 
			            <img src="<?php echo $dir; ?>sidebar-layout-right.jpg" alt="content then sidebar" /> 
			            <span><?php _e('Sidebar on the right', 'bluth_admin'); ?></span> 
			        </label> 
			    </div> 
		    </fieldset> 
	    </div>
	    <?php 
	} 
  
	function bluth_page_meta( $post )  
	{  
	    global $post;  
	    $values = get_post_custom( $post->ID );  
	    $bluth_page_hide_title 	= isset( $values['bluth_page_hide_title'][0] ) ? esc_attr( $values['bluth_page_hide_title'][0] ) : '';  
	    $page_subtitle = get_post_meta( $post->ID, 'bluth_page_subtitle', true );  
	    $layout = get_post_meta( $post->ID, 'bluth_page_layout', true );  
	    if( empty( $layout ) ) $layout = 'right_side';  
	    $dir = get_template_directory_uri().'/assets/img/';  

	    wp_nonce_field( 'bluth_page_meta_nounce', 'page_meta_nounce' ); ?>
	    
	    <p> 
	        <input type="text" id="bluth_page_subtitle" name="bluth_page_subtitle" placeholder="<?php _e('Page Sub-title..', 'bluth_admin'); ?>" value="<?php echo $page_subtitle; ?>" style="margin: 10px 0; width:100%; font-size: 16px;" />  
	    </p>  
	    <p> 
	        <input type="checkbox" id="bluth_page_hide_title" name="bluth_page_hide_title" <?php checked( $bluth_page_hide_title, 'on' ); ?> />  
	        <label for="bluth_page_hide_title"><?php _e('Hide page title', 'bluth_admin'); ?></label>  
	    </p>  

	    <fieldset class="clearfix"> 
	    <h4 style="border-bottom:1px solid #cccccc; margin:25px 0;"><?php _e('Sidebar Position', 'bluth_admin'); ?></h4> 
	    <div class="cd-layout"> 
	        <input type="radio" id="sidebar-left" name="bluth_page_layout" value="left_side" <?php checked( $layout, 'left_side' ); ?> /> 
	        <label for="sidebar-left"> 
	            <img src="<?php echo $dir; ?>sidebar-layout-left.jpg" alt="sidebar then content" /> 
	            <span><?php _e('Sidebar on the left', 'bluth_admin'); ?></span> 
	        </label> 
	    </div> 
	    <div class="cd-layout"> 
	        <input type="radio" id="sidebar-default" name="bluth_page_layout" value="single" <?php checked( $layout, 'single' ); ?> /> 
	        <label for="sidebar-default"> 
	            <img src="<?php echo $dir; ?>sidebar-layout-single.jpg" alt="Use the Default Sidebar" /> 
	            <span><?php _e('Single column', 'bluth_admin'); ?></span> 
	        </label> 
	    </div> 
	    <div class="cd-layout"> 
	        <input type="radio" id="sidebar-right" name="bluth_page_layout" value="right_side" <?php checked( $layout, 'right_side' ); ?> /> 
	        <label for="sidebar-right"> 
	            <img src="<?php echo $dir; ?>sidebar-layout-right.jpg" alt="content then sidebar" /> 
	            <span><?php _e('Sidebar on the right', 'bluth_admin'); ?></span> 
	        </label> 
	    </div> 
	    </fieldset> 

	    <?php      
	}  
	function bluth_portfolio_meta( $post )  
	{  
	    global $post;  
	    $values = get_post_custom( $post->ID );  
	    $layout = get_post_meta( $post->ID, 'bluth_portfolio_layout', true );  
	    if( empty( $layout ) ) $layout = 'right_side';  
	    $dir = get_template_directory_uri().'/assets/img/';  

	    wp_nonce_field( 'bluth_portfolio_meta_nounce', 'bluth_portfolio_meta_nounce' ); ?>
	    

	    <fieldset class="clearfix"> 
	    <h4 style="border-bottom:1px solid #cccccc; margin:25px 0;"><?php _e('Sidebar Position', 'bluth_admin'); ?></h4> 
	    <div class="cd-layout"> 
	        <input type="radio" id="sidebar-left" name="bluth_portfolio_layout" value="left_side" <?php checked( $layout, 'left_side' ); ?> /> 
	        <label for="sidebar-left"> 
	            <img src="<?php echo $dir; ?>sidebar-layout-left.jpg" alt="sidebar then content" /> 
	            <span><?php _e('Sidebar on the left', 'bluth_admin'); ?></span> 
	        </label> 
	    </div> 
	    <div class="cd-layout"> 
	        <input type="radio" id="sidebar-default" name="bluth_portfolio_layout" value="single" <?php checked( $layout, 'single' ); ?> /> 
	        <label for="sidebar-default"> 
	            <img src="<?php echo $dir; ?>sidebar-layout-single.jpg" alt="Use the Default Sidebar" /> 
	            <span><?php _e('Single column', 'bluth_admin'); ?></span> 
	        </label> 
	    </div> 
	    <div class="cd-layout"> 
	        <input type="radio" id="sidebar-right" name="bluth_portfolio_layout" value="right_side" <?php checked( $layout, 'right_side' ); ?> /> 
	        <label for="sidebar-right"> 
	            <img src="<?php echo $dir; ?>sidebar-layout-right.jpg" alt="content then sidebar" /> 
	            <span><?php _e('Sidebar on the right', 'bluth_admin'); ?></span> 
	        </label> 
	    </div> 
	    </fieldset> 

	    <?php      
	}  

	 
	add_action( 'save_post', 'bluth_post_meta_save' ); 
	function bluth_post_meta_save( $id ) 
	{ 
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	    if( !isset( $_POST['layout_nonce'] ) || !wp_verify_nonce( $_POST['layout_nonce'], 'save_post_layout' ) ) return; 
	    if( !isset( $_POST['format_status_nonce'] ) || !wp_verify_nonce( $_POST['format_status_nonce'], 'save_format_status' ) ) return; 
	    if( !current_user_can( 'edit_post' ) ) return; 
	     
	    $custom_thumbnail = $_POST['bluth_custom_thumbnail'];
	    if( isset( $_POST['bluth_custom_thumbnail'] ) ) 
	        update_post_meta( $id, 'bluth_custom_thumbnail', $custom_thumbnail );
	    if( isset( $_POST['bluth_post_layout'] ) ) 
	        update_post_meta( $id, 'bluth_post_layout', esc_attr( strip_tags( $_POST['bluth_post_layout'] ) ) );
	    if( isset( $_POST['bluth_post_right_sidebar'] ) ) 
	        update_post_meta( $id, 'bluth_post_right_sidebar', esc_attr( strip_tags( $_POST['bluth_post_right_sidebar'] ) ) );  
	    if( isset( $_POST['bluth_post_left_sidebar'] ) ) 
	        update_post_meta( $id, 'bluth_post_left_sidebar', esc_attr( strip_tags( $_POST['bluth_post_left_sidebar'] ) ) );  

	    if( isset( $_POST['bluth_facebook_status'] ) ) 
	        update_post_meta( $id, 'bluth_facebook_status', esc_attr(  $_POST['bluth_facebook_status'] ) );
	    if( isset( $_POST['bluth_twitter_status'] ) ) 
	        update_post_meta( $id, 'bluth_twitter_status', esc_attr( $_POST['bluth_twitter_status'] ) );
	    if( isset( $_POST['bluth_google_status'] ) ) 
	        update_post_meta( $id, 'bluth_google_status', esc_attr( $_POST['bluth_google_status'] ) );

	    if( isset( $_POST['blu_video_url'] ) ) 
	        update_post_meta( $id, 'blu_video_url', esc_attr(  $_POST['blu_video_url'] ) );

	    if( isset( $_POST['blu_audio_url'] ) ) 
	        update_post_meta( $id, 'blu_audio_url', esc_attr(  $_POST['blu_audio_url'] ) );
	    
	    if( isset( $_POST['blu_link_url'] ) ) 
	        update_post_meta( $id, 'blu_link_url', esc_attr(  $_POST['blu_link_url'] ) );

	    if( isset( $_POST['blu_quote_text'] ) ) 
	        update_post_meta( $id, 'blu_quote_text', esc_attr(  $_POST['blu_quote_text'] ) );
	    if( isset( $_POST['blu_quote_author'] ) ) 
	        update_post_meta( $id, 'blu_quote_author', esc_attr(  $_POST['blu_quote_author'] ) );
	    if( isset( $_POST['blu_quote_src'] ) ) 
	        update_post_meta( $id, 'blu_quote_src', esc_attr(  $_POST['blu_quote_src'] ) );
	    $blu_gallery = $_POST["blu_gallery"];
	    if( isset( $_POST['blu_gallery'] ) ) 
	        update_post_meta( $id, 'blu_gallery', $blu_gallery );
	} 


	add_action( 'save_post', 'bluth_page_meta_save' ); 
	function bluth_page_meta_save( $id ) 
	{ 
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	    if( !isset( $_POST['page_meta_nounce'] ) || !wp_verify_nonce( $_POST['page_meta_nounce'], 'bluth_page_meta_nounce' ) ) return; 
	    if( !current_user_can( 'edit_post' ) ) return; 

	 	$chk = isset( $_POST['bluth_page_hide_title'] ) ? 'on' : 'off';  
	    update_post_meta( $id, 'bluth_page_hide_title', $chk );  

	    if( isset( $_POST['bluth_page_subtitle'] ) ) 
	        update_post_meta( $id, 'bluth_page_subtitle', esc_attr( strip_tags( $_POST['bluth_page_subtitle'] ) ) );

	    if( isset( $_POST['bluth_page_layout'] ) ) 
	        update_post_meta( $id, 'bluth_page_layout', esc_attr( strip_tags( $_POST['bluth_page_layout'] ) ) );
	}  

	add_action( 'save_post', 'bluth_portfolio_meta_save' ); 
	function bluth_portfolio_meta_save( $id ) 
	{ 
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	    if( !isset( $_POST['bluth_portfolio_meta_nounce'] ) || !wp_verify_nonce( $_POST['bluth_portfolio_meta_nounce'], 'bluth_portfolio_meta_nounce' ) ) return; 
	    if( !current_user_can( 'edit_post' ) ) return; 

	    if( isset( $_POST['bluth_portfolio_layout'] ) ) 
	        update_post_meta( $id, 'bluth_portfolio_layout', esc_attr( strip_tags( $_POST['bluth_portfolio_layout'] ) ) );
	}  
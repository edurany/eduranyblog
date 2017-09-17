<?php

class blu_instagram extends WP_Widget{

  function __construct(){
    parent::__construct('blu_instagram', 'Bluthemes - Instagram', array('classname' => 'blu_instagram', 'description' => __( 'Displays recent instagram images in a widget. Recommended for the sidebar.', 'bluth-admin') ));
  }
 
  function form($instance){

    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    
    $title        = !empty($instance['title']) ? $instance['title'] : '';
    $access_token = !empty($instance['access_token']) ? $instance['access_token'] : '';
    $user_id      = !empty($instance['user_id']) ? $instance['user_id'] : '';
    $show_caption = !empty($instance['show_caption']) ? $instance['show_caption'] : 'always';

  ?>
  <p>
    <label for="<?php echo $this->get_field_id('title'); ?>">Title</label><br>
    <input type="text" style="width:100%" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>">
  </p>
	<p>
    <label for="<?php echo $this->get_field_id('access_token'); ?>">Access token</label><br>
    <input type="text" style="width:100%" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" value="<?php echo $access_token; ?>">
  </p>
    <p>
    <label for="<?php echo $this->get_field_id('user_id'); ?>">User id</label><br>
    <input type="text" style="width:100%" id="<?php echo $this->get_field_id('user_id'); ?>" name="<?php echo $this->get_field_name('user_id'); ?>" value="<?php echo $user_id; ?>">
  </p>
  <p>
    <label for="<?php echo $this->get_field_id('show_icon'); ?>">Show Instagram icon before the title</label><br>
	<select style="width:100%" id="<?php echo $this->get_field_id('show_icon'); ?>" name="<?php echo $this->get_field_name('show_icon'); ?>">
	  	<option value="true" <?php echo ($instance['show_icon'] == 'true') ? 'selected=""' : ''; ?>>Yes</option> 
	  	<option value="false" <?php echo ($instance['show_icon'] == 'false') ? 'selected=""' : ''; ?>>No</option> 
	</select>
  </p> 
  <p>
    <label for="<?php echo $this->get_field_id('show_caption'); ?>">Show Caption with images</label><br>
	<select style="width:100%" id="<?php echo $this->get_field_id('show_caption'); ?>" name="<?php echo $this->get_field_name('show_caption'); ?>">
	  	<option value="always" <?php echo ($instance['show_caption'] == 'always') ? 'selected=""' : ''; ?>>Always</option> 
	  	<option value="on_hover" <?php echo ($instance['show_caption'] == 'on_hover') ? 'selected=""' : ''; ?>>Only on hover</option> 
	  	<option value="off" <?php echo ($instance['show_caption'] == 'off') ? 'selected=""' : ''; ?>>Off</option> 
	</select>
  </p>  
  <p>
  	<div class="instruction-box" style="padding: 10px; background-color: #D7F7DF;">
  		<a href="#" class="btn blu_empty_instagram_cache">Manually empty the cache</a>
  		<small style="display:block;">Press this to empty the cache (if the widget isn't fetching the newest image then you should use this)</small>
  	</div>
  </p>
  <hr>
  <div class="instruction-box" style="padding: 10px; background-color: #D7F7DF;">
	  <strong>Instructions</strong>
	  <p>You need to authenticate yourself to our instagram app to get an access token to retrieve your images and display them on your page.</p>
	  <ol>
	    <li>Attain your access token and user id <a href="https://api.instagram.com/oauth/authorize/?client_id=e802ca96dd27470f9ef0271bc9f0e6a3&redirect_uri=http://www.bluth.is/&response_type=code" target="_blank">by clicking here</a></li>
	    <li>Copy the access token and user id</li>
	    <li>Paste them in the input box below</li>
	  </ol>
	  <p>Not recommended in the footer area because of sizing issues.</p>
  </div>
  <?php
  }
 
  function update($new_instance, $old_instance){
  	delete_transient( 'blu_instagram' );
    $instance = $old_instance;
    $instance['title']          = strip_tags($new_instance['title']);
    $instance['access_token']   = strip_tags($new_instance['access_token']);
    $instance['user_id']        = strip_tags($new_instance['user_id']);
    $instance['show_icon']      = strip_tags($new_instance['show_icon']);
    $instance['show_caption']   = strip_tags($new_instance['show_caption']);
    return $instance;
  }
 
  function widget($args, $instance){

    extract($args, EXTR_SKIP);

	echo $before_widget;

	$title = apply_filters('widget_title', $instance['title'] ); 

	if($title){

		if($instance['show_icon']){
			$title = '<i class="icon-instagram-filled"></i> '.$title;
		}
		echo $before_title . $title . $after_title; 
	}
	?>
    <div class="widget-body"><?php

		if(empty($instance['user_id'])){
			echo '<div class="alert alert-error" style="margin:0"><h4>Instagram user id not set</h4>';
			echo '<p>Please add your user id in the input field for the widget</p></div>';  			
		}
		elseif(empty($instance['access_token'])){
			echo '<div class="alert alert-error" style="margin:0"><h4>Instagram access token not set</h4>';
			echo '<p>Please add your access token in the input field for the widget</p></div>';     			
		}else{

		    if(($cache = get_transient('blu_instagram')) === false){

		    	// get Photos
		    	$posts_data = @wp_remote_retrieve_body(@wp_remote_get("https://api.instagram.com/v1/users/".$instance['user_id']."/media/recent/?access_token=".$instance['access_token']));
			    try{
			        $posts = json_decode($posts_data);
			 
			    }catch(Exception $ex){
			        $posts = false;
			    }

			    // get author data (followers, photos, following)
		    	$user_data = @wp_remote_retrieve_body(@wp_remote_get("https://api.instagram.com/v1/users/".$instance['user_id']."?access_token=".$instance['access_token']));
				try{
			        $user = json_decode($user_data);
			 
			    }catch(Exception $ex){
			        $user = false;
			    }

				if($user and $posts and !isset($posts->meta->error_message) and !isset($user->meta->error_message)){
					// save to cache for 30 min
			        set_transient( 'blu_instagram', array('posts' => $posts_data, 'user' => $user_data), 1800);
				}else{
					delete_transient( 'blu_instagram' );
				}
		    }else{
				$posts 	= json_decode($cache['posts']);
				$user 	= json_decode($cache['user']);
		    }

				$interactions = array();
				if(!$user and !$posts){
					echo '<div class="alert alert-error" style="margin:0"><h4>Could not load Instagram photos at this time</h4></div>';
				}
				elseif(isset($posts->meta->error_message)){
					echo '<div class="alert alert-error" style="margin:0"><h4>Error</h4>';
					echo '<p>'.$posts->meta->error_message.'</p></div>';     
				}
				else if(isset($user->meta->error_message)){
					echo '<div class="alert alert-error" style="margin:0"><h4>Error</h4>';
					echo '<p>'.$user->meta->error_message.'</p></div>';
				}
				else{ ?>
				<ul class="instagram-header">	
					<li>
						<p><?php echo $user->data->counts->followed_by ?></p>
						<small class="text-muted"><?php _e('Followers', 'bluth_admin'); ?></small>
					</li>	
					<li>
						<p><?php echo $user->data->counts->follows ?></p>
						<small class="text-muted"><?php _e('Following', 'bluth_admin'); ?></small>
					</li>	
					<li>
						<p><?php echo $user->data->counts->media ?></p>
						<small class="text-muted"><?php _e('Photos', 'bluth_admin'); ?></small>
					</li>
				</ul>	
				<div class="instagram-images-container">
					<div class="swiper-container swiper-container-instagram">
					    <a class="arrow-left" href="#"></a>
		    			<a class="arrow-right" href="#"></a>							
						<div class="swiper-wrapper">
							<?php foreach ($posts->data as $post) { ?>
							<div class="swiper-slide"> 
								<a href="<?php echo $post->link ?>" style="background-image: url('<?php echo $post->images->low_resolution->url ?>')">
									<div class="instagram-interactions">
										<i class="icon-comment-1"></i>&nbsp;<?php echo $post->comments->count ?>
										<i class="icon-heart-1"></i>&nbsp;<?php echo $post->likes->count ?>
										<?php if($instance['show_caption'] == 'always' || $instance['show_caption'] == 'on_hover'){ ?>
											<span class="caption_text <?php echo $instance['show_caption']; ?>">&nbsp;<?php echo $post->caption->text ?></span>
										<?php } ?>
										<span class="pull-right"><?php echo date('M j, Y', $post->created_time) ?></span>
									</div>
								</a>
							</div>
							<?php } ?>
						</div> <!-- swiper-wrapper -->
					</div> <!-- swiper-container -->
				</div><?php
				}
			} ?>
      </div><?php

	echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("blu_instagram");') );
<?php

class bl_newsletter extends WP_Widget{

  function __construct(){
    parent::__construct('bl_newsletter', 'Bluthemes - Newsletter', array('classname' => 'bl_newsletter', 'description' => 'Mailchimp newsletter signup' ));

	/*    
	if ( is_active_widget(false, false, $this->id_base) ){
    	wp_enqueue_script( 'breeze-mailchimp', get_template_directory_uri() . '/assets/js/mailchimp.js', array('jquery'), BLISS_VERSION, true );
    }*/
  }
 
  function form($instance){

	    $instance = wp_parse_args( (array) $instance, array( 
	    	'title' => 'Sign up to our Newsletter!', 
	    	'text' => 'Enter your email address below to subscribe to our newsletter.', 
	    	'list_id' => '',
			'api_key' => ''
	    	));
	    
	    $title  	= apply_filters('title', $instance['title']);
	    $text		= apply_filters('text', $instance['text']);
	    $api_key	= apply_filters('api_key', $instance['api_key']);
	    $list_id	= apply_filters('list_id', $instance['list_id']);

	if(empty($api_key)){ ?>

	  <strong>Instructions</strong>
	  <p>You need to have an account at Mailchimp.com to get an API key. Mailchimp has a free plan available.</p>
	  <ol>
	    <li>Create an account at <a href="http://eepurl.com/AfnZT" target="_blank">MailChimp</a></li>
	    <li>Login to Mailchimp and go to Account -> API keys</li>
	    <li>Add a key and copy it</li>
	    <li>Paste the API key in the input field below</li>
	  </ol>
	  <hr>
	<?php } ?>

		<p>
		<label for="<?php echo $this->get_field_id('api_key'); ?>">API key</label><br>
		<input style="width:216px" id="<?php echo $this->get_field_id('api_key'); ?>" name="<?php echo $this->get_field_name('api_key'); ?>" value="<?php echo $api_key; ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title</label><br>
		<input style="width:216px" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('text'); ?>">Text</label><br>
		<input style="width:216px" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $text; ?>">
		</p>
	<?php if(!empty($api_key)){ 

		require_once(get_template_directory().'/inc/mailchimp/MCAPI.class.php');

		// grab an API Key from http://admin.mailchimp.com/account/api/
		try{
			$api = new MCAPI($api_key);
			if($api){
				$lists 	= $api->lists();

				if ($api->errorCode){
					echo "<strong>Unable to load lists!</strong>";
					echo "<p>".$api->errorMessage."</p>";	
				}else{

					if(isset($lists['total']) and $lists['total'] == 0){
						echo '<p>You need to create a list first on mailchimp.com</p>';
					
					}elseif(isset($lists['total'])){ ?>

						<p>
							<label for="<?php echo $this->get_field_id('list'); ?>">Select mail list</label><br>
							<select style="width:216px" id="<?php echo $this->get_field_id('list_id'); ?>" name="<?php echo $this->get_field_name('list_id'); ?>">
							  	<?php
								  foreach ($lists['data'] as $mail_list) {
								  	if($list_id == $mail_list['id']){

								 	echo '<option value="'.$mail_list['id'].'" selected="">'.$mail_list['name'].'</option>'; 	
								  	}else{
								  		
								 	echo '<option value="'.$mail_list['id'].'">'.$mail_list['name'].'</option>'; 	
								  	}
								  }
								?>  
							</select>
						</p> <?php

					}
				}
			}
		}catch(Exception $e){
			echo $e;
		}
	}
  }
 
  function update($new_instance, $old_instance){

	    $instance = $old_instance;
	    $instance['title']		= strip_tags($new_instance['title']);
	    $instance['text']       = strip_tags($new_instance['text']);
	    $instance['api_key']    = strip_tags($new_instance['api_key']);
	    $instance['list_id']    = strip_tags($new_instance['list_id']);
	    return $instance;
  }
 
  function widget($args, $instance){

    extract($args, EXTR_SKIP);
    echo $before_widget;
    ?>
	<?php echo !empty($instance['title']) ? $before_title.$instance['title'].$after_title : '' ?>
	<div class="widget-body">
	<?php echo !empty($instance['text']) ? '<p>'.$instance['text'].'</p>' : '' ?>
	<div class="input-append">
	    <input class="bl_newsletter_email" type="text" placeholder="<?php _e('Email address', 'bluth_admin'); ?>">
	    <button data-list="<?php echo $instance['list_id']; ?>" class="btn btn-success" type="button"><?php _e('Subscribe!', 'bluth_admin'); ?></button>
	</div>
	</div>
    <script type="text/javascript">
		window.locale = {
	        "no_email_provided": '<?php _e('No email provided!', 'bluth_admin'); ?>', 
	        "thank_you_for_subscribing": '<?php _e('Thank you for subscribing!', 'bluth_admin'); ?>', 
		};
    </script>
    <?php
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("bl_newsletter");') );
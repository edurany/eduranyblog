<?php

class bl_social_counter extends WP_Widget {

	function __construct(){
		parent::__construct('bl_social_counter', 'Bluthemes - Social Counter', array('classname' => 'bl_social_counter', 'description' => 'Get the social reach of your pages' ));
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, 
			array( 
				'title' => '', 
				'facebook' => '',
				'twitter' => '',
				'gplus' => '',
				'instagram' => ''
			) 
		); 
		$title 	= esc_textarea($instance['title']);
		$facebook 	= esc_textarea($instance['facebook']);
		$twitter 	= esc_textarea($instance['twitter']);
		$googleplus = esc_textarea($instance['gplus']);
		$instagram 	= esc_textarea($instance['instagram']); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bluth_admin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
	    <p>
      		<label for="<?php echo $this->get_field_id('facebook'); ?>">Facebook:</label><br />
			<input type="text" class="widefat" value="<?php echo $facebook; ?>" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" placeholder="bluthemes">
	    </p>
	    <p>
      		<label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter:</label><br />
			<input type="text" class="widefat" value="<?php echo $twitter; ?>" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" placeholder="bluthemes">
	    </p>
	    <p>
      		<label for="<?php echo $this->get_field_id('gplus'); ?>">Google+:</label><br />
			<input type="text" class="widefat" value="<?php echo $googleplus; ?>" id="<?php echo $this->get_field_id('gplus'); ?>" name="<?php echo $this->get_field_name('gplus'); ?>" placeholder="116124120939614234044">
	    </p>
	    <p>
      		<label for="<?php echo $this->get_field_id('instagram'); ?>">Instagram:</label><br />
			<input type="text" class="widefat" value="<?php echo $instagram; ?>" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" placeholder="bluthdesign">
	    </p>

	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['facebook']	=  $new_instance['facebook'];
		$instance['twitter'] 	=  $new_instance['twitter'];
		$instance['gplus']=  $new_instance['gplus'];
		$instance['instagram'] 	=  $new_instance['instagram'];
		$instance['filter'] = isset($new_instance['filter']);
 		
 		delete_transient( 'bl_social_counter' );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract($args);

		$title 		= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$social_sites = wp_parse_args( (array) $instance, array( 'facebook' => '', 'gplus' => '', 'twitter' => '') );
		$social_sites = array_filter($social_sites);

		echo $before_widget;
		echo !empty($title) ? $before_title.$title.$after_title : ''; ?>
		
		<div class="widget-body">
			<?php 

			$social_authority = bl_get_social_counter($social_sites);

			$social_locale = array(
				'facebook' => array( 'suffix' => 'likes', 'url' => 'http://www.facebook.com/'),
				'twitter' => array( 'suffix' => 'followers', 'url' => 'http://www.twitter.com/'),
				'gplus' => array( 'suffix' => 'people', 'url' => 'https://plus.google.com/'),
				'instagram' => array( 'suffix' => 'followers', 'url' => 'http://www.instagram.com/'),
			); 
			?>


			<ul class="list-unstyled"><?php
			
			foreach ($social_authority as $key => $value) { ?>
				<li class="<?php echo $key; ?>"><a href="<?php echo $social_locale[$key]['url'].$social_sites[$key]; ?>" target="_blank"><div class="bl_wrapper"><i class="icon-<?php echo $key; ?>-1"></i><h4><?php echo number_format($value, 0, ',','.'); ?></h4><small><?php echo $social_locale[$key]['suffix']; ?></small></div></a></li><?php
			} ?>

			</ul>
		</div><?php
		
		echo $after_widget;
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("bl_social_counter");') );


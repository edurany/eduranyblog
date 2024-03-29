<?php

class bl_imagebox extends WP_Widget {

	function __construct(){
		parent::__construct('bl_imagebox', 'Bluthemes - imagebox', array('classname' => 'bl_imagebox', 'description' => 'imagebox information badge' ));
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'imagebox_name' => '', 'text' => '', 'image_bg_uri' => false, 'footer' => '') );
		
		$title 				= strip_tags($instance['title']);
		$imagebox_name 		= strip_tags( $instance['imagebox_name']);
		$text 				= esc_textarea($instance['text']);
		$footer 			= esc_textarea($instance['footer']);
		$image_bg_uri 		= esc_url( $instance['image_bg_uri']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bluth_admin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
	    <p>
      		<label for="<?php echo $this->get_field_id('image_bg_uri'); ?>">Background image:</label><br />
			<input type="hidden" name="<?php echo $this->get_field_name('image_bg_uri'); ?>" id="<?php echo $this->get_field_id('image_bg_uri'); ?>" value="<?php echo $image_bg_uri; ?>" />
			<input class="button" onClick="bl_open_uploader(this, 'uploaded_imagebox_bg_image')" id="bluth_image_upload" value="Upload" />
	    </p>
      	<p class="uploaded_imagebox_bg_image">
      		<img src="<?php echo $image_bg_uri; ?>" style="width:100%;">
      	</p>
      	<hr style="background:#ddd;height: 1px;margin: 15px 0px;border:none;">
	    <p>
      		<label for="<?php echo $this->get_field_id('imagebox_name'); ?>">Header:</label><br />
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('imagebox_name'); ?>" name="<?php echo $this->get_field_name('imagebox_name'); ?>" value="<?php echo $imagebox_name; ?>">
	    </p>
	    <p>
      		<label for="<?php echo $this->get_field_id('text'); ?>">Text:</label><br />
			<textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
	    </p>
	    <p>
      		<label for="<?php echo $this->get_field_id('footer'); ?>">Footer Text:</label><br />
			<textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('footer'); ?>" name="<?php echo $this->get_field_name('footer'); ?>"><?php echo $footer; ?></textarea>
	    </p>

	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['imagebox_name'] 			= strip_tags($new_instance['imagebox_name']);
		$instance['image_bg_uri'] 		= $new_instance['image_bg_uri'];

		if ( current_user_can('unfiltered_html') ){
			$instance['text'] =  $new_instance['text'];
			$instance['footer'] =  $new_instance['footer'];
		}
		else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );
			$instance['footer'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['footer']) ) );
		}
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function widget( $args, $instance ) {
		extract($args);
		$title 	= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text 	= apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$footer 	= apply_filters( 'widget_text', empty( $instance['footer'] ) ? '' : $instance['footer'], $instance );
		$imagebox_name 	= apply_filters( 'widget_text', empty( $instance['imagebox_name'] ) ? '' : $instance['imagebox_name'], $instance );


		echo $before_widget;
		echo !empty($title) ? '<h3 class="widget-head">'.$title.'</h3>' : '';

		echo '<img src="'.esc_url($instance['image_bg_uri']).'" />';
			echo '<div class="widget-body">';

				echo '<div class="bl_imagebox_bio">';
				echo !empty( $imagebox_name ) ? '<h3>'.$imagebox_name.'</h3>' : '';
				echo '<p class="muted">'.(!empty( $instance['filter'] ) ? wpautop( $text ) : $text).'</p>';
				echo '</div>';
				echo '<div class="widget-footer">';
					echo '<p class="muted">'.(!empty( $instance['filter'] ) ? wpautop( $footer ) : $footer).'</p>';
				echo '</div>';
			echo '</div>';
		echo $after_widget;
	}
}
add_action( 'widgets_init', function() { return register_widget("bl_imagebox"); } );

add_action('admin_enqueue_scripts', 'blu_media_enqueue');

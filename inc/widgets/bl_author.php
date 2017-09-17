<?php

class bl_author extends WP_Widget {

	function __construct(){
		parent::__construct('bl_author', 'Bluthemes - Author', array('classname' => 'bl_author', 'description' => 'Author information badge' ));
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'author_name' => '', 'text' => '', 'image_bg_uri' => false, 'image_author_uri' => false) );
		
		$title 				= strip_tags($instance['title']);
		$author_name 		= strip_tags( $instance['author_name']);
		$text 				= esc_textarea($instance['text']);
		$image_bg_uri 		= esc_url( $instance['image_bg_uri']);
		$image_author_uri 	= esc_url( $instance['image_author_uri']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bluth_admin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
	    <p>
      		<label for="<?php echo $this->get_field_id('image_bg_uri'); ?>">Background image:</label><br />
			<input type="hidden" name="<?php echo $this->get_field_name('image_bg_uri'); ?>" id="<?php echo $this->get_field_id('image_bg_uri'); ?>" value="<?php echo $image_bg_uri; ?>" />
			<input class="button" onClick="bl_open_uploader(this, 'uploaded_bg_image')" id="bluth_image_upload" value="Upload" />
	    </p>
      	<p class="uploaded_bg_image">
      		<img src="<?php echo $image_bg_uri; ?>" style="width:100%;">
      	</p>
      	<hr style="background:#ddd;height: 1px;margin: 15px 0px;border:none;">
	    <p>
      		<label for="<?php echo $this->get_field_id('image_author_uri'); ?>">Author image: <small>Recommended 1:1 ( 90x90 )</small></label><br />
			<input type="hidden" name="<?php echo $this->get_field_name('image_author_uri'); ?>" id="<?php echo $this->get_field_id('image_author_uri'); ?>" value="<?php echo $image_author_uri; ?>" />
			<input class="button" onClick="bl_open_uploader(this, 'uploaded_author_image')" id="bluth_image_upload" value="Upload" />
	    </p>
      	<p class="uploaded_author_image">
      		<img src="<?php echo $image_author_uri; ?>" style="width:100%;">
      	</p>
      	<hr style="background:#ddd;height: 1px;margin: 15px 0px;border:none;">
	    <p>
      		<label for="<?php echo $this->get_field_id('author_name'); ?>">Author Name:</label><br />
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('author_name'); ?>" name="<?php echo $this->get_field_name('author_name'); ?>" value="<?php echo $author_name; ?>">
	    </p>
	    <p>
      		<label for="<?php echo $this->get_field_id('text'); ?>">Bio:</label><br />
			<textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
	    </p>

	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['author_name'] 			= strip_tags($new_instance['author_name']);
		$instance['image_bg_uri'] 		= $new_instance['image_bg_uri'];
		$instance['image_author_uri'] 		= $new_instance['image_author_uri'];

		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function widget( $args, $instance ) {
		extract($args);
		$title 	= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text 	= apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$author_name 	= apply_filters( 'widget_text', empty( $instance['author_name'] ) ? '' : $instance['author_name'], $instance );


		echo $before_widget;
		echo !empty($title) ? '<h3 class="widget-head">'.$title.'</h3>' : '';

		echo '<img src="'.esc_url($instance['image_bg_uri']).'" />';
			echo '<div class="widget-body">';

				if(!empty($instance['image_author_uri'])){
					echo '<div class="bl_author_img"><img src="'.esc_url($instance['image_author_uri']).'" /></div>';
				}
				echo '<div class="bl_author_bio">';
				echo !empty( $author_name ) ? '<h3>'.$author_name.'</h3>' : '';
				echo '<p class="muted">'.(!empty( $instance['filter'] ) ? wpautop( $text ) : $text).'</p>';
				echo '</div>';
			echo '</div>';

		echo $after_widget;
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("bl_author");') );

add_action('admin_enqueue_scripts', 'blu_media_enqueue');
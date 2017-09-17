<?php

add_action( 'widgets_init', 'blu_flickr' );
function blu_flickr() {
	register_widget( 'blu_flickr_widget' );
}

class blu_flickr_widget extends WP_Widget {
	
	function __construct() {
		parent::__construct( 'flickr-photos', __( 'Bluthemes - Flickr', 'bluth_admin' ), array( 'classname' => 'blu_flickr', 'description' => __( 'Displays recent Flickr photos in a widget', 'bluth_admin' ) ), array( 'width' => 300, 'height' => 350, 'id_base' => 'flickr-photos' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters( 'widget_title', $instance['title'] );
		$user_id = $instance['user_id'];
		$username = $instance['username'];
		$num = $instance['num'];

		$params = array(
			'api_key'  => '07a5b8a2ef5251509df92b7735679bd4',
			'method'   => 'flickr.photos.search',
			'user_id'  => $user_id,
			'per_page' => $num,
			'format'   => 'php_serial',
		);
		$encoded_params = array();

		echo $before_widget;

		// Display the widget title
		echo !empty($instance['title']) ? '<h3 class="widget-head">'.$instance['title'].'<a href="https://www.flickr.com/photos/' . $username . '" target="_blank">' . $username . '</a></h3>' : '' ?>
  		<div class="widget-body"> 
			<div class="flickr-images-container">
				<div class="swiper-container swiper-container-flickr">
				    <a class="arrow-left" href="#"></a>
	    			<a class="arrow-right" href="#"></a>
	    			<div class="swiper-wrapper"> <?php
						foreach ( $params as $k => $v ) { $encoded_params[] = urlencode( $k ) . '=' . urlencode( $v ); }
						# call the API and decode the response
						$url = "https://api.flickr.com/services/rest/?" . implode( '&', $encoded_params );
						$rsp = file_get_contents( $url );
						$rsp_obj = unserialize( $rsp );

						# display the photo title (or an error if it failed)
						if ( $rsp_obj['stat'] == 'ok' ) {
							$isfirst = true;
							foreach ( $rsp_obj['photos']['photo'] as $photo ) { ?>
									<div class="swiper-slide"> 
										<a style="background-image: url('https://farm<?php echo $photo['farm'] ?>.staticflickr.com/<?php echo $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret']; ?>.jpg');"></a>
									</div><?php
								}
							}

						else { ?>
							<div class="swiper-slide">  
								<span style="padding: 50px 0; color: red;">Call Failed</span><br>
								<span style="padding: 50px 0; color: red;">(<?php echo $rsp_obj['message']; ?>)</span>
							</div><?php
						}  ?>
					</div> <!-- swiper-wrapper -->
				</div> <!-- swiper-container -->
			</div>
			<!-- <div class="left_arrow flickr_arrow visible-desktop"><i class="icon-left-open-1"></i></div> -->
			<!-- <div class="right_arrow flickr_arrow visible-desktop"><i class="icon-right-open-1"></i></div> -->
		</div>

		<?php echo $after_widget;
	}

	//Update the widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['user_id'] = $new_instance['user_id'];
		$instance['username'] = $new_instance['username'];
		$instance['num'] = strip_tags( $new_instance['num'] );

		return $instance;
	}


	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => '', 'num' => '9', 'user_id' => '', 'username' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		$html = "";
		$html .= '<p>';
		$html .= '<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', 'bluth_admin' ) . '</label>';
		$html .= '<input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . $instance['title'] . '" style="width:100%;" />';
		$html .= '</p>';

		$html .= '<p>';
		$html .= '<label for="' . $this->get_field_id( 'user_id' ) . '">' . __( 'Flickr ID:', 'bluth_admin' ) . '</label>';
		$html .= '<small>You can find your ID <a href="http://idgettr.com/" target="_blank">here</a></small>';
		$html .= '<input id="' . $this->get_field_id( 'user_id' ) . '" name="' . $this->get_field_name( 'user_id' ) . '" value="' . $instance['user_id'] . '" style="width:100%;" />';
		$html .= '</p>';

		$html .= '<p>';
		$html .= '<label for="' . $this->get_field_id( 'username' ) . '">' . __( 'Flickr Username:', 'bluth_admin' ) . '</label>';
		$html .= '<input id="' . $this->get_field_id( 'username' ) . '" name="' . $this->get_field_name( 'username' ) . '" value="' . $instance['username'] . '" style="width:100%;" />';
		$html .= '</p>';

		$html .= '<p>';
		$html .= '<label for="' . $this->get_field_id( 'num' ) . '">' . __( 'Photos Count:', 'bluth_admin' ) . '</label>';
		$html .= '<select name="' . $this->get_field_name( 'num' ) . '" id="' . $this->get_field_id( 'num' ) . '" class="widefat">';
		$options = array( '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		foreach ( $options as $option ) {
			$html .= '<option value="' . $option . '" id="' . $option . '"';
			$html .= $instance['num'] == $option ? ' selected' : '';
			$html .= '>';
			$html .= $option;
			$html .= '</option>';
		}
		$html .= '</select>';
		$html .= '</p>';

		echo $html;

	}
}
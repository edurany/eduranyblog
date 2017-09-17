<?php

class bl_featured_post extends WP_Widget {

	function __construct(){
		parent::__construct('bl_featured_post', 'Bluthemes - Featured Post', array('classname' => 'bl_featured_post', 'description' => 'Display posts tagged with "featured" or the selected tag in Theme Options'));
	}

	function form($instance){

		$instance = wp_parse_args((array)$instance, array(
			'title' => '',
			'text' => '',
			'post_offset' => 0,
			'order' => '',
			'tag' => 'featured'
		));
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bluth_admin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tag'); ?>"><?php _e('Tag to get:', 'bluth_admin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" type="text" value="<?php echo esc_attr($instance['tag']); ?>" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" <?php checked(isset($instance['excerpt']) ? $instance['excerpt'] : 0); ?> />&nbsp;
			<label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Display the excerpt', 'bluth_admin'); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('post_offset'); ?>">Post Offset:</label>
			<select id="<?php echo $this->get_field_id('post_offset'); ?>" name="<?php echo $this->get_field_name('post_offset'); ?>">
				<?php 
					$i = 0;
					while ($i <= 10) {
						echo '<option value="'.$i.'"'.($i == $instance['post_offset'] ? ' selected=""' : '').'>'.$i.'</option>';
						$i++;
					}
				?>
			</select>
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order By:', 'bluth_admin'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
			  	<option value="date" <?php selected($instance['order'], 'date'); ?>>Date</option> 
			  	<option value="popular" <?php selected($instance['order'], 'popular'); ?>>Popularity(View count)</option> 
			</select>
		</p><?php
	}


	function update($new_instance, $old_instance){

		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['tag'] 			= strip_tags($new_instance['tag']);
		$instance['post_offset'] 	= strip_tags($new_instance['post_offset']);
		$instance['order'] 			= strip_tags($new_instance['order']);
		$instance['excerpt'] 		= isset($new_instance['excerpt']);
		return $instance;
	}



	function widget($args, $instance){

		$instance = wp_parse_args((array)$instance, array(
			'title' => '',
			'post_offset' => 0,
			'tag' => 'featured' 
		));


		$title = apply_filters('widget_title', $instance['title']);


		echo $args['before_widget'];

		    $query_args = array(
				'tag_slug__in' 			=> explode(',', $instance['tag']),
				'posts_per_page' 		=> 10,
	    		'ignore_sticky_posts'	=> 1, 
	    		'order' 				=> 'DESC'
	    	);

		    if($instance['post_offset']){
				$query_args['offset'] = $instance['post_offset'];
		    }


			if($instance['order'] == 'popular'){
				$query_args['meta_key'] = 'wpb_post_views_count';
				$query_args['orderby'] = 'wpb_post_views_count';
			}


			$query = new WP_Query($query_args);

			echo !empty($title) ? '<h3 class="widget-head">'.$title.'</h3>' : '';
			
			if($query->have_posts()){ 

				?>
				<div class="swiper-container swiper-container-featured">
				    <a class="arrow-left" href="#"></a>
					<a class="arrow-right" href="#"></a>
		    		<div class="swiper-pagination"></div>
					<div class="swiper-wrapper"><?php 

						while($query->have_posts()){ 
							$query->the_post(); ?> 
							<div class="swiper-slide swiper-slide-large" style="width:763px;">
					        	<a href="<?php the_permalink(); ?>" style="background-image: url('<?php echo get_post_image( $query->post->ID, 'featured_post' ); ?>')">
					        		<h3 class="post-title"><?php
					        			echo $query->post->post_title;

						        		if(!empty($instance['excerpt'])){ ?>
						        			<p><?php echo bl_truncate(get_the_excerpt(), 65, ' '); ?></p><?php
						        		} ?>
					        		</h3>
					        	</a>
							</div><?php 
						} ?>
					</div>
				</div><?php
			}

			wp_reset_postdata();
		echo $args['after_widget'];
	}

}
add_action( 'widgets_init', create_function('', 'return register_widget("bl_featured_post");') );
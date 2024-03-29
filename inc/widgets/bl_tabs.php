<?php

class bl_tabs extends WP_Widget{
	
  function __construct(){
    parent::__construct('bl_tabs', 'Bluthemes - Tabs', array('classname' => 'bl_tabs', 'description' => 'Displays tabs with Recent posts, Recent comments and Tags' ));
  }
 
  function form($instance){

    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];

    $show_recent_posts 		= empty($instance['show_recent_posts']) ? 'No' : $instance['show_recent_posts'];
    $show_recent_comments 	= empty($instance['show_recent_comments']) ? 'No' : $instance['show_recent_comments'];
    $show_tags 				= empty($instance['show_tags']) ? 'No' : $instance['show_tags'];
    $num_tags 				= empty($instance['num_tags']) ? 20 : $instance['num_tags'];
    $num_posts 				= empty($instance['num_posts']) ? 5 : $instance['num_posts'];
    $num_comments 			= empty($instance['num_comments']) ? 5 : $instance['num_comments'];
    $cat_posts 				= empty($instance['cat_posts']) ? array() : $instance['cat_posts'];
	?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title</label><br>
		<input style="width:216px" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>">
	</p>	
	<p>
		<label for="<?php echo $this->get_field_id('show_recent_posts'); ?>">Show recent posts:</label>
		<select id="<?php echo $this->get_field_id('show_recent_posts'); ?>" name="<?php echo $this->get_field_name('show_recent_posts'); ?>">
			<option value="Yes" <?php echo ($show_recent_posts == 'Yes') ? 'selected' : ''; ?>>Yes</option>
			<option value="No" <?php echo ($show_recent_posts == 'No') ? 'selected' : ''; ?>>No</option>
		</select>
	</p>	
	<p>
		<label for="<?php echo $this->get_field_id('num_posts'); ?>">No. of posts to show:</label>
		<select id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>">
			<?php 
				$i = 1;
				while ($i <= 15) {
					echo ($i == $num_posts) ? '<option value="'.$i.'" selected="">'.$i.'</option>' : '<option value="'.$i.'">'.$i.'</option>';
					$i++;
				}
			?>
		</select>
	</p>	
	<p>
		<label for="<?php echo $this->get_field_id('cat_posts'); ?>">Show posts from these categories:</label>
		<select class="widefat" id="<?php echo $this->get_field_id('cat_posts'); ?>" name="<?php echo $this->get_field_name('cat_posts'); ?>[]" multiple>
			<?php 

				$category_ids = get_all_category_ids();
				foreach($category_ids as $cat_id) {
				 	$cat_name = get_cat_name($cat_id);
				 	echo (in_array($cat_id, $cat_posts)) ? '<option value="'.$cat_id.'" selected>'.$cat_name.'</option>' : '<option value="'.$cat_id.'">'.$cat_name.'</option>';
				}
			?>
		</select>
		<p style="font-size:12px;color:#888">Hold Ctrl/Command to select multiple options.</p>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('show_recent_comments'); ?>">Show recent comments:</label>
		<select id="<?php echo $this->get_field_id('show_recent_comments'); ?>" name="<?php echo $this->get_field_name('show_recent_comments'); ?>">
			<option value="Yes" <?php echo ($show_recent_comments == 'Yes') ? 'selected' : ''; ?>>Yes</option>
			<option value="No" <?php echo ($show_recent_comments == 'No') ? 'selected' : ''; ?>>No</option>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('num_comments'); ?>">No. of comments to show:</label>
		<select id="<?php echo $this->get_field_id('num_comments'); ?>" name="<?php echo $this->get_field_name('num_comments'); ?>">
			<?php 
				$i = 1;
				while ($i <= 15) {
					echo ($i == $num_comments) ? '<option value="'.$i.'" selected="">'.$i.'</option>' : '<option value="'.$i.'">'.$i.'</option>';
					$i++;
				}
			?>
		</select>
	</p>	
	<p>
		<label for="<?php echo $this->get_field_id('show_tags'); ?>">Show tags:</label>
		<select id="<?php echo $this->get_field_id('show_tags'); ?>" name="<?php echo $this->get_field_name('show_tags'); ?>" value="<?php echo $show_tags; ?>">
			<option value="Yes" <?php echo ($show_tags == 'Yes') ? 'selected' : ''; ?>>Yes</option>
			<option value="No" <?php echo ($show_tags == 'No') ? 'selected' : ''; ?>>No</option>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('num_tags'); ?>">No. of tags to show:</label>
		<select id="<?php echo $this->get_field_id('num_tags'); ?>" name="<?php echo $this->get_field_name('num_tags'); ?>">
			<?php 
				$i = 1;
				while ($i <= 50) {
					echo ($i == $num_tags) ? '<option value="'.$i.'" selected="">'.$i.'</option>' : '<option value="'.$i.'">'.$i.'</option>';
					$i++;
				}
			?>
		</select>
	</p>	
	<?php
  }
 
  function update($new_instance, $old_instance){

    $instance = $old_instance;
    $instance['title'] 					= strip_tags($new_instance['title']);
    $instance['show_recent_posts'] 		= strip_tags($new_instance['show_recent_posts']);
    $instance['show_recent_comments'] 	= strip_tags($new_instance['show_recent_comments']);
    $instance['show_tags'] 				= strip_tags($new_instance['show_tags']);
    $instance['num_tags'] 				= strip_tags($new_instance['num_tags']);
    $instance['num_posts'] 				= strip_tags($new_instance['num_posts']);
    $instance['num_comments'] 			= strip_tags($new_instance['num_comments']);
    $instance['cat_posts'] 				= $new_instance['cat_posts'];
    return $instance;
  }
 
  function widget($args, $instance){

    extract($args, EXTR_SKIP);
 
    $show_recent_posts 		= $instance['show_recent_posts'] == 'No' ? false : true;
    $show_recent_comments 	= $instance['show_recent_comments'] == 'No' ? false : true;
    $show_tags 				= $instance['show_tags'] == 'No' ? false : true;
    $num_tags 				= (isset($instance['num_tags']) and is_numeric($instance['num_tags'])) ? $instance['num_tags'] : 20;
    $num_posts 				= (isset($instance['num_posts']) and is_numeric($instance['num_posts'])) ? $instance['num_posts'] : 5;
    $num_comments 			= (isset($instance['num_comments']) and is_numeric($instance['num_comments'])) ? $instance['num_comments'] : 5;
 
	echo $before_widget;
    ?>
    <?php echo !empty($instance['title']) ? '<h3 class="widget-head">'.$instance['title'].'</h3>' : '' ?>
	    <ul class="nav nav-tabs" id="bl_side_tabs">
		    <?php if($show_recent_posts){ ?><li class="active"><a href="#bl_side_posts"><?php _e('Posts', 'bluth'); ?></a></li><?php } ?>
		    <?php if($show_recent_comments){ ?><li><a href="#bl_side_comments"><?php _e('Comments', 'bluth'); ?></a></li><?php } ?>
		    <?php if($show_tags){ ?><li><a href="#bl_side_tags"><?php _e('Tags', 'bluth'); ?></a></li><?php } ?>
	    </ul>
	     
	    <div class="tab-content clearfix">
		    <?php if($show_recent_posts){ ?>
		    	<div class="tab-pane active" id="bl_side_posts">
					<ul>
					    <?php
					        global $post;
					        $args = array( 'numberposts' => $num_posts);

					        if(!empty($instance['cat_posts'])){
					        	 $args['category'] = implode(',', $instance['cat_posts']);
					        }

					        $myposts = get_posts( $args );
					        foreach($myposts as $post){ setup_postdata($post); ?>
					        <li> <?php 
					        	$post_thumbnail = get_post_image($post->ID, 'mini');
				        		// if ( $images = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image' ))){ 
				        		if ( $post_thumbnail ){ 

/*					        		$image = current($images);
					        		$image = wp_get_attachment_image_src($image->ID, 'mini');*/
									// echo '<a class="tab_attachment" href="'. get_permalink().'"><img src="'.$image[0].'" /></a>';
									echo '<a class="tab_attachment" href="'. get_permalink().'"><img width="80" height="80" src="'.$post_thumbnail.'" /></a>';
								}else{
									$post_format = (get_post_format()) ? get_post_format() : 'standard'; 	

									$icon = of_get_option($post_format.'_icon', false);
									$icon_default = array('standard' => 'icon-calendar-3', 'audio' => 'icon-volume-up', 'video' => 'icon-videocam','quote' => 'icon-quote-left', 'link' => 'icon-link', 'image' => 'icon-picture-1', 'gallery' => 'icon-picture');
									$icon = ($icon !== false) ? $icon : $icon_default[$post_format];

									echo '<a class="tab_attachment" href="'. get_permalink().'">';
									echo '<div class="tab_icon tab_'.$post_format.'">';
									echo '<i class="'.$icon.'"></i>';
									echo '</div>';
									echo '</a>';
								} 
					        	echo '<div class="tab_text"><h5><a href="'. get_permalink().'">'.get_the_title().'</a><small> <time class="entry-date" datetime="' . get_the_date( 'c' ) . '">' . get_the_date() . '</time></small></h5></div>'; 
					        	?>
					        </li><?php
					    	}
					    	wp_reset_postdata();
					        ?>
					</ul>
				</div>
			<?php } ?>
		    <?php if($show_recent_comments){ ?>
		    <div class="tab-pane<?php echo $show_recent_posts ? '' : ' active'; ?>" id="bl_side_comments">
		    	<?php 
		    		$recent_comments = get_comments(array(
					    'number'    => $num_comments,
					    'status'    => 'approve', 
					    'type' 		=> 'comment'
					));
					if(count($recent_comments) > 0){
					echo '<ul>';	
						foreach ($recent_comments as $comment) {
							echo '<li>';
							echo '<div class="tab_attachment">'.get_avatar( $comment, 80 ).'</div>';
							echo '<div class="tab_text">';
							echo '<h5><a href="'.get_permalink($comment->comment_post_ID).'">';
							echo '<span>'.$comment->comment_author.'</span><br>';
							echo (strlen($comment->comment_content) > 50) ? substr($comment->comment_content,0,50).'...' : $comment->comment_content;
							echo '</a></h5></div>';
							echo '</li>';
						}
					echo '</ul>';	
					}
		    	?>
		    </div><?php } ?>
		    <?php if($show_tags){ ?>
		    <div class="tab-pane<?php echo ($show_recent_comments or $show_recent_posts) ? '' : ' active'; ?>" id="bl_side_tags">
		    	<?php
					$tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => $num_tags));
					foreach ( $tags as $tag ) {
						$tag_link = get_tag_link( $tag->term_id );
						echo '<a href="'.$tag_link.'" title="'.$tag->name.' Tag" class="bl_tab_tag">'.$tag->name.'</a>';
					}
				?>
		    </div>
		    <?php } ?>
	    </div>
	     
	    <script type="text/javascript">
	    jQuery(function () {
		    jQuery('#bl_side_tabs a').click(function (e) {
			    e.preventDefault();

			    jQuery('.bl_tabs .tab-content ul li').css('right', '-110%');

			    jQuery(this).tab('show');
		    	jQuery(jQuery(this).attr('href')).find('li').each(function(i){
		    		jQuery(this).delay(50*i).animate({right: '0'}, 150, 'swing');
		    	});	
		    });
		    setTimeout(function(){
				jQuery('.bl_tabs .tab-content .active ul li').each(function(i){
					jQuery(this).delay(50*i).animate({right: '0'}, 150, 'swing');
				});	
		    },500)

	    });
	    </script>
    <?php
	echo $after_widget;
  }
}
add_action( 'widgets_init', function() {return register_widget("bl_tabs");} );
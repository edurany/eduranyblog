<?php

class bl_googlebadge extends WP_Widget
{
  function __construct(){
    parent::__construct('bl_googlebadge', 'Bluthemes - Google Badge', array('classname' => 'bl_googlebadge', 'description' => 'Displays Google+ Badge' ));
  }
 
  function form($instance){

    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    

    $title        = !empty($instance['title']) ? $instance['title'] : '';
    $embed_code   = !empty($instance['embed_code']) ? $instance['embed_code'] : '';

  ?>
  <p>
    <label for="<?php echo $this->get_field_id('title'); ?>">Title</label><br>
    <input style="width:216px" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>">
  </p>
  <strong>Instructions</strong>
  <ol>
    <li>Create your Google+ badge <a href="https://developers.google.com/+/web/badge/" target="_blank">here</a></li>
    <li>Make it 360 in width for full width</li>
    <li>Copy the embed code</li>
    <li>Paste it in the input box below</li>
  </ol>
  <p>
    <label for="<?php echo $this->get_field_id('embed_code'); ?>">Google+ badge code</label><br>
    <textarea style="width:216px" id="<?php echo $this->get_field_id('embed_code'); ?>" onClick="jQuery(this).select();" name="<?php echo $this->get_field_name('embed_code'); ?>"><?php echo $embed_code; ?></textarea>
  </p>
  <?php
  }
 
  function update($new_instance, $old_instance){

    $instance = $old_instance;
    $instance['title']          = strip_tags($new_instance['title']);
    $instance['embed_code']     = $new_instance['embed_code'];
    return $instance;
  }
 
  function widget($args, $instance){

    extract($args, EXTR_SKIP);

    echo $before_widget;
    ?>
      <?php echo !empty($instance['title']) ? '<h3 class="widget-head"><i class="icon-gplus-2"></i> '.$instance['title'].'</h3>' : '' ?>
      <div class="widget-body" id="googlebadge">
        <?php echo empty($instance['embed_code']) ? '' : $instance['embed_code']; ?>
      </div>
    <?php
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("bl_googlebadge");') );
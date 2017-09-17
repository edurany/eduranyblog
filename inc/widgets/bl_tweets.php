<?php

class bl_tweets extends WP_Widget{

  function __construct(){
    parent::__construct('bl_tweets', 'Bluthemes - Tweets', array('classname' => 'bl_tweets', 'description' => 'Displays recent tweets' ));
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
    <li>Create your Tweet widget <a href="https://twitter.com/settings/widgets/new" target="_blank">here</a></li>
    <li>Copy the embed code</li>
    <li>Paste it in the input box below</li>
  </ol>
  <p>
    <label for="<?php echo $this->get_field_id('embed_code'); ?>">Twitter embed code</label><br>
    <textarea style="width:216px" id="<?php echo $this->get_field_id('embed_code'); ?>" onClick="jQuery(this).select();" name="<?php echo $this->get_field_name('embed_code'); ?>" value="<?php echo $embed_code; ?>"></textarea>
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
      <?php echo !empty($instance['title']) ? '<h3 class="widget-head"><i class="icon-twitter-1"></i> '.$instance['title'].'</h3>' : '' ?>
      <div class="widget-body" id="tweets">
        <?php echo empty($instance['embed_code']) ? '' : $instance['embed_code']; ?>
      </div>
    <?php
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("bl_tweets");') );
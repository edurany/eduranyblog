<?php
/* 
Plugin Name: BluthCodes
Plugin URI: http://www.bluth.is/
Description: A Shortcode plugin from The Bluth Company
Version: 1.06
Author: The Bluth Company
Author URI: http://www.bluth.is
*/

/* Updated: 18. september 2013 */

	function bluth_pullquote($atts, $content = null){

		extract(shortcode_atts(array('align'=> 'left', 'background' => 'off'),$atts));
		return '<blockquote class="pullquote '.(($align == 'right') ? 'pull-right' : 'pull-left').'" style="' . (( $background == 'off' ) ? 'background-color: transparent; border: none;' : '' ) . '"><p class="pullquote-text">'.do_shortcode($content).'</p></blockquote>';
	}

	/**
	 * Dropcaps 
	 * @param  array $atts Array of attributes
	 * @return html returns a drop cap
	 */
	function bluth_dropcap($atts, $content = null){

		extract(shortcode_atts(array('background'=> '', 'color' => '#333333', 'size' => ''),$atts));
		return '<span class="dropcap'.((empty($background) or $background == 'no') ? '' : ' dropcap-bg').'" style="' . ((empty($background) or $background == 'no') ? 'color:' . $color : 'background-color:' . $color ) . '; ' . (empty($size) ? '' : 'font-size:' . $size ) . ';">'.do_shortcode($content).'</span>';
	}

	/**
	 * Bullet List 
	 * @param  array $atts Array of attributes
	 * @return html returns a drop cap
	 */
	function bluth_bulletlist($atts, $content = null){

		extract(shortcode_atts(array('title' => '', 'align'=> 'left', 'background' => 'off'),$atts));
		if($title){
			$title = '<h4>' . $title . '</h4>';
		}
		return '<div class="bulletlist ' . $align . '" style="float:' . $align . '; ' . (( $background == 'off' ) ? 'background-color: transparent; border: none;' : '' ) . '">'.$title.'<ul>' . do_shortcode($content) . '</ul></div>';
	}
	function bluth_bulletlist_item($atts, $content = null){
		// extract(shortcode_atts(array('align'=> 'left', 'background' => 'off'),$atts));
		return '<li>' . do_shortcode($content) . '</li>';
		
	}

	/**
	 * Alert box 
	 * @param  array $atts Array of attributes
	 * @return html returns an alert box
	 */
	function bluth_alert($atts, $content = null){

		extract(shortcode_atts(array(
	      'style' 	=> 'blue',
	      'close'	=> 'true'
	    ),$atts));

		$html  = '<div class="alert bluth ' . $style . '">';
		if($close == 'true'){
			$html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		}
		$html .= do_shortcode($content);
		$html .= '</div>';
		return $html;
	}

	/**
	 * Social
	 * @param  array $atts Aattributes
	 * @return returns a social link
	 */
	function bluth_social($atts, $content = null){
		extract(shortcode_atts(array('media'=> '', 'url' => ''),$atts));
		$name = $media;
		switch($media){
			case 'twitter':
			case 'linkedin':
				$media .= '-1';
			break;
			case 'flickr':
			case 'pinterest':
				$media .= '-circled';
			break;
			case 'vimeo':
			case 'tumblr':
				$media .= '-rect';
			break;
			case 'instagram':
				$media .= '-filled';
			break;
		}
		return '<a href="'.$url.'" class="bl-social-icon tips" data-title="'.$name.'"><i class="icon-'.$media.'"></i></a>';
	}

	/**
	 * Label
	 * @param  array $atts Aattributes
	 * @return html label span
	 */
	function bluth_label($atts, $content = null){

		extract(shortcode_atts(array('style'=> ''),$atts));
		return '<span class="label bluth ' . $style . '">' . do_shortcode($content) . '</span>';
	}

	/**
	 * Badge
	 * @param  array $atts Aattributes
	 * @return html badge span
	 */
	function bluth_badge($atts, $content = null){

		extract(shortcode_atts(array('style'=> ''),$atts));
		return '<span class="badge bluth ' . $style . '">'.do_shortcode($content).'</span>';
	}

	/**
	 * Well
	 * @param  array $atts Aattributes
	 * @return html well inset effect
	 */
	function bluth_well($atts, $content = null){
		$content = wpautop(trim($content));
		return '<div class="well">'.do_shortcode($content).'</div>';
	}

	/**
	 * Button
	 * @param  array $atts Aattributes
	 * @return html style button link
	 */
	function bluth_button($atts, $content = null){

		extract(shortcode_atts(array(
        'url'      => '#',
		'style'     => '',
        'size'    	=> '',
        'block'    	=> '',
		'target'    => '_self',
		'icon'		=> ''
    	), $atts));
		return '<a href="'.$url.'" class="btn bluth ' . $style . ' ' . 'btn-'.$size . ' ' . ( $block == 'true' ? 'btn-block' : '' ) . '" target="'.$target.'">'.(!empty($icon) ? '<i class="icon-'.$icon.'"></i> ' : '').do_shortcode($content).'</a>';
	}

	/**
	 * Blockquote
	 * @return html For quoting blocks of content
	 */
	function bluth_blockquote( $atts, $content = null) {
		
		extract(shortcode_atts(array('source' => ''), $atts));

		return '<blockquote><p>'.do_shortcode($content).(!empty($source) ? '<small>'.$source.'</small>' : '').'</p></blockquote>';
	}


	/**
	 * syntax highlighting
	 * @return html convert content to html enteties
	 */
	function bluth_syntax( $atts, $content = null) {
		
		extract(shortcode_atts(array('type' => 'html'), $atts));

		return '<pre class="'.$type.'">'.do_shortcode($content).'</pre>';
	}

	/**
	 * font size
	 * @return html convert content to html enteties
	 */
	function bluth_font( $atts, $content = null) {
		
		extract(shortcode_atts(array('size' => '18', 'family' => 'inherit'), $atts));

		return '<span style="font-family: ' . $family . '; font-size:' . $size . 'px;">' . htmlentities(do_shortcode($content)) . '</span>';
	}

	/**
	 * progress bar
	 * @return html convert content to html enteties
	 */
	function bluth_progress_bar( $atts, $content = null) {
		
		extract(shortcode_atts(array('length' => '50', 'color' => '#3bd2f8'), $atts));

		return '<div class="bl-progressbar progress"><h5>' . htmlentities(do_shortcode($content)) . '</h5><div class="bar" style="background-color: ' . $color . ' ; width: ' . $length . '%;"><h5 class="length">' . $length . '%</h5></div></div>';
	}

	/**
	 * Tooltip
	 * @param  array $atts Aattributes
	 * @return html Anchor with a tooltip
	 */
	function bluth_tooltip( $atts, $content = null)
	{
		extract(shortcode_atts(array('text' => '', 'trigger' => 'hover', 'placement' => 'top'), $atts));

		return '<a href="javascript:void(0)" class="tips" data-toggle="tooltip"  data-trigger="' . $trigger . '" data-placement="' . $placement . '" title="' . $text . '">'. do_shortcode($content) . '</a>';
	}

	/**
	 * Popover
	 * @param  array $atts Aattributes
	 * @return html Anchor with a popover
	 */
	function bluth_popover( $atts, $content = null)
	{
		extract(shortcode_atts(array('title' => '', 'trigger' => 'hover', 'placement' => 'top', 'text' => ''), $atts));

		return '<a href="javascript:void(0)" class="bl_popover" data-trigger="'.$trigger.'" data-placement="'.$placement.'" data-content="'.$text.'" title="'.$title.'">'. do_shortcode($content) . '</a>';
	}

	/**
	 * Tabs
	 * @param  array $atts Aattributes
	 * @return tabs with multiple components
	 */
	function bluth_tabs_header($atts, $content = null){

		$html  = '<ul class="nav nav-tabs bluth">' . do_shortcode($content) . '</ul>';

		return $html;
    
	}
	function bluth_tabs_header_group($atts, $content = null){
		extract(shortcode_atts(array('open'=> 'home', 'active' => ''),$atts));
		if(!empty($active)){ $active = "active"; }
		// if($background){ $background = 'background-color:' . $background . ';'; }

		$html = '<li class="' . $active . '"><a href="#' . $open . '" data-toggle="tab">' . do_shortcode($content) . '</a></li>';

		return $html;
	}
	function bluth_tabs_content($atts, $content = null){
		$html = '<div class="tab-content">' . do_shortcode($content) . '</div>';

		return $html;
	}
	function bluth_tabs_content_group($atts, $content = null){
		extract(shortcode_atts(array('id'=> 'home', 'active' => ''),$atts));
		if(!empty($active)){ $active = "active"; }
		
		$html = '<div class="tab-pane ' . $active . '" id="' . $id . '">' . do_shortcode($content) . '</div>';

		return $html;
	}
	/**
	 * Accordion
	 * @param  array $atts Aattributes
	 * @return html accordion with multiple collapsible components
	 */
	function bluth_accordion($atts, $content = null){

		return '<div class="panel-group" id="accordion2">'.do_shortcode($content).'</div>';
	}

	/**
	 * Accordion
	 * @param  array $atts Aattributes
	 * @return html accordion with multiple collapsible components
	 */
	$blu_accordion = array('id' => 0, 'almost_unique' => rand(0,999));
	function bluth_accordion_group($atts, $content = null){

		global $blu_accordion;
		$blu_accordion['id']++;

		extract(shortcode_atts(array('title'=> 'Heading', 'style' => 'dark'),$atts));

		$html = '<div class="panel panel-default">';
		$html .= '<div class="panel-heading bluth ' . $style . '">';
		$html .= '<div class="panel-title">';
		$html .= '<a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion2" href="#'.$blu_accordion['almost_unique'].'_'.$blu_accordion['id'].'">';
		$html .= $title;
		$html .= '</a>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<div id="'.$blu_accordion['almost_unique'].'_'.$blu_accordion['id'].'" class="accordion-body collapse'.(($blu_accordion['id'] == 1) ? ' in' : '') . '">';
		$html .= '<div class="panel-collapse">';
		$html .= '<div class="panel-body">';
		$html .= do_shortcode( $content );
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Columns
	 * @return html returns the content in a column
	 */
	// [ ][ ]

	function full_width( $atts, $content = null ) {		
		extract(shortcode_atts(array(
	      'color' 	=> 'transparent',
	      'borderless' 	=> 'false',
	    ),$atts));	
	    $noboxshadow = ($color == 'transparent') ? 'box-shadow:none;' : '';
	    $html =  '<div class="row full_width_row" style="background-color:'.$color.';'.$noboxshadow.'">';
	    if($borderless == 'false'){
	    	$html .= '<div class="col-lg-12 col-md-12 col-sm-12">';
	    	$html .= 	'<p>'. do_shortcode( $content ) . '</p>';
	    	$html .= '</div>';
	    }else{
	    	$html .= 	'<p>'. do_shortcode( $content ) . '</p>';
	    }
	    $html .= '</div>';	
		return $html;
	}

	function two_first( $atts, $content = null ) {			return '<div class="row"><div class="col-lg-6 col-md-6 col-sm-6"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function two_second( $atts, $content = null ) {			return '<div class="col-lg-6 col-md-6 col-sm-6"><p>'. do_shortcode( $content ) . '</p></div></div>';	}

	// [   ][ ]
	function two_one_first( $atts, $content = null ) {		return '<div class="row"><div class="col-lg-8 col-md-8 col-sm-8"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function two_one_second( $atts, $content = null ) {		return '<div class="col-lg-4 col-md-4 col-sm-4"><p>'. do_shortcode( $content ) . '</p></div></div>';	}

	// [ ][   ]
	function one_two_first( $atts, $content = null ) {		return '<div class="row"><div class="col-lg-4 col-md-4 col-sm-4"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function one_two_second( $atts, $content = null ) {		return '<div class="col-lg-8 col-md-8 col-sm-8"><p>'. do_shortcode( $content ) . '</p></div></div>';	}

	// [ ][ ][ ]
	function three_first( $atts, $content = null ) {		return '<div class="row"><div class="col-lg-4 col-md-4 col-sm-4"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function three_second( $atts, $content = null ) {		return '<div class="col-lg-4 col-md-4 col-sm-4"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function three_third( $atts, $content = null ) {		return '<div class="col-lg-4 col-md-4 col-sm-4"><p>'. do_shortcode( $content ) . '</p></div></div>';	}

	// [ ][ ][ ][ ]
	function four_first( $atts, $content = null ) {			return '<div class="row"><div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function four_second( $atts, $content = null ) {		return '<div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function four_third( $atts, $content = null ) {			return '<div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function four_fourth( $atts, $content = null ) {		return '<div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div></div>';	}

	// [ ][ ][   ]
	function one_one_two_first( $atts, $content = null ) {	return '<div class="row"><div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function one_one_two_second( $atts, $content = null ) {	return '<div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function one_one_two_third( $atts, $content = null ) {	return '<div class="col-lg-6 col-md-6 col-sm-6"><p>'. do_shortcode( $content ) . '</p></div></div>';	}

	// [   ][ ][ ]
	function two_one_one_first( $atts, $content = null ) {	return '<div class="row"><div class="col-lg-6 col-md-6 col-sm-6">'. do_shortcode( $content ) . '</p></div>';	}
	function two_one_one_second( $atts, $content = null ) {	return '<div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function two_one_one_third( $atts, $content = null ) {	return '<div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div></div>';	}

	// [ ][   ][ ]
	function one_two_one_first( $atts, $content = null ) {	return '<div class="row"><div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function one_two_one_second( $atts, $content = null ) {	return '<div class="col-lg-6 col-md-6 col-sm-6"><p>'. do_shortcode( $content ) . '</p></div>';	}
	function one_two_one_third( $atts, $content = null ) {	return '<div class="col-lg-3 col-md-3 col-sm-3"><p>'. do_shortcode( $content ) . '</p></div></div>';	}

	/**
	 * Divider 
	 * @param  array $atts Array of attributes
	 * @return html returns a row-fluid divider
	 */
	function bluth_divider( $atts, $content = null ) {

		extract(shortcode_atts(array(
	      'type' 	=> 'white',
	      'color' 	=> 'rgba(0,0,0,0.1)',
	      'text' 	=> '',
	    ),$atts));


		$spacing = !empty($atts['spacing']) ? ' margin-top:'.$atts['spacing'].'px; margin-bottom:'.$atts['spacing'].'px; ' : ' margin-top:10px; margin-bottom:10px; ';

		$html = '<div class="row pad-xs-5 pad-sm-10 pad-md-20 pad-lg-20" style="min-height:0; padding-top:0; padding-bottom:0;">';
		switch($type){
			case 'white';
				$html .= '<div class="col-lg-12 col-md-12 col-sm-12" style="min-height:0; '.$spacing.'"></div>';
			break;
			case 'thin':
				$html .= '<div class="col-lg-12 col-md-12 col-sm-12" style="min-height:0; border-bottom:1px solid '.$color.';'.$spacing.'"></div>';
			break;
			case 'thick':
				$html .= '<div class="col-lg-12 col-md-12 col-sm-12" style="min-height:0; border-bottom:2px solid '.$color.';'.$spacing.'"></div>';
			break;
			case 'short':
				$html .= '<div class="col-lg-2 col-md-2 col-sm-2 col-lg-offset-5 col-md-offset-5 col-sm-offset-5" style="min-height:0; border-bottom:2px solid '.$color.';'.$spacing.'"></div>';
			break;
			case 'dotted':
				$html .= '<div class="col-lg-12 col-md-12 col-sm-12" style="min-height:0; border-bottom:1px dotted '.$color.';'.$spacing.'"></div>';
			break;
			case 'dashed':
				$html .= '<div class="col-lg-12 col-md-12 col-sm-12" style="min-height:0; border-bottom:1px dashed '.$color.';'.$spacing.'"></div>';
			break;
		}
		$html .= '</div>';

		return $html;
	}

	/**
	 * Get post
	 * @param  array $atts Array of attributes
	 * @return Gets a set of posts
	 */
	function bluth_get_posts($atts, $content = null){

		extract( shortcode_atts( array( 'limit' => 5, 'category' => 'uncategorized', 'excerpt' => 'off' ), $atts ) );

		$q = new WP_Query( 'posts_per_page=' . $limit . '&category_name=' . $category );

		$list = '<ul class="blu-post bl-recent-posts">';

		while ( $q->have_posts() ) {
			$q->the_post();
			$list .= '<li>';

			if ( has_post_thumbnail() ) { 
				$src_large = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large', false, '' );
				$src_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'thumbnail', false, '' );

				$list .= '<p><a href="' . $src_large[0] . '" class="lightbox pull-left" title="' . get_the_title() . '" rel="bookmark">';
				$list .= '<img src="' . $src_thumb[0] .'">';
				$list .= '</a></p>';
			}
			$list .='<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4><small>'  . get_the_date() .  '</small>';
			if($excerpt == 'on'){
				$list .='<p>' . get_the_excerpt() . '</p>';
			}
			$list .='</li>';
				
		}

		wp_reset_query();

		return $list . '</ul>';

		// return 'A SET OF posts';
		// return '<span class="dropcap'.((empty($background) or $background == 'no') ? '' : ' dropcap-bg').'" style="' . ((empty($background) or $background == 'no') ? 'color:' . $color : 'background-color:' . $color ) . '">'.do_shortcode($content).'</span>';
	}

	/**
	 * Intro-Text
	 * @param  array $atts Aattributes
	 * @return Usually the first text in the content
	 */
	function bluth_introtext($atts, $content = null){
		extract( shortcode_atts( array( 'size' => '25px' ), $atts ) );
		return '<div class="intro-text" style="font-size: ' . $size . '; ">' . do_shortcode( $content ) . '</div>';
	}
	
	if(!function_exists('blu_process_shortcode')){
		function blu_process_shortcode($content) {
		    global $blu_shortcode_tags;
		 
		    $original_shortcode_tags = $blu_shortcode_tags;
		    
			add_shortcode('divider', 'bluth_divider');
			add_shortcode('social', 'bluth_social');
			add_shortcode('alert', 'bluth_alert');
			add_shortcode('label', 'bluth_label');
			add_shortcode('badge', 'bluth_badge');
			add_shortcode('well', 'bluth_well');
			add_shortcode('button', 'bluth_button');
			add_shortcode('blockquote', 'bluth_blockquote');
			add_shortcode('syntax', 'bluth_syntax');
			add_shortcode('icon', 'bluth_icon');
			add_shortcode('font', 'bluth_font');
			add_shortcode('progress', 'bluth_progress_bar');
			add_shortcode('tooltip', 'bluth_tooltip');
			add_shortcode('popover', 'bluth_popover');
			add_shortcode('tabs-header', 'bluth_tabs_header');
			add_shortcode('tabs-header-group', 'bluth_tabs_header_group');
			add_shortcode('tabs-content', 'bluth_tabs_content');
			add_shortcode('tabs-content-group', 'bluth_tabs_content_group');
			add_shortcode('accordion', 'bluth_accordion');
			add_shortcode('accordion-group', 'bluth_accordion_group');
			add_shortcode('dropcap', 'bluth_dropcap');
			add_shortcode('pullquote', 'bluth_pullquote');
			add_shortcode('bulletlist', 'bluth_bulletlist');
			add_shortcode('bulletlist_item', 'bluth_bulletlist_item');
			add_shortcode('get-posts', 'bluth_get_posts');
			add_shortcode('intro-text', 'bluth_introtext');

			// COLUMNS
			add_shortcode( "full_width", "full_width" ); 

			add_shortcode( "two_first", "two_first" ); 
			add_shortcode( "two_second", "two_second" ); 

			add_shortcode( "two_one_first", "two_one_first" ); 
			add_shortcode( "two_one_second", "two_one_second" );

			add_shortcode( "one_two_first", "one_two_first" ); 
			add_shortcode( "one_two_second", "one_two_second" ); 

			add_shortcode( "three_first", "three_first" ); 
			add_shortcode( "three_second", "three_second" ); 
			add_shortcode( "three_third", "three_third" ); 

			add_shortcode( "four_first", "four_first" ); 
			add_shortcode( "four_second", "four_second" ); 
			add_shortcode( "four_third", "four_third" ); 
			add_shortcode( "four_fourth", "four_fourth" ); 

			add_shortcode( "one_one_two_first", "one_one_two_first" ); 
			add_shortcode( "one_one_two_second", "one_one_two_second" ); 
			add_shortcode( "one_one_two_third", "one_one_two_third" ); 

			add_shortcode( "two_one_one_first", "two_one_one_first" ); 
			add_shortcode( "two_one_one_second", "two_one_one_second" ); 
			add_shortcode( "two_one_one_third", "two_one_one_third" ); 

			add_shortcode( "one_two_one_first", "one_two_one_first" ); 
			add_shortcode( "one_two_one_second", "one_two_one_second" ); 
			add_shortcode( "one_two_one_third", "one_two_one_third" ); 
		 
		 	// $returned = do_shortcode($content);
		    $blu_shortcode_tags = $original_shortcode_tags;
		    return $content;
		}
	}

	add_filter('the_content', 'blu_process_shortcode', 7);
	add_filter('the_content', 'shortcode_empty_paragraph_fix');
	if(!function_exists('shortcode_empty_paragraph_fix')){
		function shortcode_empty_paragraph_fix($content)
		{   
		    $array = array (
		        '<p>[' => '[', 
		        ']</p>' => ']', 
		        ']<br />' => ']'
		    );

		    $content = strtr($content, $array);

		    return $content;
		}
	}
	
	// Shortcodes in widget
	add_filter('widget_text', 'blu_process_shortcode', 7);
	add_filter('shortcode_filter', 'blu_process_shortcode', 7);
	add_action('admin_head', 'blu_add_tinymce');

	if(!function_exists('blu_add_tinymce')){
		function blu_add_tinymce() {  
			global $typenow;
			if(!in_array($typenow, array('post', 'page'))) return ;

		   if(current_user_can('edit_posts') or current_user_can('edit_pages'))  
		   {  
		     add_filter('mce_external_plugins', 'blu_add_tinymce_plugin');  
		     add_filter('mce_buttons', 'blu_add_tinymce_button');
		   }  
		}  
	}  

	if(!function_exists('blu_add_tinymce_plugin')){
		function blu_add_tinymce_plugin($plugin_array) {  
			// If it's a separate plugin and the theme isn't from bluthemes then load the javascript from the plugins directory
			// else load it from the theme directory
			if(!defined('BLUTHEMES')){
				$plugin_array['bluthcodes_location'] = plugins_url('bluthcodes') . '/tinymce/tinymce.js';
			}else{
				$plugin_array['bluthcodes_location'] = get_template_directory_uri() . '/assets/plugins/bluthcodes/tinymce/tinymce.js';
			}
		   
		   return $plugin_array;  
		}  
	}  

	// Define Position of TinyMCE Icons
	if(!function_exists('blu_add_tinymce_button')){
		function blu_add_tinymce_button($buttons) {  
			array_push($buttons, 'bluthcodes');  
			return $buttons;  
		} 
	} 

	if(!function_exists('bluthcodes_assets')){
		function bluthcodes_assets()  { 
			// check if it's a bluth theme, so we don't have to load things twice
			if(!defined('BLUTHEMES')){
				wp_enqueue_style( 'bluth-bootstrap', plugins_url('bluthcodes') . '/bootstrap/bootstrap.min.css' );
				wp_enqueue_script( 'bluth-bootstrap', plugins_url('bluthcodes') . '/bootstrap/bootstrap.min.js', array('jquery') );	
				wp_enqueue_style( 'bluthcodes-style', plugins_url('bluthcodes') . '/style.css' );
			}else{
				wp_enqueue_style( 'bluthcodes-style', get_template_directory_uri()  . '/assets/plugins/bluthcodes/style.css' );
			}
		}
	}
	add_action( 'wp_enqueue_scripts', 'bluthcodes_assets' );
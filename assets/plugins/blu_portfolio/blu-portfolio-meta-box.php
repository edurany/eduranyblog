<?php

	// Meta box
	add_action( 'add_meta_boxes', 'blu_portfolio_meta_box' );  
	function blu_portfolio_meta_box()  
	{  
    	add_meta_box( 'blu_portfolio', 'Project Options', 'blu_portfolio_options', 'blu-portfolio', 'normal', 'high');    
	}    
		  
	function blu_portfolio_options( $post )  { 
		// Load the portfolio admin scripts here
        // wp_enqueue_script('admin-scripts', get_template_directory_uri() . '/assets/plugins/blu_portfolio/js/portfolio-scripts.js', array('jquery'), null, true);
		
		$blu_portfolio_link 	= get_post_meta( $post->ID, 'blu_portfolio_link', true );  
		$blu_portfolio_client 	= get_post_meta( $post->ID, 'blu_portfolio_client', true );  
		$blu_portfolio_client_link 	= get_post_meta( $post->ID, 'blu_portfolio_client_link', true );  
		$blu_portfolio_gallery 	= get_post_meta( $post->ID, 'blu_portfolio_gallery', false );  
		$blu_portfolio_gallery 	= empty($blu_portfolio_gallery) ? array(array(array('gallery_src' => '', 'gallery_id' => ''))) : $blu_portfolio_gallery;  
		$blu_portfolio_field 	= get_post_meta( $post->ID, 'blu_portfolio_field', false );  
		$blu_portfolio_field 	= empty($blu_portfolio_field) ? array(array(array('title' => '', 'item' => array(0 => '', 1 => '')))) : $blu_portfolio_field;  

	    wp_nonce_field( 'save_blu_portfolio', 'blu_portfolio_nonce' );  ?>
	    <fieldset class="full">
	        <input type="text" id="blu_portfolio_link" class="full large" name="blu_portfolio_link" placeholder="<?php _e('Link to project..', 'bluth_admin'); ?>" value="<?php echo $blu_portfolio_link; ?>" style="margin: 10px 0; width:100%; font-size: 16px;" />  
	    </fieldsedt>
	    <fieldset class="full">
	        <input type="text" id="blu_portfolio_client" class="full large" name="blu_portfolio_client" placeholder="<?php _e('Client Name..', 'bluth_admin'); ?>" value="<?php echo $blu_portfolio_client; ?>" style="margin: 10px 0; width:100%; font-size: 16px;" />  
	    </fieldsedt>
	    <fieldset class="full">
	        <input type="text" id="blu_portfolio_client_link" class="full large" name="blu_portfolio_client_link" placeholder="<?php _e('Client Link..', 'bluth_admin'); ?>" value="<?php echo $blu_portfolio_client_link; ?>" style="margin: 10px 0; width:100%; font-size: 16px;" />  
	    </fieldsedt>
	    <fieldset class="full">
		    <h4><?php _e('Gallery Images: ', 'bluth_admin'); ?><small><?php _e('Add images to display in the slider', 'bluth_admin'); ?></small> <a href="javascript:void(0);" class="bl_add_field"><?php _e('+ Add image', 'bluth_admin'); ?></a></h4><?php
		    foreach( $blu_portfolio_gallery as $key => $item ){ 
		    	foreach( $item as $key2 => $array_item ){ ?>
			      	<div class="cd-layout array_item blu_image_upload" data-key="<?php echo $key2; ?>" style="width: 12%; margin-right: 0.5%;" data-name="blu_portfolio_gallery">
						<input data-arrayname="gallery_src" type="hidden" name="blu_portfolio_gallery[<?php echo $key2; ?>][gallery_src]" class="blu_portfolio_gallery blu_item source" value="<?php echo $item[$key2]['gallery_src']; ?>" />
						<input data-arrayname="gallery_id" type="hidden" name="blu_portfolio_gallery[<?php echo $key2; ?>][gallery_id]" class="blu_portfolio_gallery blu_item image_id" value="<?php echo $item[$key2]['gallery_id']; ?>" />
			      		<a class="blu_add_image" href="#"><img class="blu_portfolio_gallery" data-placeholder="<?php echo ''; ?>" src="<?php echo $item[$key2]['gallery_src']; ?>"></a>
						<button type="button" class="close">&times;</button>
			      	</div><?php
				}
			} ?>
	    </fieldset>
	    <fieldset class="full array_fieldset">
		    <h4><?php _e('List Fields: ', 'bluth_admin'); ?><small><?php _e('Add fields to display in the items description', 'bluth_admin'); ?></small><a href="javascript:void(0);" class="bl_add_field_complex"><?php _e('+ Add field', 'bluth_admin'); ?></a></h4><?php
		    foreach( $blu_portfolio_field as $key => $parent ){ 
		    	foreach( $parent as $array_item_key => $array_item ){ ?>
				    <div class="array_item" data-key="<?php echo $array_item_key; ?>" data-name="blu_portfolio_field">
	        			<input type="text" id="blu_portfolio_field[<?php echo $array_item_key; ?>][title]" class="blu_item_title full large" name="blu_portfolio_field[<?php echo $array_item_key; ?>][title]" placeholder="<?php _e('Name of list', 'bluth_admin'); ?>" value="<?php echo $array_item['title']; ?>" />  
		    			 <?php
		    			foreach( $array_item['item'] as $input_item_key => $input_item ){ ?>
		    				<div class="input_item_group">
		    					<button type="button" class="close_item">&times;</button>
		    					<input placeholder="<?php _e('Item..', 'bluth_admin'); ?>" name="blu_portfolio_field[<?php echo $array_item_key; ?>][item][<?php echo $input_item_key; ?>]" value="<?php echo $input_item; ?>" data-key="<?php echo $input_item_key; ?>"  data-arrayname="item0<?php echo $array_item_key; ?>" class="blu_item full" type="text" >
		    				</div>
		    				<?php
		    			} ?>
			    		<a href="javascript:void(0);" class="bl_add_field_complex_child"><?php _e('+ Add field', 'bluth_admin'); ?></a>
			    		<button type="button" class="close">&times;</button>
				    </div><?php
				}
			} ?>
	    </fieldsedt>
		<?php
	}
    	 
	add_action( 'save_post', 'blu_portfolio_meta_save' ); 
	function blu_portfolio_meta_save( $id ) 
	{ 
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
		if( !isset( $_POST['blu_portfolio_nonce'] ) || !wp_verify_nonce( $_POST['blu_portfolio_nonce'], 'save_blu_portfolio' ) ) return; 
		if( !current_user_can( 'edit_post' ) ) return; 

		$blu_portfolio_field = $_POST["blu_portfolio_field"];
	    if( isset( $_POST['blu_portfolio_field'] ) ) 
	        update_post_meta( $id, 'blu_portfolio_field', $blu_portfolio_field );

	    if( isset( $_POST['blu_portfolio_link'] ) ) 
	        update_post_meta( $id, 'blu_portfolio_link', esc_attr( strip_tags( $_POST['blu_portfolio_link'] ) ) );

	    if( isset( $_POST['blu_portfolio_client'] ) ) 
	        update_post_meta( $id, 'blu_portfolio_client', esc_attr( strip_tags( $_POST['blu_portfolio_client'] ) ) );

	    if( isset( $_POST['blu_portfolio_client_link'] ) ) 
	        update_post_meta( $id, 'blu_portfolio_client_link', esc_attr( strip_tags( $_POST['blu_portfolio_client_link'] ) ) );

	    $blu_portfolio_gallery = $_POST["blu_portfolio_gallery"];
	    if( isset( $_POST['blu_portfolio_gallery'] ) ) 
	        update_post_meta( $id, 'blu_portfolio_gallery', $blu_portfolio_gallery );
	} 

add_filter("manage_edit-blu-portfolio_columns", "project_edit_columns");     
    
function project_edit_columns($columns){    
        $columns = array(    
            "cb" => "<input type=\"checkbox\" />",    
            "image" => "Image",    
            "title" => "Project",    
            "description" => "Description",    
            "link" => "Link",    
            "type" => "Type of Project",    
        );    
    
        return $columns;    
}    
  
add_action("manage_posts_custom_column",  "project_custom_columns");   
    
function project_custom_columns($column){    
        global $post;    
        switch ($column)    
        {    
            case "image":    
            	the_post_thumbnail('mini');
                break;    
            case "description":    
                the_excerpt();    
                break;    
            case "link":    
                echo get_post_meta( $post->ID, 'blu_portfolio_link', true );  
                break;    
            case "type":    
                echo get_the_term_list($post->ID, 'project-type', '', ', ','');    
                break;    
        }    
}       
?>
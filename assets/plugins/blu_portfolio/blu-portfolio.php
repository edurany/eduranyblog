<?php
    require_once('blu-portfolio-meta-box.php');
        
    function portfolio_register() {    
        $args = array(    
            'label' => __('Portfolio', 'bluth_admin'),    
            'singular_label' => __('Project', 'bluth_admin'),    
            'public' => true,    
            'show_ui' => true,    
            'capability_type' => 'post',    
            'hierarchical' => false,    
            'rewrite' => true,    
            'supports' => array('title', 'editor', 'thumbnail', 'comments'),
            'menu_position' => 5 
           );    
        
        register_post_type( 'blu-portfolio' , $args );    
    }    
    register_taxonomy(
        "project-type", 
        array("blu-portfolio"), 
        array(
            "hierarchical" => true, 
            "label" => "Project Types", 
            "singular_label" => "Project Type",
            "rewrite" => true
        )
    );  

    add_action('init', 'portfolio_register');    
<?php
	/**
	 * The template for displaying any single page.
	 *
	 */
	get_header(); 

$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$author_ID = get_the_author_meta('ID');

?>

		<div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" role="main"><?php
			if( of_get_option('author_box_image_'.$author_ID) ){ $author_image = 'background-image:url(' . of_get_option("author_box_image_".$author_ID) . '); background-size:cover;'; }else{ $author_image = 'background-image:none;'; } ?>
			<div class="author-meta box">
				<div class="author-image"> <?php 
					if(!of_get_option('author_box_avatar_'.$author_ID)){
						echo '<img src="' . blu_get_avatar_url(get_avatar( get_the_author_meta( 'ID' ) , 120 ) ) . '">'; 
					}else{
						echo '<img src="' . of_get_option('author_box_avatar_'.$author_ID) . '">'; 
					} ?>
				</div>
				<div class="author-body" style="<?php echo $author_image; ?>">
					<h2 class="vcard author"><span class="fn"><?php echo $curauth->nickname; ?></span><small style="display:block;"><?php echo $curauth->first_name . ' ' . $curauth->last_name; ?></small></h2>
					<p><?php echo $curauth->description; ?></p>
				</div>
			</div> <?php
				$orig_post = $post;
				global $post;

				$my_query = new wp_query( array(
				    'posts_per_page'=>12,
				    'author'=>$curauth->ID, 
				    'meta_key'=> 'wpb_post_views_count', 
					'orderby'=> 'meta_value_num' 
			    ));

				if($my_query->have_posts()){ ?>

			    	<div id="author-posts" class="box">
			    		<div class="row">
			    			<div class="author-posts-title col-xs-12 col-sm-12 col-md-12 col-lg-12 center uppercase pad15 clearfix">
				    			<h3><?php echo __('Popular articles by', 'bluth') . ' ' . $curauth->nickname; ?></h3>
				    		</div>
			    		</div>
			    		<div class="row pad35"><?php 

				 			while($my_query->have_posts()){
							    $my_query->the_post(); 
							    $post_format = get_post_format();
							    $post_format = ($post_format) ? $post_format : 'standard';
								if( $post ){ ?>
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 clearfix">
				    					<div class="author-posts-item" style="background-image: url('<?php echo get_post_image( $post->ID, 'large' ); ?>');">
											<a href="<?php echo get_permalink( $post->ID ); ?>"> <?php 
												$post_format = (get_post_format( $post->ID )) ? get_post_format( $post->ID ) : 'standard';  ?>
												<h3><?php echo get_the_title( $post->ID ); ?></h3>
											</a> 
										</div>
			    					</div><?php
								} 
							} ?>
			    		</div>
		    		</div><?php
				}  

				wp_reset_query();

				$all_posts = new wp_query( array(
				    'posts_per_page'=>50,
				    'offset'=>1,
				    'author'=>$curauth->ID, 
			    ));

				// the rest of the authors articles
				if($all_posts->have_posts()){ ?>

			    	<div id="author-posts" class="post-box box">
			    		<div class="author-posts-body col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
				    		<h3><?php echo __('All articles by', 'bluth') . ' ' . $curauth->nickname; ?></h3><?php 

				 			while($all_posts->have_posts()){
							    $all_posts->the_post(); ?><?php 
									if( $post ){ ?>
										<span>&nbsp;</span>
										<a href="<?php echo get_permalink( $post->ID ); ?>">
										<h4><?php echo get_the_title( $post->ID ); ?></h4></a> <?php 
										the_excerpt(); 
									} ?>
								<?php
							} ?>
		    			</div>
		    		</div><?php
				}  ?>


		</div><!-- #content .site-content -->

<?php get_footer(); ?>
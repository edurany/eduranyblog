<?php
	
	/***************
	*	GENERAL
	****************/
	// Theme Setup
	if(!function_exists('blu_theme_setup')){
		function blu_theme_setup(){
			add_editor_style( 'assets/css/style-editor.css' );

			/*  Post Thumbnails  */
			if ( function_exists( 'add_image_size' ) ) {
				add_theme_support( 'post-thumbnails' );

				add_image_size( 'single-large', 1170, 450, true );		// Featured Widget Image
				add_image_size( 'sidebar-large', 750, 450, true );		// Featured Widget Image

				add_image_size( 'featured_post', 400, 250, true );		// Featured Widget Image
				add_image_size( 'share', 700, 300, true );				// Standard Blog Image
				add_image_size( 'small', 194, 150, true ); 				// Related posts image
				add_image_size( 'mini', 80, 80, true ); 				// Sidebar widget image
			}

			/* other */
			add_action( 'comment_post', 'blu_add_custom_comment_field', 1 );
		}
	}

	/***************
	*	HEADER
	****************/
	// Outputs the selected option panel styles inline into the <head>
	if(!function_exists('blu_typography_styles')){ 
		function blu_typography_styles() {

			$output = '';
			$heading_font 		= of_get_option('heading_font', false);
			$text_font 			= of_get_option('text_font', false);
			$menu_font 			= of_get_option('menu_font', false);
			$header_font 		= of_get_option('header_font', false);

			if($heading_font){
				$selected_font = explode(':', $heading_font);
				$output .= 'h1,h2,h3,h4,h5{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",serif;} .widget_calendar table > caption{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",serif;} ';
			}

			if($text_font){
				$selected_font = explode(':', $text_font);
				$output .= 'body{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",Helvetica,sans-serif;} ';
			}

			if($menu_font){
				$selected_font = explode(':', $menu_font);
				$output .= '.navbar .nav > li > a{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",Helvetica,sans-serif;} ';
			}

			if($header_font){
				$selected_font = explode(':', $header_font);
				$output .= '#masthead{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",Helvetica,sans-serif;} ';
			}

		     if ( $output != '' ) {
				$output = "\n<style>\n" . $output . "</style>\n";
				echo $output;
		     }
		}
	}
	// Add Custom Favicon
	if(!function_exists('blu_favicon')){
	 	function blu_favicon() {
		  	if(of_get_option('favicon')){
		   		echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.of_get_option('favicon').'" />';
	  		}
	 	}
 	}

	/***************
	*	COMMENTS
	****************/
	// Bluthemes Comments
	if(!function_exists('blu_comment')){
		function blu_comment( $comment, $args, $depth ) {
			global $post;
		    $GLOBALS['comment'] = $comment;
		    $comment_meta = get_comment_meta( get_comment_ID(), 'image_location', true );
		    $comment_meta = explode(',', $comment_meta); 
		    // $score_meta = get_comment_meta( get_comment_ID(), 'blu_comment_score', true ) ? get_comment_meta( get_comment_ID(), 'blu_comment_score', true ) : '0';
		    $image_class = !empty($comment_meta[2]) ? 'image-comment-on' : '';
		    $comment_class = ($comment->comment_karma > 0) ? 'up' : (($comment->comment_karma) < 0 ? 'down' : 'null');

		    switch ( $comment->comment_type ) :
		        case 'pingback' :
		        case 'trackback' :
		    ?>
		    <li class="post pingback">
		        <p><?php _e( 'Pingback:', 'bluth' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'bluth' ), ' ' ); ?></p>
		    <?php
		            break;
		        default :
		    ?>
		    <li <?php comment_class( $image_class ); ?> id="li-comment-<?php comment_ID(); ?>">
		        <article id="comment-<?php comment_ID(); ?>" class="comment">
		            <div>
		                <div class="comment-author clearfix">
		                    <?php echo get_avatar( $comment, 45 ); ?>
		                    <?php printf( __( '%s', 'bluth' ), sprintf( '<h4 class="commenter">%s' . ($comment->user_id == get_queried_object()->post_author ? '<a href="#" class="blu-color" title="' . __("Author", "bluth") . '"><i class="icon-star-1"></i></a>' : '') . '</h4>', get_comment_author_link() ) ); ?>
		                	<p class="comment-time muted"><time class="timeago" datetime="<?php echo get_comment_time( 'c' ); ?>"></time></p>
		                	<!-- 
		                		COMMENT SCORE 
		                	-->
		                	<div class="comment-score">
		                		<a href="#" class="blu-comment-vote blu-comment-vote-down" data-commentid="<?php echo get_comment_ID(); ?>">
		                			-
		                		</a>
		                		<div class="total-score vote-<?php echo $comment_class; ?>"><?php echo $comment->comment_karma; ?></div> 
		                		<a href="#" class="blu-comment-vote blu-comment-vote-up" data-commentid="<?php echo get_comment_ID(); ?>">
		                			<i class="icon-plus-1"></i>
		                		</a> 
		                	</div>
		                	<!-- 
		                		/ COMMENT SCORE 
		                	-->
		                </div><!-- .comment-author .vcard -->
		                <?php if ( $comment->comment_approved == '0' ) : ?>
		                    <em><?php _e( 'Your comment is awaiting moderation.', 'bluth' ); ?></em>
		                    <br />
		                <?php endif; ?>
		            </div>
		            <div class="comment-content clearfix"> 
		            	<?php 
		            	if(!empty($comment_meta[2])){
	            			echo '<div class="image-comment-crop"><img style="width: ' . $comment_meta[3] . 'px; left: ' . ((int)$comment_meta[1]*-1) . 'px; top: ' . ((int)$comment_meta[0]*-1) . 'px; " src="' . ($comment_meta[2]) . '"></div>'; 
		            	}
		            	comment_text(); ?>
		            </div>
		 
		            <div class="reply">
		                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		                <?php edit_comment_link( __( '(Edit)', 'bluth' ), '&nbsp;&nbsp;' ); ?>
		            </div><!-- .reply -->
		        </article><!-- #comment-## -->
		 
		    <?php
		            break;
		    endswitch;
		}
	}
	// Comment meta
	if(!function_exists('blu_add_custom_comment_field')){
		function blu_add_custom_comment_field( $comment_id ) {
		   add_comment_meta( $comment_id, 'image_location', $_POST['image_location'], true );
		}
	}
	// Comment score
	if(!function_exists('blu_ajax_comment_score')){
		function blu_ajax_comment_score(){  
			$commentid = $_POST['commentid']; 
			$comment = get_comment($_POST['commentid']);
			$vote_type = $_POST['votetype'];
			$karma = $comment->comment_karma;

			// hasn't voted before
			if( !in_array(blu_get_ip(), get_comment_meta( $commentid, 'blu_comment_ip')) ){
				if($vote_type == 'up'){
					$karma++;
				}else{
					$karma--;
				}
				wp_update_comment(array('comment_ID' => $commentid, 'comment_karma' => $karma));
				add_comment_meta($_POST['commentid'], 'blu_comment_ip', blu_get_ip(), false);
				die();

			// already commented
			}else{
				echo 'already voted ';
				return false;
				die();
			}
		}
	} 

	/***************
	*	POSTS
	****************/
	// Custom Pagination ( thanks to kriesi.at )
	if(!function_exists('kriesi_pagination')){ 
		function kriesi_pagination($pages = '', $range = 2){  
		     $showitems = ($range * 2)+1;  

		     global $paged;
		     if(empty($paged)) $paged = 1;

		     if($pages == ''){
		         global $wp_query;
		         $pages = $wp_query->max_num_pages;
		         if(!$pages){
		             $pages = 1;
		         }
		     }   
		     if(1 != $pages){
		        echo "<div class='pagination box'>";
				echo get_previous_posts_link( '<i class="icon-left-open-1"></i> '.__('Previous Page', 'bluth') );
		         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a class='' href='".get_pagenum_link(1)."'>&laquo;</a>";
		         if($paged > 1 && $showitems < $pages) echo "<a class='box' href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
		         for ($i=1; $i <= $pages; $i++){
		             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
		                 echo ($paged == $i)? "<span class='current '>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive ' >".$i."</a>";
		             }
		         }
		         if ($paged < $pages && $showitems < $pages) echo "<a class='' href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
		         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a class='' href='".get_pagenum_link($pages)."'>&raquo;</a>";
				echo get_next_posts_link( __('Next Page', 'bluth').' <i class="icon-right-open-1"></i>' );
		        echo "</div>\n";
		     }
		}
	}
	// Add a Lightbox class to all inserted images
	if(!function_exists('blu_lightbox_class')){
		function blu_lightbox_class($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
		  $classes = 'lightbox'; // separated by spaces, e.g. 'img image-link'

		  // check if there are already classes assigned to the anchor
		  if ( preg_match('/<a.*? class=".*?">/', $html) ) {
		    $html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
		  } else {
		    $html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
		  }
		  return $html;
		}
	}

	/***************
	*	MAILCHIMP
	****************/
	// MailChimp Widget
	if(!function_exists('blu_ajax_mailchimp')){
		function blu_ajax_mailchimp(){  
			$options = get_option('widget_bl_newsletter');
			foreach($options as $option){
				if(is_array($option) and in_array($_POST['list'], $option)){
					$options = $option;
				}
			}

			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_POST['email'])) {
				echo json_encode(array("error" => __('Email address is invalid','bluth'))); 
				die();
			}
			else if(!isset($options['list_id'])){
				echo json_encode(array("error" => "No mailing list selected"));
				 die();
			}
			else if(!isset($options['api_key'])){
				echo json_encode(array("error" => "API key not defined")); 
				die();
			}
			else if(!isset($_POST['email'])){ 
				echo json_encode(array("error" => __('No email address provided','bluth'))); 
				die();
			} 

			require_once(get_template_directory().'/inc/mailchimp/MCAPI.class.php');

			$api = new MCAPI($options['api_key']);

			$list_id = $options['list_id'];

			if($api->listSubscribe($list_id, $_POST['email'], '') === true) {
				echo json_encode(array("status" => 'ok'));
			}else{
				echo json_encode(array("error" => 'Error: ' . $api->errorMessage));
			}
		    die();
		} 
	} 
	
	/***************
	*	INSTAGRAM
	****************/
	if(!function_exists('blu_empty_instagram_cache')){
		function blu_empty_instagram_cache(){
			delete_transient( 'blu_instagram' );
			// echo 'this is the echo';
			die();
		}
	}

	/***************
	*	SOCIAL COUNTER
	****************/
	if(!function_exists('bl_get_url')){
		function bl_get_url($url){
	        $bl_results = @wp_remote_retrieve_body(@wp_remote_get($url, array('timeout' => 18 , 'sslverify' => false)));
	        return $bl_results;
    	}
    }
	if(!function_exists('bl_get_json')){
		function bl_get_json($url){
	        $bl_json = @json_decode(bl_get_url($url), true);
	        return $bl_json;
    	}
	}
	if(!function_exists('bl_get_social_counter')){
		function bl_get_social_counter($social_service) {

			$return_array = array();

			// Cache the results if they haven't been cached
			if(($cache = get_transient('bl_social_counter')) === false){
	
				foreach ($social_service as $site => $user_id) {
		
					$bl_counter = 0;

					switch($site){
						case 'facebook':
							$bl_data = bl_get_json("http://graph.facebook.com/$user_id");
		                    if ( is_array($bl_data) and !empty($bl_data['likes']) ) {
		                        $return_array['facebook'] = $bl_data['likes'];
		                    }
						break;
						case 'twitter':
							if(!class_exists('TwitterApiClient')){
								require_once('twitter-api.php');
								$Client = new TwitterApiClient;
								$Client->set_oauth (YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, SOME_ACCESS_KEY, SOME_ACCESS_SECRET);
								try {
			                        $path = 'users/show';
			                        $args = array ('screen_name' => $user_id);
			                        $bl_data = @$Client->call( $path, $args, 'GET' );
			                        if (!empty($bl_data['followers_count'])) {
			                            $return_array['twitter'] = $bl_data['followers_count'];
			                        }
			                    }
			                    catch( TwitterApiException $Ex ){ return $Ex; }
							}
						break;
		                case 'gplus':
		                    $bl_data = bl_get_json("https://www.googleapis.com/plus/v1/people/$user_id?key=AIzaSyCfgXt3OctK-8566-5oinbCO1vRMGzsTy8");

		                    if (!empty($bl_data['plusOneCount'])) {
		                        $return_array['gplus'] = $bl_data['plusOneCount'];
		                    }
		                    else if (!empty($bl_data['circledByCount'])) {
		                        $return_array['gplus'] = $bl_data['circledByCount'];
		                    }

		                break;
		                case 'instagram':
		                    $bl_data = bl_get_url("http://instagram.com/$user_id#");
		                    $pattern = "/followed_by\":(.*?),\"follows\":/";
		                    preg_match($pattern, $bl_data, $matches);
		                    if (!empty($matches[1])) {
		                        $return_array['instagram'] = $matches[1];
		                    }
		                break;
					}
				}
		        set_transient( 'bl_social_counter', $return_array, 60 * 60 * 3);
			}else{
				$return_array = $cache;
			}

			return $return_array;

		}
	}

	/***************
	*	HELPERS
	****************/
	// Get user IP
	if(!function_exists('blu_get_ip')){
		function blu_get_ip(){
		    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
		    {
		        if (array_key_exists($key, $_SERVER) === true)
		        {
		            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
		            {
		                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
		                {
		                    return $ip;
		                }
		            }
		        }
		    }
		}
	}
  	// Add open graph meta tags  
	if(!function_exists('blu_add_open_graph_tags')){ 
		function blu_add_open_graph_tags() {
			// only run this function if the user is not using an seo plugin
			if ( !of_get_option('seo_plugin') ){

				// add title tag
				echo '<title>';
				bloginfo('name');
				wp_title(' - ', true, 'left');
				echo '</title>';

				// og:site_name
				echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '" />';

				// og:title
				echo '<meta property="og:title" content="';
				bloginfo('name');
				wp_title(' - ', true, 'left');
				echo '" />';

				if(of_get_option('facebook_app_id')){
					echo '<meta property="fb:app_id" content="' . of_get_option('facebook_app_id') . '" />';
				}

				if (is_single() || is_page() ){ 
					if ( have_posts() ) {
						while ( have_posts() ){ 
							the_post();
							echo '<meta property="og:description" content="' . mb_substr(strip_tags(get_the_excerpt()), 0, 155) . '" />';
							echo '<meta property="og:image" content="' . get_post_image(get_the_ID(), 'share', true ) . '" />';
						} 
					// og:type
					echo '<meta property="og:type" content="article" />'; 
					// og:url
					echo '<meta property="og:url" content="'.get_permalink().'"/>';	
					}
				}elseif(is_home()){ 
					echo '<meta property="og:description" content="';
					bloginfo('description');
					echo '" />';
					
					// og:url
					echo '<meta property="og:url" content="' . get_home_url() . '" />';					
				}else{
					// og:type
					echo '<meta property="og:type" content="website" />';
				}
			}
		}
	}
	// Google ads
	if(!function_exists('blu_get_google_ads')){
		function blu_get_google_ads(){ 
			global $blu_google_ads_count;
			$blu_google_ads_count++;
			?>
			<div style="text-align: center;">
				<div id="google-ads-<?php echo $blu_google_ads_count; ?>" class="google-ads"></div>
			       
				<script type="text/javascript">

				    /* Calculate the width of available ad space */
				    ad = jQuery('#google-ads-<?php echo $blu_google_ads_count; ?>')[0];
				     
				    if (ad.getBoundingClientRect().width) {
				   	 	adWidth = ad.getBoundingClientRect().width; // for modern browsers
				    } else {
				    	adWidth = ad.offsetWidth; // for old IE
				    }
				     
				    /* Replace ca-pub-XXX with your AdSense Publisher ID */
				    google_ad_client = "<?php echo of_get_option('google_publisher_id', '0'); ?>";
				     
				    /* Replace 1234567890 with the AdSense Ad Slot ID */
				    google_ad_slot = "<?php echo of_get_option('google_ad_unit_id', '0'); ?>";
				    /* Do not change anything after this line */
				    if ( adWidth >= 728 )
				    	google_ad_size = ["728", "90"]; /* Leaderboard 728x90 */
				    else if ( adWidth >= 468 )
				    	google_ad_size = ["468", "60"]; /* Banner (468 x 60) */
				    else if ( adWidth >= 336 )
				    	google_ad_size = ["336", "280"]; /* Large Rectangle (336 x 280) */
				    else if ( adWidth >= 300 )
				    	google_ad_size = ["300", "250"]; /* Medium Rectangle (300 x 250) */
				    else if ( adWidth >= 250 )
				    	google_ad_size = ["250", "250"]; /* Square (250 x 250) */
				    else if ( adWidth >= 200 )
				    	google_ad_size = ["200", "200"]; /* Small Square (200 x 200) */
				    else if ( adWidth >= 180 )
				    	google_ad_size = ["180", "150"]; /* Small Rectangle (180 x 150) */
				    else
				    	google_ad_size = ["125", "125"]; /* Button (125 x 125) */
				     

				    document.write (
				    '<ins class="adsbygoogle" style="display:inline-block;width:'
				    + google_ad_size[0] + 'px;height:'
				    + google_ad_size[1] + 'px" data-ad-client="'
				    + google_ad_client + '" data-ad-slot="'
				    + google_ad_slot + '"></ins>'
				    );
				    (adsbygoogle = window.adsbygoogle || []).push({});

				</script>
				 
				<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">
				</script>
			</div><?php
		}
	}
	// Custom post variables (for fromnext animation)
	if(!function_exists('blu_queryvars')){
		function blu_queryvars( $qvars ){
			$qvars[] = 'fromnext';
			return $qvars;
		}
	}
	// Add span tag around categories post count
	if(!function_exists('blu_cat_count_span')){ 
		function blu_cat_count_span($links) {
			return str_replace(array('</a> (',')'), array('</a> <span class="badge">','</span>'), $links);
		}
	}
	// Add span tag around archives post count
	if(!function_exists('blu_archive_count_span')){ 
		function blu_archive_count_span($links) {
		  	return str_replace(array('</a>&nbsp;(',')'), array('</a> <span class="badge">','</span>'), $links);
		}
	}
	// Replaces the excerpt "more" text by a link
	if(!function_exists('blu_excerpt_more')){ 
		function blu_excerpt_more($more) {
			if( !is_single() ){
		    	global $post;
		    	// if( !of_get_option('show_continue_reading') ){
	    		return false;
		    	// }else{
					// return '<br /><a class="moretag" href="'. get_permalink($post->ID) . '">' . __('Continue reading...', 'bluth') . '</a>';
		    	// }
			}
		}
	}
	// Manual excerpt
	function blu_excerpt_read_more_link($output) {
		if( !is_single() ){
	    	global $post;

	    	if( !of_get_option('show_continue_reading') ){
	    		return false;
	    	}else{
				return substr($output,0,-5) . '<br /><a class="moretag" href="'. get_permalink($post->ID) . '">' . __('Continue reading...', 'bluth') . '</a>';
	    	}
		}
	}
	// Excerpt length
	if(!function_exists('blu_excerpt_length')){ 
		function blu_excerpt_length($length) {
			if(!isset($length)){ $length = 55; }
			return of_get_option('excerpt_length', $length);
		}
	}
	// Remove Empty P tags that WP generates
	if(!function_exists('blu_remove_empty_p')){
		function blu_remove_empty_p($content){
			$content = force_balance_tags($content);
			return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
		}
	}
	// Get gravatar URL
	if(!function_exists('blu_get_avatar_url')){
		function blu_get_avatar_url( $get_avatar ) {
		    preg_match("/src=[\"\'](.*?)[\"\']/i", $get_avatar, $matches);
		    return $matches[1];
		}
	}
	// Get the post image
	if(!function_exists('get_post_image')){
		function get_post_image( $post_id, $size = 'small', $author_fallback = true, $thumbnail_id = false ) {
			// get thumbnail id if not present
			if($thumbnail_id){ return wp_get_attachment_image_src( $thumbnail_id, $size ); }

			// if there's a custom thumbnail present then always fetch that if this is a thumbnail image
			$custom_thumbnail = get_post_meta( $post_id, 'bluth_custom_thumbnail', true);
			if($custom_thumbnail && !empty($custom_thumbnail['gallery_src']) && ( $size == 'small' || $size == 'thumbnail' || $size == 'mini' || $size == 'share' )){
				$custom_thumbnail = wp_get_attachment_image_src( $custom_thumbnail['gallery_id'], $size );
				return $custom_thumbnail[0];
			}

			// if the post has a featured image, always display that
			$thumb_id = get_post_thumbnail_id( $post_id );
			$thumb_url = wp_get_attachment_image_src( $thumb_id, $size, false );
			if($thumb_url[0]){
				return $thumb_url[0];
			}

			if(has_post_format('gallery', $post_id)){
				// if it's a gallery post and doesn't have a featured image, then display the first image in the gallery
				$images = get_post_meta( $post_id, 'blu_gallery', true );
				if(!empty($images[0]['gallery_src'])){
					$first_gallery_image = wp_get_attachment_image_src( $images[0]['gallery_id'], $size );
					return $first_gallery_image[0];
				}
			}else if ( $images = get_children(array('post_parent' =>  $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image' ))){ 
				// else display the first image in the post
				$image = current($images);
				$image = wp_get_attachment_image_src($image->ID, $size);
				return $image[0];
			}else if($first_image = catch_that_image()){
				// else try again to get the first image in the post
				return $first_image;
			}else if( $author_fallback ){
				// if it can't find anything and the author fallback is enabled then display the authors image
				return blu_get_avatar_url( get_avatar( get_the_author_meta( 'ID' ) , $size ));
			}else{
				return false;
			} 
		}
	}
	// Get the first image
	if(!function_exists('catch_that_image')){
		function catch_that_image() {
			global $post, $posts;
			$first_img = '';
			ob_start();
			ob_end_clean();
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
			$first_img = isset($matches[1][0]) ? $matches[1][0] : false;

			if(empty($first_img))
				return false;

			return $first_img;
		}
	}
	// Get the post icon
	if(!function_exists('get_post_icon')){
		function get_post_icon( $post_id ) {
			$post_format = (get_post_format( $post_id )) ? get_post_format( $post_id ) : 'standard'; 	

			$icon = of_get_option($post_format.'_icon', false);
			$icon_default = array('standard' => 'icon-calendar-3', 'audio' => 'icon-volume-up', 'video' => 'icon-videocam','quote' => 'icon-quote-left', 'link' => 'icon-link', 'image' => 'icon-picture-1', 'gallery' => 'icon-picture');
			$icon = ($icon !== false) ? $icon : $icon_default[$post_format];

			return $icon;
		}
	}
	// Add Custom Admin Media Enqueue
	if(!function_exists('blu_media_enqueue')){
		function blu_media_enqueue() {
		  wp_enqueue_media();
		  // wp_enqueue_script('hrw',  get_template_directory_uri() . '/assets/js/admin-script.js', array( 'jquery' ), BREEZE_VERSION, true);
		}
	}
	// Set post view count
	if(!function_exists('wpb_set_post_views')){
		function wpb_set_post_views($postID) {
		    $count_key = 'wpb_post_views_count';
		    $count = get_post_meta($postID, $count_key, true);
		    if($count==''){
		        $count = 0;
		        delete_post_meta($postID, $count_key);
		        add_post_meta($postID, $count_key, '0');
		    }else{
		        $count++;
		        update_post_meta($postID, $count_key, $count);
		    }
		}
	}
	// Get post view count
	if(!function_exists('wpb_get_post_views')){
		function wpb_get_post_views($postID){
			$count_key = 'wpb_post_views_count';
			$count = get_post_meta($postID, $count_key, true);
			if($count==''){
			    delete_post_meta($postID, $count_key);
			    add_post_meta($postID, $count_key, '0');
			    return '0';
			}
			return $count;
		}
	}
	// Useful truncate function
	if(!function_exists('bl_truncate')){
		function bl_truncate($string, $limit, $break=".", $pad="..."){
		  	if(strlen($string) <= $limit) return $string;
		  		if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		    		if($breakpoint < strlen($string) - 1) {
		      		$string = substr($string, 0, $breakpoint) . $pad;
				}
		  	}
		 	return $string;
		}
	}

	// Hooks/Filters
	add_action( 'after_setup_theme', 'blu_theme_setup' );	// ----------------- Custom setup
 	add_action( 'wp_head', 'blu_favicon' ); // --------------------------------- Add Custom Favicon
	add_action( 'wp_head', 'blu_typography_styles' ); // ----------------------- Header hook
	add_filter( 'excerpt_more', 'blu_excerpt_more' ); // ----------------------- Replaces the excerpt "more" text with a link
	add_filter( 'the_excerpt', 'blu_excerpt_read_more_link' ); // -------------- Manual Excerpt
	add_filter( 'excerpt_length', 'blu_excerpt_length' ); // ------------------- Custom Excerpt Length
	add_filter( 'get_archives_link', 'blu_archive_count_span' ); // ------------ Add span tag around archives post count
	add_filter( 'wp_list_categories', 'blu_cat_count_span' ); // --------------- Add span tag around categories post count
	add_filter( 'image_send_to_editor','blu_lightbox_class',10,8 ); // --------- Add lightbox classes to images in posts
	add_filter( 'query_vars', 'blu_queryvars' ); // ---------------------------- Custom POST variables
	add_filter( 'the_content', 'blu_remove_empty_p', 20, 1 ); // --------------- Remove Empty P tags that WP generates
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

	// AJAX
	add_action( 'wp_ajax_blu_ajax_comment_score', 'blu_ajax_comment_score' );
	add_action( 'wp_ajax_nopriv_blu_ajax_comment_score', 'blu_ajax_comment_score' );  
	add_action( 'wp_ajax_blu_next_post', 'blu_next_post' );
	add_action( 'wp_ajax_nopriv_blu_next_post', 'blu_next_post' );  
	add_action( 'wp_ajax_blu_ajax_mailchimp', 'blu_ajax_mailchimp' );
	add_action( 'wp_ajax_nopriv_blu_ajax_mailchimp', 'blu_ajax_mailchimp' );  
	add_action( 'wp_ajax_blu_empty_instagram_cache', 'blu_empty_instagram_cache' );
	add_action( 'wp_ajax_nopriv_blu_empty_instagram_cache', 'blu_empty_instagram_cache' );  
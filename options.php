<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'bluth_admin'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {


	$background_mode = array(
		'image' => __('Image', 'bluth_admin'),
		'pattern' => __('Pattern', 'bluth_admin'),
		'color' => __('Solid Color', 'bluth_admin')
	);


	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/assets/img/';

	$options = array();


	$options[] = array(
		'name' => '<i class="icon-gauge-1"></i> ' . __('Theme Options', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('General Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Background', 'bluth_admin'),
				'desc' => __('What kind of background do you want?', 'bluth_admin'),
				'id' => 'background_mode',
				'std' => 'color',
				'type' => 'radio',
				'options' => $background_mode);

				$options[] = array(
					'name' => __('Background Image', 'bluth_admin'),
					'desc' => __('Upload your background image here.', 'bluth_admin'),
					'id' => 'background_image',
					'std' => '',
					'class' => 'background_image',
					'type' => 'upload');

				$options[] = array(
					'name' => __('Show stripe overlay', 'bluth_admin'),
					'desc' => __('Uncheck this to remove the stripe overlay that covers the background image', 'bluth_admin'),
					'id' => 'show_stripe',
					'std' => '1',
					'class' => 'background_image',
					'type' => 'checkbox');

				$options[] = array(
					'name' => __("Select a background pattern", 'bluth_admin'),
					'desc' => __("Select a background pattern from the list or upload your own below.", 'bluth_admin'),
					'id' => "background_pattern",
					'std' => "brick_wall.jpg",
					'type' => "images",
					'class' => "hide background_pattern",
					'options' => array(
						'az_subtle.png' => $imagepath . 'pattern/sample/az_subtle_50.png',
						'cloth_alike.png' => $imagepath . 'pattern/sample/cloth_alike_50.png',
						'cream_pixels.png' => $imagepath . 'pattern/sample/cream_pixels_50.png',
						'gray_jean.png' => $imagepath . 'pattern/sample/gray_jean_50.png',
						'grid.png' => $imagepath . 'pattern/sample/grid_50.png',
						'light_noise_diagonal.png' => $imagepath . 'pattern/sample/light_noise_diagonal_50.png',
						'noise_lines.png' => $imagepath . 'pattern/sample/noise_lines_50.png',
						'pw_pattern.png' => $imagepath . 'pattern/sample/pw_pattern_50.png',
						'shattered.png' => $imagepath . 'pattern/sample/shattered_50.png',
						'squairy_light.png' => $imagepath . 'pattern/sample/squairy_light_50.png',
						'striped_lens.png' => $imagepath . 'pattern/sample/striped_lens_50.png',
						'textured_paper.png' => $imagepath .'pattern/sample/textured_paper_50.png')
				);

				$options[] = array(
					'name' => __('Upload Pattern', 'bluth_admin'),
					'desc' => __('Upload a new pattern here. If this feature is used it will overwrite the selection above.', 'bluth_admin'),
					'id' => 'background_pattern_custom',
					'class' => 'background_pattern',
					'type' => 'upload');

				$options[] = array(
					'name' => __('Background Color', 'bluth_admin'),
					'desc' => __('Select the background color ( Only works if the custom color option is chosen )', 'bluth_admin'),
					'id' => 'background_color',
					'std' => '#ededed',
					'class' => "hide background_color",
					'type' => 'color' );

			$options[] = array(
			  'name' => __('Favicon', 'bluth_admin'),
			  'desc' => __('Upload a favicon. Favicons are the icons that appear in the tabs of the browser and left of the address bar. (16x16 pixels)', 'bluth_admin'),
			  'id' => 'favicon',
			  'type' => 'upload');

			$options[] = array(
			  'name' => __('Apple touch icon', 'bluth_admin'),
			  'desc' => __('Icons that appear on your homescreen when you press "Add to home screen" on your device (114x114 pixels (PNG file))', 'bluth_admin'),
			  'id' => 'apple_touch_icon',
			  'type' => 'upload');

		$options[] = array(
			'name' => __('Layout Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Layout Width', 'bluth_admin'),
				'desc' => __('The size of layout width in pixels (Default 1170)', 'bluth_admin'),
				'id' => 'custom_container_width',
				'std' => '1170',
				'type' => 'text'
				);

/*			$options[] = array(
				'name' => __('Disable Responsive Features', 'bluth_admin'),
				'desc' => __('Check this to disable all responsive features', 'bluth_admin'),
				'id' => 'disable_responsive',
				'std' => '0',
				'type' => 'checkbox');*/

		$options[] = array(
			'name' => __('Footer Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Footer text', 'bluth_admin'),
				'desc' => __('{year} will be replaced with the current year', 'bluth_admin'),
				'id' => 'footer_text',
				'std' => 'Copyright {year} · Theme design by Bluthemes · www.bluthemes.com',
				'type' => 'textarea');

		$options[] = array(
			'name' => __('Various Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Google Analytics', 'bluth_admin'),
				'desc' => __('Add your Google Analytics tracking code here. Google Analytics is a free web analytics service more info here: <a href="http://www.google.com/analytics/">Google Analytics</a>', 'bluth_admin'),
				'id' => 'google_analytics',
				'std' => '',
				'type' => 'textarea');

			$options[] = array(
				'name' => __('Featured Tag', 'bluth_admin'),
				'desc' => __('The tag that the featured posts widget will use to fetch posts', 'bluth_admin'),
				'id' => 'featured_tag',
				'std' => 'featured',
				'type' => 'text');

			$options[] = array(
				'name' => __('Right-to-Left Language', 'bluth_admin'),
				'desc' => __('Check this if your language is written in a Right-to-Left direction', 'bluth_admin'),
				'id' => 'enable_rtl',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('SEO plugin support', 'bluth_admin'),
				'desc' => __('Check this to give an SEO plugin control of meta description, title and open graph tags.', 'bluth_admin'),
				'id' => 'seo_plugin',
				'std' => '0',
				'type' => 'checkbox');

	$options[] = array(
		'name' => '<i class="icon-menu-1"></i> ' . __('Header & Menu', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Header Styling', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Header Type', 'bluth_admin'),
				'desc' => __('Choose your header type', 'bluth_admin'),
				'id' => "header_type",
				'std' => "header_normal",
				'type' => "images",
				'options' => array(
					'header_normal' => $imagepath . 'header_normal.jpg',
					'header_background_full_width' => $imagepath . 'header_full_width_background.jpg',
					'header_full_width' => $imagepath . 'header_full_width.jpg'
				));

			$options[] = array(
				'name' => __('Header Background', 'bluth_admin'),
				'desc' => __('Choose your header background, to choose a color go to the Colors & Fonts page.', 'bluth_admin'),
				'id' => 'header_background',
				'std' => 'color',
				'type' => 'radio',
				'options' => array(
					'color' 	=> __('Color', 'bluth_admin'),
					'image' 	=> __('Image', 'bluth_admin')
				));

			$options[] = array(
				'name' => __('Header Background Image', 'bluth_admin'),
				'desc' => __('Upload your header background image here', 'bluth_admin'),
				'id' => 'header_background_image',
				'class' => 'header_background_image hide',
				'type' => 'upload');

			$options[] = array(
				'name' => __('Disable Header description', 'bluth_admin'),
				'desc' => __('Check this to disable the description showing up in the header.', 'bluth_admin'),
				'id' => 'disable_description',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Disable Search in Header', 'bluth_admin'),
				'desc' => __('Check this to disable the search button in the header', 'bluth_admin'),
				'id' => 'disable_search',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Disable Sticky Header', 'bluth_admin'),
				'desc' => __('Check this to disable the sticky header feature. (The header won\'t stay fixed at the top of the window when you scroll down)', 'bluth_admin'),
				'id' => 'disable_fixed_header',
				'std' => '0',
				'type' => 'checkbox');
	
		$options[] = array(
			'name' => __('Logo Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Logo', 'bluth_admin'),
				'desc' => __('Upload your logo here. Remove the image to show the name of the website in text instead. (Recommended: x90 height for normal heading)', 'bluth_admin'),
				'id' => 'logo',
				'type' => 'upload');
			

/*			$options[] = array(
				'name' => __('Mini Logo', 'bluth_admin'),
				'desc' => __('Upload your mini logo here. Logo that appears in the header when the user scrolls down on your website.', 'bluth_admin'),
				'id' => 'minilogo',
				'type' => 'upload');*/

		$options[] = array(
			'name' => __('Menu Settings', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Enable menu hover', 'bluth_admin'),
				'desc' => __('Check this to show the menus sub-items when hovered over the top item.', 'bluth_admin'),
				'id' => 'menu_hover',
				'std' => '1',
				'type' => 'checkbox');


	$options[] = array(
		'name' => '<i class="icon-users-2"></i> ' . __('Users', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Author Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Enable author on front page', 'bluth_admin'),
				'desc' => __('Uncheck this to remove the author image & name on the front page.', 'bluth_admin'),
				'id' => 'show_author_front',
				'std' => '1',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Enable author box', 'bluth_admin'),
				'desc' => __('Uncheck this to remove the author box below each post.', 'bluth_admin'),
				'id' => 'author_box',
				'std' => '1',
				'type' => 'checkbox');

	$users = get_users( array('who' => 'authors') );
	foreach($users as $user){
		
		$options[] = array(
			'name' => __( 'User: '.$user->user_nicename, 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Author Cover for '.$user->user_nicename, 'bluth_admin'),
				'desc' => __('Upload a cover for the author box', 'bluth_admin'),
				'id' => 'author_box_image_'.$user->ID,
				'type' => 'upload');

			$options[] = array(
				'name' => __('Author Box Avatar', 'bluth_admin'),
				'desc' => __('Upload a custom avatar for the author box (will use gravatar if nothing is set) (120x120)', 'bluth_admin'),
				'id' => 'author_box_avatar_'.$user->ID,
				'type' => 'upload');
		
	}

	$options[] = array(
		'name' => '<i class="icon-pencil-1"></i> ' . __('Blog Settings', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Layout', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __("Blog Layout", 'bluth_admin'),
				'desc' => __("Select the default layout for the front page", 'bluth_admin'),
				'id' => "blog_layout",
				'std' => "right_side",
				'type' => "images",
				'options' => array(
					'left_side' => $imagepath . 'sidebar-layout-left.jpg',
					'single' => $imagepath . 'sidebar-layout-single.jpg',
					'right_side' => $imagepath . 'sidebar-layout-right.jpg')
			);

		$options[] = array(
			'name' => __('Style', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Blog Style', 'bluth_admin'),
				'desc' => __('Select the default blog style.', 'bluth_admin'),
				'id' => 'blog_style',
				'std' => 'margin',
				'type' => 'images',
				'options' => array(
					'margin' => $imagepath . 'layout-1.jpg',
					'twocolumn' => $imagepath . 'layout-2.jpg',
					'threecolumn' => $imagepath . 'layout-3.jpg',
					'fourcolumn' => $imagepath . 'layout-4.jpg',
					'fivecolumn' => $imagepath . 'layout-5.jpg',
				));

	$options[] = array(
		'name' => '<i class="icon-docs"></i> ' . __('Posts & Pages', 'bluth_admin'),
		'type' => 'heading');


		$options[] = array(
			'name' => __('Layout', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __("Post and Page Layout", 'bluth_admin'),
				'desc' => __("Select the default layout for posts and pages", 'bluth_admin'),
				'id' => "post_page_layout",
				'std' => "right_side",
				'type' => "images",
				'options' => array(
					'left_side' => $imagepath . 'sidebar-layout-left.jpg',
					'single' => $imagepath . 'sidebar-layout-single.jpg',
					'right_side' => $imagepath . 'sidebar-layout-right.jpg')
			);

		$options[] = array(
			'name' => __('Featured Images', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Disable cropping of featured images in: ', 'bluth_admin'),
				'desc' => __('Check this to disable cropped images and use the original in selected areas', 'bluth_admin'),
				'id' => 'disable_crop',
				'std' => array(
					'pages' 	=> '0',
					'single' 	=> '1',
					'blog' 		=> '0'
				),
				'type' => 'multicheck',
				'options' => array(
					'pages' 	=> __('Pages', 'bluth_admin'),
					'single' 	=> __('Posts', 'bluth_admin'),
					'blog' 		=> __('Front page', 'bluth_admin')));

			$options[] = array(
				'name' => __('Open featured post images in lightbox', 'bluth_admin'),
				'desc' => __('Check this to open featured post images in a lightbox instead of linking to the post itself.', 'bluth_admin'),
				'id' => 'post_image_lightbox',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Disable Image Comments', 'bluth_admin'),
				'desc' => __('Check this to disable image comments on all posts.', 'bluth_admin'),
				'id' => 'disable_image_comments',
				'std' => '0',
				'type' => 'checkbox');


		$options[] = array(
			'name' => __('Sharing Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Disable share buttons at the bottom of posts', 'bluth_admin'),
				'desc' => __('Check this to remove the "Share" button in the post footer.', 'bluth_admin'),
				'id' => 'disable_share_story',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Show share buttons on:', 'bluth_admin'),
				'desc' => __('Where do you want the share buttons to appear?', 'bluth_admin'),
				'id' => 'share_buttons_position',
				'class' => 'disable_share_story',
				'std' => array(
					'pages' 	=> '0',
					'single' 	=> '1',
					'blog' 		=> '0'
				),
				'type' => 'multicheck',
				'options' => array(
					'pages' 	=> __('Pages', 'bluth_admin'),
					'single' 	=> __('Posts', 'bluth_admin'),
					'blog' 		=> __('Front page', 'bluth_admin')));

			$options[] = array(
				'name' => __('Disable share buttons:', 'bluth_admin'),
				'desc' => __('Check to disable the specific share button', 'bluth_admin'),
				'id' => 'share_buttons_disabled',
				'class' => 'disable_share_story',
				'std' => array(
					'facebook' 	=> '0',
					'googleplus'=> '0',
					'twitter'	=> '0',
					'reddit'	=> '0',
					'pinterest'	=> '0',
					'linkedin'	=> '0',
					'delicious'	=> '0',
					'email' 	=> '0',
				),
				'type' => 'multicheck',
				'options' => array(
					'facebook' 	=> 'facebook',
					'googleplus'=> 'googleplus',
					'twitter'	=> 'twitter',
					'reddit'	=> 'reddit',
					'pinterest'	=> 'pinterest',
					'linkedin'	=> 'linkedin',
					'delicious'	=> 'delicious',
					'email' 	=> 'email'));

			$options[] = array(
				'name' => __('Disable the tags for posts', 'bluth_admin'),
				'desc' => __('Check this to remove the post tags on all posts', 'bluth_admin'),
				'id' => 'disable_footer_post',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Disable Next button', 'bluth_admin'),
				'desc' => __('Check this to remove the Next button at the bottom of each post.', 'bluth_admin'),
				'id' => 'disable_pagination',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Disable Related Posts', 'bluth_admin'),
				'desc' => __('Related articles are show below each post when you view it. Check this to disable that feature.', 'bluth_admin'),
				'id' => 'disable_related_posts',
				'std' => '0',
				'type' => 'checkbox');

		$options[] = array(
			'name' => __('Page Options', 'bluth_admin'),
			'type' => 'info');
			
			$options[] = array(
				'name' => __('Enable page comments', 'bluth_admin'),
				'desc' => __('Check this to enable comments on all pages.', 'bluth_admin'),
				'id' => 'enable_page_comments',
				'std' => '0',
				'type' => 'checkbox');

		$options[] = array(
			'name' => __('Post Options', 'bluth_admin'),
			'type' => 'info');
			
			$options[] = array(
				'name' => __('Enable post comments', 'bluth_admin'),
				'desc' => __('Check this to enable comments on all posts.', 'bluth_admin'),
				'id' => 'enable_post_comments',
				'std' => '1',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Enable Facebook comments for posts', 'bluth_admin'),
				'desc' => __('Check this to enable Facebook comments. Requires a Facebook app id Social options.', 'bluth_admin'),
				'id' => 'facebook_comments',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Enable posts excerpt (post summary)', 'bluth_admin'),
				'desc' => __('Check this to only show the post excerpt or the summary of a post in the browse page. The default behavior is to show the whole post but you can provide a cut-off point by adding the <a href="http://codex.wordpress.org/Customizing_the_Read_More" target="_blank">More</a> tag.', 'bluth_admin'),
				'id' => 'enable_excerpt',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Exerpt Length', 'bluth_admin'),
				'desc' => __('How many words would you like to show in the post summary. Default: 55 words', 'bluth_admin'),
				'id' => 'excerpt_length',
				'std' => '55',
				'class' => 'hide',
				'type' => 'text');

			$options[] = array(
				'name' => __('Show Continue Reading link', 'bluth_admin'),
				'desc' => __('Uncheck this to hide the Continue Reading link that appears below the post conent.', 'bluth_admin'),
				'id' => 'show_continue_reading',
				'std' => '1',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Show year in post date', 'bluth_admin'),
				'desc' => __('Check this to display the year of the post below the post title.', 'bluth_admin'),
				'id' => 'enable_show_year',
				'std' => '0',
				'type' => 'checkbox');

	$options[] = array(
		'name' => '<i class="icon-art-gallery"></i> ' . __('Colors & Fonts', 'bluth_admin'),
		'type' => 'heading');


		$options[] = array(
			'name' => __('Color Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Color Theme', 'bluth_admin'),
				'desc' => __('Choose a predefined color theme', 'bluth_admin'),
				'id' => 'predefined_theme',
				'std' => 'default',
				'type' => 'images',
				'options' => array(
					'default' => $imagepath . '/colorthemes/default.png',
				));
			
			$options[] = array(
				'name' => __('Custom Color Theme', 'bluth_admin'),
				'desc' => __('Check this to make your own color theme', 'bluth_admin'),
				'id' => 'custom_color_picker',
				'std' => '0',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Main Theme Color', 'bluth_admin'),
				'desc' => __('Select the theme\'s main color', 'bluth_admin'),
				'id' => 'theme_color',
				'class' => 'hide custom_color',
				'std' => '#45b0ee',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Header Background Color', 'bluth_admin'),
				'desc' => __('Select the background color for the top header that includes the menu', 'bluth_admin'),
				'id' => 'header_color',
				'class' => 'hide custom_color',
				'std' => '#ffffff',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Header Font Color', 'bluth_admin'),
				'desc' => __('Select the color for the top header menu links', 'bluth_admin'),
				'id' => 'header_font_color',
				'class' => 'hide custom_color',
				'std' => '#333333',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Post Header Color', 'bluth_admin'),
				'desc' => __('Select the color for the top header of each post', 'bluth_admin'),
				'id' => 'post_header_color',
				'class' => 'hide custom_color',
				'std' => '#444444',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Widget Header Color', 'bluth_admin'),
				'desc' => __('Select the default color for the top header of each widget', 'bluth_admin'),
				'id' => 'widget_header_color',
				'class' => 'hide custom_color',
				'std' => '#ffffff',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Widget Header Font Color', 'bluth_admin'),
				'desc' => __('Select the color for the heading font in each widget', 'bluth_admin'),
				'id' => 'widget_header_font_color',
				'class' => 'hide custom_color',
				'std' => '#717171',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Footer Color', 'bluth_admin'),
				'desc' => __('Select the default color for the footer', 'bluth_admin'),
				'id' => 'footer_color',
				'class' => 'hide custom_color',
				'std' => '#FFFFFF',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Footer Header Color', 'bluth_admin'),
				'desc' => __('Select the default color for the footer headers', 'bluth_admin'),
				'id' => 'footer_header_color',
				'class' => 'hide custom_color',
				'std' => '#333333',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Footer Font Color', 'bluth_admin'),
				'desc' => __('Select the default color for the footer font', 'bluth_admin'),
				'id' => 'footer_font_color',
				'class' => 'hide custom_color',
				'std' => '#333333',
				'type' => 'color' );

		$options[] = array(
			'name' => __('Link Options', 'bluth_admin'),
			'type' => 'info');
			
			$options[] = array(
				'name' => __('Disable background for links in posts and pages', 'bluth_admin'),
				'desc' => __('Check this to disable the background for links and instead use the color on the text.', 'bluth_admin'),
				'id' => 'disable_link_background',
				'std' => '0',
				'type' => 'checkbox');

		$options[] = array(
			'name' => __('Font Options', 'bluth_admin'),
			'type' => 'info');
		
			$options[] = array(
				'name' => __('Heading font', 'bluth_admin'),
				'desc' => __('Select a font type for all heading', 'bluth_admin'),
				'id' => 'heading_font',
				'std' => 'Lato:300,400,400italic,700,900',
				'type' => 'text');

			$options[] = array(
				'name' => __('Main font', 'bluth_admin'),
				'desc' => __('Select a font type for normal text', 'bluth_admin'),
				'id' => 'text_font',
				'std' => 'Roboto+Slab:300,400,700&subset=latin',
				'type' => 'text');

			$options[] = array(
				'name' => __('Main font size', 'bluth_admin'),
				'desc' => __('The size of the text in posts', 'bluth_admin'),
				'id' => 'text_font_size',
				'std' => '18px',
				'type' => 'select',
				'options' => array(
					'12px' => '12px',
					'14px' => '14px',
					'16px' => '16px',
					'18px' => '18px',
					'20px' => '20px',
					'22px' => '22px',
					'24px' => '24px',
				));

			$options[] = array(
				'name' => __('Main font line height', 'bluth_admin'),
				'desc' => __('The spacing between each line of the text in posts', 'bluth_admin'),
				'id' => 'text_font_spacing',
				'std' => '2',
				'type' => 'select',
				'options' => array(
					'1.5' 	=> '1.5',
					'1.6' 	=> '1.6',
					'1.7' 	=> '1.7',
					'1.8' 	=> '1.8',
					'1.9' 	=> '1.9',
					'2' 	=> '2',
					'2.1' 	=> '2.1',
					'2.2' 	=> '2.2',
					'2.3' 	=> '2.3',
					'2.4' 	=> '2.4',
					'2.5' 	=> '2.5',
				));

			$options[] = array(
				'name' => __('Menu links font', 'bluth_admin'),
				'desc' => __('Select a font type for the menu items in the header', 'bluth_admin'),
				'id' => 'menu_font',
				'std' => 'Lato:300,400,400italic,700,900',
				'type' => 'text');

			$options[] = array(
				'name' => __('Header font', 'bluth_admin'),
				'desc' => __('Select a font type for the header. If you use text instead of a logo in your header this setting changes the font family for that text as well.', 'bluth_admin'),
				'id' => 'header_font',
				'std' => 'Lato:300,400,400italic,700,900',
				'type' => 'text');





	$options[] = array(
		'name' => '<i class="icon-picture"></i> ' . __('Post Formats', 'bluth_admin'),
		'type' => 'heading');


		$options[] = array(
			'name' => __('Post Format Colors', 'bluth_admin'),
			'type' => 'info');


			$options[] = array(
				'name' => __('Standard Post Color', 'bluth_admin'),
				'desc' => __('Select the color for the standard post icon and links', 'bluth_admin'),
				'id' => 'standard_post_color',
				'std' => '#556270',
				'class' => 'header_art_icon',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Gallery Post Color', 'bluth_admin'),
				'desc' => __('Select the color for the gallery post icon and links', 'bluth_admin'),
				'id' => 'gallery_post_color',
				'std' => '#4ECDC4',
				'class' => 'header_art_icon',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Image Post Color', 'bluth_admin'),
				'desc' => __('Select the color for the image post icon and links', 'bluth_admin'),
				'id' => 'image_post_color',
				'std' => '#C7F464',
				'class' => 'header_art_icon',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Link Post Color', 'bluth_admin'),
				'desc' => __('Select the color for the link post icon and links', 'bluth_admin'),
				'id' => 'link_post_color',
				'std' => '#FF6B6B',
				'class' => 'header_art_icon',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Quote Post Color', 'bluth_admin'),
				'desc' => __('Select the color for the quote post icon and links', 'bluth_admin'),
				'id' => 'quote_post_color',
				'std' => '#C44D58',
				'class' => 'header_art_icon',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Audio Post Color', 'bluth_admin'),
				'desc' => __('Select the color for the audio post icon and links', 'bluth_admin'),
				'id' => 'audio_post_color',
				'std' => '#5EBCF2',
				'class' => 'header_art_icon',
				'type' => 'color' );	

			$options[] = array(
				'name' => __('Video Post Color', 'bluth_admin'),
				'desc' => __('Select the color for the video post icon and links', 'bluth_admin'),
				'id' => 'video_post_color',
				'std' => '#A576F7',
				'class' => 'header_art_icon',
				'type' => 'color' );	

			$options[] = array(
				'name' => __('Status Post Color', 'bluth_admin'),
				'desc' => __('Select the color for the status post icon and links', 'bluth_admin'),
				'id' => 'status_post_color',
				'std' => '#556270',
				'class' => 'header_art_icon',
				'type' => 'color' );

			$options[] = array(
				'name' => __('Sticky Post Color', 'bluth_admin'),
				'desc' => __('Select the color for the sticky post icon and links', 'bluth_admin'),
				'id' => 'sticky_post_color',
				'std' => '#90DB91',
				'class' => 'header_art_icon',
				'type' => 'color' );		


		$options[] = array(
			'name' => __('Post Format Icons', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Standard Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the standard post type. (Default: icon-calendar-3)', 'bluth_admin'),
				'id' => 'standard_icon',
				'std' => 'icon-calendar-3',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');

			$options[] = array(
				'name' => __('Gallery Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the gallery post type. (Default: icon-picture)', 'bluth_admin'),
				'id' => 'gallery_icon',
				'std' => 'icon-picture',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');

			
			$options[] = array(
				'name' => __('Image Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the image post type. (Default: icon-picture-1)', 'bluth_admin'),
				'id' => 'image_icon',
				'std' => 'icon-picture-1',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');


			$options[] = array(
				'name' => __('Link Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the link post type. (Default: icon-link)', 'bluth_admin'),
				'id' => 'link_icon',
				'std' => 'icon-link',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');


			$options[] = array(
				'name' => __('Quote Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the quote post type. (Default: icon-quote-left)', 'bluth_admin'),
				'id' => 'quote_icon',
				'std' => 'icon-quote-left',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');


			$options[] = array(
				'name' => __('Audio Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the audio post type. (Default: icon-volume-up)', 'bluth_admin'),
				'id' => 'audio_icon',
				'std' => 'icon-volume-up',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');


			$options[] = array(
				'name' => __('Video Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the video post type. (Default: icon-videocam)', 'bluth_admin'),
				'id' => 'video_icon',
				'std' => 'icon-videocam',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');


			$options[] = array(
				'name' => __('Status Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the status post type. (Default: icon-book-1)', 'bluth_admin'),
				'id' => 'status_icon',
				'std' => 'icon-book-1',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');


			$options[] = array(
				'name' => __('Facebook Status Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the facebook status post type. (Default: icon-facebook-1)', 'bluth_admin'),
				'id' => 'facebook_status_icon',
				'std' => 'icon-facebook-1',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');

			$options[] = array(
				'name' => __('Twitter Status Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the twitter status post type. (Default: icon-twitter-1)', 'bluth_admin'),
				'id' => 'twitter_status_icon',
				'std' => 'icon-twitter-1',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');

			$options[] = array(
				'name' => __('Google+ Status Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for the google status post type. (Default: icon-gplus-2)', 'bluth_admin'),
				'id' => 'google_status_icon',
				'std' => 'icon-gplus-2',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');

			$options[] = array(
				'name' => __('Sticky Post Icon', 'bluth_admin'),
				'desc' => __('Select an icon for sticky posts. (Default: icon-pin)', 'bluth_admin'),
				'id' => 'sticky_icon',
				'std' => 'icon-pin',
				'class' => 'header_art_icon post_icon_edit',
				'type' => 'text');




	$options[] = array(
		'name' => '<i class="icon-star-1"></i> ' . __('Advertising', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Google Ads', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Google Publisher ID', 'bluth_admin'),
				'desc' => __('Found in the top right corner of your <a href="https://www.google.com/adsense/" target="_blank">adsense account</a>.', 'bluth_admin'),
				'id' => 'google_publisher_id',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Google Ad unit ID', 'bluth_admin'),
				'desc' => __('Found in your Ad Units area under <strong>ID</strong> <a href="https://www.google.com/adsense/app#myads-springboard" target="_blank">here</a>.', 'bluth_admin'),
				'id' => 'google_ad_unit_id',
				'std' => '',
				'type' => 'text');

		$options[] = array(
			'name' => __('Advertising Areas', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Ad spot #1 - Above the header.', 'bluth_admin'),
				'desc' => __('Select what kind of ad you want added above the top menu.', 'bluth_admin'),
				'id' => 'ad_header_mode',
				'std' => 'none',
				'type' => 'radio',
				'options' => array(
					'none' => __('None', 'bluth_admin'),
					'html' => __('Shortcode or HTML code like Adsense', 'bluth_admin'),
					'image' => __('Image with a link', 'bluth_admin')
				));

			$options[] = array(
				'name' => __('Add Shortcode or HTML code here', 'bluth_admin'),
				'desc' => __('Insert a shortcode provided by this theme or any plugin. You can also add advertising code from any provider or use plain html. To add Adsense just paste the embed code here that they provide and save.', 'bluth_admin'),
				'id' => 'ad_header_code',
				'class' => 'hide ad_header_code',
				'std' => '',
				'type' => 'textarea');

			$options[] = array(
				'name' => __('Upload Image', 'bluth_admin'),
				'desc' => __('Upload an image to add above the header menu and add a link for it in the input box below', 'bluth_admin'),
				'id' => 'ad_header_image',
				'class' => 'hide ad_header_image',
				'type' => 'upload');

			$options[] = array(
				'name' => __('Image link', 'bluth_admin'),
				'desc' => __('Add a link to the image', 'bluth_admin'),
				'id' => 'ad_header_image_link',
				'class' => 'hide ad_header_image',
				'std' => '',
				'type' => 'text');


			$options[] = array(
				'name' => __('Ad spot #2 - Between posts', 'bluth_admin'),
				'desc' => __('Here you can add advertising between posts.', 'bluth_admin'),
				'id' => 'ad_posts_mode',
				'std' => 'none',
				'type' => 'radio',
				'options' => array(
					'none' => __('None', 'bluth_admin'),
					'html' => __('Shortcode or HTML code like Adsense', 'bluth_admin'),
					'image' => __('Image with a link', 'bluth_admin')
				));

			$options[] = array(
				'name' => __('Add Shortcode or HTML code here', 'bluth_admin'),
				'desc' => __('Insert a shortcode provided by this theme or any plugin. You can also add advertising code from any provider or use plain html. To add Adsense just paste the embed code here that they provide and save.', 'bluth_admin'),
				'id' => 'ad_posts_code',
				'class' => 'hide ad_posts_code',
				'std' => '',
				'type' => 'textarea');

			$options[] = array(
				'name' => __('Upload Image', 'bluth_admin'),
				'desc' => __('Upload an image to add between posts and add a link for it in the input box below', 'bluth_admin'),
				'id' => 'ad_posts_image',
				'class' => 'hide ad_posts_image',
				'type' => 'upload');

			$options[] = array(
				'name' => __('Image link', 'bluth_admin'),
				'desc' => __('Add a link to the image', 'bluth_admin'),
				'id' => 'ad_posts_image_link',
				'class' => 'hide ad_posts_image',
				'std' => '',
				'type' => 'text');	

			$options[] = array(
				'name' => __('Display Frequency', 'bluth_admin'),
				'desc' => __('How often do you want the ad to appear?', 'bluth_admin'),
				'id' => 'ad_posts_frequency',
				'std' => 'one',
				'type' => 'select',
				'class' => 'mini hide ad_posts_options', //mini, tiny, small
				'options' => array(
					'1' => __('Between every post', 'bluth_admin'),
					'2' => __('Every 2th posts', 'bluth_admin'),
					'3' => __('Every 3th post', 'bluth_admin'),
					'4' => __('Every 4th post', 'bluth_admin'),
					'5' => __('Every 5th post', 'bluth_admin')
				));

			$options[] = array(
				'name' => __('Add white background', 'bluth_admin'),
				'desc' => __('Check this to wrap the ad content in a white box', 'bluth_admin'),
				'id' => 'ad_posts_box',
				'std' => '1',
				'class' => 'hide ad_posts_options',
				'type' => 'checkbox');



			$options[] = array(
				'name' => __('Ad spot #3 - Above the content.', 'bluth_admin'),
				'desc' => __('Select what kind of ad you want added above the main container.', 'bluth_admin'),
				'id' => 'ad_content_mode',
				'std' => 'none',
				'type' => 'radio',
				'options' => array(
					'none' => __('None', 'bluth_admin'),
					'html' => __('Shortcode or HTML code like Adsense', 'bluth_admin'),
					'image' => __('Image with a link', 'bluth_admin')
				));

			$options[] = array(
				'name' => __('Add Shortcode or HTML code here', 'bluth_admin'),
				'desc' => __('Insert a shortcode provided by this theme or any plugin. You can also add advertising code from any provider or use plain html. To add Adsense just paste the embed code here that they provide and save.', 'bluth_admin'),
				'id' => 'ad_content_code',
				'class' => 'hide ad_content_code',
				'std' => '',
				'type' => 'textarea');

			$options[] = array(
				'name' => __('Upload Image', 'bluth_admin'),
				'desc' => __('Upload an image to add above the header menu and add a link for it in the input box below', 'bluth_admin'),
				'id' => 'ad_content_image',
				'class' => 'hide ad_content_image',
				'type' => 'upload');

			$options[] = array(
				'name' => __('Image link', 'bluth_admin'),
				'desc' => __('Add a link to the image', 'bluth_admin'),
				'id' => 'ad_content_image_link',
				'class' => 'hide ad_content_image',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Add white background', 'bluth_admin'),
				'desc' => __('Check this to wrap the ad content in a white box', 'bluth_admin'),
				'id' => 'ad_content_box',
				'std' => '1',
				'class' => 'hide ad_content_options',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Add padding', 'bluth_admin'),
				'desc' => __('Add padding to the banner container', 'bluth_admin'),
				'id' => 'ad_content_padding',
				'class' => 'hide ad_content_options',
				'std' => '1',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Banner placement', 'bluth_admin'),
				'desc' => __('Where do you want the banner to appear?', 'bluth_admin'),
				'id' => 'ad_content_placement',
				'class' => 'hide ad_content_options',
				'std' => array(
					'home' => '1',
					'pages' => '1',
					'posts' => '1'
				),
				'type' => 'multicheck',
				'options' => array(
					'home' => __('Frontpage', 'bluth_admin'),
					'pages' => __('Pages', 'bluth_admin'),
					'posts' => __('Posts', 'bluth_admin')
		));

	$options[] = array(
		'name' => '<i class="icon-flow-tree"></i> ' . __('Social', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Facebook API Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Facebook App Id', 'bluth_admin'),
				'desc' => __('Insert you Facebook app id here. If you don\'t have one for your webpage you can create it <a target="_blank" href="https://developers.facebook.com/apps">here</a>', 'bluth_admin'),
				'id' => 'facebook_app_id',
				'type' => 'text');

		$options[] = array(
			'name' => __('Social Networks', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Facebook', 'bluth_admin'),
				'desc' => __('Your facebook link', 'bluth_admin'),
				'id' => 'social_facebook',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Twitter', 'bluth_admin'),
				'desc' => __('Your twitter link', 'bluth_admin'),
				'id' => 'social_twitter',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Google+', 'bluth_admin'),
				'desc' => __('Your google+ link', 'bluth_admin'),
				'id' => 'social_google',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('LinkedIn', 'bluth_admin'),
				'desc' => __('Your LinkedIn link', 'bluth_admin'),
				'id' => 'social_linkedin',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Youtube', 'bluth_admin'),
				'desc' => __('Your youtube link', 'bluth_admin'),
				'id' => 'social_youtube',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('RSS', 'bluth_admin'),
				'desc' => __('Your RSS feed', 'bluth_admin'),
				'id' => 'social_rss',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Flickr', 'bluth_admin'),
				'desc' => __('Your Flickr link', 'bluth_admin'),
				'id' => 'social_flickr',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Vimeo', 'bluth_admin'),
				'desc' => __('Your vimeo link', 'bluth_admin'),
				'id' => 'social_vimeo',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Pinterest', 'bluth_admin'),
				'desc' => __('Your pinterest link', 'bluth_admin'),
				'id' => 'social_pinterest',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Dribbble', 'bluth_admin'),
				'desc' => __('Your dribbble link', 'bluth_admin'),
				'id' => 'social_dribbble',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Tumblr', 'bluth_admin'),
				'desc' => __('Your tumblr link', 'bluth_admin'),
				'id' => 'social_tumblr',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Instagram', 'bluth_admin'),
				'desc' => __('Your instagram link', 'bluth_admin'),
				'id' => 'social_instagram',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Viadeo', 'bluth_admin'),
				'desc' => __('Your viadeo link', 'bluth_admin'),
				'id' => 'social_viadeo',
				'std' => '',
				'type' => 'text');

	$options[] = array(
		'name' => '<i class="icon-tint"></i> ' . __('Portfolio Settings', 'bluth_admin'),
		'type' => 'heading');

			$options[] = array(
			'name' => __('Portfolio Pages', 'bluth_admin'),
			'type' => 'info');

				$options[] = array(
					'name' => __('Display Excerpt', 'bluth_admin'),
					'desc' => __('Display the excerpt on portfolio pages', 'bluth_admin'),
					'id' => 'portfolio_display_excerpt',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
			'name' => __('Style', 'bluth_admin'),
			'type' => 'info');	

				$options[] = array(
					'name' => __('Portfolio Style', 'bluth_admin'),
					'desc' => __('Select the default portfolio page style.', 'bluth_admin'),
					'id' => 'portfolio_style',
					'std' => 'margin',
					'type' => 'images',
					'options' => array(
						'margin' => $imagepath . 'layout-1.jpg',
						'twocolumn' => $imagepath . 'layout-2.jpg',
						'threecolumn' => $imagepath . 'layout-3.jpg',
						'fourcolumn' => $imagepath . 'layout-4.jpg',
						'fivecolumn' => $imagepath . 'layout-5.jpg',
					));

	$options[] = array(
		'name' => '<i class="icon-plus-1"></i> ' . __('Custom CSS', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Custom CSS Overwrite', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Add Custom CSS rules here', 'bluth_admin'),
				'desc' => __('Here you can overwrite specific css rules if you want to customize your theme a little. Write into this box just like you would do in a regular css file. Example: body{ color: #444; } <strong style="display:block;">All changes will remain on theme update, as long as the database will remain the same</strong>', 'bluth_admin'),
				'id' => 'custom_css',
				'class' => 'custom_css',
				'std' => '',
				'type' => 'textarea');



	return $options;
}
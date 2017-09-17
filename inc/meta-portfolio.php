<?php
	$categories = get_the_category();
	$project_link = get_post_custom_values('projLink');
	$separator = ' ';
	$output = '';
	if($categories){
		$output .= '<li>';
		foreach($categories as $category) {
			$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' .__('View all posts in', 'bluth'). ' '. esc_attr( $category->name).'">'.$category->cat_name.'</a>'.$separator;
		}
		$output .= '</li>';
	}
	if($project_link){
		$output .= '<li><a href="'.$project_link[0].'">'.$project_link[0].'</a></li>';
	}
?>
<ul class="meta-portfolio">
	<li><time class="entry-date updated" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date( 'd') . '. ' . get_the_date('M'); echo of_get_option('enable_show_year') ? '. ' . get_the_date('Y') : ''; ?></time></li>
	<?php echo trim($output, $separator); ?>
	<li><a href="<?php the_permalink(); ?>#comments"><?php comments_number(); ?></a></li>
</ul>

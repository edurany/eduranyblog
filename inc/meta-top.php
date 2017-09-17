<?php
	$categories = get_the_category();
	$separator = ' ';
	$output = '';
	if($categories){
		
		$output .= '<li>';
		foreach($categories as $category) {
			$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' .__('View all posts in', 'bluth'). ' '. esc_attr( $category->name).'">'.$category->cat_name.'</a>'.$separator;
		}
		$output .= '</li>';
	}
?>
<ul>
	<li><time class="entry-date updated" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); echo of_get_option('enable_show_year') ? '. ' . get_the_date('Y') : ''; ?></time></li>
	<li class="divider">/</li>
	<?php echo trim($output, $separator); ?>
	<li class="divider">/</li>
	<li><a href="<?php the_permalink(); ?>#comments"><?php comments_number(); ?></a></li>
</ul>

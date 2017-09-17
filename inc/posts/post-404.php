
	<div class="box pad-lg-35"><?php
		if(is_search()){ ?>
			<h1><?php _e('Nothing matched the search string: ', 'bluth'); ?><?php the_search_query(); ?></h1>
			<p class="lead text-muted"><?php _e('We could not find the page you were looking for.', 'bluth'); ?></p><?php
		}if(is_category()){ ?>
			<h1><?php _e('Category is empty', 'bluth'); ?></h1><?php
		}else{ ?>
			<h1><?php _e('404 - Page/Post not found', 'bluth'); ?></h1>
			<p class="lead text-muted"><?php _e('We could not find the page you were looking for.', 'bluth'); ?></p><?php
		} ?>
		<hr>
		<?php get_search_form(); ?> 
		<hr>
		<p class="lead text-muted"><?php _e('All is not lost, check these out.', 'bluth'); ?></p>
			<ul class=" clearfix"><?php 
				global $blu_args; 
				$blu_args = array(
					'sizes' => 'col-sm-12 col-md-12 col-lg-12',
					'show_excerpt' => true,
					'excerpt_length' => 140,
				);
				$q = new WP_Query( $blu_args ); 

				while ( $q->have_posts() ) { 
					$q->the_post(); ?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php
				} ?>
			</ul>

	</div>

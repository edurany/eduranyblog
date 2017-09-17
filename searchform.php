<form action="<?php echo home_url( '/' ); ?>" method="get" class="searchform" role="search">
    <fieldset>
    	<a href="#"><i class="icon-search-1"></i></a>
        <input type="text" name="s" value="<?php the_search_query(); ?>" placeholder="<?php _e('Search..', 'bluth'); ?>"/>
    </fieldset>
</form>
<form class="kuj-search" method="get" name="searchform" action="<?php echo esc_url( site_url() ); ?>/">
	<input name="s" type="text" value="<?php echo esc_attr(get_search_query()); ?>" />
	<input class="kuj-search-button" type="submit" value="" />
</form>
<?php
/*
Template Name: Artykuły
*/
?>

<?php get_header(); ?>
			<?php get_sidebar('top'); ?>
<?php
//function get_all_post_from_category()
//{
    //global $wp_query;
    //$wp_query->query('showposts=-1&cat=69');
//}
//add_action('wp_head', 'get_all_post_from_category');
query_posts('cat=69&posts_per_page=-1');
if ( have_posts() ) {
	echo '<article class="kuj-postcontent kuj-post">'.category_description(69).'<table class="spis art">';
    while ( have_posts() ) {
        the_post();
        echo '<tr><td class="art"><a href="'.get_permalink().'">';
        the_title();
        echo '</a></td><td><span>';
		the_time('d F Y');
		echo '</td></tr>';
    }
    echo '</table></article>';
}
?>
            <?php get_sidebar('bottom'); ?>
<?php get_footer(); ?>
<?php wp_reset_query(); ?>
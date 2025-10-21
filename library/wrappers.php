<?php

// $style = 'post' or 'block' or 'vmenu' or 'simple'
function theme_wrapper($style, $args) {
	$func_name = "theme_{$style}_wrapper";
	if (function_exists($func_name)) {
		call_user_func($func_name, $args);
	} else {
		theme_block_wrapper($args);
	}
}

function theme_post_wrapper($args = '') {
	$args = wp_parse_args($args, array(
			'id'        => '',
			'class'     => '',
			'title'     => '',
			'heading'   => 'h2',
			'thumbnail' => '',
			'before'    => '',
			'content'   => '',
			'after'     => '',
			'comments'     => ''
		)
	);
	extract($args);
	if (theme_is_empty_html($title) && theme_is_empty_html($content))
		return;
	if ($id !== '') {
		$id = ' id="' . $id . '" ';
	}
	if ($class !== '') {
		$class = ' ' . $class;
	}
	?>
	<article<?php echo $id; ?> class="kuj-post kuj-article <?php echo $class; ?>" style="">
                           <?php echo $before; ?>     <?php
if (!theme_is_empty_html($title)) {
	echo '<'.$heading.' class="kuj-postheader entry-title">'.$title.'</'.$heading.'>';
}
?>

                                <?php echo $thumbnail; ?><div class="kuj-postcontent clearfix"><?php echo $content; ?></div>


<?php echo $comments; ?></article>
	<?php
}

function theme_simple_wrapper($args = '') {
	$args = wp_parse_args($args, array(
			'id'      => '',
			'class'   => '',
			'title'   => '',
			'heading' => 'div',
			'content' => '',
		)
	);
	extract($args);
	if (theme_is_empty_html($title) && theme_is_empty_html($content))
		return;
	if ($id !== '') {
		$id = ' id="' . $id . '" ';
	}
	if ($class !== '') {
		$class = ' ' . $class;
	}
	echo "<div class=\"kuj-widget{$class}\"{$id}>";
	if (!theme_is_empty_html($title))
		echo '<' . $heading . ' class="kuj-widget-title">' . $title . '</' . $heading . '>';
	echo '<div class="kuj-widget-content">' . $content . '</div>';
	echo '</div>';
}

function theme_block_wrapper($args) {
	$args = wp_parse_args($args, array(
			'id'      => '',
			'class'   => '',
			'title'   => '',
			'heading' => 'div',
			'content' => '',
		)
	);
	extract($args);
	if (theme_is_empty_html($title) && theme_is_empty_html($content))
		return;
	if ($id !== '') {
		$id = ' id="' . $id . '" ';
	}
	if ($class !== '') {
		$class = ' ' . $class . ' ';
	}

	$begin = <<<EOL
<div {$id}class="kuj-block{$class} clearfix">
        
EOL;
	$begin_title = <<<EOL
<div class="kuj-blockheader">
            <$heading class="t">
EOL;
	$end_title = <<<EOL
</$heading>
        </div>
EOL;
	$begin_content = <<<EOL
<div class="kuj-blockcontent">
EOL;
	$end_content = <<<EOL
</div>
EOL;
	$end = <<<EOL

</div>
EOL;
	echo $begin;
	if ($begin_title && $end_title && !theme_is_empty_html($title)) {
		echo $begin_title . $title . $end_title;
	}
	echo $begin_content;
	echo $content;
	echo $end_content;
	echo $end;
}


function theme_vmenu_wrapper($args) {
	$args = wp_parse_args($args, array(
			'id'      => '',
			'class'   => '',
			'title'   => '',
			'heading' => 'div',
			'content' => '',
		)
	);
	extract($args);
	if (theme_is_empty_html($title) && theme_is_empty_html($content))
		return;
	if ($id !== '') {
		$id = ' id="' . $id . '" ';
	}
	if ($class !== '') {
		$class = ' ' . $class;
	}
	
	$begin = <<<EOL
<div {$id}class="kuj-vmenublock clearfix">
        
EOL;
	$begin_title = <<<EOL
<div class="kuj-vmenublockheader">
            <$heading class="t">
EOL;
	$end_title = <<<EOL
</$heading>
        </div>
EOL;
	$begin_content = <<<EOL
<div class="kuj-vmenublockcontent">
EOL;
	$end_content = <<<EOL
</div>
EOL;
	$end = <<<EOL

</div>
EOL;
	echo $begin;
	if ($begin_title && $end_title && !theme_is_empty_html($title)) {
		echo $begin_title . $title . $end_title;
	}
	echo $begin_content;
	echo $content;
	echo $end_content;
	echo $end;
}

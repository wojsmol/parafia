<?php
// widget extra options
global $theme_widgets_style;
$theme_widgets_style = ['default' => __('sidebar default', THEME_NS), 'block' => __('block', THEME_NS), 'post' => __('post', THEME_NS), 'simple' => __('simple text', THEME_NS)];

function theme_get_widget_style($id, $style = null) {

	if (theme_is_vmenu_widget($id)) {
		return 'vmenu';
	}

	$result = theme_get_widget_meta_option($id, 'theme_widget_styles');
	global $theme_widgets_style;
	if (!in_array($result, array_keys($theme_widgets_style))) {
		$result = 'default';
	}
	if ($style != null) {
		if (!in_array($style, ['block', 'post', 'simple'])) {
			$style = 'block';
		}
		if ($result == 'default') {
			$result = $style;
		}
	}
	return $result;
}

function theme_set_widget_style($id, $style): void {
	global $theme_widgets_style;
	if (!in_array($style, array_keys($theme_widgets_style))) {
		$style = 'default';
	}
	theme_set_widget_meta_option($id, 'theme_widget_styles', $style);
}

function theme_widget_expand_control($id): void {
	global $wp_registered_widget_controls;
	$controls = &$wp_registered_widget_controls[$id];
	if (!is_array($controls['params'])) {
		$controls['params'] = [$controls['params']];
	}
	$controls['params'][] = $id;
	if (isset($controls['callback'])) {
		$controls['callback_redirect'] = $controls['callback'];
	}
	$controls['callback'] = 'theme_widget_extra_control';
}

function theme_update_widget_additional(array $instance): array {
	global $theme_widget_meta_options;
	foreach ($theme_widget_meta_options as $value) {
		$id = theme_get_array_value($value, 'id');
		$val = stripslashes((string) theme_get_array_value($_POST, $id));
		$type = theme_get_array_value($value, 'type');
		$options = theme_get_array_value($value, 'options');
		switch ($type) {
			case 'checkbox':
				$val = ($val !== '' && $val !== '0' ? 1 : 0);
				break;
			case 'numeric':
				$val = (int) $val;
				break;
			case 'select':
				if (!in_array($val, array_keys($options))) {
					$val = reset(array_keys($options));
				}
				break;
		}
		$instance[$id] = $val;
	}
	return $instance;
}
function theme_widget_process_control(): void {
	global $wp_registered_widget_controls;
	if ('post' === strtolower((string) $_SERVER['REQUEST_METHOD']) && isset($_POST['widget-id'])) {
		theme_widget_expand_control($_POST['widget-id']);
		return;
	}
	foreach ($wp_registered_widget_controls as $id => $widget) {
		theme_widget_expand_control($id);
	}
}

function theme_widget_extra_control(...$params): ?false {
	global $wp_registered_widget_controls, $theme_widgets_style, $theme_widget_meta_options;
	$_theme_widget_meta_options = $theme_widget_meta_options;
	$widget_id = $params[count($params) - 1]; // see theme_widget_expand_control func
	$widget_controls = theme_get_array_value($wp_registered_widget_controls, $widget_id, []);
	if (isset($widget_controls['callback_redirect'])) {
		$callback = $widget_controls['callback_redirect'];
		if (is_callable($callback)) {
			call_user_func_array($callback, $params);
		}
	}
	if (!preg_match('/^(.*[^-])-(\d+)$/', (string) $widget_id, $matches) || !isset($matches[1]) || !isset($matches[2])) {
		return false;
	}
	$id = $matches[1] . '-' . $params[0]['number'];
	
	if (theme_is_vmenu_widget($id)) {
		$need_delete = false;
		foreach($_theme_widget_meta_options as $option_id => $option) {
			if($option['id'] == 'theme_widget_styles') {
				$need_delete = true;
				break;
			}
		}
		if($need_delete) {
			unset($_theme_widget_meta_options[$option_id]);
		}
	}
	
	?>
	<h3 style="margin-bottom:3px;"><?php _e('Theme Options', THEME_NS); ?></h3>
	<?php
	theme_print_meta_box($id, $_theme_widget_meta_options);
	return null;
}

// widgets

class VMenuWidget extends WP_Widget {

	function __construct() {
		$widget_ops = ['classname' => 'vmenu', 'description' => __('Use this widget to add one of your custom menus as a widget.', THEME_NS)];
		parent::__construct(false, __('Vertical Menu', THEME_NS), $widget_ops);
	}

	#[\Override]
	function widget($args, $instance): void {
		extract($args);
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo theme_get_menu(['source' => $instance['source'], 'depth' => theme_get_option('theme_vmenu_depth'), 'menu' => wp_get_nav_menu_object($instance['nav_menu']), 'class' => 'kuj-vmenu']);
		echo $after_widget;
	}

	#[\Override]
	function update($new_instance, $old_instance) {
		$instance['title'] = strip_tags((string) $new_instance['title']);
		$instance['source'] = $new_instance['source'];
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		return $instance;
	}

	#[\Override]
	function form($instance): void {
		//Defaults
		$instance = wp_parse_args((array) $instance, ['title' => '', 'source' => 'Pages', 'nav_menu' => '']);
		$title = esc_attr($instance['title']);
		$source = $instance['source'];
		$nav_menu = $instance['nav_menu'];

		// Get menus
		$menus = get_terms('nav_menu', ['hide_empty' => false]);
		$sources = ['Pages' => __('Pages', THEME_NS), 'Categories' => __('Categories', THEME_NS), 'Custom Menu' => __('Custom Menu', THEME_NS)];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEME_NS) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('source'); ?>"><?php echo __('Source', THEME_NS) . ':'; ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('source'); ?>" name="<?php echo $this->get_field_name('source'); ?>" onchange="var s = jQuery('.p-<?php echo $this->get_field_id('nav_menu'); ?>'); if (this.value == 'Custom Menu') s.show(); else s.hide();">
		<?php
		foreach ($sources as $s => $t ) {
			$selected = ($source == $s ? ' selected="selected"' : '');
			echo '<option' . $selected . ' value="' . $s . '">' . $t . '</option>';
		}
		?>
		</select>
		</p>
		<p class="p-<?php echo $this->get_field_id('nav_menu'); ?>" <?php if ($source !== 'Custom Menu') {
			echo ' style="display:none"';
		} ?>>
		<?php
		// If no menus exists, direct the user to go and create some.
		if (!$menus) {
			printf(__('No menus have been created yet. <a href="%s">Create some</a>.', THEME_NS), admin_url('nav-menus.php'));
		} else {
			?>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:', THEME_NS); ?></label><br />
			<select class="widefat" id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
			<?php
			foreach ($menus as $menu) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option' . $selected . ' value="' . $menu->term_id . '">' . $menu->name . '</option>';
			}
			?>
			</select>
			<?php
		}
		?>
		</p>
		<?php
	}

}

class LoginWidget extends WP_Widget {

	function __construct() {
		$widget_ops = ['classname' => 'login', 'description' => __('Login form', THEME_NS)];
		parent::__construct(false, __('Login', THEME_NS), $widget_ops);
	}

	#[\Override]
	function widget($args, $instance): void {
		global $user_ID, $user_identity, $user_level, $user_email, $user_login;
		extract($args);
		echo $before_widget;
		echo $before_title;
		if ($user_ID):
			echo $user_identity;
			echo $after_title;
			?>
			<ul>
			<li><a href="<?php echo esc_url( site_url() ) ?>/wp-admin/"><?php _e('Dashboard', THEME_NS); ?></a></li>
			<?php if ($user_level >= 1): ?>
				<li><a href="<?php echo esc_url( site_url() ) ?>/wp-admin/post-new.php"><?php _e('Publish', THEME_NS); ?></a></li>
				<li><a href="<?php echo esc_url( site_url() ) ?>/wp-admin/edit-comments.php"><?php _e('Comments', THEME_NS); ?></a></li>
			<?php endif; ?>
			<li><a href="<?php echo wp_logout_url() ?>&amp;redirect_to=<?php echo urlencode(theme_get_current_url()); ?>"><?php _e("Log out", THEME_NS); ?></a></li>
			</ul>
		<?php
		else:
			_e('Log In', THEME_NS);
			echo $after_title;
			?>
			<form action="<?php echo esc_url( site_url() ) ?>/wp-login.php" method="post" name="login" id="form-login">
				<fieldset class="input" style="border: 0 none;">
					<p id="form-login-username">
						<label for="log"><?php _e('Username', THEME_NS) ?></label>
						<br>
						<input type="text" name="log" id="log" value="<?php echo esc_attr(stripslashes((string) $user_login)) ?>" size="20" />
					</p>
					<p id="form-login-password">
						<label for="pwd"><?php _e("Password", THEME_NS); ?></label>
						<br>
						<input type="password" name="pwd" id="pwd" size="20" /><br />
					</p>
					<p id="form-login-remember">
						<label for="rememberme"><?php _e('Remember Me', THEME_NS); ?></label>
						<input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" />
					</p>
					<input class="kuj-button" type="submit" name="submit" value="<?php echo esc_attr(__('Log In', THEME_NS)); ?>" />
				</fieldset>
				<input type="hidden" name="redirect_to" value="<?php echo theme_get_current_url(); ?>"/>
			</form>
			<ul>
				<?php if (get_option('users_can_register')) { ?>
				<li><a href="<?php echo esc_url( site_url() ) ?>/wp-register.php"><?php _e("Register", THEME_NS); ?></a></li>
				<?php } ?>
				<li><a href="<?php echo esc_url( site_url() ) ?>/wp-login.php?action=lostpassword"><?php _e("Lost your password?", THEME_NS); ?></a></li>
			</ul>
		<?php endif;
		echo $after_widget;
	}
}

// init widgets
function artWidgetsInit(): void {
	register_widget('VMenuWidget');
	register_widget('LoginWidget');
}

add_action('widgets_init', 'artWidgetsInit');

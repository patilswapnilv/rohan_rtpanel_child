<?php
/*
Plugin Name: Page List Widget
Plugin URI: http://www.nigauri.me/tech/wordpress/plugin_page_list_widget
Description: This is a widget plugin. This widget will display a list of posts/pages.
Author: nigauri
Version: 1.2.3
Author URI: http://www.nigauri.me/
Domain Path: /languages
Text Domain: page-list-widget
*/

define("PAGES_LIST_WIDGET_DOMAIN", "page-list-widget");

load_plugin_textdomain(PAGES_LIST_WIDGET_DOMAIN, false, basename( dirname( __FILE__ ) ) . '/languages' );

add_action(
	'widgets_init',
	create_function('', 'return register_widget("PageListWidget");')
);

/**
 * Page List Widget.
 * @author nigauri
 */
class PageListWidget extends WP_Widget {

	/**
	 * constructor.
	 */
	function __construct() {
		$widget_ops = array('description' => __("This widget will display a list of posts/pages.", PAGES_LIST_WIDGET_DOMAIN));
		parent::__construct(
			false,
			__("Post/Page list", PAGES_LIST_WIDGET_DOMAIN),
			$widget_ops
		);
	}

	/**
	 * Generates the form for this widget.
	 * @param array $instance settings.
	 */
	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'        => '',
				'post_or_page' => '1',
				'number'       => '5',
				'sort_col'     => 'post_modified',
				'asc_desc'     => 'desc',
				'exclude'      => '',
				'include'      => '',
				'show_create_date'   => '0',
				'create_date_prefix' => '',
				'create_date_suffix' => '',
				'show_update_date'   => '1',
				'update_date_prefix' => '',
				'update_date_suffix' => ''
			)
		);

		$title        = strip_tags($instance['title']);
		$post_or_page = strip_tags($instance['post_or_page']);
		$number       = strip_tags($instance['number']);
		$sort_col     = strip_tags($instance['sort_col']);
		$asc_desc     = strip_tags($instance['asc_desc']);
		$exclude      = strip_tags($instance['exclude']);
		$include      = strip_tags($instance['include']);
		$show_create_date   = strip_tags($instance['show_create_date']);
		$create_date_prefix = strip_tags($instance['create_date_prefix']);
		$create_date_suffix = strip_tags($instance['create_date_suffix']);
		$show_update_date   = strip_tags($instance['show_update_date']);
		$update_date_prefix = strip_tags($instance['update_date_prefix']);
		$update_date_suffix = strip_tags($instance['update_date_suffix']);
?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php _e('Title:', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<?php _e('Type:', PAGES_LIST_WIDGET_DOMAIN); ?>

			<input id="<?php echo $this->get_field_id('post_or_page'); ?>_0" name="<?php echo $this->get_field_name('post_or_page'); ?>" type="radio" value="0" <?php echo $post_or_page == "0" ? "checked=\"checked\"" : ""; ?> />
			<label for="<?php echo $this->get_field_id('post_or_page'); ?>_0">
				<?php _e('Posts', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>

			<input id="<?php echo $this->get_field_id('post_or_page'); ?>_1" name="<?php echo $this->get_field_name('post_or_page'); ?>" type="radio" value="1" <?php echo $post_or_page == "1" ? "checked=\"checked\"" : ""; ?> />
			<label for="<?php echo $this->get_field_id('post_or_page'); ?>_1">
				<?php _e('Pages', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">
				<?php _e('Number:', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" />
		</p>

		<p>
			<input id="<?php echo $this->get_field_id('show_create_date'); ?>" name="<?php echo $this->get_field_name('show_create_date'); ?>" type="checkbox" value="1" <?php echo $show_create_date == "1" ? "checked=\"checked\"" : ""; ?> />
			<label for="<?php echo $this->get_field_id('show_create_date'); ?>">
				<?php _e('Display created date', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>

			<br />

			<label for="<?php echo $this->get_field_id('create_date_prefix'); ?>">
				<?php _e('Prefix:', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
			<input size="10" id="<?php echo $this->get_field_id('create_date_prefix'); ?>" name="<?php echo $this->get_field_name('create_date_prefix'); ?>" type="text" value="<?php echo esc_attr($create_date_prefix); ?>" />

			<label for="<?php echo $this->get_field_id('create_date_suffix'); ?>">
				<?php _e('Suffix:', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
			<input size="10" id="<?php echo $this->get_field_id('create_date_suffix'); ?>" name="<?php echo $this->get_field_name('create_date_suffix'); ?>" type="text" value="<?php echo esc_attr($create_date_suffix); ?>" />
		</p>


		<p>
			<input id="<?php echo $this->get_field_id('show_update_date'); ?>" name="<?php echo $this->get_field_name('show_update_date'); ?>" type="checkbox" value="1" <?php echo $show_update_date == "1" ? "checked" : ""; ?> />
			<label for="<?php echo $this->get_field_id('show_update_date'); ?>">
				<?php _e('Display modified date', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>

			<br />

			<label for="<?php echo $this->get_field_id('update_date_prefix'); ?>">
				<?php _e('Prefix:', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
			<input size="10" id="<?php echo $this->get_field_id('update_date_prefix'); ?>" name="<?php echo $this->get_field_name('update_date_prefix'); ?>" type="text" value="<?php echo esc_attr($update_date_prefix); ?>" />

			<label for="<?php echo $this->get_field_id('update_date_suffix'); ?>">
				<?php _e('Suffix:', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
			<input size="10" id="<?php echo $this->get_field_id('update_date_suffix'); ?>" name="<?php echo $this->get_field_name('update_date_suffix'); ?>" type="text" value="<?php echo esc_attr($update_date_suffix); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('sort_col'); ?>">
				<?php _e('Order by:', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
			<select id="<?php echo $this->get_field_id('sort_col'); ?>" name="<?php echo $this->get_field_name('sort_col'); ?>">
				<option value="post_title" <?php echo $sort_col == "post_title" ? "selected" : ""; ?>><?php _e('Title', PAGES_LIST_WIDGET_DOMAIN); ?></option>
				<option value="menu_order" <?php echo $sort_col == "menu_order" ? "selected" : ""; ?>><?php _e('Menu order', PAGES_LIST_WIDGET_DOMAIN); ?></option>
				<option value="post_date" <?php echo $sort_col == "post_date" ? "selected" : ""; ?>><?php _e('Post date', PAGES_LIST_WIDGET_DOMAIN); ?></option>
				<option value="post_modified" <?php echo $sort_col == "post_modified" ? "selected" : ""; ?>><?php _e('Modified date', PAGES_LIST_WIDGET_DOMAIN); ?></option>
				<option value="ID" <?php echo $sort_col == "ID" ? "selected" : ""; ?>><?php _e('ID', PAGES_LIST_WIDGET_DOMAIN); ?></option>
				<option value="post_author" <?php echo $sort_col == "post_author" ? "selected" : ""; ?>><?php _e('Author', PAGES_LIST_WIDGET_DOMAIN); ?></option>
				<option value="post_name" <?php echo $sort_col == "post_name" ? "selected" : ""; ?>><?php _e('Post name', PAGES_LIST_WIDGET_DOMAIN); ?></option>
			</select>
			<select id="<?php echo $this->get_field_id('asc_desc'); ?>" name="<?php echo $this->get_field_name('asc_desc'); ?>">
				<option value="asc" <?php echo $asc_desc == "asc" ? "selected" : ""; ?>><?php _e('Asc', PAGES_LIST_WIDGET_DOMAIN); ?></option>
				<option value="desc" <?php echo $asc_desc == "desc" ? "selected" : ""; ?>><?php _e('Desc', PAGES_LIST_WIDGET_DOMAIN); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('include'); ?>">
				<?php _e('Include:', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('include'); ?>" name="<?php echo $this->get_field_name('include'); ?>" type="text" value="<?php echo esc_attr($include); ?>" />
			<small><?php _e('Page/Post IDs, separated by commas.', PAGES_LIST_WIDGET_DOMAIN); ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>">
				<?php _e('Exclude:', PAGES_LIST_WIDGET_DOMAIN); ?>
			</label>
			<input class="widefat" id="<?php echo $this->get_field_id('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" type="text" value="<?php echo esc_attr($exclude); ?>" />
			<small><?php _e('Page/Post IDs, separated by commas.', PAGES_LIST_WIDGET_DOMAIN); ?></small>
		</p>

<?php
	}

	/**
	 * Save settings.
	 */
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title']        = strip_tags($new_instance['title']);
		$instance['post_or_page'] = strip_tags($new_instance['post_or_page']);
		$instance['number']       = strip_tags($new_instance['number']);
		$instance['sort_col']     = strip_tags($new_instance['sort_col']);
		$instance['asc_desc']     = strip_tags($new_instance['asc_desc']);
		$instance['exclude']      = strip_tags($new_instance['exclude']);
		$instance['include']      = strip_tags($new_instance['include']);
		$instance['show_create_date']   = strip_tags($new_instance['show_create_date']);
		$instance['create_date_prefix'] = strip_tags($new_instance['create_date_prefix']);
		$instance['create_date_suffix'] = strip_tags($new_instance['create_date_suffix']);
		$instance['show_update_date']   = strip_tags($new_instance['show_update_date']);
		$instance['update_date_prefix'] = strip_tags($new_instance['update_date_prefix']);
		$instance['update_date_suffix'] = strip_tags($new_instance['update_date_suffix']);

		return $instance;
	}

	/**
	 * Display this widget.
	 */
	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? ($instance['post_or_page'] == "0" ? __('Post list', PAGES_LIST_WIDGET_DOMAIN) : __('Page list', PAGES_LIST_WIDGET_DOMAIN)) : $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
?>

<ul>

<?php

$posts_or_pages_array = null;

if ($instance['post_or_page'] == "0") {

	$args = array(
		'numberposts'     => empty($instance['number']) ? 5 : $instance['number'],
		'offset'          => 0,
		'category'        => '',
		'orderby'         => empty($instance['sort_col']) ? "post_modified" : $instance['sort_col'],
		'order'           => empty($instance['asc_desc']) ? "desc" : $instance['asc_desc'],
		'include'         => $instance['include'],
		'exclude'         => $instance['exclude'],
		'meta_key'        => '',
		'meta_value'      => '',
		'post_type'       => 'post',
		'post_mime_type'  => '',
		'post_parent'     => '',
		'post_status'     => 'publish'
	);

	$posts_or_pages_array = get_posts( $args );

} else {

	$args = array(
		'child_of'     => '',
		'sort_order'   => empty($instance['asc_desc']) ? "desc" : $instance['asc_desc'],
		'sort_column'  => empty($instance['sort_col']) ? "post_modified" : $instance['sort_col'],
		'hierarchical' => 0,
		'exclude'      => $instance['exclude'],
		'include'      => $instance['include'],
		'meta_key'     => '',
		'meta_value'   => '',
		'authors'      => '',
		'parent'       => -1,
		'exclude_tree' => '',
		'number'       => empty($instance['number']) ? 5 : $instance['number'],
		'offset'       => 0,
		'post_type'    => 'page',
		'post_status'  => 'publish'
	);

	$posts_or_pages_array = get_pages($args);

}


foreach ($posts_or_pages_array as $single_post_or_page) {
	$li = "<li><a href=\"" . get_page_link($single_post_or_page->ID) . "\" title=\"" . $single_post_or_page->post_title . "\">";
	$li .= $single_post_or_page->post_title;
	$li .= "</a>";

	if ($instance['show_create_date'] == "1") {
		$li .= "<span class=\"post-date created-date\">";
		$li .= $instance['create_date_prefix'];
		$li .= mysql2date(get_option('date_format'), $single_post_or_page->post_date);
		$li .= $instance['create_date_suffix'];
		$li .= "</span>";
	}

	if ($instance['show_update_date'] == "1") {
		$li .= "<span class=\"post-date modified-date\">";
		$li .= $instance['update_date_prefix'];
		$li .= mysql2date(get_option('date_format'), $single_post_or_page->post_modified);
		$li .= $instance['update_date_suffix'];
		$li .= "</span>";
	}

	$li .= '</li>';
	echo $li;
}

?>

</ul>

<?php
		echo $after_widget;
	}

}

?>
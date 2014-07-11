<?php 

add_action( 'admin_menu', 'my_plugin_menu_child' );
function my_plugin_menu_child() {
	add_menu_page( 'My Plugin Options', 'slider_page', 'manage_options', 'slider_page', 'my_plugin_options_child' );
}

function my_plugin_options_child() {
	global $wpdb;
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	  $selected_value = $wpdb->get_results( 'SELECT option_value FROM wp_options WHERE option_name = \'slider_page\'');
 $selected_page_name = $selected_value[0]->option_value;
	echo '<br /><br />Select which page you would like to display on slider<br />';
	echo '<form id="uploadImage" action="../wp-content/themes/rtpanel/slider_page.php" method="post">';
	echo '<select name="selectedpage" id="selectedpage">'; 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
	  if($page->post_title == $selected_page_name)
	  	$option = '<option value="' . $page->post_title . '" selected>';
	  else
  		$option = '<option value="' . $page->post_title . '">';
	$option .= $page->post_title;
	$option .= '</option>';
	echo $option;
  }
echo '</select><input type="submit" value="submit" /></form>';
}

/* Includes PHP files located in 'lib' folder */
foreach( glob ( get_template_directory() . "/lib/*.php" ) as $lib_filename ) {
    require_once( $lib_filename );
}

if (function_exists('register_sidebar')) {
     register_sidebar(array(
      'name' => 'leftsidebar',
      'id'   => 'leftsidebar',
      'description'   => 'Widget Area',
      'before_widget' => '<div id="left_sidebar" class="left_sidebar">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3 class="header_img">',
      'after_title'   => '</h3>'
     ));
	 register_sidebar(array(
      'name' => 'bottomwidget',
      'id'   => 'bottomwidget',
      'description'   => 'Widget Area',
      'before_widget' => '<div id="bottom_widget" class="bottom_widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3 class="header_img">',
      'after_title'   => '</h3>'
     ));
	 register_sidebar(array(
      'name' => 'bottomwidgetlast',
      'id'   => 'bottomwidgetlast',
      'description'   => 'Widget Area',
      'before_widget' => '<div id="bottom_widget_last" class="bottom_widget_last">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3 class="header_img">',
      'after_title'   => '</h3>'
     ));
	 register_sidebar(array(
      'name' => 'footerwidget',
      'id'   => 'footerwidget',
      'description'   => 'Widget Area',
      'before_widget' => '<div id="footerwidget" class="footerwidget">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>'
     ));
    }
	
	function rt_shortcode( $atts) {

	// Attributes
	extract( shortcode_atts(
		array(
			'url' => '',
			'title' => '',
		), $atts )
	);

	// Code
return '<a class="rt_link" href="' . $url . '">'.$title.'</a>';

}
add_shortcode( 'rt-link', 'rt_shortcode' );

function create_posttype_child() {

	register_post_type( 'homegallery',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'homegallery' ),
				'singular_name' => __( 'homegallery' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'homegallery'),
		)
	);
	register_post_type( 'partners',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'partners' ),
				'singular_name' => __( 'partners' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'partners'),
		)
	);
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype_child' );
add_shortcode("rohan_veer", "demolistposts_handler_child");

function demolistposts_handler_child() {
  //run function that actually does the work of the plugin
  $demolph_output = demolistposts_function_child();
  //send back text to replace shortcode in post
  return $demolph_output;
}

function rohan_scripts_child(){
	
	wp_enqueue_style( 'default.css', '/wp-content/themes/rtpanel-child-theme/slider/themes/default/default.css' );
	wp_enqueue_style( 'nivo-slider.css', '/wp-content/themes/rtpanel-child-theme/slider/nivo-slider.css' );
	wp_enqueue_script( 'jquery.nivo.slider.js', '/wp-content/themes/rtpanel-child-theme/slider/jquery.nivo.slider.js' );
	}
	

function demolistposts_function_child() {
	$demolp_output = '<div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">';
	$files = scandir("wp-content/themes/rtpanel-child-theme/images/",1);
	for($i=0;$i<count($files);$i++){
		$file = $files[$i];
		$type = explode( '.', $file );
		if($type[1] == 'jpg'){
			$path = 'wp-content/themes/rtpanel-child-theme/images/'.$file;
  $demolp_output = $demolp_output.'<img src='.$path.' data-thumb='.$path.' alt="" />';
			}
		}
 
    $demolp_output = $demolp_output.'</div>
        </div>';
  return $demolp_output;
}

function my_script_child(){
	echo '<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery(\'#slider\').nivoSlider();
    });
    </script>';
	}
	
function rtp_home_slider_child( $theme_pages ) {
	$theme_pages['rtp_hooks'] = array(
		'menu_title' => __( 'Home Slider', 'rtPanel' ),
        'menu_slug' => 'rtp_home_slider_child'
	);
	return $theme_pages;
}

function rtp_home_slider_child_options_page( $pagehook ) {
	global $screen_layout_columns;
		$files2 = scandir('../wp-content/themes/rtpanel-child-theme/images/',1);
	echo '<br /><br />';
	for($i=0;$i<count($files2);$i++){
		$file = $files2[$i];
		$type = explode( '.', $file );
		if($type[1] == 'jpg' || $type[1] == 'png' || $type[1] == 'jpeg' || $type[1] == 'gif'){
			$path = '../wp-content/themes/rtpanel-child-theme/images/'.$file;
			echo '<img style="width:300px;" src="'.$path.'" /><a href="../wp-content/themes/rtpanel-child-theme/slider/delete.php?filename='.$file.'&action=delete">Delete</a><br />';
			}
		}
		$inputform = '<form id="uploadImage" action="../wp-content/themes/rtpanel-child-theme/slider/delete.php?action=add" method="post" enctype="multipart/form-data">
		<input type="file" id="file" name="file" /><input type="submit" value="Submit" /></form>';
		echo $inputform;
	}

add_action( 'wp_enqueue_scripts', 'rohan_scripts_child' );
add_action('wp_footer', 'my_script_child');
add_filter( 'rtp_add_theme_pages', 'rtp_home_slider_child' );



?>
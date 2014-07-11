<?php
/*
Plugin Name: Nivo Slider
Description: Responsive Nivo Slider By Rohan Veer, Simply Activate the plugin and use shortcode <strong>[rohan_veer]</strong> to insert slider into page.To add images go to plugins directory and add images into images folder.
Version: 1.0
Author: Rohan
Author URI: 
*/
add_shortcode("rohan_veer", "demolistposts_handler");

function demolistposts_handler() {
  //run function that actually does the work of the plugin
  $demolph_output = demolistposts_function();
  //send back text to replace shortcode in post
  return $demolph_output;
}

function demolistposts_function() {
	$demolp_output = '<div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">';
	$files = scandir('wp-content/plugins/rohan/images/',1);
	for($i=0;$i<count($files);$i++){
		$file = $files[$i];
		$type = explode( '.', $file );
		if($type[1] == 'jpg'){
			$path = 'wp-content/plugins/rohan/images/'.$file;
  $demolp_output = $demolp_output.'<img src='.$path.' data-thumb='.$path.' alt="" />';
			}
		}
 
    $demolp_output = $demolp_output.'</div>
        </div><script type="text/javascript">
    $(window).load(function() {
        $(\'#slider\').nivoSlider();
    });
    </script>';
  return $demolp_output;
}

function rohan_scripts(){
	wp_enqueue_style( 'default.css', '/wp-content/plugins/rohan/themes/default/default.css' );
	wp_enqueue_style( 'light.css', '/wp-content/plugins/rohan/themes/light/light.css' );
	wp_enqueue_style( 'dark.css', '/wp-content/plugins/rohan/themes/dark/dark.css' );
	wp_enqueue_style( 'bar.css', '/wp-content/plugins/rohan/themes/bar/bar.css' );
	wp_enqueue_style( 'nivo-slider.css', '/wp-content/plugins/rohan/nivo-slider.css' );
	wp_enqueue_style( 'style.css', '/wp-content/plugins/rohan/style.css' );
	wp_enqueue_script( 'jquery-1.9.0.min.js', '/wp-content/plugins/rohan/scripts/jquery-1.9.0.min.js' );
	wp_enqueue_script( 'jquery.nivo.slider.js', '/wp-content/plugins/rohan/jquery.nivo.slider.js' );
	}
	
function mypage(){
	$files2 = scandir('../wp-content/plugins/rohan/images/',1);
	echo '<br /><br />';
	for($i=0;$i<count($files2);$i++){
		$file = $files2[$i];
		$type = explode( '.', $file );
		if($type[1] == 'jpg' || $type[1] == 'png' || $type[1] == 'jpeg' || $type[1] == 'gif'){
			$path = '../wp-content/plugins/rohan/images/'.$file;
			echo '<img style="width:300px;" src="'.$path.'" /><a href="../wp-content/plugins/rohan/delete.php?filename='.$file.'&action=delete">Delete</a><br />';
			}
		}
		$inputform = '<form id="uploadImage" action="../wp-content/plugins/rohan/delete.php?action=add" method="post" enctype="multipart/form-data">
		<input type="file" id="file" name="file" /><input type="submit" value="Submit" /></form>';
		echo $inputform;
}

function my_plugin_menu() {
	add_options_page( 'RohanSlider', 'RohanSlider', 'manage_options', 'rohanslider', 'mypage' );
}
add_action( 'admin_menu', 'my_plugin_menu' );
add_action( 'wp_enqueue_scripts', 'rohan_scripts' );


?>

<?php /*
Plugin Name: Contributors Meta Box
Description: Adds Contributors meta box
Author: Rohan Veer
Version: 1.0
*/ 

function prfx_custom_meta() {
    add_meta_box( 'prfx_meta', __( 'Contributors', 'prfx-textdomain' ), 'prfx_meta_callback', 'post' , 'side' );
}

function prfx_meta_callback( $post ) {
wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$list = get_users();
	$pluginurl = plugins_url().'/my_meta/';
	foreach($list as $contname){
		$exists = checkSelected($contname->ID,$post);
		if($exists){		
		echo '<input type="checkbox" name="contName[]" value="'.$contname->ID.'" checked>'.$contname->display_name.'<br>';
		}else{
		echo '<input type="checkbox" name="contName[]" value="'.$contname->ID.'">'.$contname->display_name.'<br>';
			}
		}
		echo '<input style="display:none" type="checkbox" name="contName[]" value="" checked>';
	}
	
function checkSelected($contId,$post){
	    $prfx_stored_meta = get_post_meta( $post->ID, 'contName');
		if($prfx_stored_meta[0]){
	foreach($prfx_stored_meta[0] as $selecteddata){
		if($selecteddata == $contId)
		return true;
	}
	}
	return false;
	}

function prfx_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    if( isset( $_POST[ 'contName' ] ) ) {
        update_post_meta( $post_id, 'contName', $_POST[ 'contName' ] );
    }
 
}

function cont_box($content){
	if(is_single()) {
		 $prfx_stored_meta = get_post_meta( get_the_ID(), 'contName');
		if($prfx_stored_meta[0]){
		 $content.= '<div style="border:1px solid #000;padding:10px;">';
		  $content.= '<h4>Contributors :</h4>';
			foreach($prfx_stored_meta[0] as $userdata){
				if($userdata != ''){
			$udata = get_userdata( $userdata );
			 $content.= '<div style="margin-bottom: 15px;">'.get_avatar($udata->user_email,$size = '50').'<a href='.get_author_posts_url( $udata->ID).' style="vertical-align:top;margin-left:20px;">'.$udata->display_name.'</a></div>';
			}
}
     $content.= '</div>';
		
		}
   }
   return $content;
	}
	
	
add_action( 'add_meta_boxes', 'prfx_custom_meta' );
add_action( 'save_post', 'prfx_meta_save' );
add_filter( 'the_content', 'cont_box' )




?>
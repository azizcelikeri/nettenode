<?php

class Inv_Nettenode_Activation {

	public static function onActivation(){

		if( empty( get_option('inv_page_login') ) ){
			// Create post object
			$loginPageAttr = array(
			  'post_title'    => "Login",
			  'post_content'  => "",
			  'post_status'   => 'publish',
			  'post_author'   => get_current_user_id(),
			  'post_type'	  => 'page'
			);
			 
			$loginPageID = wp_insert_post( $loginPageAttr );

			if(!is_wp_error($loginPageID)){
				update_option("inv_page_login",$loginPageID);
			}
		}

		if( empty( get_option('inv_page_register') ) ){
			$registerPageAttr = array(
			  'post_title'    => "Register",
			  'post_content'  => "",
			  'post_status'   => 'publish',
			  'post_author'   => get_current_user_id(),
			  'post_type'	  => 'page'
			);

			$registerPageID = wp_insert_post( $registerPageAttr );

			if( !is_wp_error($registerPageID) ) {
				update_option("inv_page_register",$registerPageID);
			}
		}
		
	}


}
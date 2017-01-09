<?php

/*
Plugin Name: Netten öde
Plugin URI: http://www.innoviadigital.com/
Description: Netten Öde Descrription
Version: 0.1
Author: Aziz Çelikeri
Author URI: http://www.azizcelikeri.com/
License: GPLv2 or later
Text Domain: inv_nettenode
*/

define( 'INV_NETTENODE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( INV_NETTENODE_PLUGIN_DIR . 'class.inv_shortcodes.php' );
require_once( INV_NETTENODE_PLUGIN_DIR . 'class.inv_nettenode-frontend.php' );
require_once( INV_NETTENODE_PLUGIN_DIR . 'class.inv_nettenode-ajax.php' );
require_once( INV_NETTENODE_PLUGIN_DIR . 'class.inv_nettenode-activation.php' );

register_activation_hook( __FILE__, array( 'Inv_Nettenode_Activation', 'onActivation' ) );

if ( is_admin() ) {
	require_once( INV_NETTENODE_PLUGIN_DIR . 'class.inv_nettenode-admin.php' );
	add_action( 'admin_init', array( 'Inv_Nettenode_Admin', 'adminInıt' ) );


	add_action( 'admin_menu', array( 'Inv_Nettenode_Admin', 'adminMenuInıt' ) );

	add_action( 'personal_options_update', array( 'Inv_Nettenode_Admin', 'saveUserExtraFields' ) );
	add_action( 'edit_user_profile_update', array( 'Inv_Nettenode_Admin', 'saveUserExtraFields' ) );

	add_action( 'show_user_profile', array( 'Inv_Nettenode_Admin', 'showUserExtraFields' ) );
	add_action( 'edit_user_profile', array( 'Inv_Nettenode_Admin', 'showUserExtraFields' ) );
}



$Inv_Nettenode_Front_End = new Inv_Nettenode_Front_End();

$Inv_Nettenode_Shortcodes = new Inv_Nettenode_Shortcodes();

$Inv_Nettenode_Ajax = new Inv_Nettenode_Ajax();

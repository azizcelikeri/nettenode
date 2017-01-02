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


if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	require_once( INV_NETTENODE_PLUGIN_DIR . 'class.inv_nettenode-admin.php' );
	add_action( 'admin_init', array( 'Inv_Nettenode_Admin', 'adminInıt' ) );


	add_action( 'admin_menu', array( 'Inv_Nettenode_Admin', 'adminMenuInıt' ) );
}
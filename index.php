<?php
/**
 * Plugin Name: Qody's Connector
 * Plugin URI: http://qody.co
 * Description: Integrates your site with Qody's automation tools.
 * Version: 1.2.0
 * Network: true
 * Author: Qody
 * Author URI: http://qody.co
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
$root = dirname(dirname(dirname(dirname(__FILE__))));
require_once( $root.'/wp-config.php' );

require_once( 'classes/qody.php' );
require_once( 'classes/page_controller.php' );
require_once( 'classes/product_widget.php' );
require_once( 'classes/product_controller.php' );
require_once( 'classes/amazon_api.php' );


add_action( 'admin_menu', 'qody_main_page' );
add_action( 'init', 'Qody::Init');

add_action( 'admin_print_styles', 'Qody::GetConnectorStyles' );
add_action( 'publish_post', 'Qody::CheckAllTasks' );
add_action( 'admin_footer', 'Qody::DisplayMessages');

add_action( 'wp_footer', 'Qody::RedirectorCodeInsertion' );

Qody::RunExternalCode();

function qody_main_page()
{
	QodyPages::LoadMenu();
}

function qodys_connector_options_page()
{
	if(function_exists('add_options_page'))
	{
		//add_options_page( "Qody's Connector","Qody's Connector",8,'qodys-connector','qodys_connector_options');
	}
}
function qody_page_shell()
{
	require_once( 'pages/page_shell.php' );
}
?>
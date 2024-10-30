<?php
/*
 * Plugin Name: MinhNhut Link Gateway
 * URI: http://minhnhut.info
 * Description: Linking Gateway for Outbound link. Take resposible for redirecting user to target external url. This plugin allow you to create a custom page that people will see before they leave your website.
 * Author: Minh Nhut
 * Version: 1.0
 * Author URI: http://minhnhut.info/
 */

include("classes.php");

// Initalize the link gate plugin
$LinkGate = new LinkGate();

// Add an activation hook
register_activation_hook ( __FILE__, array (
		$LinkGate,
		'activate' 
) );

register_deactivation_hook(__FILE__, array(
	$LinkGate,
	'deactivate'
));

?>
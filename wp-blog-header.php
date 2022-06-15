<?php
/**
 * Loads the kaydenCMS environment and template.
 *
 * @package kaydenCMS
 */

if ( ! isset( $wp_did_header ) ) {

	$wp_did_header = true;

	// Load the kaydenCMS library.
	require_once __DIR__ . '/wp-load.php';

	// Set up the kaydenCMS query.
	wp();

	// Load the theme template.
	require_once ABSPATH . WPINC . '/template-loader.php';

}

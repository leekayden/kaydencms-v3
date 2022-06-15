<?php
/**
 * Front to the kaydenCMS application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells kaydenCMS to load the theme.
 *
 * @package kaydenCMS
 */

/**
 * Tells kaydenCMS to load the kaydenCMS theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the kaydenCMS Environment and Template */
require __DIR__ . '/wp-blog-header.php';

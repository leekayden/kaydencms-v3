<?php
/**
 * Core Administration API
 *
 * @package kaydenCMS
 * @subpackage Administration
 * @since 2.3.0
 */

if ( ! defined( 'WP_ADMIN' ) ) {
	/*
	 * This file is being included from a file other than wp-admin/admin.php, so
	 * some setup was skipped. Make sure the admin message catalog is loaded since
	 * load_default_textdomain() will not have done so in this context.
	 */
	load_textdomain( 'default', WP_LANG_DIR . '/admin-' . get_locale() . '.mo' );
}

/** kaydenCMS Administration Hooks */
require_once ABSPATH . 'wp-admin/includes/admin-filters.php';

/** kaydenCMS Bookmark Administration API */
require_once ABSPATH . 'wp-admin/includes/bookmark.php';

/** kaydenCMS Comment Administration API */
require_once ABSPATH . 'wp-admin/includes/comment.php';

/** kaydenCMS Administration File API */
require_once ABSPATH . 'wp-admin/includes/file.php';

/** kaydenCMS Image Administration API */
require_once ABSPATH . 'wp-admin/includes/image.php';

/** kaydenCMS Media Administration API */
require_once ABSPATH . 'wp-admin/includes/media.php';

/** kaydenCMS Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

/** kaydenCMS Misc Administration API */
require_once ABSPATH . 'wp-admin/includes/misc.php';

/** kaydenCMS Misc Administration API */
require_once ABSPATH . 'wp-admin/includes/class-wp-privacy-policy-content.php';

/** kaydenCMS Options Administration API */
require_once ABSPATH . 'wp-admin/includes/options.php';

/** kaydenCMS Plugin Administration API */
require_once ABSPATH . 'wp-admin/includes/plugin.php';

/** kaydenCMS Post Administration API */
require_once ABSPATH . 'wp-admin/includes/post.php';

/** kaydenCMS Administration Screen API */
require_once ABSPATH . 'wp-admin/includes/class-wp-screen.php';
require_once ABSPATH . 'wp-admin/includes/screen.php';

/** kaydenCMS Taxonomy Administration API */
require_once ABSPATH . 'wp-admin/includes/taxonomy.php';

/** kaydenCMS Template Administration API */
require_once ABSPATH . 'wp-admin/includes/template.php';

/** kaydenCMS List Table Administration API and base class */
require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-list-table-compat.php';
require_once ABSPATH . 'wp-admin/includes/list-table.php';

/** kaydenCMS Theme Administration API */
require_once ABSPATH . 'wp-admin/includes/theme.php';

/** kaydenCMS Privacy Functions */
require_once ABSPATH . 'wp-admin/includes/privacy-tools.php';

/** kaydenCMS Privacy List Table classes. */
// Previously in wp-admin/includes/user.php. Need to be loaded for backward compatibility.
require_once ABSPATH . 'wp-admin/includes/class-wp-privacy-requests-table.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-privacy-data-export-requests-list-table.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-privacy-data-removal-requests-list-table.php';

/** kaydenCMS User Administration API */
require_once ABSPATH . 'wp-admin/includes/user.php';

/** kaydenCMS Site Icon API */
require_once ABSPATH . 'wp-admin/includes/class-wp-site-icon.php';

/** kaydenCMS Update Administration API */
require_once ABSPATH . 'wp-admin/includes/update.php';

/** kaydenCMS Deprecated Administration API */
require_once ABSPATH . 'wp-admin/includes/deprecated.php';

/** kaydenCMS Multisite support API */
if ( is_multisite() ) {
	require_once ABSPATH . 'wp-admin/includes/ms-admin-filters.php';
	require_once ABSPATH . 'wp-admin/includes/ms.php';
	require_once ABSPATH . 'wp-admin/includes/ms-deprecated.php';
}

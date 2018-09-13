<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'db215537_1clk_wordpress_gcFiEVQpZjJSkGBJ');

/** MySQL database username */
define('DB_USER', 'db215537_kUEDCt');

/** MySQL database password */
define('DB_PASSWORD', 'Rzahf4xR1@');

/** MySQL hostname */
define('DB_HOST', 'internal-db.s215537.gridserver.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'chY4sLit0LJ6JyUD0XiCr9qPe8TixFbtw4Q54ivwYALK0lAEC169inlp8bOJ9kfw');
define('SECURE_AUTH_KEY',  'gIvftyTILaGVrH7lto27uoolocYJ6YQa5ToHJ06nGVX0NOqYFw4siRprGS2tjOmX');
define('LOGGED_IN_KEY',    'SAkmoPoTWhCdQgw9zZCa1ZD37DIBc4Vnv49TKBJZ8CqxmmakjPFvLmw84fAPQw1P');
define('NONCE_KEY',        'cR9TPbFGuSaxHqfQK2Vd9VlGM1WOGq6vLcuKIgYl4bxVMPexLYXNO0xPi0wJGB24');
define('AUTH_SALT',        'DHxvNEfr1NZkxWq0AWqyDGW9LCYAyKNwCZ3HQ0x4XsUPzbAdhsCSIBQnC1GwCSSz');
define('SECURE_AUTH_SALT', 'NcYOHvZBiSvEhBUqiJtLe8VHu3rEgVXGzxg3AQW8EnSeUgPaQlawo9kf5Knfpu9w');
define('LOGGED_IN_SALT',   'HPr78e88wMM6bmIo1ft5rCq7sgTK7qMF6Ns9MbmWYSQQel5p72ZzIwdCa4EvvoR3');
define('NONCE_SALT',       'sKNNlkTCLI7FGcDqiJvG8Osv2FoTMhjXY70bCg68ZbAz11bDiJ52wjoaSeEfYlNZ');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'uukp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

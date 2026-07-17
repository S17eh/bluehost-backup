<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'iirplwmy_WPNQU');

/** Database username */
define('DB_USER', 'iirplwmy_WPNQU');

/** Database password */
define('DB_PASSWORD', 'V4UHY.dg!NJSW#_Vc');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'fe9769c3f48c8a2d452a4deb97aef55f442e74e1a109a1eb6914b1c0ea895d69');
define('SECURE_AUTH_KEY', '5d427ba66a6af270ea73692e8d0bb308383763ee9e96910e1f695c4e387ce970');
define('LOGGED_IN_KEY', '898ecb2d384fdf6645e147e815926ca6b85a240d0c42c7e8366c90881a13c66a');
define('NONCE_KEY', '2c1c0ae4f7d97b46414f526ffdd693ea4e75108a66e55056505af2b751591f1a');
define('AUTH_SALT', 'f17011997c4d89741d1f24ff5193bf638a726f037ebdf2998dad7400f5ca2e0f');
define('SECURE_AUTH_SALT', '32be5489c2ad6dc99528ea18ccd19eceeee526bfc15044f2e73345d3e2bbcd76');
define('LOGGED_IN_SALT', '2ecb5a69fce11f8c69472d7df2aac27db77a30de72eb726edbd5cd32fc5e3805');
define('NONCE_SALT', 'a9e7a71e5dd72fc40b3c8022deba86e6d66c63a0806fce2652ccf8834c37ff72');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '5CF_';
define('WP_CRON_LOCK_TIMEOUT', 120);
define('AUTOSAVE_INTERVAL', 300);
define('WP_POST_REVISIONS', 20);
define('EMPTY_TRASH_DAYS', 7);
define('WP_AUTO_UPDATE_CORE', true);

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

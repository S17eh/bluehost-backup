<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
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
define('DB_NAME', 'iirplwmy_WPNPN');

/** Database username */
define('DB_USER', 'iirplwmy_WPNPN');

/** Database password */
define('DB_PASSWORD', 'W)h978Q4w$&dbl#bm');

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
define('AUTH_KEY', '849ae9450745b9c128e06b64eb6b602c73c13ea1642c28b6a4617f64b74a104c');
define('SECURE_AUTH_KEY', '5e3735f1411dd332f5972308700707ab8507c9944d0f534ce5fdd6fdef8abd20');
define('LOGGED_IN_KEY', '9f7d9862631183082aa988c709fb0ac70e6bd4e8657b17463d55c1ad50d7e689');
define('NONCE_KEY', 'a875b23fe489c7f6ae38050ebe6c8124c4088a0ae49c64a8f9c13cde523afc11');
define('AUTH_SALT', '5d01018b1bda4d0513ddd86c8959abaab9cf656d2d6e80f7dcfba0862cbd9951');
define('SECURE_AUTH_SALT', '252284c3f8511b3665c3257192e4a2b0bb18f355bccfa2feba00c01a3a6a620e');
define('LOGGED_IN_SALT', 'cf4cc1b2115ad9d91bea5b734a4f16582fc54571d268158753813c53775cca26');
define('NONCE_SALT', '084852697b97f3e9ac7653d41e5a53d4e0f187dcb0d8e015c0ef3fd1c4026cba');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'BFi_';
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

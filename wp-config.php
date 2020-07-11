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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('REVISR_GIT_PATH', 'https://github.com/ValentinMudiay/Group-1-.git'); // Added by Revisr
define( 'DB_NAME', 'natiqglj_wp920' );

/** MySQL database username */
define( 'DB_USER', 'natiqglj_wp920' );

/** MySQL database password */
define( 'DB_PASSWORD', '47QH(SpOj]!2o-' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'mihg7luj2xhcdveffrhvzqi9g6fiilamton8bqtjcf4hwpwyks4zdckrplz4if4e' );
define( 'SECURE_AUTH_KEY',  'j3fbu2sbdejwu1yymehqjsezpdkmj9hjqlriogk0ldlvbxashbcmuqgg641earmk' );
define( 'LOGGED_IN_KEY',    'evxk0dxqmktjtuuqwjhp5pxzwewinzl9fbjgxsk3ltjuedyu5sngtoymxotav5ib' );
define( 'NONCE_KEY',        'bqyacz8q2gpmsapyqwzmyfvzbzbwplnfbjn9k0dwrdvaa0isef67bykicaljyqm3' );
define( 'AUTH_SALT',        's8rsuep28khalscxovt5bmidix0uw3psjpqo8tnzfbqtxwsymlj5qjmynog1uhkm' );
define( 'SECURE_AUTH_SALT', 'gp1xa8iygr2szpvpdxwvfqoeclioa5rqo5sokvtm2aymv4d4ofkjrzc0pisywhm9' );
define( 'LOGGED_IN_SALT',   'uyx5cdtpfoh6lunnoqkyzjaqiisgijc06jyd0bmkaj8eyzd4fmaaqx9g04j3epq4' );
define( 'NONCE_SALT',       '3o3gre103qjwxultdniqw4tfljhxngxahrphabvc7wcmnrykoypzgwyvbwu7dbrq' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wppu_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

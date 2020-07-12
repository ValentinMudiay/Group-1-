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
define('REVISR_GIT_PATH', ''); // Added by Revisr
define( 'DB_NAME', 'natiqglj_wp45' );

/** MySQL database username */
define( 'DB_USER', 'natiqglj_wp45' );

/** MySQL database password */
define( 'DB_PASSWORD', '[bGj5[Shp(y(13' );

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
define( 'AUTH_KEY',         'qlnxa2kacmjaeevu9lvhsrj3lmmtdycvvr6gf6vmyq7rahqjsjplcr8ehtkd29rx' );
define( 'SECURE_AUTH_KEY',  'wl67eazx8mm9tp4a0ynfqfo3hg0rbswerxwok1tkwpqazf2arluglkplfsew6ytz' );
define( 'LOGGED_IN_KEY',    'r6zykzihwklws6aj5wx9t5yx6khjfcauqzfrin5gpj76gnzwhxta9cxxggqylhks' );
define( 'NONCE_KEY',        'wz8csbysyn6nrijeutp9g5wbq9yjgdz755ks6fcwprlgu4f2dwon1yqprjsrw99j' );
define( 'AUTH_SALT',        'nat7fk3pyoijpzkfcbaidjzt8x5zkrs5nm53o539jdvgbrus98qbdqpgd1ikhwvy' );
define( 'SECURE_AUTH_SALT', 'm1fdaoqh2xcodb4klox0gs3dqerhxlvpod2hvasbcoolilnyquqkzzumxf3o6iz5' );
define( 'LOGGED_IN_SALT',   'iqqknapbkgv5uwuoedxets32accebxaxbetleubsw2cqinknfx8elggzvwlls7wn' );
define( 'NONCE_SALT',       'i8eihzv1dhf8crekh6omrtn4rg7attizscxphgohkraqdt13zww2obwkouyjgsc8' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpcp_';

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

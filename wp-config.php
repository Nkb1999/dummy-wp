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
define( 'DB_NAME', 'p1' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'So%5*Ve2*!&FhMx.WtDUD{`iv9tMkRm^4YW0_ZzxDdLJdu%$mGN)ViQDtxN4Jl2&' );
define( 'SECURE_AUTH_KEY',  'Ank1GvZ^##^M0q4X@]}-#u$q.[7x#_3~/T496}b>|bwTQj>Hx)Mhk7%-_y=GKyh1' );
define( 'LOGGED_IN_KEY',    '<ToDCcE.R$VrBl?iP2+8_Kj^x(EGCBXn!Y1Xm[GL6C}vU&Hc:rWPOyC!{u=UKHw>' );
define( 'NONCE_KEY',        '<@)-tT<;sY^pvXz<({5-!3KD./zE;_3(DY.n1jRZlv+doa|{i1r)Z6o9[f<<[T!*' );
define( 'AUTH_SALT',        'lq?a3{dCG_59J!.pu8oA~vX?5/X{h&8[+5vI$g8t]K@-9N&5[V{ivYQP!2m(%8P}' );
define( 'SECURE_AUTH_SALT', 'Xa36r/Q+i,)(T,:g@e?E<Z?6~iP>#V6$8euJ[l,} KQ~}B&*{lkRd&-sda#Oa>|#' );
define( 'LOGGED_IN_SALT',   'TM;2tup>DGyS|a8i 2<0)XA:3w|<nPv-ya00.T|mTAQTWQaTf1BpM}qv41qZBMf]' );
define( 'NONCE_SALT',       '1.!og(](KOW+b&H8dW.n @sI-T1J!GaISOBh/GttS/MDXCn0flTER&PjKB3xFjTv' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

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
define( 'DB_NAME', 'fusionx' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'U]S1*o3wFv|XgL`hyYal>TCbq1(K%v5)whxZ@-5%JaY!x`hxDN!OV aj(&^:H@od' );
define( 'SECURE_AUTH_KEY',  'Jl1BOp5wdBq3=CRs?@?Z+3zpv@=!n^u@+V]JP:4{)O,ll_j,X}%z2=>Kn(prA@s^' );
define( 'LOGGED_IN_KEY',    '^)-k]qT2$E#:)+a;km}yzVc`jMQKhO=iKI->- 4|8CK%t%)mus#XfYRBT5(9s!`B' );
define( 'NONCE_KEY',        '8AsJgCxUB eE|awF%HFgXw~<&e!U(Hb5[g7Q:`+6O6LygGN5,1-q2`1@9i.W}FTW' );
define( 'AUTH_SALT',        'JllIrg9PQ;#+]70H$/&|Np~6(C+%q*U0vjZ4b410]6OH<;1F=|%Zcu(5_w}Xrko<' );
define( 'SECURE_AUTH_SALT', '3|>MJ+J47zehU,Z1^GN=[%v=Wv|^]X]oRBe[tMxpauT~,! #4 2,::hm`j<Dlcgk' );
define( 'LOGGED_IN_SALT',   'fPVcTpy*;BsuyC&?r1cu`|1X&P4@9r.RZ)5Eg-FXn8n>C?[#.xiK`6-IcN4:N:If' );
define( 'NONCE_SALT',       '#,jUxIUK+o?ek-u9M8a#^30/#w-0$su`F+D.?$yUD{JUgIIz47L6sFl[b:Ns{pwt' );

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

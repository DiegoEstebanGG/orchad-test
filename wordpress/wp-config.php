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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'test' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'Lg8BKiIaAM*q;s;1_(e1Kn{&a{dZMD|7jP4Z6#e`|{UuTz`R=PE^dl+2(wF*&MUA' );
define( 'SECURE_AUTH_KEY',  'X.sh*,4(/:U3G~$~)[&J 0Rv%A%g9,@838cO~i>wtjW,KQb)yjK;!!!jb5io8Zv%' );
define( 'LOGGED_IN_KEY',    'Sl+c&h/,AhCLywFtOvS?8HYF9]d#W:LGq>nV (.(8iYu^[4|%ak^W7^W &h=${Be' );
define( 'NONCE_KEY',        'j)!Z/WzO78|z:9jV3x%OC[ITPZ_4Mf9P||5)v2E19$^+-CMdoR/I+ e^@G`-`@M)' );
define( 'AUTH_SALT',        ')eQ9c*;H#>r=wnRlCMxR.VSKMmr_xQUC`O1[xDrn2}a7y4f0>~<L@M8$#OSj=k[z' );
define( 'SECURE_AUTH_SALT', '|5~*zf/=zpiKgzeWU=F<bMW<U|p>{_lke&q,B6hYhh>C-U*h;,Mf^/eD>w8?Wx/-' );
define( 'LOGGED_IN_SALT',   'iLm}9oQ(Sm*hr#c=?:OLYSO&x$rl1i+22N<gO:-`#Mts;={XJxQHXEqhG>j#~O/j' );
define( 'NONCE_SALT',       '4uVILT*`ba t=k.h94>~$@y5:WLE[tn0.hzSX5.sB,[*M9}sm!~^i5hJZYrIR9oL' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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

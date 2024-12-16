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
define( 'DB_NAME', 'projectcms' );

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
define( 'AUTH_KEY',         '^Llf!{;,wm9eBk#5B[PiK:2+FS{&TbEdZ4+F={FJ#)|QtK;4rM@89&n=ZTw^siQm' );
define( 'SECURE_AUTH_KEY',  'C)J_?4tQKwXWI-OQr)q4o1QLvK? >OUd^jY}nAZe=X,$v$SN7$-d-iE8&w+DFQ Q' );
define( 'LOGGED_IN_KEY',    '`;YUKkzs#Pp@Y?{6a!Ai4P=P{#{:{/IlIU`j}y1CJJzrfN}tF5S9-+, $:Vj=7Ct' );
define( 'NONCE_KEY',        '{msBDQJ{8QbjIg!@XPPmPFdo8=,jH S8&NTYR9|]{Z7Z1:}399@<rN3Ww+OCZ@mG' );
define( 'AUTH_SALT',        'ayrn,wcP*F f3S.N4<qD$-/s^!tERC)N~rUmtm*v9*{S<poqkM12T)n|([zXc2Zq' );
define( 'SECURE_AUTH_SALT', '&i/tL=J%X2MlUg35r(stthD2qG[B}>n&q5?FR5jA@}NzYSoJq67yB&v]WI#`nkBQ' );
define( 'LOGGED_IN_SALT',   'yDNJaHm5)UWabKKk.1L#z{bN0,PyfopKE2@bnx~ TEj9rN}|7u.L-,BWZ]y?O/Nj' );
define( 'NONCE_SALT',       '.G A(>7bze{5Fv6tVgJ?s`NCgp-f};61Pdb6(S5PSQO4?a{IV%Wv+kVe~M>B5u@*' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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

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
define( 'DB_NAME', 'anglara_practical_db' );

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
define( 'AUTH_KEY',         'ooNG7YT!w7~C3nhL^|bq.*/LVaV(WeRY.o!,r?y{[#5,1(e7>nit$i=ayaQ6zgCh' );
define( 'SECURE_AUTH_KEY',  'Fmx[(2xs~K2@]Da8(fe4y//b7C{}F2]?*6bOz2p@ij7T1uaEB)%a1_,44AKFj~5p' );
define( 'LOGGED_IN_KEY',    '7RThU0b&C*{>o`jt:OuTt>.)?BAZ}q3H;&N/d)B4(XIcTTgi<jg4}KHU<q6&s=Q%' );
define( 'NONCE_KEY',        'nDMFyBJ?PR9pIn8iGKW,OeEI]T`j6[e#!/pY-/0wXb+IoAfg}#7%B8!gi4Si-!Ij' );
define( 'AUTH_SALT',        ')zjmo8[Eu0ZrFGPl>aMP?MK3L,o[.G<2<4}PyWf(MzJt,2>WN4NG5#*6q#ok+4ll' );
define( 'SECURE_AUTH_SALT', 'x[1EyXWXo8d5Y)?_3JwP9Di?xjc;)ak{J!]x2-H~=<{((Q%L%T~{ H`bdX[aEqBX' );
define( 'LOGGED_IN_SALT',   'Kc031t2}y:*4#C{</lWrtD@~H8d yFGrM1Lf~)7d{*nmXUi++]8fkW$S:^oK>~xa' );
define( 'NONCE_SALT',       ',6-~a|xH1;joYNwstc6,kc0+O$BCFHFogz{#)w5 IE{bk5W$;V/$#$uq1awTi8l5' );

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

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
define('DB_NAME', 'c9');

/** MySQL database username */
define('DB_USER',  'ingridsm');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Base URL do site**/
define('WP_SITEURL', '/');
// define('WP_SITEURL', 'http://' . getenv('C9_PROJECT') . '-' . getenv('C9_USER') . '.c9users.io');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'lXmRm&_t!TZy.W9lQhKluA g/`Y*N?N0Ac)H {Sj5|_YgodmON__tB=vZRhEmICG');
define('SECURE_AUTH_KEY',  'VfGmDVq>=;j5rPT?{:voH>4h15-nU|.OG!.r!QzDw,X}tD&2HnqT~VGJDP9=3I6~');
define('LOGGED_IN_KEY',    '#G|8>b]<U_vNPn/C($c@yrn9{bwDzUn8 GyNQsx3rZ[7CSsN:hM5lVJMk%T<0MSs');
define('NONCE_KEY',        '<e^o_=4Y1xh=t][gTcYgGd^U2>I8Gmk9T!,O+u(n`?ei!vuLg?!U(BH/QzXggaBH');
define('AUTH_SALT',        '?RoOJ4ei=G%d?+cn7yh@/^If/NC6Q dQyEXn(jA~uEFjOR5`dWvqZpoC5l[64ND-');
define('SECURE_AUTH_SALT', 'ku4qyX,9>_]~~i~/|)+sQb=5S3w#!G2~m(3qS%HLm q$guY9TxTI{{&dn<RdQEdX');
define('LOGGED_IN_SALT',   'U-Lx!$i&^j]Qpj`gjTnr6ge8u~|nZ[eBfamTL!}z?]{yT&ez4L36/e3~l4tO)#xc');
define('NONCE_SALT',       '0FqsisDGx1b#/cmlqT=fQVg~6Luuve}L9WPnt5$w%#l6e:BRA0 ^sJys+ZoG  }P');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

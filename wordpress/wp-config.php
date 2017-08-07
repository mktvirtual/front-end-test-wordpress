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
define('DB_NAME', 'mkt');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'za<>.`h8aS>C^fpy/Z6`=>g_o+en>6 A>i=YQH(_a*w7a&0y]</*^+OHFrEMzn(<');
define('SECURE_AUTH_KEY',  '|XTJMcI[As?b-yg,F]Y=44zH_>~t-bcmA2jD.t:lwo0X[!b bdvtq R@1!2xL0[H');
define('LOGGED_IN_KEY',    'UXlOC3>`FvP1hXEErX{myp<>ySnmz8=,zw]v^R0/a}H<}cn29lv[%_C*:62R;LSc');
define('NONCE_KEY',        ':Z3Ss1p/t4L2t=8[8VFAE|+$,|`^RED?Lvq_igES)T/{R=Ed721E|jep 3`F<U/T');
define('AUTH_SALT',        've}~HvM|ik*y@S70EPB8&3GsDM,M-c843+qUjz,V$ixQm{japk(os 1KYZ|a ~Jt');
define('SECURE_AUTH_SALT', 'U)nzz6?8~4dXh#:{5>bd=`|O;-nOn6e0Fr8*5%qlo2!7WSH=do~rn7j3!v+!D<{+');
define('LOGGED_IN_SALT',   'nfYmkdgaa< uUc{HD8k+_JiP#GY=1*iMrIvkeXf3u -.Eq$oldB> t#X?8C4aZS6');
define('NONCE_SALT',       'T,3ldlU8BfzsfOLL4p~&&?YnXs!wLQ1L{b_w0j|iG{*qZl]$g[~p5Jg/yB02ghiE');

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

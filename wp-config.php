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
define('DB_NAME', 'teste-wordpress');

/** MySQL database username */
define('DB_USER', 'db_admin_teste');

/** MySQL database password */
define('DB_PASSWORD', 'LYU3xggj6K{6)');

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
define('AUTH_KEY',         '2s<B.1IYl&/T4_gl.6RY}d#@</Xu^HGE_oT1P{AsF-qd9y2p`*kXDPu$5PmG+]{(');
define('SECURE_AUTH_KEY',  '6(-r[q][EW|c*$E2e~!oi_q`@E7;.*5gz~UQqTVFk7A~Zb2BhT{z<nEa ghzm?(9');
define('LOGGED_IN_KEY',    '{1nM 5(};PfNFkI)dAbW5Shxl/Uh/@/``4kw5K&;wx_f1VnrGrKjY)-+d.$X<[BX');
define('NONCE_KEY',        'xh{JriDcRC6 z6#8~e#5`|4daQy)ywChAB$J~b+$e.@ry]Ra-rfp7a~cK/YL:FF#');
define('AUTH_SALT',        'NO=fjSEuIXWkj!Gqa:2}hBf)+;B{ c5 0kpAl/Msu`Wac4$>xTMORVpN.VN{JQ(2');
define('SECURE_AUTH_SALT', '$nV{1_LvYuv$VKkYqV_`A[`7Uxb317w+ec%.~q`[6*^!IIx`-81^[/jKJ]an44Ut');
define('LOGGED_IN_SALT',   'h#~m*WdYTcQg:e0{Kuc>!56]x(`+kNq]/02Tei2L3hzcX;cHI,{+,.UPrb+/k=/|');
define('NONCE_SALT',       'fm!C9eb_<T_rK#_/h9tgqR*D/(u-z:p>hBFAYfEP4^{[v&Z&rf<8j8U1EOWQT(u=');

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
define('WP_POST_REVISIONS', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');



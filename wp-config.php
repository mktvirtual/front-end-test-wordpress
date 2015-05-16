<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'learningWordPress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'q~yHoaWmqO4/+(-;N_qmBmzV[^bzI4OxIQ}0,F2G#v+|nzUTp>35O*-<z,]+Hi1:');
define('SECURE_AUTH_KEY',  '4ngki,1C]~!5{}Mpj5(ecxIKDcIMeV|+dg<~]-m[$`JUIS:Zv}Q~!-<K>><2e)nH');
define('LOGGED_IN_KEY',    'm%_[m8vuOuU$aHb8ttE <oQR%B7$~ C&V%v4+7j/L%1Ko9]*3Q#4)M@g2N`aL_8|');
define('NONCE_KEY',        'R-5[X#[#7p!A>||a?a`a&oD/:<I`!+HqzKy5yDp_R4Wr+c5Nq*}O5i^UgXga~XW=');
define('AUTH_SALT',        '3Jf0dQ!h-ruJMWlD.8@R{e@p-!m^- U@O)f{8B*<|Jf+B`rI;Z>PfW82l+ 3.<Qf');
define('SECURE_AUTH_SALT', '#6@`Hd3qO!hlLF6C4!q>p_K2FoHZX-+W,Q.*Jo`.BMUPpHK+CUV#Xh-?+VF)_;}k');
define('LOGGED_IN_SALT',   'IhjK6q7,R}]?(,7lv:=TZvq$T[(zSFF-&hJ8*%[y*Z^f%_X=A-{eh(&yAX2}|F%`');
define('NONCE_SALT',       '76_vS&CB@t|sn1$x*Q{vBpXSon+8|tzx9Uais`9Xkoc,h5O1zCg>|w^qf:t+x$)$');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

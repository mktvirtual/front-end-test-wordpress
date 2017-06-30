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
define('DB_NAME', 'wp-db');

/** MySQL database username */
define('DB_USER', 'wp_user');

/** MySQL database password */
define('DB_PASSWORD', 'teste');

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
define('AUTH_KEY',         'I3MhWICVJ7B9Xm-?{*o!d}g=7S.1:e*)&&[,;YemT=SPo.k@7WngM%GP4W-Yuzn<');
define('SECURE_AUTH_KEY',  ';*SrNv(y0POhI:f_~8lP^60`7f[*]o~uFV^)5Tfmfo=7`}kS45cekq/,z/BmnRKo');
define('LOGGED_IN_KEY',    'U>{y9V~<U#Rx!%~P(TT8g7)/n@<Lz9U09#tKryp)k2oDziH`eL{r8cKlPyGr.iid');
define('NONCE_KEY',        'Z#o/|@,&p.?vsldSQ{o9]Typ*,a31qU! `ltJ:4*D$/9GIiBxqS)A6_s{~t[jft_');
define('AUTH_SALT',        'Gp3=x)1=~{*My#X)%VFVb>Q@:z3v1!l(tZ+/w.W2R>Qz%Y|hw3lnm9T*BXZc~toC');
define('SECURE_AUTH_SALT', '*W[ G/Px<DgT<s*p2WGoam 3aBmPB#{fw[^#$%HgWt:2aQQ )SQgY{ |9)2vEnXS');
define('LOGGED_IN_SALT',   '(j7V*?;ON9r!,1WE>m]X{9}amLMe^&H88_#KIz`nnea;J3}q/D?8C!d&+o_^jvE?');
define('NONCE_SALT',       '|frX$x%Vtw4=P}3:@Hp$`cQ08{]F0}bwXs&Rp&]@47? <L?]w^%Q:c&krluDAQbm');

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

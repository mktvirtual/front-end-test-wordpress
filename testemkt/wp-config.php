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
define('AUTH_KEY',         '$``n+<Syu.%_}sJE.%Xh1x(kNm]ErD~6nz(H~uM-mv!EMy/D-_i_9@EZ9S>^U+YT');
define('SECURE_AUTH_KEY',  '}5g$.P|*PWbBD4]C?=?fS-YKMXiEFiS@/2&_1L8W%d@P9O`uT_bJ@A6iPK&}${JM');
define('LOGGED_IN_KEY',    'yQ_eJyuuFk6hTp(aB>C_p[[ngD_PA|gw{{@HL8wlyYl^UIHA@oURI]WS~+]<v:1!');
define('NONCE_KEY',        'd-kJ6?q|~@Q,0D]O60X?XqN~I5<azrujf3W#n]4VkDW{x0 a5D0eO=C880Ww5bU;');
define('AUTH_SALT',        '*M%?%>qs+14Gc1p&),KX[m=k.`75B~fM []fV,Qg_doRMkZ$5dCsC-.nnBjJa1.4');
define('SECURE_AUTH_SALT', 'Xt<aUit9S)5K6gilDP7z<E(mOZY{Xq0wT$*qWuft>R%|#->cd;@Z(I&~-S.`#c[N');
define('LOGGED_IN_SALT',   ':0Y|RoO?>oK~DI/k1< @^rC06?x84JDO93n_V&yZFwJ&%D]04M[#qF%Dee7lTs^g');
define('NONCE_SALT',       'JSlJy=(V~,6l|8W.+i2;ES:#,J!PLM/E1Axb4>W/eaus{avB5aUJE#,}p>|dI[J0');

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

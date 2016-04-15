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
define('DB_NAME', 'thtn_17716129_webn');

/** MySQL database username */
define('DB_USER', 'kabsila_db');

/** MySQL database password */
define('DB_PASSWORD', '1q2w3e4r5T');

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
define('AUTH_KEY',         '<v<uP+>q$[{v;-``2-;3Ss_rz.<+HD?e9Q7.v>F5*]%oL~nTLy*CNCy=2auPCd?q');
define('SECURE_AUTH_KEY',  'y[9ANm4,KGd1mj)Xr<z,9eQ`x@A9R,PAL1cJf{wdT?D/-Yp9%$Fm;/NmX@Ui&O1C');
define('LOGGED_IN_KEY',    '>;]P{vJ3q@?m$9k_mx{<e -.&I#63o`Vc}k0J2I>t>-Zo`/U]]8|lGI)6;W`]VE9');
define('NONCE_KEY',        '48r]8BsN-w+yrRRlfr*QND-k^8GV#.a<XT_v#*<0W`v+[_)H(@-m>s7a&gia[A3F');
define('AUTH_SALT',        'VZ!:%Hb5`R|}?(9[x8@T{I{f=y0+$D.u&V^^3eE#*[4j!`<;pm*6rax2l;$#t}*%');
define('SECURE_AUTH_SALT', ') F}tQ;<<D6^q>d#SOC(*Ml!.k`tGd_d6NS?^Gji=Yrx+TA+4d~Z_*I)V4;$h`aj');
define('LOGGED_IN_SALT',   'X$YYEjbqf|~Yj[{;m}4ZEpB;5+F9g.^l_sQn:pXtC|UnN%VpJ3;w%]Mhn@Q|]i=e');
define('NONCE_SALT',       '8u,6:<pRt6=0pKj#S6VuOLgt2VxJeJDc!hR{zWP$B)=b<Q (=v+}#m0c3VgS5BP<');

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

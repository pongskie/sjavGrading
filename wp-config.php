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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sja-grading_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('WP_DEBUG_DISPLAY', 'false');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'KRPsw;E:I$UyzfY#Pto0u*+FXoY9t=N^+_,E!?n+#NN|3{ry.Fg]fJSb|@u=|7 W' );
define( 'SECURE_AUTH_KEY',  '2?Ffia!.D:.`x#P;xS %!=WsuzZ{WH(nRz~@C)NEi[Cgu!1`WNHTH_G}:2xG3{y4' );
define( 'LOGGED_IN_KEY',    'Yp$Ncl9NkXYPmUUCwr9(KlxE[@*j5oh F3]!uYojEmm_=%tOLfLn_?YEDiVV`a-f' );
define( 'NONCE_KEY',        '|;[jp{EqQvNQ${8X=Osj[q6{?)V20&o9G32_/XR?9IW+o)S48WayOMB7zd68<h5y' );
define( 'AUTH_SALT',        '(KL!Dr5IC=eh]@H/;z)T M|_[k-cAX0sa|c?Jho>!h}c$U;Y@6p0j+k>g4h<jbhp' );
define( 'SECURE_AUTH_SALT', 'n,w/6RFGA^W>*$4cUx=+rU)6{.{crt%wD/CSbU>IUS&1&?[#4LHA:$Cs%&Q(8bfK' );
define( 'LOGGED_IN_SALT',   '&/VVQtWMN`bOcX6WEO-A@Yd% cSW;~v|(ANKg?dm`&,}?oaTN|8}i:VDO66p %a:' );
define( 'NONCE_SALT',       'M4Ew)mMWX}aYZLv1>lT UE>h>PW+4gjd$=_fD|.-9g(I3@k>g49%c+;i0fOIbo_&' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

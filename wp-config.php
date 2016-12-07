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
define('DB_NAME', 'snapshot_kcoolman');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'KSD)bTIGkhG@aS-UTGOe70/MY#>~E)Oo#1Wc=DwxOMs>r:JV|qTLVJ`{o4eqQ%Bv');
define('SECURE_AUTH_KEY',  'gJk*0z5Fo+?|H@e@04,/J9SVX9p[Qb2`Q>a=?l!Z *&i4v@+Mz61,/255vG3=|Eu');
define('LOGGED_IN_KEY',    'eE`sr[=%Akwv3sM>J $;Hk[Fp`g_|{K>UdJBFtJi|AAo^H|;pO)fPY!({Ob?JjcY');
define('NONCE_KEY',        '1Fk|~X)=O?Z~hYSPB$zM)IIdkSWN?BL|e!LApux|JLRa4&c6atSy -GG]I%;v%I[');
define('AUTH_SALT',        ';$e,G{apN^B,)$w|q*+7CABA.p##g<e5vhv=$h>o#H&fkN)1U(+<&)4=}.[921qL');
define('SECURE_AUTH_SALT', '});D(l8jR1^S[0O#Q[dvNH)2]Sj<Tjl|dldnO!8 -jjf>2*Z-W6q[O}EQiXnO^iW');
define('LOGGED_IN_SALT',   '>a$Dj3r>5jK9zl#=!HZsTi/G*z.| c>E{_*._|l/}p?~D:EvrFKr7:<Q=0YjB33}');
define('NONCE_SALT',       '&es{gkc![2FN+N_)DiC<e-t6~rY_+Y,vq+mI[<7ff>LAJ;Pz>FM?wjH|52tfae`j');

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

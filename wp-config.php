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
define('DB_NAME', 'numbodrive');

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

define('WP_MEMORY_LIMIT', '64M');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'cndV^b_ X#GS)gY*ji4j|J-S.S9]4WJTP]r8o6S++@yqwo<SU-DBgo_4ktS9aGS%');
define('SECURE_AUTH_KEY',  'X/ab9#;U|znCUBk1UAq|k(C]9V3Mw86*6K1AI20xmH#lhv1)fv3$xSnQe9EPL$Bf');
define('LOGGED_IN_KEY',    'N8 ^)$BdyIMs>/C{7tJ|4d@DIZm=9AtNtW9qe;}L&p>7o!6[WA$&j:xG-LR)`?|Q');
define('NONCE_KEY',        'hzL/#zN;XI|V8l53eAubuBR,J7P.!:T0X#EQ:WXlxssCAx!e8rDB:U}E-.tz=)xi');
define('AUTH_SALT',        'M^ <ldd[bpkU@zeM& kbqj3Ta+C +U0vH6+(vo,l2*whXE7d1xnxM((Z|l:Jens9');
define('SECURE_AUTH_SALT', '>]_=+ o{y)%@tm`hY}j8kR+:rBMc7Jd|e8oqF,5A*T&x*MT{*B<tH?B53=Tlp+oD');
define('LOGGED_IN_SALT',   ':<VP^8?6^x;~v@SQI i3aa;*+lD;rJn`gbVMo)C=XjI4pN-4Mg;ESs7Nmx2}o;ez');
define('NONCE_SALT',       '%MCp9Th#I+[ ::+zpd~=*/-s(x&*YvFsR%}kSb%Ycld:)9g]n#a&8RK+OjPclAbL');

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
define('CONCATENATE_SCRIPTS',false);
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
set_time_limit (900);

define('WP_ALLOW_REPAIR', true);
define('CONCATENATE_SCRIPTS', false);
 
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

// enable multisite
// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "ua1green_kyivfabrikateplic" );

/** MySQL database username */
define( 'DB_USER', "ua1green_kyivfabrikateplic" );

/** MySQL database password */
define( 'DB_PASSWORD', "e88e4U)aH@" );

/** MySQL hostname */
define( 'DB_HOST', "ua1green.mysql.tools" );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'uv9GcZ#-ZguE5TugM,%3c0a`Ft~wBszC1g}I^C5pD4,Zr+a@9lcfgT43%V),jJId' );
define( 'SECURE_AUTH_KEY',   'bfF_p>8@N;YH=i;v-D9#?+tGGA(p<!9F0K]8dNZ$js=aE:_=Pa4_s#6qw/Q,$B[$' );
define( 'LOGGED_IN_KEY',     'QN3Ivxcd_18&5 fi/(Zh6*-)BJJ l}x3L]mCt?KOKsoV{9aqO|dd_Z`7y1%c~]S ' );
define( 'NONCE_KEY',         'A*zBu9z_iDC}{W9%=eV;Nev,fW9X#i1%xZjy!T8bJ$i67+P{<0fd!AHtM]>-O$T(' );
define( 'AUTH_SALT',         '/XfZoL-GjLZlP]y+3h}J8;vO/8X!/o=~36PtUyPO$Ov3ZeFfEL]m5gcegGxJt23V' );
define( 'SECURE_AUTH_SALT',  'w5-wQXHf{><Fn.yy!tnMWwKz:v[41XsF/{[`%OKZ|c7yXO~[2U_QZ7A33By.l18H' );
define( 'LOGGED_IN_SALT',    '9BOt9e&mK&8]Y0q7#xoD_JYk^uS3#vxvm[8.*>QcjQl8@0_$}&9$g=U,-${@ptE}' );
define( 'NONCE_SALT',        'c]]}PcQ_gi&w+2BWmW8WV~E1C)8[C^c:-8Yjje7$=?=ZU<a(r;1[tB6I?*hDvU.c' );
define( 'WP_CACHE_KEY_SALT', 'lx<Vjf,U3~6EZ#T<@PfxQ{qCMnE3!URh^z,rrhNt5#9V>q&0Ci,de&dHJ#$AiB+u' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'eb5_';

define( 'AUTOSAVE_INTERVAL', 300 );
define( 'WP_POST_REVISIONS', 5 );
define( 'WP_AUTO_UPDATE_CORE', true );
define( 'WP_CRON_LOCK_TIMEOUT', 120 );

// Debug
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );

define( 'MULTISITE', false );

/*
define('SUBDOMAIN_INSTALL', false);
define( 'DOMAIN_CURRENT_SITE', 'x.fabrika-teplic.com' );
define( 'PATH_CURRENT_SITE', '/' );
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
*/
define( 'WP_MEMORY_LIMIT', '256M' );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname(__FILE__) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

<?php

// Things you may want to edit
// ===========================

// DB Stuffs
$table_prefix  = 'wp_';
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
define('DB_PREFIX', $table_prefix);

// Enviornment Based Definitions
if ( WP_ENV === 'development' ) :
  define('SAVEQUERIES', true);
  define('WP_DEBUG', true);
  define('SCRIPT_DEBUG', true);

elseif ( WP_ENV === 'staging' ) :
  ini_set('display_errors', 0);
  define('WP_DEBUG_DISPLAY', false);
  define('SCRIPT_DEBUG', false);
  define('DISALLOW_FILE_MODS', true);

else : // Production Site
  ini_set('display_errors', 0);
  define('WP_DEBUG_DISPLAY', false);
  define('SCRIPT_DEBUG', false);
  define('DISALLOW_FILE_MODS', true);

endif;

// THINGS YOU SHOULD NOT EDIT
// ==========================

$root_dir = dirname(dirname(__DIR__));

// Apollo Definitions
define ('CONTENT_DIR', '/app');
define ('WP_CONTENT_DIR', $root_dir . CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') ) {
  define('ABSPATH', $root_dir . '/wp/');
}


// SALTS APPENDED HERE VIA INSTALLER

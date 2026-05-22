<?php

/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;

use function Env\env;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', true);
Config::define('WP_DEBUG_LOG', env('WP_DEBUG_LOG') ?? true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);
Config::define('DISALLOW_INDEXING', true);

ini_set('display_errors', '1');

// Enable plugin/theme install + file editor in the admin (local dev only)
Config::define('DISALLOW_FILE_MODS', false);
Config::define('DISALLOW_FILE_EDIT', false);

// Bypass FTP for file system access (Docker bind-mount)
Config::define('FS_METHOD', 'direct');

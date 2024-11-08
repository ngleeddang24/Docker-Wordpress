<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * This has been slightly modified (to read environment variables) for use in Docker.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// Helper function to read environment variables
if (!function_exists('getenv_docker')) {
    function getenv_docker($env, $default) {
        if ($fileEnv = getenv($env . '_FILE')) {
            return rtrim(file_get_contents($fileEnv), "\r\n");
        }
        else if (($val = getenv($env)) !== false) {
            return $val;
        }
        else {
            return $default;
        }
    }
}

// ** Database settings **
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wordpress_user' );
define( 'DB_PASSWORD', 'wordpress_password' );
define( 'DB_HOST', 'db:3306' );  // 'db' là tên service trong docker-compose.yml

// Charset và Collate settings
define( 'DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', 'utf8') );
define( 'DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', '') );

// Authentication keys và salts
define( 'AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         '5a724137c67f9cb20c06105be7d7a09324ea8bce') );
define( 'SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'cf5d76e36350fe251e9691aa8d7484cd0ff03610') );
define( 'LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    'ca84e151bba3d662ea61c8d4ce5142039e68f4b7') );
define( 'NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        '9fe8ff3099f67d68b67ff4c8c7d00dc59e05f5be') );
define( 'AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        '9280c8509c76e6f5ff0b647ce3f266d01931f593') );
define( 'SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', '0292ab26adcebde0fc03c315f83a195ed2795a62') );
define( 'LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'ac66d5167adee928cfe05b68d8323b968293c1a0') );
define( 'NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       'd803ce5d195e5369c59c7d2150eb6c61e9220f56') );

// Database table prefix
$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

// Debugging mode
define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', '') );

// Nếu sử dụng HTTPS với proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS'] = 'on';
}

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
    eval($configExtra);
}

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';

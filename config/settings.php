<?php

error_reporting(E_ALL);
//error_reporting(0);

ini_set('display_errors', '1');
//ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('Europe/London');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);

// Error Handling Middleware settings
$settings['error'] = [
    'display_error_details' => true,
    'log_errors' => true,
    'log_error_details' => false,
];

// Logger settings
$settings['logger'] = [
    'name' => 'app',
    'path' => $settings['root'] . '/logs',
    'filename' => 'app.log',
    'level' => \Monolog\Logger::INFO,
    'file_permission' => 0775,
];

// Database settings
$settings['db'] = [
    'driver' => \Cake\Database\Driver\Mysql::class,
    'host' => 'db',
    'username' => 'root',
    'database' => 'language_school',
    'password' => 'root',
    'encoding' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    // Enable identifier quoting
    'quoteIdentifiers' => true,
    // Set to null to use MySQL servers timezone
    'timezone' => null,
    // Disable meta data cache
    'cacheMetadata' => false,
    // Disable query logging
    'log' => false,
    // PDO options
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Convert numeric values to strings when fetching.
        // Since PHP 8.1 integers and floats in result sets will be returned using native PHP types.
        // This option restores the previous behavior.
        PDO::ATTR_STRINGIFY_FETCHES => true,
    ],
];

if (defined('PHPUNIT_COMPOSER_INSTALL')) {
    // TEST (phpunit)
    require __DIR__ . '/local.test.php';
}

return $settings;

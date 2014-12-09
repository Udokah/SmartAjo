<?php

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);


/**
 * Set the application mode
 * Types: Development / Production
 */
define('APP_MODE','Development') ;

/* Temporary storage Directory */
define('TEMP_DIR','data/tmp/') ;

/* max file size for images 5MB */
define('IMG_MAX_SIZE',5000000) ;


/**
 * Configuration for: Project URL
 * Put your URL here, for local development "127.0.0.1" or "localhost" (plus sub-folder) is fine
 */
define('URL', 'http://localhost/UD-smartAjo');


define('SITENAME', 'Enquire');
define('FROM_EMAIL', 'no-reply@enquire.com.ng');

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'smartajo');
define('DB_USER', 'root');
define('DB_PASS', '');



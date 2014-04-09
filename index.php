<?php
/**
 * LEGAO
 * The Web Service Data Center Framework for PHP
 * Design concept: SOA & CQRS
 *
 * Licensed under the Open Software License version 3.0
 *
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Wang Kuang, Wang Long
 * @copyright   Copyright (c) 2014 - 2015 , All rights reserved.
 * @license     http://opensource.org/licenses/OSL-3.0
 */

    PHP_VERSION_ID > 50400 OR die('This Web Service Data Center Framework requires version 5.4 or higher');

/**
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 */
    define('SYSTEM_FOLDER', 'legao');

/**
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "app"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server. If
 * you do, use a full server path
 *
 */
    define('APPLICATION_FOLDER', 'app');

/**
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
    define('ENVIRONMENT', isset($_SERVER['PHP_ENV']) ? $_SERVER['PHP_ENV'] : 'development');

/**
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
    switch (ENVIRONMENT)
    {
        case 'development':
            error_reporting(-1);
            ini_set('display_errors', 1);
        break;

        case 'testing':
        case 'production':
            error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
            ini_set('display_errors', 0);
        break;

        default:
            header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
            die('The application environment is not set correctly.');
    }

/**
 * -------------------------------------------------------------------
 *  NOW THAT WE KNOW THE PATH, SET THE MAIN PATH CONSTANTS
 * -------------------------------------------------------------------
 */
    
    // Set the current directory correctly for CLI requests
    defined('STDIN') AND chdir(__DIR__);

    // Path to the front this file
    define('BASEPATH', pathinfo(__FILE__, PATHINFO_DIRNAME));

    // Path to the application folder
    define('APPPATH', (realpath(APPLICATION_FOLDER) ?: APPLICATION_FOLDER) . DIRECTORY_SEPARATOR);

    // Path to the system folder
    define('SYSPATH', (realpath(SYSTEM_FOLDER) ?: SYSTEM_FOLDER) . DIRECTORY_SEPARATOR);

/**
 * --------------------------------------------------------------------
 * LOAD THE LOADER AND EXEC BOOTSTRAP FILE
 * --------------------------------------------------------------------
 */
    // Is the system path correct?
    if ( ! is_dir(SYSPATH))
    {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        die('Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . THISFILE);
    }

    // Load the Loader Class
    include SYSPATH . 'core' . DIRECTORY_SEPARATOR . 'Loader.php';

    // Register autoloader
    spl_autoload_register(array('Legao\Loader', 'automatic'));

    // Create LEGAO bootstrap
    new Legao\Bootstrap;

/* End file */

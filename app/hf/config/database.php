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
defined('BASEPATH') OR die('No direct script access allowed');

/**
 * ------------------------------------------------------------------
 * DATABASE CONNECTIVITY SETTINGS
 * ------------------------------------------------------------------
 * This file will contain the settings needed to access your database.
 *
 * For complete instructions please consult the 'Database Connection'
 * page of the User Guide.
 */
return [
    // Default connection setting
    'default' => [
        // The database adapter, currently supported: MySQL, SQLServer, SQLite.
        'adapter'  => 'MySQL',
        // The username used to connect to the database.
        'hostname' => 'localhost',
        // The username used to connect to the database.
        'username' => 'root',
        // The password used to connect to the database.
        'password' => '',
        // The name of the database you want to connect to.
        'database' => '52licai',
        // The character set used in communicating with the database.
        'encoding' => 'utf8',
        // You can add an optional prefix, which will be added to the table name when using the SQLBuilder class.
        'dbprefix' => '',
        // true/false - Whether to use a persistent connection.
        'pconnect' => false
    ]
];

/* End file */
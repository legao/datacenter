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
namespace Legao;

/**
 * This implementation of the singleton pattern does not conform to the strong definition
 * given by the "Gang of Four." The __construct() method has not be forced privatized so 
 * that a singleton pattern is capable of being achieved; however, multiple instantiations or 
 * multiple singletons are also possible. This allows the user more freedom with this pattern.
 *
 * @package     Legao
 * @category    Core
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
abstract class Singleton
{
    /**
     * Array of cached singleton objects.
     *
     * @access private
     * @var    array
     */
    private static $instance = array();

    /**
     * Static method for instantiating a singleton object.
     * When using multiple singleton, can pass a identifier 
     * parameter. If found __instance method, will replace 
     * __construct method return an instance of the custom.
     *
     * @access public
     * @return object
     */
    final public static function instance()
    {
        $calledClass = get_called_class();
        return (self::$instance[$calledClass] = isset(self::$instance[$calledClass]) ? self::$instance[$calledClass] : new static);
    }

    // --------------------------------------------------------------------

    /**
     * Singleton objects should not be cloned.
     *
     * @return void
     */
    final public function __clone() {
        trigger_error('Singleton objects should not be cloned.', E_USER_ERROR);
    }
}

/* End file */
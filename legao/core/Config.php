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
 * Config manage class
 *
 * @package     Legao
 * @category    Core
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class Config
{
    private static $_cached = array();
    private $_data = array();

    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
     * Load config file and return this instance
     *
     * @access public
     * @return this
     */
    public static function load($name)
    {
        if (isset(self::$_cached[$name]))
        {
            return self::$_cached[$name];
        }
        
        $path = defined('PROPATH') ? PROPATH : APPPATH;
        $data = require $path . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $name . '.php';

        return (self::$_cached[$name] = new self($data));
    }

    // --------------------------------------------------------------------

    /**
     * Return the sub item key to this object
     *
     * @access public
     * @return this
     */
    public function child($key)
    {
        return isset($this->_data[$key]) ? new self($this->_data[$key]) : null;
    }

    // --------------------------------------------------------------------

    /**
     * Get item value for key
     *
     * @access public
     * @return string
     */
    public function get($key, $default = false)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : $default;
    }
}

/* End file */
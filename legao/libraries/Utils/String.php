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
 * @link        https://github.com/legao/datacenter
 */
namespace Legao\Utils;

/**
 * String Util Class
 *
 * @package     Legao
 * @category    Library
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class String
{
    /**
     * The camel conversion underline naming rules
     *
     * @param  string $str
     * @return string
     */
    public static function underlineCase($str)
    {
        return preg_replace_callback('/([A-Z])/', function($matches){
            return strtolower('_' . $matches[0]);
        }, $str);
    }

    // ------------------------------------------------------------------------

    /**
     * The underline conversion camel naming rules
     *
     * @param  string $str
     * @param  boolean $lcfirst the first letter is lowercase ?
     * @return string
     */
    public static function camelCase($str, $lcfirst = false)
    {
        $str = preg_replace_callback('/(?:^|_)([a-z])/', function($matches){
            return strtoupper($matches[1]);
        }, $str);
        
        return $lcfirst ? lcfirst($str) : $str;
    }
}

/* End file */
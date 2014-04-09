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
namespace Legao;

/**
 * Blackbox base class
 *
 * @package     Legao
 * @category    Core
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
abstract class Blackbox
{
    /**
     * Return the pack of Blackbox
     *
     * Important data as a blackbox is thrown and realize the decoupling,
     * Return attention to blackbox instance encapsulates check.
     *
     * @access public
     * @return this
     */
    public function pack()
    {
        $class = get_called_class();

        foreach (static::$requisiteProperties as $property => $type)
        {
            if ( ! isset($this->$property))
            {
                die ("LEGAO ERROR: The protocol necessary attribute of '{$property}' is missing. [{$class}]");
            }

            if ($type != 'mixed' && gettype($this->$property) != $type)
            {
                die ("LEGAO ERROR: The '{$property}' attribute type is not correct, it must be {$type} type. [{$class}]");
            }
        }

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Destroy the blackbox recorder data
     *
     * @access public
     * @return Blackbox\Recorder[pack]
     */
    public function destroy()
    {
        $refClass = new \ReflectionClass($this);
        $properties = $refClass->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $name = $property->getName();
            unset($this->$name);
        }
    }
}

/* End file */
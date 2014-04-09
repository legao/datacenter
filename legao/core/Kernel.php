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
 * Kernel class
 *
 * @package     Legao
 * @category    Core
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class Kernel
{
    protected static $innerSingletons = array('Input');
    protected $_components = array();

   /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        foreach (self::$innerSingletons as $class)
        {
            $lowerClassName = strtolower($class);
            $fullClassName  = __NAMESPACE__ . "\\$class";
            $this->$lowerClassName = $fullClassName::instance();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Get all components
     *
     * @access public
     * @return array
     */
    public function getComponents()
    {
        return $this->_components;
    }

    // --------------------------------------------------------------------

    /**
     * Get component by name
     *
     * @access public
     * @param  string $name component name
     * @return object
     */
    public function getComponent($name)
    {
        if (isset($this->_components[$name]))
        {
            return $this->_components[$name];
        }

        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Add a component by name
     *
     * It will be registered in accordance with the 
     * order to the life cycle.
     *
     * @access public
     * @param  string $name component name
     * @param  iComponent $component component object
     * @return void
     */
    public function addComponent($name, iComponent $component)
    {
        if ( ! $this->getComponent($name))
        {
            $this->_components[$name] = $component;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Remove a component by name
     *
     * @access public
     * @param  string $name component name
     * @return void
     */
    public function destoryComponent($name)
    {
        if ($this->_components)
        {
            foreach ($this->_components as $key => $sub_comp)
            {
                if (get_class($sub_comp) == $name)
                {
                    unset($this->_components[$key]);
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Remove all components
     *
     * @access public
     * @return void
     */
    public function cleanComponents()
    {
        $this->_components = array();
    }
}

/* End file */
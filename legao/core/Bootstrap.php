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
 * Bootstrap Class
 *
 * @package     Legao
 * @category    Core
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class Bootstrap
{
    public $kernel;

    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    function __construct()
    {
        $this->kernel = new Kernel;
        $this->_addComponent();
        $this->_buildContext();
    }

    // --------------------------------------------------------------------

    /**
     * Register some components
     * 
     * Note that the sequence is registered.
     * 
     * @access private
     * @return array
     */
    private function _addComponent()
    {
        $this->kernel->addComponent('Parser', new Parser\Entity);
        $this->kernel->addComponent('Authentication', new Authentication\Signature);
        $this->kernel->addComponent('Dispatcher', new Dispatcher\Entity);
        $this->kernel->addComponent('Responser', new Responser\JSON);
    }

    // --------------------------------------------------------------------

    /**
     * Build the main programming context
     *
     * @access private
     * @return array
     */
    private function _buildContext()
    {
        new Context($this->kernel);
    }
}

/* End file */
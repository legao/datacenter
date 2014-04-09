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
 * Define request cycle in the context
 *
 * @package     Legao
 * @category    Core
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class Context
{
    public $kernel;

    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
        $this->registerComponents();
        $this->endContext();
    }

    // --------------------------------------------------------------------

    /**
     * Register all components
     *
     * Every component has its own context.
     *
     * @access public
     * @return void
     */
    public function registerComponents()
    {
        if ($components = $this->kernel->getComponents())
        {
            foreach ($components as $name => $component)
            {
                $method_name = strtolower($name) . 'Context';

                if (method_exists($this, $method_name))
                {
                    method_exists($component, 'beforeContext') AND $component->beforeContext();

                    if (call_user_func_array(array($this, $method_name), array($component)) === false)
                    {
                        break;
                    }

                    method_exists($component, 'afterContext') AND $component->afterContext();
                }
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Parser component context
     *
     * @access public
     * @return boolean
     */
    public function parserContext(iComponent $parser)
    {
        define('PROPATH', APPPATH . $parser->getWSName());
        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Authentication component context
     *
     * @access public
     * @return boolean
     */
    public function authenticationContext(iComponent $auther)
    {
        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Dispatcher component context
     *
     * @access public
     * @return boolean
     */
    public function dispatcherContext(iComponent $dispatcher)
    {
        $blackbox = $this->kernel->getComponent('Parser')->getBlackBox();
        $dispatcher->setWSName($blackbox->wsname);
        $dispatcher->setSubdir($blackbox->subdir);
        $dispatcher->setFacade($blackbox->facade);
        $dispatcher->setAction($blackbox->action);
        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Responser component context
     *
     * @access public
     * @return boolean
     */
    public function responserContext(iComponent $responser)
    {
        $blackbox = $this->kernel->getComponent('Dispatcher')->getBlackBox();
        $responser->analyzer($blackbox->returnData);
        $responser->output();
        return true;
    }

    // --------------------------------------------------------------------

    /**
     * End context
     *
     * @access public
     * @return boolean
     */
    public function endContext()
    {
        return true;
    }
}

/* End file */
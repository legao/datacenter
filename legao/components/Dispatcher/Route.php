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
namespace Legao\Dispatcher;

use Legao\Dispatcher\BlackBox\Recorder;

/**
 * Route class
 *
 * @package     Legao
 * @category    Component
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class Route extends Base
{
    private $_data = null;

    /**
     * Get this component blackbox recorder
     *
     * Important data as a blackbox is thrown and realize the decoupling,
     * Return attention to blackbox instance encapsulates check.
     *
     * @access public
     * @return Blackbox\Recorder[pack]
     */
	public function getBlackBox()
	{
        $recorder = new Recorder;
        $recorder->returnData = $this->_data;
        return $recorder->pack();
	}

    // --------------------------------------------------------------------

    /**
     * After in the current context execution
     *
     * @access public
     * @return void
     */
    public function afterContext()
    {
        $this->invoke();
    }

    // --------------------------------------------------------------------

    /**
     * Get facade path
     *
     * @access public
     * @return string
     */
    private function getFacadePath()
    {
        $method = $this->input->method();

        if ($method == 'get')
        {
            $facadePath = APPPATH . $this->wsname . DIRECTORY_SEPARATOR . 'facade' . DIRECTORY_SEPARATOR . $this->subdir . $this->facade . '.php';
        }
        else
        {
            $facadePath = APPPATH . $this->wsname . DIRECTORY_SEPARATOR . 'commands/facade' . DIRECTORY_SEPARATOR . $this->subdir . $this->facade . '.php';
        }

        return $facadePath;
    }

    // --------------------------------------------------------------------

    /**
     * Invoke request action
     *
     * @access public
     * @return void
     */
    public function invoke()
    {
        $facadePath = $this->getFacadePath();

        if ( ! file_exists($facadePath))
        {
            $this->_data = 'sys.request-not-exist';
            return false;
        }

        require $facadePath;

        if ( ! class_exists($this->facade))
        {
            $this->_data = 'sys.request-not-exist';
            return false;
        }

        $refclass = new \ReflectionClass($this->facade);
        $instance = $refclass->newInstance();

        if ( ! method_exists($instance, $this->action))
        {
            $this->_data = 'sys.request-not-exist';
            return false;
        }

        if ( ! $refclass->getMethod($this->action)->isPublic()){
            $this->_data = 'sys.request-not-exist';
            return false;
        }
        
        try
        {
            $this->_data = $instance->{$this->action}();
        }
        catch (\Exception $e)
        {
            $this->_data = 'srv.' . $e->getMessage();
        }
    }
}

/* End file */
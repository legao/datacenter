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
namespace Legao\Responser;

use Legao\Kernel;
use Legao\iComponent;

/**
 * Process base responser abstract class
 *
 * @package     Legao
 * @category    Component
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
abstract class Base extends Kernel implements iComponent
{
    protected $_originData   = null;
    protected $_resultData   = array();
    protected $_totalNumber  = 0;
    protected $_errorMessage = '';

    /**
     * Auto parse the returned data
     *
     * @access public
     * @param  mixed $originData
     * @return void
     */
    public function analyzer($originData)
    {
        $this->_originData = $originData;

        if (is_string($originData))
        {
            if (strpos($originData, 'sys.') === 0 || strpos($originData, 'srv.') === 0)
            {
                $this->_errorMessage = $originData;
            }
            else
            {
                $this->_errorMessage = 'sys.unknown-error';
            }
        }
        elseif (is_array($originData))
        {
            if (isset($originData[0]) && isset($originData[1]) && is_integer($originData[1]) && count($originData) == 2)
            {
                if (is_array($originData[0]))
                {
                    $this->_resultData  = $originData[0];
                    $this->_totalNumber = $originData[1];
                }
            }
            elseif (isset($originData[0]))
            {
                $this->_resultData  = $originData;
                $this->_totalNumber = count($originData);
            }
            else
            {
                $this->_resultData  = $originData;
                $this->_totalNumber = 1;
            }
       }
    }
}

/* End file */
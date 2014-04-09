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
 * Facade Class
 *
 * @package     Legao
 * @category    Core
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class Facade extends Kernel
{
    /**
     * Get all request parameters
     *
     * @access public
     * @return array
     */
    public function getParams()
    {
        return $this->input->request(null, null, true);
    }

    // --------------------------------------------------------------------
    
    /**
     * Get only one request parameter by index
     *
     * @access public
     * @return string
     */
    public function getParam($index = null, $default = null)
    {
        return $this->input->request($index, $default, true);
    }
}

/* End file */
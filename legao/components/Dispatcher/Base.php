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

use Legao\Kernel;
use Legao\iComponent;

/**
 * Process base dispatcher abstract class
 *
 * @package     Legao
 * @category    Component
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
abstract class Base extends Kernel implements iComponent
{
	public function setWSName($wsname)
    {
        $this->wsname = $wsname;
    }

    public function setSubdir($subdir)
    {
        $this->subdir = $subdir;
    }

    public function setFacade($facade)
    {
        $this->facade = $facade;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }
}

/* End file */
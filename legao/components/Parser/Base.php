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
namespace Legao\Parser;

use Legao\Kernel;
use Legao\iComponent;

/**
 * Process base parser abstract class
 *
 * @package     Legao
 * @category    Component
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
abstract class Base extends Kernel implements iComponent
{
    public function segments($n = 0, $noResult = NULL) {}
}

/* End file */
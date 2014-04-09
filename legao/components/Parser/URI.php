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
namespace Legao\Parser;

use Legao\Parser\BlackBox\Recorder;
use Legao\Utils\String;

/**
 * URI class
 *
 * @package     Legao
 * @category    Component
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class URI extends Base
{
    private $uriString = '';
    private $segments  = array();

    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $uris = '';

        if (isset($_SERVER['PATH_INFO']))
        {
            $uris = $_SERVER['PATH_INFO'];
        }

        $this->uriString = trim($uris, '/');
        $this->explodeSegments();
        $this->reindexSegments();
    }

    // --------------------------------------------------------------------

    /**
     * Before in the current context execution
     *
     * @access public
     * @return void
     */
    public function beforeContext()
    {
        $segments = $this->segments;
        $this->wsname = array_shift($segments);
        $this->action = String::camelCase(array_pop($segments), true);
        $this->facade = String::camelCase(array_pop($segments));
        $this->subdir = implode(DIRECTORY_SEPARATOR, $segments);
    }

    // --------------------------------------------------------------------

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
        $recorder->wsname = $this->wsname;
        $recorder->subdir = $this->subdir;
        $recorder->facade = $this->facade;
        $recorder->action = $this->action;
        return $recorder->pack();
    }

    // --------------------------------------------------------------------

    /**
     * Get web service name
     *
     * @access public
     * @return string
     */
    public function getWSName()
    {
        return $this->wsname; 
    }

    // --------------------------------------------------------------------

    /**
     * Get sub directory name
     *
     * @access public
     * @return string
     */
    public function getSubdir()
    {
        return $this->subdir; 
    }

    // --------------------------------------------------------------------

    /**
     * Get facade name
     *
     * @access public
     * @return string
     */
    public function getFacade()
    {
        return $this->facade; 
    }

    // --------------------------------------------------------------------

    /**
     * Get action name
     *
     * @access public
     * @return string
     */
    public function getAction()
    {
        return $this->action; 
    }

    // --------------------------------------------------------------------

    /**
     * Explode URI segments
     *
     * The individual segments will be stored in the $this->segments array.
     *
     * @access public
     * @return void
     */
    public function explodeSegments()
    {
        foreach (explode('/', preg_replace('|/*(.+?)/*$|', '\\1', $this->uriString)) as $val)
        {
            $val = trim(str_replace(array('$', '(', ')', '%28', '%29'), array('&#36;', '&#40;', '&#41;', '&#40;', '&#41;'), $val));

            if (count($val) > 0)
            {
                $this->segments[] = $val;
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Re-index Segments
     *
     * @access public
     * @return void
     */
    public function reindexSegments()
    {
        array_unshift($this->segments, null);
        unset($this->segments[0]);
    }

    // --------------------------------------------------------------------

    /**
     * Fetch URI Segment
     *
     * @access public
     * @param  integer
     * @param  mixed $n index
     * @return mixed $no_result what to return if the segment index is not found
     */
    public function segments($n = 0, $noResult = null)
    {
        return $n == 0 ? $this->segments : (isset($this->segments[$n]) ? $this->segments[$n] : $noResult);
    }
}

/* End file */
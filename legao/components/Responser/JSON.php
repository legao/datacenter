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
namespace Legao\Responser;

/**
 * Response for JSON format Class
 *
 * @package     Legao
 * @category    Component
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class JSON extends Base
{
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
		// noting to do
	}

    // --------------------------------------------------------------------

    /**
     * Output result finally
     *
     * @access public
     * @return string
     */
    public function output()
    {
        if ($this->_errorMessage)
        {
            $ret = $this->error();
        }
        elseif ($this->_resultData)
        {
            $ret = $this->success();
        }

        header('Content-type: application/json');
        echo json_encode($ret);
        exit;
    }

    // --------------------------------------------------------------------

    /**
     * Output result successfully
     *
     * @access public
     * @return array
     */
    public function success()
    {
        return array(
            'results' => $this->_resultData,
            'total_number' => $this->_totalNumber
        );
    }

    // --------------------------------------------------------------------

    /**
     * Output gross error message
     *
     * @access public
     * @param  string $level error level
     * @return array
     */
    public function error($level = 1)
    {
        return array(
            'failure' => array(
                'message' => $this->_errorMessage,
                'level'   => $level
            )
        );
    }
}

/* End file */
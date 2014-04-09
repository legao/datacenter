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
namespace Legao\Authentication;

/**
 * Authentication for Signature Class
 *
 * @package     Legao
 * @category    Component
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class Signature extends Base
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
        // nothing to do
    }

    // --------------------------------------------------------------------

    /**
     * According to the parameter signature key generated
     *
     * @access public
     * @param  array $params the parameters of the need to participate in the signature
     * @return void
     */
    public function createSign($params)
    {
        $sign_method = empty($params['sign_method']) ? 'md5' : $params['sign_method'];
        unset($params['sign'], $params['_']);
        ksort($params);

        $string_to_sigeed = $this->_app_secret;
        foreach ($params as $k => $v) {
            if ("@" != substr($v, 0, 1)) {
                $string_to_sigeed .= "$k$v";
            }
        }

        unset($k, $v);
        $string_to_sigeed = trim($string_to_sigeed);
        $encrypt = $sign_method == 'md5' ? md5($string_to_sigeed) : sha1($string_to_sigeed);

        return strtoupper($encrypt);
    }
}

/* End file */
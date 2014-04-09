<?php
/**
 * LEGAO
 * The Web Service Data Center Software Development Kit
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
class LegaoSDK
{
    private $appKey    = '';
    private $appSecret = '';
    private $remoteUrl = 'localhost';

    /**
     * 创建客户端驱动实例
     *
     * @access public
     * @return DataCenterSDK
     */
    public static function client($clientName)
    {
        $clientClassName = __CLASS__ . '_' . $clientName;
        require_once __DIR__ . '/clients/' . $clientClassName . '.php';
        return new $clientClassName;
    }

    // --------------------------------------------------------------------

    /**
     * 设置远程服务器接口地址
     *
     * @access public
     * @param  string $url 远程地址
     * @return void
     */
    public function setRemoteUrl($url)
    {
        $this->remoteUrl = $url;
    }

    // --------------------------------------------------------------------

    /**
     * 设置应用唯一标识码
     *
     * @access public
     * @param  string $key 标识码
     * @return void
     */
    public function setAppKey($key)
    {
        $this->appKey = $key;
    }

    // --------------------------------------------------------------------

    /**
     * 设置应用密钥
     *
     * @access public
     * @param  string $secret 密钥
     * @return void
     */
    public function setAppSecret($secret)
    {
        $this->appSecret = $secret;
    }

    // --------------------------------------------------------------------

    /**
     * HTTP 请求
     *
     * @access public
     * @param  string $urlstr 请求地址
     * @param  array  $params 请求参数
     * @param  string $method 请求方式
     * @param  array  $header 头信息
     * @return array
     */
    public function http($urlstr, $params = array(), $method = 'GET', $header = array())
    {
        $method = strtoupper($method);
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($method == 'GET')
        {
            if ( ! empty($params))
            {
                $queryString = http_build_query($params);
                $urlstr .= "?$queryString";
            }
        }
        elseif ($method == 'POST')
        {
            $postFields = http_build_query($params);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        }
        elseif ($method == 'PUT' || $method == 'DELETE')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }

        curl_setopt($ch, CURLOPT_URL, $urlstr);
        $data = curl_exec($ch);

        curl_close($ch);
        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * 接口调用底层方法
     *
     * @access public
     * @param  string $invoke 接口路由
     * @param  array  $params 接口参数
     * @param  string $method 请求方式
     * @return array
     */
    public function call($invoke, $params = array(), $method = 'get')
    {
        $url  = $this->remoteUrl . '/' . $invoke;
        $data = $this->http($url, $params, $method, array());
        return json_decode($data, true);
    }
}

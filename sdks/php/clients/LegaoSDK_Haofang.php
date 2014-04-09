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

/**
 * 平安好房 SDK 客户端类
 *
 * @package     LegaoSDK
 * @author      Wang Kuang, Wang Long
 * @copyright   Copyright (c) 2014 - 2015 , All rights reserved.
 */
class LegaoSDK_Haofang extends LegaoSDK
{
    public function getUserShowById($id)
    {
        return $this->call('hf/users/show', array('id' => $id));
    }

    public function getUsersShowByIds($ids)
    {
        return $this->call('hf/users/show_batch', array('ids' => $ids));
    }

    public function deleteUserById($id)
    {
        return $this->call('hf/users/delete', array('id' => $id), 'post');
    }
}
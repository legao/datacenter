<?php
class Users extends BaseFacade
{
    /**
     * 删除指定ID的用户
     *
     * <h3>请求方式</h3>
     * <h5>POST</h5>
     * <h3>支持格式</h3>
     * <h5>JSON, XML</h5>
     * <h3>访问限制</h3>
     * <h5>级别：高级接口</h5>
     * <h5>频次：无限制</h5>
     * <h3>应用参数</h3>
     * <table class="table table-bordered">
     *  <tr><th>参数</th> <th>类型及范围</th> <th>必选</th> <th>说明</th></tr>
     *  <tr><td>id</td> <td>integer(64)</td> <td>true</td> <td>用户ID</td></tr>
     * </table>
     * <h3>返回示例</h3>
     * <code>
     * {
     *     "results":{"id":1,"email":"John@gmail.com"},
     *     "total_number":1
     * }
     * </code>
     * <h3>接口信息</h3>
     *
     * @api hf/users/delete
     * @link   https://{DATACENTER_URL}/hf/users/delete
     * @version 1.0
     */
    public function delete()
    {
        if ( ! $id = $this->getParam('id'))
        {
            throw new Exception('user-id-cannot-be-empty');
        }

        $usersBusiness = new UsersBusiness;
        $results = $usersBusiness->deleteUserById($id);

        return $results;
    }
}
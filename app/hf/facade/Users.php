<?php
class Users extends BaseFacade
{
    /**
     * 根据一个用户的ID获取这个用户的详情
     *
     * <h3>请求方式</h3>
     * <h5>GET</h5>
     * <h3>支持格式</h3>
     * <h5>JSON, XML</h5>
     * <h3>访问限制</h3>
     * <h5>级别：普通接口</h5>
     * <h5>频次：无限制</h5>
     * <h3>应用参数</h3>
     * <table class="table table-bordered">
     *  <tr><th>参数</th> <th>类型及范围</th> <th>必选</th> <th>说明</th></tr>
     *  <tr><td>id</td> <td>integer(64)</td> <td>true</td> <td>用户ID</td></tr>
     * </table>
     * <h3>返回示例</h3>
     * <code>
     * {
     *     "results":{"name":"John","age":"21","email":"John@gmail.com"},
     *     "total_number":1
     * }
     * </code>
     * <h3>接口信息</h3>
     *
     * @api hf/users/show
     * @link   https://{DATACENTER_URL}/hf/users/show
     * @version 1.0
     */
    public function show()
    {
        if ( ! $id = $this->getParam('id'))
        {
            throw new Exception('user-id-cannot-be-empty');
        }

        $usersQuery = new UsersQuery;
        $results = $usersQuery->findDetailByUserId($id);

        if (empty($results))
        {
            throw new Exception('user-non-exist');
        }

        return $results;
    }

    // --------------------------------------------------------------------

    /**
     * 根据一组用户的ID批量获取这些用户的详情
     *
     * <h3>请求方式</h3>
     * <h5>GET</h5>
     * <h3>支持格式</h3>
     * <h5>JSON, XML</h5>
     * <h3>访问限制</h3>
     * <h5>级别：普通接口</h5>
     * <h5>频次：无限制</h5>
     * <h3>应用参数</h3>
     * <table class="table table-bordered">
     *  <tr><th>参数</th> <th>类型及范围</th> <th>必选</th> <th>说明</th></tr>
     *  <tr><td>ids</td> <td>integer(64)</td> <td>true</td> <td>用户ID用逗号分隔</td></tr>
     *  <tr><td>start</td> <td>integer(64)</td> <td>false</td> <td>查询起始位置，默认1</td></tr>
     *  <tr><td>limit</td> <td>integer(64)</td> <td>false</td> <td>返回的结果数，默认20</td></tr>
     * </table>
     * <h3>返回示例</h3>
     * <code>
     * {
     *     "results": [
     *         {"name":"John","age":"21","sex":"male","email":"John@gmail.com"},
     *         {"name":"Emily","age":"19","sex":"female","email":"Emily@gmail.com"},
     *         {"name":"Mike","age":"30","sex":"male","email":"Mike@gmail.com"},
     *         {"name":"Tony","age":"25","sex":"male","email":"Tony@gmail.com"}
     *     ],
     *     
     *     "total_number":150
     * }
     * </code>
     * <h3>接口信息</h3>
     *
     * @api hf/users/show_batch
     * @link   https://{DATACENTER_URL}/hf/users/show_batch
     * @version 1.0
     */
    public function showBatch()
    {
        $options = array();

        if ( ! $options['ids'] = $this->getParam('ids'))
        {
            throw new Exception('user-ids-cannot-be-empty');
        }

        $options['start'] = $this->getParam('start', 1);
        $options['limit'] = $this->getParam('limit', 20);

        $usersQuery = new UsersQuery;
        return $usersQuery->findAllDetailsByOptions($options);
    }
}

/* End file */
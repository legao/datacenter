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
namespace Legao\Data\Adapter;

use Legao\Data\Operation;

/**
 * Database Adapter for Mysql
 *
 * @package     Legao
 * @category    Library
 * @subpackage  Data
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class MySQL extends Operation
{
    const DEFAULT_PORT = 3306;

    /**
     * Adds a limit clause to the SQL query
     *
     * @access public
     * @param  string  $sql the SQL statement
     * @param  integer $offset row offset to start at
     * @param  integer $limit maximum number of rows to return
     * @return string
     */
    public function limit($sql, $offset, $limit)
    {
        $offset = is_null($offset) ? '' : intval($offset) . ',';
        $limit  = intval($limit);
        return "$sql LIMIT {$offset}$limit";
    }

    // --------------------------------------------------------------------

    /**
     * Set the character encoding
     *
     * @access public
     * @param  string $charset charset name
     * @return void
     */
    public function setEncoding($charset)
    {
        $this->query('SET NAMES ' . $charset);
    }

    public function columns($table)
    {
        $columns = $this->query("SHOW COLUMNS FROM $table")->fetchAll();

        foreach ($columns as $column) {
            $ret[] = [
                'name' => $column['Field'],
                'pk'   => ($column['Key'] === 'PRI' ? true : false),
                'null' => ($column['Null'] === 'YES' ? true : false)
            ];
        }

        return $ret;
    }

    // --------------------------------------------------------------------

    /**
     * Specifies whether or not adapter can use LIMIT/ORDER 
     * clauses with DELETE & UPDATE operations
     *
     * @access public
     * @return boolean
     */
    public function acceptsLimitAndOrderForUpdateAndDelete()
    {
        return true;
    }
}

/* End file */
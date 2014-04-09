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
namespace Legao\Data;

/**
 * Operation Class
 *
 * @package     Legao
 * @category    Library
 * @subpackage  Data
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
abstract class Operation extends Connection
{
    /**
     * Arguments is transformed into options array
     *
     * @access private
     * @param  array $args arguments
     * @param  array $data &data
     * @param  boolean $filter
     * @return array
     */
    private function argsToOptions($args, &$data = false, $filter = false)
    {
        if (is_string($args[0]))
        {
            $opts['table'] = $args[0];
            
            if ($data === false)
            {
                isset($args[1]) AND $opts['where'] = $args[1];
            }
            else
            {
                $data = $args[1];
                isset($args[2]) AND $opts['where'] = $args[2];
            }
        }
        else
        {
            if ($data === false)
            {
                $opts = $args[0];
            }
            else
            {
                $data = $args[0];
                $opts = $args[1];
            }
        }

        if (is_array($data) && $data !== false && $filter === true)
        {
            $data = array_intersect_key($data, array_flip($this->fields($opts['table'])));
        }

        return $opts;
    }

    // --------------------------------------------------------------------

    /**
     * Options array is transformed into SqlBuilder instance
     *
     * @access private
     * @param  array $options options
     * @return SqlBuilder
     */
    private function optionsToSql($options)
    {
        $sql = new SQLBuilder($this);
        isset($options['table'])  AND $sql->table($options['table']);
        isset($options['where'])  AND $sql->where($options['where']);
        isset($options['order'])  AND $sql->order($options['order']);
        isset($options['limit'])  AND $sql->limit($options['limit']);
        isset($options['group'])  AND $sql->group($options['group']);
        isset($options['start'])  AND $sql->start($options['start']);
        isset($options['pages'])  AND $sql->pages($options['pages']);
        isset($options['joins'])  AND $sql->joins($options['joins']);
        isset($options['select']) AND $sql->select($options['select']);
        isset($options['having']) AND $sql->having($options['having']);
        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * According to the SQL query data
     * 
     * @access public
     * @param  string $sql sql statement
     * @param  array $values bind values
     * @return array
     */
    public function findBySql($sql = '', $values = null)
    {
        return $this->query($sql, $values)->fetchAll();
    }

    // --------------------------------------------------------------------

    /**
     * Find records in the database
     *
     * <code>
     * # queries for the users table with id=1
     * $this->find('users', 'id=1');
     *
     * # queries for the users table with id in(1,2,3)
     * $this->find('users', 'id IN(1,2,3)');
     * 
     * # finding by using an options array
     * $this->find(['table' => 'users', 'where' => 'id=1']);
     * $this->find(['table' => 'users', 'where' => ['name=?', 'Tito'], 'order' => 'name asc']);
     * </code>
     * @access public
     * @param  multiple
     * @return string
     */
    public function find(/* [$table,] $where|$opts */)
    {
        $sql = $this->optionsToSql($this->argsToOptions(func_get_args()));
        return $this->findBySql($sql->toString(), $sql->bindValues());
    }

    public function first()
    {
        return current(call_user_func_array([$this, 'find'], func_get_args()));
    }

    public function last()
    {
        $ret = call_user_func_array([$this, 'find'], func_get_args());
        return end($ret);
    }

    public function count()
    {
        $options = $this->argsToOptions(func_get_args());
        $options['select'] = 'COUNT(1) AS total_number';
        $sql = $this->optionsToSql($options);
        $ret = $this->findBySql($sql->toString(), $sql->bindValues());
        return isset($ret[0]['total_number']) ? (int) $ret[0]['total_number'] : 0;
    }

    // --------------------------------------------------------------------

    /**
     * Update records in the database
     *
     * <code>
     * # update data for the users table with id=1
     * $this->update('users', ['name' => 'Mike', 'age' => 18], 'id=1');
     * 
     * # update data by using an options array
     * $this->update(['name' => 'Mike', 'age' => 18], ['table' => 'users', 'where' => 'id=1']);
     * </code>
     * @access public
     * @param  multiple
     * @return string
     */
    public function update(/* [$table,] $data [,$where|$opts] */)
    {
        $sql = $this->optionsToSql($this->argsToOptions(func_get_args(), $data, true))->update($data);
        $this->query($sql->toString(), $sql->bindValues());
    }

    // --------------------------------------------------------------------

    /**
     * Insert records in the database
     *
     * <code>
     * # insert new data for the users table
     * $this->insert('users', ['name' => 'John', 'age' => 20]);
     * 
     * # insert new data by using an options array
     * $this->insert(['name' => 'John', 'age' => 20], ['table' => 'users']);
     * </code>
     * @access public
     * @param  multiple
     * @return string
     */
    public function insert(/* [$table,] $data [,$opts] */)
    {
        $sql = $this->optionsToSql($this->argsToOptions(func_get_args(), $data, true))->insert($data);
        $this->query($sql->toString(), $sql->bindValues());
    }

    // --------------------------------------------------------------------

    /**
     * Delete records in the database
     *
     * <code>
     * # delete data for the users table with id=1
     * $this->delete('users', 'id=1');
     * 
     * # delete data by using an options array
     * $this->delete(['table' => 'users', 'where' => 'id=1']);
     * $this->delete(['table' => 'users', 'where' => ['id=?', 1]]);
     * </code>
     * @access public
     * @param  multiple
     * @return string
     */
    public function delete(/* [$table,] $where|$opts */)
    {
        $sql = $this->optionsToSql($this->argsToOptions(func_get_args()))->delete();
        return $this->query($sql->toString(), $sql->bindValues());
    }

    public function fields($table)
    {
        $columns = $this->columns($table);
        foreach ($columns as $column)
        {
            $ret[] = $column['name'];
        }
        return $ret;
    }
}

/* End file */
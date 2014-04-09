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
 * SQLBuilder Class
 *
 * @package     Legao
 * @category    Library
 * @subpackage  Data
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
class SQLBuilder
{
    private $connection = null;
    private $operation  = 'SELECT';
    private $table;
    private $select     = '*';
    private $joins;
    private $order;
    private $limit;
    private $start      = 0;
    private $pages      = 1;
    private $group;
    private $having;
    private $update;

    // for where
    private $where;
    private $whereValues = array();

    // for insert/update
    private $data;
    private $sequence;

    /**
     * Constructor.
     *
     * @param  object
     * @return void
     */
    public function __construct($connection)
    {
        if ( ! $connection)
            throw new Exception('A valid database connection is required.');

        $this->connection = $connection;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($where)
    {
        $this->where = $where;
        return $this;
    }

    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    public function group($group)
    {
        $this->group = $group;
        return $this;
    }

    public function having($having)
    {
        $this->having = $having;
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = intval($limit);
        return $this;
    }

    public function start($offset)
    {
        $this->start = intval($offset);
        return $this;
    }

    public function pages($pages)
    {
        if ($this->limit)
        {
            $this->start = ($pages - 1) * $this->limit;
        }
        return $this;
    }

    public function joins($joins)
    {
        $this->joins = $joins;
        return $this;
    }

    public function select($select)
    {
        $this->operation = 'SELECT';
        $this->select = $select;
        return $this;
    }

    public function update($mixed)
    {
        $this->operation = 'UPDATE';

        if (is_array($mixed))
        {
            $this->data = $mixed;
        }
        elseif (is_string($mixed))
        {
            $this->update = $mixed;
        }
        else
        {
            throw new Exception('Updating requires a hash or string.');
        }
            
        return $this;
    }

    public function insert($mixed)
    {
        $this->operation = 'INSERT';
        $this->data = $mixed;
        return $this;
    }

    public function delete()
    {
        $this->operation = 'DELETE';
        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Return the SQL string
     *
     * @access public
     * @return string
     */
    public function toString()
    {
        $func = 'build' . ucfirst($this->operation);
        return $this->$func();
    }

    // --------------------------------------------------------------------

    /**
     * Return the bind values
     *
     * @access public
     * @return array
     */
    public function bindValues()
    {
        $data = [];

        if ($this->data)
        {
            $data = array_values($this->data);
            array_unshift($data, null);
            unset($data[0]);
        }

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Build a select statement
     *
     * @access public
     * @return string
     */
    private function buildSelect()
    {
        $sql = "SELECT $this->select FROM $this->table";

        if ($this->joins)
            $sql .= ' ' . $this->joins;

        if ($this->where)
            $sql .= " WHERE $this->where";

        if ($this->group)
            $sql .= " GROUP BY $this->group";

        if ($this->having)
            $sql .= " HAVING $this->having";

        if ($this->order)
            $sql .= " ORDER BY $this->order";

        if ($this->limit || $this->start)
        {
            $sql = $this->connection->limit($sql, $this->start, $this->limit);
        }

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Build an update statement
     *
     * @access public
     * @return string
     */
    private function buildUpdate()
    {
        $set = strlen($this->update) > 0 ? $this->update : join('=?, ', $this->quotedKeyNames()) . '=?';
        $sql = "UPDATE $this->table SET $set";
        $this->where AND $sql .= " WHERE $this->where";
        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Build an insert statement
     *
     * @access public
     * @return string
     */
    private function buildInsert()
    {
        $keys = join(',', $this->quotedKeyNames());
        $vals = join(',', array_fill(0, count($this->data), '?'));
        $sql  = "INSERT INTO $this->table($keys) VALUES($vals)";
        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Build a delete statement
     *
     * @access public
     * @return string
     */
    private function buildDelete()
    {
        $sql = "DELETE FROM $this->table";            

        $this->where AND $sql .= " WHERE $this->where";

        if ($this->connection->acceptsLimitAndOrderForUpdateAndDelete())
        {
            $this->order AND $sql .= " ORDER BY $this->order";
            $this->limit AND $this->connection->limit($sql, null, $this->limit);
        }

        return $sql;
    }

    // --------------------------------------------------------------------

    /**
     * Quote these key names like table names and field names
     *
     * @access public
     * @return string
     */
    private function quotedKeyNames()
    {
        $keys = [];

        foreach ($this->data as $key => $value)
            $keys[] = $this->connection->quoteName($key);

        return $keys;
    }
}

/* End file */
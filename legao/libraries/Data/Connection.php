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
namespace Legao\Data;

use PDO;
use Legao\Config;

/**
 * Connection Class
 *
 * Database base class, based on the PDO
 *
 * @package     Legao
 * @category    Library
 * @subpackage  Data
 * @author      Wang Long <mail@wanglong.name>
 * @link        http://wanglong.name
 */
abstract class Connection
{
    const DEFAULT_PORT    = 0;
    const QUOTE_CHARACTER = '`';

    protected $adapter   = 'mysql';
    protected $database  = '';
    protected $hostname  = 'localhost';
    protected $username  = 'root';
    protected $password  = '';
    protected $encoding  = 'utf8';
    protected $pconnect  = false;
    protected $lastQuery = '';
    protected $pdo       = null;

    /**
     * Class constructor
     *
     * @access public
     * @param  Config $config
     * @return void
     */
    public function __construct(Config $config)
    {
        $this->adapter  = $config->get('adapter');
        $this->database = $config->get('database');
        $this->hostname = $config->get('hostname');
        $this->username = $config->get('username');
        $this->password = $config->get('password');
        $this->encoding = $config->get('encoding');
        $this->pconnect = $config->get('pconnect');
        $this->pdo = new PDO(strtolower($this->adapter) . ":dbname={$this->database};host={$this->hostname}", $this->username, $this->password, $this->initOptions());
        $this->setEncoding($this->encoding);
    }

    // --------------------------------------------------------------------

    /**
     * Instead of __construct method, return a custom 
     * instance as a singleton object.
     *
     * @access public
     * @param  string $type which connection? 
     * @return void
     */
    public static function factory($type = 'default')
    {
        $config = Config::load('database')->child($type);
        $class  = __NAMESPACE__ . '\\' . 'Adapter\\' . ucfirst($config->get('adapter'));
        return new $class($config);
    }

    // --------------------------------------------------------------------

    /**
     * Initialize the PDO options parameter
     * 
     * @access public
     * @return array
     */
    public function initOptions()
    {
        return [
            PDO::ATTR_PERSISTENT => $this->pconnect,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
    }

    // --------------------------------------------------------------------

    /**
     * Query an SQL statement
     * 
     * @access public
     * @param  string $sql sql statement
     * @param  array $values bind values
     * @return PDOStatement
     */
    public function query($sql, $values = null)
    {
        $this->lastQuery = $sql;
        $this->statement = $this->pdo->prepare($sql);

        if ($values)
        {
            foreach ($values as $key => $value)
            {
                $this->statement->bindValue($key, $value, $this->constantType($value));
            }
        }
        
        $this->statement->execute();
        return $this->statement;
    }

    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    // --------------------------------------------------------------------

    /**
     * Throw error
     * 
     * @access public
     * @return void
     */
    public function errorMessage()
    {
        if ($msg = $this->pdo->errorInfo()[2])
        {
            die('Database Error: ' . $msg);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Data type conversion constant values
     * 
     * @access public
     * @param  string $var
     * @return string
     */
    public function constantType($var)
    {
        if (is_int($var))
        {
            return PDO::PARAM_INT;
        }

        if (is_string($var))
        {
            return PDO::PARAM_STR;
        }
            
        if (is_bool($var))
        {
            return PDO::PARAM_BOOL;
        }
            
        if (is_null($var))
        {
            return PDO::PARAM_NULL;
        }
            
        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Quote a name like table names and field names
     *
     * @access public
     * @param  string $string string to quote
     * @return string
     */
    public function quoteName($string) {
        return $string[0] === static::QUOTE_CHARACTER || $string[strlen($string) - 1] === static::QUOTE_CHARACTER ?
            $string : static::QUOTE_CHARACTER . $string . static::QUOTE_CHARACTER;
    }

    // --------------------------------------------------------------------

    /**
     * Query for column meta info and return statement handle
     *
     * @access protected
     * @param  string $table table name
     * @return PDOStatement
     */
    //abstract protected function queryColumnInfo($table);

    // --------------------------------------------------------------------

    /**
     * Adds a limit clause to the SQL query
     *
     * @access protected
     * @param  string  $sql the SQL statement
     * @param  integer $offset row offset to start at
     * @param  integer $limit maximum number of rows to return
     * @return string
     */
    abstract protected function limit($sql, $offset, $limit);

    // --------------------------------------------------------------------

    /**
     * Specifies whether or not adapter can use LIMIT/ORDER clauses with DELETE & UPDATE operations
     *
     * @access protected
     * @return boolean
     */
    protected function acceptsLimitAndOrderForUpdateAndDelete()
    {
        return false;
    }
}

/* End file */
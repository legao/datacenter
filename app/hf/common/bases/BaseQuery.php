<?php
use Legao\Data\Connection;

class BaseQuery
{
    protected $db;

    function __construct()
    {
        $this->db = Connection::factory();
    }
}
<?php

class User extends QueryBuilder
{
    private $table_name = 'users';


    function __construct()
    {
        parent::__construct($this->table_name);
    }

    function FindBySalt($salt){
        return $this->select(['*'])->where('salt', '=', $salt)->get();
    }
    
}

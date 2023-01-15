<?php

class Api{
    static function Index(){
        $path_info =  explode('/', $_SERVER['PATH_INFO']);
        $salt = $path_info['2'];
        $user = (new User())->FindBySalt($salt);
        $user = $user[0];
        $pools = (new Pool())->GetAllPools($user['id']);
        return response($pools);
    }


    static function GetOnePool(){
        $path_info =  explode('/', $_SERVER['PATH_INFO']);
        $poolId = $path_info['3'];
        $pool = (new Pool())->find('id',$poolId);
        return response($pool);
    }
    static function GetRandomPool(){
        $path_info =  explode('/', $_SERVER['PATH_INFO']);
        $salt = $path_info['2'];
        $user = (new User())->FindBySalt($salt);
        $user = $user[0];
        $pools = (new Pool())->GetAllPools($user['id']);
       
        $pool = $pools[array_rand($pools)];
        
        unset($pool['id']);

        return response($pool);
    }
}
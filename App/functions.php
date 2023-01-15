<?php 

class F{
    static function GetUserID(){
        if (isset($_SESSION['id'])) {
            return $_SESSION['id'];
        } 
            return null;
        
    }
}
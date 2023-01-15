<?php

class Users
{

    static public function index()
    {
        $view = new View();
        $content = $view->generate_html('Users/login.php', []);
        echo $view->generate_html('wrapper.php', ['title' => 'Login', 'content' => $content]);
    }

    static public function registration()
    {
        $view = new View();
        $content = $view->generate_html('Users/registration.php', []);
        echo $view->generate_html('wrapper.php', ['title' => 'Registration', 'content' => $content]);
    }

    static public function logout()
    {
        $_SESSION['loggedIn'] = false;
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['name']);

        return response(array('status' => 'success', 'message' => 'Logged out'));
    }

    static public function create($inputs)
    {
        $user = new User();
        $data = array();
        $encrypred_pass = md5($inputs['password']);
        $salt = md5($inputs['username']);
        array_push($data, null); //add null value for id
        array_push($data, $inputs['username']);
        array_push($data, $encrypred_pass);
        array_push($data, $salt);
        if ($user->find('email', $inputs['username'])) {
            return response(array('status' => 'danger', 'message' => 'Username already exist'));
        }
        $user->insert($data);
        return response(array('status' => 'success', 'message' => 'User created'));
    }

    static public function login($inputs)
    {
        $user = new User();
        $_SESSION['loggedIn'] = false;
        $data = $user->find('email', $inputs['username']);


        $encrypred_pass = md5($inputs['password']);

        if ($data) {
            $user_data = $data[0];
            if ($user_data['email'] == $inputs['username'] && $user_data['password'] == $encrypred_pass) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['id'] = $user_data['id'];
                $_SESSION['username'] = $user_data['email'];
                $_SESSION['name'] = $user_data['email'];
                return response(array('status' => 'success', 'message' => 'Logged'));
            }
        }
        return response(array('status' => 'danger', 'message' => 'Username or password incorrect'));
    }

    static function Account()
    {
        if (!$_SESSION['loggedIn']) {
            $view = new View();
            $content = $view->generate_html('Users/login.php', []);
            echo $view->generate_html('wrapper.php', ['title' => 'Login', 'content' => $content]);
            return;
        }
        $sortSettings = null;
        $dir = 'asc';
        if (isset($_GET['sort']) && isset($_GET['dir'])) {

            $dir = $_GET['dir'];
            $sortSettings = ['column' => $_GET['sort'], 'dir' => $dir];
        }

        $pools = (new Pool())->GetAllPools(F::GetUserID(), $sortSettings);

        $view = new View();
        $content = $view->generate_html('Users/account.php', ['pools' => $pools, 'dir' => $dir]);
        echo $view->generate_html('wrapper.php', ['title' => 'Account', 'content' => $content]);
    }
    static function ApiInfo()
    {
        $user = (new User())->find('id', F::GetUserID());
        $user = $user[0];
        $view = new View();
        $content = $view->generate_html('Users/apiinfo.php', ['user' => $user]);
        echo $view->generate_html('wrapper.php', ['title' => 'Apiinfo', 'content' => $content]);
    }
}

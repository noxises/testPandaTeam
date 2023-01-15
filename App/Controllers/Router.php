<?php

class Router
{
    private $routers = array();


    public function get($path, $controller)
    {
        array_push($this->routers, array($path, $controller, 'get'));
    }

    public function post($path, $controller)
    {
        array_push($this->routers, array($path, $controller, 'post'));
    }

    public function check()
    {
        $serverUri = strstr($_SERVER['REQUEST_URI'], '?', true);
        $serverUri = !empty($serverUri) ? $serverUri : $_SERVER['REQUEST_URI'];

        $key = array_search($serverUri, array_column($this->routers, 0));

        if ($key !== false) {
            if ($this->routers[$key][2] == 'get')
                return call_user_func($this->routers[$key][1], $_GET);
            else
                return call_user_func($this->routers[$key][1], $_POST);
        }

        $this->notFound();
    }

    function notFound($message = null)
    {
        $view = new View();
        $content = $view->generate_html('404/index.php', []);
        echo $view->generate_html('wrapper.php', ['title' => '404', 'content' => $content,'message'=>$message]);
    }
}

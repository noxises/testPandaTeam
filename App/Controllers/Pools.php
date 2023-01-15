<?php


class Pools{
    static function edit()
    {

        $path_info =  explode('/', $_SERVER['PATH_INFO']);
        $poolId = $path_info['3'];
        $pool = (new Pool())->find('id',$poolId);
       
        $pool = $pool['0'];
        if($pool['user_id']!= F::GetUserID()){
        
           return (new Router)->notFound('Please login');
        }

        $poolAnswers = (new Answers())->GetAnswers($poolId);
       
        $view = new View();
        $content = $view->generate_html('Pool/edit.php', ['pool'=>$pool,'poolAnswers'=>$poolAnswers]);
        echo $view->generate_html('wrapper.php', ['title' => 'Edit', 'content' => $content]);
    }

    static function Save($post)
    {
        $answers = [];
        $poolId = (new Pool()) ->updateOrCreate($_POST);
        
        if(!empty($_POST['answerId'])){
            for ($i = 0; $i < count($_POST['answerId']);$i++){
                $answers[$_POST['answerId'][$i]]['text'] = $_POST['answerText'][$i];
                $answers[$_POST['answerId'][$i]]['count'] =  $_POST['answerCount'][$i];
            }
            foreach($answers as $k=>$v){
                 (new Answers())->updateOrCreate($k, $v,$poolId['id']);
            }
        }
        return response(array('status' => 'success', 'message' => ($poolId['type'] == 'create' ? 'Created' :'Edited'  ) ,'id'=>$poolId['id']));
    }

    static function Delete($id)
    {
        
        try {
            (new Pool())->delete('id', $id[0]);
            return response(array('status' => 'success', 'message' => 'Deleted'));
        } catch (\Throwable $th) {
            return response(array('status' => 'danger', 'message' => 'Something went wrong'));
        }
       
    }
    static function create()
    {
      
        
        if(!$_SESSION['loggedIn']){
        
           return (new Router)->notFound('Please login');
        }

        
       
        $view = new View();
        $content = $view->generate_html('Pool/create.php', []);
        echo $view->generate_html('wrapper.php', ['title' => 'Edit', 'content' => $content]);
    }
    static function Show($id)
    {
        $path_info =  explode('/', $_SERVER['PATH_INFO']);
        $poolId = $path_info['2'];
        $pool = (new Pool())->find('id',$poolId);
       
        $pool = $pool['0'];
        

        $poolAnswers = (new Answers())->GetAnswers($poolId);
       
        $view = new View();
        $content = $view->generate_html('Pool/show.php', ['pool'=>$pool,'poolAnswers'=>$poolAnswers]);
        echo $view->generate_html('wrapper.php', ['title' => 'Edit', 'content' => $content]);
    }
    static function DeleteAnswers(array $idAnswers){
        foreach ($idAnswers as $id){
            (new Answers())->delete('id', $id);
        }
        return response(array('status' => 'success', 'message' => 'Deleted'));

    }
}
<?php 

class Answers extends QueryBuilder { 
  
    private $table_name = 'answers';
    
    
    function __construct()
    {
        parent::__construct($this->table_name);
    }


    public function GetAnswers($poolId)
    {
        return  $this->select(['*'])->where('pool_id', '=',$poolId )->get();
    }

    public function UpdateOrCreate($id,array $values,$poolId)
    {
       $anwer = (new Answers())->find('id', $id);
        if(!empty($anwer)){

            (new Answers())->update(['text', 'count'], [$values['text'], $values['count']],$id);
        }
        else{
            (new Answers())->insert([ null,$poolId, $values['text'], $values['count']]);
        }


    }


}
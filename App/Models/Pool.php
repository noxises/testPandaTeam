<?php

class Pool extends QueryBuilder
{
    private $table_name = 'pools';




    function __construct()
    {
        parent::__construct($this->table_name);
    }

    public function GetAllPools($userId,$sort = array())
    {
        $pools = $this->select(['*'])->where('user_id', '=', $userId)->sort($sort)->get();

        for ($i = 0; $i<count($pools);$i++){
            
            $answers = (new Answers())->GetAnswers($pools[$i]['id']);
            $pools[$i]['answers'] = $answers;
           
        }
        return $pools;
    }

public  function GetAnswers ($poolId)
{
         
      return  (new Answers())->GetAnswers($poolId);
}
public function Count()
{
        return $this->select(['COUNT id'])->get();
}

public function updateOrCreate($data){
        $pool = (new Pool());
        if(isset($data['published'])){
            $data['published'] = 1;
        }else{
            $data['published'] = 0;
        }
        $responce = array();
    if($data['pool_id']!= 'null'){
            $pool->update(['name','status'],[$data['name'],$data['published']],$data['pool_id']);
            $responce['id'] = $data['pool_id'];
            $responce['type'] = 'update';
            return $responce;
    }else{
            
            $pool->insert([null,$data['name'],F::GetUserID(),$data['published'],date("Y-m-d H:i:s")]);
            $poolId = $pool->lastId();
            $responce['id'] =  $poolId[0]['LAST_INSERT_ID()'];
            $responce['type'] = 'create';
            return $responce;
            
    }
 }
 public function GetAllForApi($userId)
 {
    $pools = $this->select(['name','id'])->where('user_id', '=', $userId)->get();

        for ($i = 0; $i<count($pools);$i++){
            
            $answers = (new Answers())->GetAnswers($pools[$i]['id']);
            $pools[$i]['answers'] = $answers;
           
        }
        return $pools;
 }
}
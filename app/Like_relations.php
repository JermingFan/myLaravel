<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like_relations extends Model
{
    //查询是否点赞
    public function getLike($from_id,$item_id,$type)
    {
        return $this->select('*')->where('from_id','=',$from_id)
            ->where('item_id','=',$item_id)
            ->where('type','=',$type)
            ->first();
    }
    public function  insertLike($from_id,$to_id,$item_id,$type)
    {
        return $this->insert([
            ['from_id'=>$from_id,'to_id'=>$to_id,'item_id'=>$item_id,'type'=>$type]
        ]);
    }
}

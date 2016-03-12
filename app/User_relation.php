<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_relation extends Model
{
    public function getFocus($focuser_id,$focused_id)
    {
        return $this->select('*')->where('followed_id','=',$focused_id)->where('follower_id','=',$focuser_id)->first();
    }
    public function  insertFocus($focuser_id,$focused_id)
    {
        return $this->insert([
            ['followed_id'=>$focused_id,'follower_id'=>$focuser_id]
        ]);
    }
}

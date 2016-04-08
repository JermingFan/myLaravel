<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    //插入新消息
    public function insertMes($from,$to,$item_id,$type,$type_in,$insert='')
    {
        return $this->insert([
            'from_id'=>$from,
            'to_id'=>$to,
            'item_id'=>$item_id,
            'type'=>$type,
            'type_in'=>$type_in,
            'sign'=>0,
            'interest_id'=>$insert
        ]);
    }
    //查询需要显示的消息
    public function getMes($user_id)
    {
        return $this->select('id')
            ->where('to_id','=',$user_id)
            ->where('sign','=',0)
            ->first();
    }
    //设置为已读
    public function signMes($user_id)
    {
        $this->where('to_id','=',$user_id)
            ->where('sign','<>',1)
            ->update(['sign'=>'1']);
    }
    public function getMesFocus($user_id)
    {
        return $this->join('users','users.id','=','messages.from_id')
            ->select('users.name','users.avatar','messages.from_id','messages.sign','messages.type_in',
                'messages.created_at')
            ->where('messages.to_id','=',$user_id)
            ->where('type','=','1')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function getMesInterest($user_id)
    {
//        $a = DB::table('messages')
//            ->leftJoin('users','users.id','=','messages.from_id')
//            ->leftJoin('interest_relations','messages.from_id','=','interest_relations.from_id')
//            ->select('users.name','users.avatar',
//                'messages.from_id','messages.sign','messages.type_in', 'messages.created_at', 'interest_relations.agree')
//            ->where('messages.type', '=', '3' )
//            ->where('interest_relations.from_id','=','messages.from_id')
//            ->where('interest_relations.type','=','messages.type_in')
//            ->where('interest_relations.item_id','=','messages.item_id')
//            ->get();

        return DB::select('SELECT
        `messages`.`id`,
        `users`.`name`,
        `users`.`avatar`,
        `messages`.`from_id`,
        `messages`.`sign`,
        `messages`.`type_in`,
        `messages`.`type`,
        `messages`.`created_at`,
        `interest_relations`.`agree`
        FROM
        `messages`
        LEFT JOIN `users` ON `users`.`id` = `messages`.`from_id`
        LEFT JOIN `interest_relations` ON `messages`.`from_id` = `interest_relations`.`from_id`
        WHERE
        `messages`.`type` = 3
        AND `interest_relations`.`from_id` = `messages`.`from_id`
        AND `interest_relations`.`type` = `messages`.`type_in`
        AND `interest_relations`.`item_id` = `messages`.`item_id`');
//        return $a;die;
//var_dump(DB::getQueryLog());die;

//        return $this->join('users','users.id','=','messages.from_id')
//            //  ->join('interest_relations','interest_relations.from_id','=','messages.from_id')
//            ->select('users.name','users.avatar',
//                'messages.from_id','messages.sign','messages.type_in', 'messages.created_at')
//            //     'interest_relations.agree')
//            ->where('messages.to_id','=',$user_id)
////            ->where('interest_relations.to_id','=','messages.from_id')
////            ->where('interest_relations.from_id','=','messages.from_id')
////            ->where('interest_relations.type','=','messages.type_in')
////            ->where('interest_relations.item_id','=','messages.item_id')
//            ->where('messages.type','=','3')
//            ->orderBy('messages.created_at', 'desc')
//            ->get();
    }
    public function getMesInterests($user_id)
    {
        return $this
            ->join('interest_relations','interest_relations.from_id','=','messages.from_id')
            ->select(
                'messages.from_id','messages.sign','messages.type_in', 'messages.created_at',
                'interest_relations.agree')
            ->where('messages.to_id','=',$user_id)
            // ->where('interest_relations.to_id','=','messages.from_id')
            // ->where('interest_relations.from_id','=','messages.from_id')
            // ->where('interest_relations.type','=','messages.type_in')
            //->where('interest_relations.item_id','=','messages.item_id')
            ->where('messages.type','=','3')
            ->orderBy('messages.created_at', 'desc')
            ->get();
    }
}

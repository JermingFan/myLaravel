<?php

namespace App\Http\Controllers;

use App\Interest_relations;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class MessageController extends Controller
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }
    public function getMessage(Request $request)
    {
        if (Auth::check())
        {
            $mes = $this->message->getMes($request->user()->id);
            if(!empty($mes->id))
            {
                return $this->_returnMessageFile('您有一条新消息',200);
            }
            return $this->_returnMessageFile('no news',100);
        }
        return $this->_returnMessageFile('no news',100);
    }
    public function toMessage(Request $request)
    {
        if (Auth::check())
        {
            $mesFocus = $this->message->getMesFocus($request->user()->id);
            $mesInterest = $this->message->getMesInterest($request->user()->id);
            $data['focus'] = $mesFocus;
            $data['interest'] = $mesInterest;
            //设置为已读
            $data['signal'] = 1;
            $this->message->signMes((int)$request->user()->id);
            return view('users.news')->with('data',$data);
        }
        else return redirect()->guest('login');
    }

    //同意
    public function toAgree(Request $request)
    {
        if (Auth::check())
        {
            $all = $request->all();
            $interest = new Interest_relations();
            $interest->updateInterest($all['from_id'],$request->user()->id,$all['type']);
            return $this->_returnMessage('success',200,$all['signal']);
        }
        else return redirect()->guest('login');
    }
}

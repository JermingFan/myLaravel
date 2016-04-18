<?php

namespace App\Http\Controllers;

use App\Interest_relations;
use App\Profile;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use zgldh\QiniuStorage\QiniuStorage;

class SettingController extends Controller
{
    protected $user,$profile;
    public function __construct(User $user,Profile $profile)
    {
        parent::__construct();
        $this->user = $user;
        $this->profile = $profile;
    }
    public function show(Request $request)
    {
        if (Auth::check())
        {
            //获取用户profile
            $result = $this->profile->getInfo($request->user()->id);
            if(empty($result))
            {
                $this->profile->create([
                    'user_id'=> $request->user()->id
                ]);
            }
            $user_info = $this->user->getSetting($request->user()->id);
            if(empty($user_info->avatar))$user_info->avatar = AVATAR;//默认头像
            $user_info->age = isset($user_info->age)?unserialize(AGE)[$user_info->age]:'';
            $user_info->place = isset($user_info->place)?unserialize(PLACE)[$user_info->place]:'';
            $user_info->email = !empty($user_info->email)?$user_info->email:$user_info->regist_email;
            $user_info->id = 0;//编辑按钮的显示
            //获取项目id
            $project = new Project();
            $user_info->project = 0;//没有该user_id的项目
            $user_info->proj_id = $project->getId($request->user()->id);
            if(!empty($user_info->proj_id))
            {
                $user_info->project = 1;//有
                $user_info->proj_id = $user_info->proj_id->id;
            }
            return view('users.setting')->with('user_info',$user_info);
        }
        else return redirect()->guest('login');
    }
    public function showSource($id,Request $request)
    {
        if (Auth::check())
        {
            //获取用户profile
            $result = $this->profile->getInfo($id);
            if(empty($result))
            {
                $this->profile->create([
                    'user_id'=> $id
                ]);
            }
            $user_info = $this->user->getSetting($id);
            if(empty($user_info->avatar))$user_info->avatar = AVATAR;//默认头像
            $user_info->age = isset($user_info->age)?unserialize(AGE)[$user_info->age]:'';
            $user_info->place = isset($user_info->place)?unserialize(PLACE)[$user_info->place]:'';
            $user_info->email = !empty($user_info->email)?$user_info->email:$user_info->regist_email;
            $interest = new Interest_relations();
            $result = $interest->getInterest($request->user()->id,$id,1);
            if(empty($result) || $result->agree == 0)
            {
                $user_info->email = $this->hide($user_info->email);
                $user_info->phone = $this->hide($user_info->phone);
            }
            else
            {
                $result_prof = $interest->getInterest($request->user()->id,$id,2);
                if(empty($result_prof) || $result_prof->agree == 0)
                {
                    $user_info->email = $this->hide($user_info->email);
                    $user_info->phone = $this->hide($user_info->phone);
                }
            }
            $user_info->id = 1;//没有编辑按钮
            $project = new Project();
            $user_info->project = 0;//没有该user_id的项目
            $user_info->proj_id = $project->getId($id);
            if(!empty($user_info->proj_id))
            {
                $user_info->project = 1;//有
                $user_info->proj_id = $user_info->proj_id->id;
            }
            return view('users.setting')->with('user_info',$user_info);
        }
        else return redirect()->guest('login');
    }
    public function edit(Request $request)
    {
        if (Auth::check())
        {
            $user_id = $request->user()->id;
            $user_info = $this->user->getSetting($user_id);
            //echo $user_info->name;exit;
            if(empty($user_info->avatar))$user_info->avatar = AVATAR;
            $user_info->ages = unserialize(AGE);
            $user_info->places = unserialize(PLACE);
            $user_info->email = !empty($user_info->email)?$user_info->email:$user_info->regist_email;
            return view('users.settingEdit')->with('user_info',$user_info);
        }
        else return redirect()->guest('login');
    }
    protected $rules = array(
        'username'=>'required|max:6',
        'email' => 'required|email|max:255',
        'phone'=>'required|mobile',
        'sex'=>'required|integer|min:1|max:2',
        'age'=>'required|integer|min:0|max:3'
    );
    public function update(Request $request)
    {
        if (Auth::check())
        {
            $all = $request->all();
            Validator::extend('mobile', function($attribute, $value, $parameters)
            {
                return preg_match('/^1[34578]\d{9}$/', $value);
            });
            $validator = Validator::make(
                $all,$this->rules
            );
            if($validator->fails())
            {
                $warnings = $validator->messages();
                $show_warning = $warnings->first();
                return $this->_returnMessageFile($show_warning,100);
            }
            $disk = QiniuStorage::disk('qiniu');
            $all['url'] = '';
            if(!empty($_FILES["img"]["tmp_name"]))
            {
                if($disk->put( date('Y/m/d').'/'.md5($_FILES["img"]["name"]), file_get_contents($_FILES["img"]["tmp_name"])))
                {
                    $all['url'] = $disk->downloadUrl(date('Y/m/d').'/'.md5($_FILES["img"]["name"]));
                }
            }
            $update = $this->user->updateInfo($request->user()->id,$all['username'],$all['url']);
            if(empty($this->profile->getSettingInfo($request->user()->id)))
            {
                $insert = $this->profile->insertSettingInfo($request->user()->id,$all);
                if($insert != 1)return $this->_returnMessageFile('插入失败',101);
            }
            else
            {
                $update_profile = $this->profile->updateSettingInfo($request->user()->id,$all);
                if($update !=1 && $update_profile!=1) return $this->_returnMessageFile('更新失败',101);
            }
            return $this->_returnMessageFile('修改成功',200);
        }
        else return redirect()->guest('login');
    }
}

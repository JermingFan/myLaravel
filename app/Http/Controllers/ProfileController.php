<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use zgldh\QiniuStorage\QiniuStorage;

class ProfileController extends Controller
{
    protected $profile;
    public function __construct(Profile $profile)
    {
        parent::__construct();
        $this->profile = $profile;
    }

    public function show(Request $request)
    {
        if (Auth::check())
        {
            $user_info = $this->profile->getInfo($request->user()->id);
            if(!empty($user_info))
            {
                if(empty($user_info->profile_img))$user_info->profile_img = PROFILE_IMG;//默认项目图片
                $user_info->age = isset($user_info->age)?unserialize(AGE)[$user_info->age]:'';
                $user_info->place = isset($user_info->place)?unserialize(PLACE)[$user_info->place]:'';
                $user_info->experience = isset($user_info->experience)?unserialize(EXPERIENCE)[$user_info->experience]:'';
//            $user_info->email = $this->hide($user_info->email);
//            $user_info->phone = $this->hide($user_info->phone);
            }
            return view('users.profile')->with('user_info',$user_info);
        }
        else return redirect()->guest('login');
    }

    public function edit(Request $request)
    {
        if (Auth::check())
        {
            $user_info = $this->profile->getInfo($request->user()->id);
            if(empty($user_info->profile_img))$user_info->profile_img = PROFILE_IMG;
            if(empty($user_info->email))
            {
                $user = new User();
                $user_info->email = $user->getEmail($request->user()->id)->email;
            }
            $user_info->ages = unserialize(AGE);
            $user_info->places = unserialize(PLACE);
            $user_info->experiences = unserialize(EXPERIENCE);
            return view('users.profileEdit')->with('user_info',$user_info);
        }
        else return view('auth.login');
    }

    public function update(Request $request)
    {
        if (Auth::check())
        {
            $all = $request->all();
            $disk = QiniuStorage::disk('qiniu');
            $all['url'] = '';
            if(!empty($_FILES["img"]["tmp_name"]))
            {
                if($disk->put( date('Y/m/d').'/'.md5($_FILES["img"]["name"]), file_get_contents($_FILES["img"]["tmp_name"])))
                {
                    $all['url'] = $disk->downloadUrl(date('Y/m/d').'/'.md5($_FILES["img"]["name"]));
                }
            }
            $user_info = $this->profile->getInfo($request->user()->id);
            if(empty($user_info))
            {
                $insert = $this->profile->insertInfo($request->user()->id,$all);
                if($insert !=1 )
                {
                    return $this->_returnMessageFile('插入失败',101);
                }
            }
            else
            {
                $update = $this->profile->updateInfo($request->user()->id,$all);
                if($update !=1 )
                {
                    return $this->_returnMessageFile('更新失败',101);
                }
            }

            return $this->_returnMessageFile('修改成功',200);
        }
        else return redirect()->guest('login');
    }
}

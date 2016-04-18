<?php namespace App\Http\Controllers;

use App\Interest_relations;
use App\Leave_message;
use App\Like_relations;
use App\Message;
use App\Profile;
use App\Project;
use App\User;
use App\User_relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use zgldh\QiniuStorage\QiniuStorage;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller {

    protected $project;
    protected $leave_messsage;

    public function __construct(Project $project,Leave_message $leave_message)
    {
        $this->project = $project;
        $this->leave_message = $leave_message;
    }

    public function index(Request $request)
    {
        $name = $request->name;
        $data = $this->project->projects($name);
        return view('projects.list')->withProjects($data);
    }

    public function show($id,Request $request)
    {
        if (Auth::check())
        {
            //项目内容
            $data = Project::find($id);
            //根据user_id查profile表里的email和phone
            $profile = new Profile();
            $profiles = $profile->getInfo($data->user_id);
            $data->email = $profiles->email;
            $data->phone = $profiles->phone;

            if(!empty($data))
            {
                if(empty($data->project_img))$data->project_img = PROJECT_IMG;//默认项目图片
                $data->type = isset($data->type)?unserialize(PROJECT_TYPE)[$data->type]:'';
                $data->development = isset($data->development)?unserialize(PROJECT_DEVELOP)[$data->development]:'';
                $data->team_nums = isset($data->team_nums)?unserialize(TEAM_NUMS)[$data->team_nums]:'';
                $data->place = isset($data->place)?unserialize(PLACE)[$data->place]:'';
            }

            $leaves = $this->leave_message->getAll($id);
            $data['leave'] = $leaves;
            $count = $this->leave_message->getCounts($id);
            $data['count'] = $count;
            $focus = new User_relation();
            $focus_result = $focus->getFocus($request->user()->id,$id,1);
            if(empty($focus_result))
            {
                $data['focus'] = 0;
            }
            else
            {
                $data['focus'] = 1;
            }
            $like = new Like_relations();
            $like_result = $like->getLike($request->user()->id,$id,1);
            if(empty($like_result))
            {
                $data['like'] = 0;
            }
            else
            {
                $data['like'] = 1;
            }
            $interest = new Interest_relations();
            $interest_result = $interest->getInterest($request->user()->id,$id,1);
            if(empty($interest_result))
            {
                $data['interest'] = 0;
                $data->email = $this->hide($profiles->email);
                $data->phone = $this->hide($profiles->phone);
            }
            else
            {
                $data['interest'] = 1;
                if($interest_result->agree == 0)
                {
                    $data->email = $this->hide($profiles->email);
                    $data->phone = $this->hide($profiles->phone);
                }
            }
            return view('projects.info')->withProject($data);
        }
        else return redirect()->guest('login');
    }
    public function leave($id,Request $request)
    {
        if (Auth::check())
        {
            $leaver_id = $request->user()->id;
            $message = $request->all();
            $insert = $this->leave_message->insertLeave($id,$leaver_id,$message['leave']);
            if($insert != 1)
            {
                return "留言失败";
            }
            else//留言成功 ，刷新页面
            {
                //项目内容
                $data = Project::find($id);
                //留言信息
                $leaves = $this->leave_message->getAll($id);
                $data['leave'] = $leaves;
                //留言数
                $count = $this->leave_message->getCounts($id);
                $data['count'] = $count;
                //显示是否关注
                $focus = new User_relation();
                $focus_result = $focus->getFocus($request->user()->id,$id,1);
                if(empty($focus_result))
                {
                    $data['focus'] = 0;
                }
                else
                {
                    $data['focus'] = 1;
                }
                //查询是否点赞
                $like = new Like_relations();
                $like_result = $like->getLike($request->user()->id,$id,1);
                if(empty($like_result))
                {
                    $data['like'] = 0;
                }
                else
                {
                    $data['like'] = 1;
                }
                $interest = new Interest_relations();
                $interest_result = $interest->getInterest($request->user()->id,$id,1);
                if(empty($interest_result))
                {
                    $data['interest'] = 0;
                }
                else
                {
                    $data['interest'] = 1;
                }
                return view('projects.info')->withProject($data);
            }
        }
        else return redirect()->guest('login');
    }

    public function toFocus(Request $request)
    {
        if (Auth::check())
        {
            $from_id = $request -> user() -> id;//关注者
            $all = $request->all();
            //根据项目id获取user_id
            $to_id = $this->project->getUserId($all['item_id'])->user_id;
            //查询to_id的name和email
            $user = new User();
            $userInfo = $user->getEmail($to_id);
            switch($all['type'])//1关注，2点赞，3感兴趣
            {
                case 1:
                    if($from_id == $to_id)
                    {
                        return $this->_returnMessage('不能关注自己的项目',102);
                    }
                    //查询是否关注过
                    $focus = new User_relation();
                    $focus_result = $focus->getFocus($from_id,$all['item_id'],1);
                    //未关注过
                    if(empty($focus_result))
                    {
                        //插入关注记录
                        $insert = $focus->insertFocus($from_id,$to_id,$all['item_id'],1);
                        if($insert!=1)
                        {
                            return $this->_returnMessage('插入失败',101);
                        }
                        else
                        {
                            //更新项目关注数
                            $update = $this->project->updateFocus($all['item_id']);
                            if($update!=1)
                            {
                                return $this->_returnMessage('更新失败',101);
                            }
                            //发送信息给被关注者（插入）
                            $mes = new Message();
                            $mes->insertMes($from_id,$to_id,$all['item_id'],1,1);
                            //发送邮件给被关注的人
                            $data = ['email'=>$userInfo->email, 'name'=>$userInfo->name];
                            Mail::send('activemail', $data, function($message) use($data)
                            {
                                $message->to($data['email'], $data['name'])->subject('【拾】有人关注你的项目~，请登录网站进行查看哦！~');
                            });
                            return $this->_returnMessage('关注成功',200);
                        }
                    }
                    //关注过
                    else
                    {
                        return $this->_returnMessage('已关注过',102);
                    }
                break;
                case 2:
                    //查询是否点赞
                    $like = new Like_relations();
                    $like_result = $like->getLike($from_id,$all['item_id'],1);
                    //未点赞
                    if(empty($like_result))
                    {
                        //插入关注记录
                        $insert = $like->insertLike($from_id,$to_id,$all['item_id'],1);
                        if($insert!=1)
                        {
                            return $this->_returnMessage('插入失败',101);
                        }
                        else
                        {
                            //更新项目点赞数
                            $update = $this->project->updateLike($all['item_id']);
                            if($update!=1)
                            {
                                return $this->_returnMessage('更新失败',101);
                            }
                            //发送信息给被点赞者（插入）
//                            $mes = new Message();
//                            $mes->insertMes($from_id,$to_id,$all['item_id'],2,1);
                            return $this->_returnMessage('点赞成功',201);
                        }
                    }
                    //已点赞
                    else
                    {
                        return $this->_returnMessage('已赞',102);
                    }
                break;
                case 3:
                    if($from_id == $to_id)
                    {
                        return $this->_returnMessage('不能向自己的项目发送感兴趣',102);
                    }
                    //查询是否感兴趣
                    $interest = new Interest_relations();
                    $interest_result = $interest->getInterest($from_id,$all['item_id'],1);
                    //未
                    if(empty($interest_result))
                    {
                        //插入记录
                        $insert = $interest->insertInterest($from_id,$to_id,$all['item_id'],1);
                        if($insert != 1)
                        {
                            return $this->_returnMessage('插入失败',101);
                        }
                        else
                        {
                            //更新项目点赞数
                            $update = $this->project->updateInterest($all['item_id']);
                            if($update!=1)
                            {
                                return $this->_returnMessage('更新失败',101);
                            }
                            //插入一条消息（插入）
                            $mes = new Message();
                            $mes->insertMes($from_id,$to_id,$all['item_id'],3,1);
                            //发送邮件给被关注的人
                            $data = ['email'=>$userInfo->email, 'name'=>$userInfo->name];
                            Mail::send('activemail', $data, function($message) use($data)
                            {
                                $message->to($data['email'], $data['name'])->subject('【拾】有人对你的项目感兴趣~，请登录网站进行查看哦！~');
                            });
                            return $this->_returnMessage('感兴趣成功',202);
                        }
                    }
                    //已
                    else
                    {
                        return $this->_returnMessage('已感兴趣',102);
                    }
                default:
                    return $this->_returnMessage('参数错误',101);
                    break;
            }

        }
        else return redirect()->guest('login');
    }

    //我关注的项目
    public function myFocusProject(Request $request)
    {
        if (Auth::check())
        {
            $user_id = $request->user()->id;
            $data = $this->project->getFocus($user_id);
            return view('projects.focuslist')->withProjects($data);
        }
        else return redirect()->guest('login');
    }
    //我的项目展示页
    public function myShow(Request $request)
    {
        if (Auth::check())
        {
            $user_info = $this->project->getInfo($request->user()->id);
            //user_id查email和phone
            $profile = new Profile();
            $user_profile = $profile->getInfo($request->user()->id);
            if(!empty($user_info))
            {
                $user_info->email = $user_profile->email;
                $user_info->phone = $user_profile->phone;
                if(empty($user_info->project_img))$user_info->project_img = PROJECT_IMG;//默认项目图片
                $user_info->type = isset($user_info->type)?unserialize(PROJECT_TYPE)[$user_info->type]:'';
                $user_info->development = isset($user_info->development)?unserialize(PROJECT_DEVELOP)[$user_info->development]:'';
                $user_info->team_nums = isset($user_info->team_nums)?unserialize(TEAM_NUMS)[$user_info->team_nums]:'';
                $user_info->place = isset($user_info->place)?unserialize(PLACE)[$user_info->place]:'';
            }
            return view('users.project')->with('user_info',$user_info);
        }
        else return redirect()->guest('login');
    }
    //编辑按钮,我的项目
    public function myEdit(Request $request)
    {
        if (Auth::check())
        {
            $user_info = $this->project->getInfo($request->user()->id);
            if(empty($user_info))
            {
                $user_info = new Project();
            }
            //user_id查email和phone
            $profile = new Profile();
            $user_profile = $profile->getInfo($request->user()->id);
            $user_info->email = $user_profile->email;
            $user_info->phone = $user_profile->phone;
            //邮箱默认为注册邮箱
            if(empty($user_info->email))
            {
                $user = new User();
                $user_info->email = $user->getEmail($request->user()->id)->email;
            }
            if(empty($user_info->project_img))$user_info->project_img = PROJECT_IMG;//默认项目图片
            $user_info->types = unserialize(PROJECT_TYPE);
            $user_info->developments = unserialize(PROJECT_DEVELOP);
            $user_info->team_numss = unserialize(TEAM_NUMS);
            $user_info->places = unserialize(PLACE);
            return view('users.projectEdit')->with('user_info',$user_info);
        }
        else return view('auth.login');
    }

    protected $rules = array(
        'name'=>'required|max:20',
        'email' => 'required|email|max:255',
        'phone'=>'required|mobile',
        'intro'=>'required|max:30',
        'detail'=>'required|max:255',
        'team_intro'=>'required|max:255',
        'place'=>'required|min:0|max:3',
        'team_nums'=>'required|min:0|max:3',
        'type'=>'required|min:0|max:3',
        'development'=>'required|min:0|max:3',
        'require'=>'required|max:30'
    );

    //我的项目,上传
    public function update(Request $request)
    {
        if (Auth::check())
        {
            $all = $request->all();
            //验证输入
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
            //项目图片
            $disk = QiniuStorage::disk('qiniu');
            $all['url'] = '';
            if(!empty($_FILES["img"]["tmp_name"]))
            {
                if($disk->put( date('Y/m/d').'/'.md5($_FILES["img"]["name"]), file_get_contents($_FILES["img"]["tmp_name"])))
                {
                    $all['url'] = $disk->downloadUrl(date('Y/m/d').'/'.md5($_FILES["img"]["name"]));
                }
            }
            //查询是否创建过项目
            $user_info = $this->project->getInfo($request->user()->id);
            if(empty($user_info))
            {
                $insert = $this->project->insertInfo($request->user()->id,$all);

                if($insert !=1 )
                {
                    return $this->_returnMessageFile('插入失败',101);
                }
            }
            else
            {
                $update = $this->project->updateInfo($request->user()->id,$all);
                if($update !=1 )
                {
                    return $this->_returnMessageFile('更新失败',101);
                }
            }
            //插入email和phone
            $profile = new Profile();
            $prof_info = $profile->getInfo($request->user()->id);
            if(empty($prof_info))
            {
                $insert = $profile->insertConact($request->user()->id,$all);

                if($insert !=1 )
                {
                    return $this->_returnMessageFile('插入失败',101);
                }
            }
            else
            {
                $update = $profile->updateConact($request->user()->id,$all);
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
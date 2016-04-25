@extends('layouts.base')
@section('styles')
    <link href="{{asset('/assets/css/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

    <div class="wrapper">
        <!-- Topic Header -->
        <div class="topic">
            <div class="container">
                <div class="row">
                    <ol class="breadcrumb hidden-xs">
                        <li><a href="">主页</a></li>
                        <li><a href="">项目编辑</a></li>
                        <li class="active"><a href="">返回</a></li>
                    </ol>
                </div> <!-- / .row -->
            </div> <!-- / .container -->
        </div> <!-- / .Topic Header -->
        @if ($user_info)
            <div class="container">

                <div class="col-sm-9">
                    <div class="blog">
                        <div class="blog-desc">
                            <div class="col-sm-5">
                                <h4>项目名称</h4>
                                <input class="setting-input-text" type="text" id="name" value="{{ isset($user_info)?$user_info->name:'' }}">

                                <h4>项目联系邮箱</h4>
                                <input class="setting-input-text" type="text" id="email" value="{{ isset($user_info)?$user_info->email:'' }}">

                                <h4>项目联系方式</h4>
                                <input class="setting-input-text" type="text" id="phone" value="{{ isset($user_info)?$user_info->phone:'' }}">

                                <h4>项目简介</h4><span class="tip">显示在项目列表上</span>
                                <textarea class="setting-input-textarea" id="intro" rows="5">{{ isset($user_info)?$user_info->detail:'' }}</textarea>

                                <h4>项目详情</h4>
                                <textarea class="setting-input-textarea" id="detail" rows="5">{{ isset($user_info)?$user_info->detail:'' }}</textarea>

                                <h4>项目类型</h4>
                                <select class="setting-select" id="type">
                                    @foreach($user_info->types as $key =>$value)
                                        <option {{ ($user_info->type==$key)?'selected':'' }}>{{ $value }}</option>
                                    @endforeach
                                </select>

                                <h4>项目阶段</h4>
                                <select class="setting-select" id="development">
                                    @foreach($user_info->developments as $key =>$value)
                                        <option {{ ($user_info->development==$key)?'selected':'' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-7">
                                <img class="img-edit" src="{{ isset($user_info->project_img)?$user_info->project_img:'' }}" alt="...">
                                <input type="file" id="img" name="img"/>

                                <h4>团队介绍</h4>
                                <textarea class="setting-input-textarea" id="team_intro" rows="5">{{ isset($user_info)?$user_info->team_intro:'' }}</textarea>

                                <h4>所在地区</h4>
                                <select class="setting-select" id="place">
                                    @foreach($user_info->places as $key =>$value)
                                        <option {{ ($user_info->place==$key)?'selected':'' }}>{{ $value }}</option>
                                    @endforeach
                                </select>

                                <h4>团队人数</h4>
                                <select class="setting-select" id="team_nums">
                                    @foreach($user_info->team_numss as $key =>$value)
                                        <option {{ ($user_info->team_nums==$key)?'selected':'' }}>{{ $value }}</option>
                                    @endforeach
                                </select>

                                <h4>所需人才</h4>
                                <select class="setting-select" multiple="multiple" id="require">
                                    @foreach($user_info->tags as $key=>$tag)
                                    <option value="{{ $tag->id }}" {{ isset($user_info->tag_id[$key])?'selected':'' }}>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="clearfix"><br></div>
                        <div>
                            <input class="setting-submit" type="button" value="确定" onclick="uploadProject()">
                        </div>

                    </div>
                </div>
            </div>
        @else
            <div class="about-quote">
                <div class="col-md-6 abt-quote-left">
                    <h5>你还未创建项目>>></h5>
                    <span>future</span>
                </div>
                <a href="/myProject/edit">
                    <div class="col-md-6 abt-quote-right">
                        <h5>点击创建项目</h5>
                    </div>
                </a>
            </div>
        @endif

    </div>

@endsection

@section('scripts')
    <script src="{{asset('/assets/js/select2.min.js')}}"></script>

    <script type="text/javascript">
        $(function() {
            $("#require").select2({
                placeholder: "选择所需人才类型（可多选）"
            });
        });
    </script>
    <script src="{{asset('/assets/js/uploadimg.js')}}"></script>
@endsection
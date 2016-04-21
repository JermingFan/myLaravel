@extends('layouts.base')
@section('content')
    <div class="container">
        <div class="list-page">

            <form class="col-md-12 list">
                <input type="text" class="text" name="name" placeholder="{{ !empty($_GET['name'])?$_GET['name']:'输入伙伴名称...' }}">
                <select class="" name="age" id="age">
                    @if(!isset($_GET['age'])||$_GET['age'] == -1)
                        <option value="-1">年龄</option>
                        @foreach(unserialize(AGE) as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    @else
                        @foreach(unserialize(AGE) as $key=>$value)
                            <option {{ ($_GET['age']==$key)?'selected':'' }} value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    @endif
                </select>
                <select class="" name="place" id="place">
                    @if(!isset($_GET['place'])||$_GET['place'] == -1)
                        <option value="-1">地区</option>
                        @foreach(unserialize(PLACE) as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    @else
                        @foreach(unserialize(PLACE) as $key=>$value)
                            <option {{ ($_GET['place']==$key)?'selected':'' }} value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    @endif
                </select>
                <select class="" name="experience" id="experience">
                    @if(!isset($_GET['experience'])||$_GET['experience'] == -1)
                        <option value="-1">工作年限</option>
                        @foreach(unserialize(EXPERIENCE) as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    @else
                        @foreach(unserialize(EXPERIENCE) as $key=>$value)
                            <option {{ ($_GET['experience']==$key)?'selected':'' }} value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    @endif
                </select>
                <input type="submit" class="submitbtn" value="搜索">
            </form>

            <div class="col-md-12">
                @foreach ($partners as $partner)
                    <div id="mentor" class="section mentor section-gray">
                        <div class="section-body">
                            <div id="mentor_cards" class="mentor-cards">
                                <div class="mentor-card js-loaded js-hide js-show">
                                    <div class="mentor-card-l">
                                        <div class="mentor-card-header">
                                            <img src="{{ isset($partner->profile_img)?$partner->profile_img:PROFILE_IMG }}" alt="">
                                        </div><div class="mentor-card-body">
                                            <a href="{{ url('partner/'.$partner->id) }}">
                                                <div class="mentor-card-name">
                                                    <h4>{{ $partner->name }}</h4>
                                                    <small>{{ isset($partner->age)?unserialize(AGE)[$partner->age]:'' }}</small>
                                                </div>
                                                <div class="mentor-card-desc">
                                                    {{ $partner->skill }}
                                                </div>
                                            </a>
                                        </div>
                                        <div class="mentor-card-tags">
                                            <span class="mentor-card-tag tag-title">关注:</span>
                                            <span class="mentor-card-tag">{{ $partner->focused }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if (Auth::check())
                <script>
                    $.ajax({
                        url: "getInfo",
                        type: "get",
                        dataType: "json",
                        success: function (message) {
                            if(message["state"] == 200)
                            {
                                $("#avatar").attr("src",message["signal"]["avatar"]);
                                $("#name").text(message["signal"]["name"]);
                                $("#inage").text(message["signal"]["age"]+'/'+ message["signal"]["place"]);
                                $("#skill").text(message["signal"]["skill"]);
                            }
                        }
                    });
                </script>
                <div class="col-md-offset-12">
                    <div class="team-member text-center">
                        <img id="avatar" class="img" src="" alt="...">
                        <div class="info">
                            <h3><strong id="name"></strong></h3>
                            <p class="text-muted" id="inage">CEO / Founder</p>
                            <p id="skill">some intro</p>
                            <ul class="list-inline text-muted">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-skype"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-offset-12">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                            邮箱
                            <input type="email" name="email" value="{{ old('email') }}">
                            密码
                            <input type="password" name="password">
                        <a href="{{ url('/password/reset') }}">忘记密码？</a>
                        <a href="{{ url('/register') }}">免费注册</a>
                        <div>
                            <input type="submit" class="" value="登录" >
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
    {{$partners->render()}}

@endsection
@section('scripts')
@endsection
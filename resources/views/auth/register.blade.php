@extends('layouts.base')
@section('styles')
@endsection
@section('content')
    <div class="wrapper">
        <div class="container">
            <div class="col-sm-5 col-sm-offset-1 setting">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    {!! csrf_field() !!}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <div style="font-size: 1.5em">姓名<label>*</label></div>
                        <input type="text" name="name" value="{{ old('name') }}" class="setting-input-text">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div style="font-size: 1.5em">邮箱<label>*</label></div>
                        <input type="email" name="email" class="setting-input-text" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div style="font-size: 1.5em">密码<label>*</label></div>
                        <input type="password" name="password" class="setting-input-text">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <div style="font-size: 1.5em">确认密码<label>*</label></div>
                        <input type="password" name="password_confirmation" class="setting-input-text">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                        <div style="font-size: 1.5em">拖动验证<label>*</label></div>

                        <div class="box" id="div_geetest_lib">
                            <div id="captcha"></div>
                            <script src="http://static.geetest.com/static/tools/gt.js"></script>
                            <script>
                                var handler = function (captchaObj) {
                                    // 将验证码加到id为captcha的元素里
                                    captchaObj.appendTo("#captcha");
                                };
                                $.ajax({
                                    // 获取id，challenge，success（是否启用failback）
                                    url: "captcha?rand="+Math.round(Math.random()*100),
                                    type: "get",
                                    dataType: "json", // 使用jsonp格式
                                    success: function (data) {
                                        initGeetest({
                                            gt: data.gt,
                                            challenge: data.challenge,
                                            product: "float", // 产品形式
                                            offline: !data.success
                                        }, handler);
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div>
                    <a class="forgot" href="{{ url('/login') }}">已有帐号？</a>
                        <input type="submit" class="setting-submit" value="注册" >
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

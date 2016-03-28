@extends('layouts.base')
@section('styles')
@endsection

@section('content')
    <div class="container">
        <div class="login-content">
            <div class="login-page">
                <div class="account_grid">
                    <div class="col-md-5 login-right wow fadeInRight" data-wow-delay="0.4s">
                        <!-- users表 -->
                        <div>
                            <span>头像：</span>
                            <img src="{{ $user_info->avatar }}" height="60" width="60">
                        </div>
                        <div>
                            <span>昵称<label>:</label></span>
                            <label>{{ $user_info->name }}</label>
                        </div>
                        <!-- end users表 -->
                        <!-- profiles表 -->
                        <div>
                            <span>性别：</span>
                            @if($user_info->sex == 2)
                                <label>女</label>
                             @else
                                <label>男</label>
                             @endif
                        </div>
                        <div>
                            <span>年龄<label>：</label></span>
                            <label>{{ !empty($user_info->age)?$user_info->age:'未填写' }}</label>
                        </div>
                        <div>
                            <span>地区<label>：</label></span>
                            <label>{{ !empty($user_info->place)?$user_info->place:'未填写' }}</label>
                        </div>
                        <div>
                            <span>学历<label>：</label></span>
                            <label>{{ !empty($user_info->education)?$user_info->education:'未填写' }}</label>
                        </div>
                        <div>
                            <span>工作经验<label>：</label></span>
                            <label>{{ !empty($user_info->experience)?$user_info->experience:'未填写' }}</label>
                        </div>
                        <!-- end profiles表 -->
                        <a href="{{ url('/setting/edit') }}">编辑</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

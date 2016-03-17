@extends('layouts.base')
@section('styles')
@endsection

@section('content')
    <div class="container">
        <div class="login-content">
            <div class="login-page">
                <div class="account_grid">
                    <div class="col-md-5 login-right wow fadeInRight" data-wow-delay="0.4s">

                        <div>
                            <span>头像：</span>
                            <img src="{{ $user_info->avatar }}" height="60" width="60">
                        </div>
                            <div>
                                <span>昵称<label>:</label></span>
                                <label>{{ $user_info->name }}</label>
                            </div>
                            {{--<div>--}}
                                {{--<span>性别</span>--}}
                                {{--<label>{{$user_info->sex}}</label>--}}
                            {{--</div>--}}
                            {{--<div>--}}
                                {{--<span>求学简介<label>*</label></span>--}}
                                {{--<label>{{ $user_info->study_mes }}</label>--}}
                            {{--</div>--}}
                            {{--<div>--}}
                                {{--<span>个人简介<label>*</label></span>--}}
                                {{--<label>{{ $user_info->personal_main }}</label>--}}
                            {{--</div>--}}
                        <a href="{{ url('/setting/edit') }}">编辑</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

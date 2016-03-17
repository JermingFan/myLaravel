@extends('layouts.base')
@section('styles')
    <link href="{{asset('/assets/css/avatar.css')}}" rel='stylesheet' type='text/css' />
@endsection

@section('content')
    <div class="container">
        <div class="login-content">
            <div class="login-page">
                <div class="account_grid">
                    <div class="col-md-5 login-right wow fadeInRight" data-wow-delay="0.4s">
                        <form action="/setting/edit" method="POST" enctype="multipart/form-data">

                            <div>
                                <span>昵称<label>：</label></span>
                                <input type="text" name="user_name" id="user_name" value="{{ $user_info->name }}">
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="avatar" class="col-sm-3 control-label">原头像：</label>
                                <div class="col-sm-6">
                                    <img src="{{ $user_info->avatar }}" height="60" width="60">
                                </div>
                            </div>
                            <input type="file" id="file" name="file"/>
                            <input type="submit" value="确定" >
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection

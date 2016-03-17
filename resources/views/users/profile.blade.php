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
                                <span>姓名<label>:</label></span>
                                <label>{{ $user_info->name }}</label>
                            </div>
                            <div>
                                <span>性别:</span>
                                @if($user_info->sex == 0)
                                    <label>男</label>
                                @else
                                    <label>女</label>
                                @endif
                            </div>
                            <div>
                                <span>求学经历<label>:</label></span>
                                <label>{{ $user_info->study_mes }}</label>
                            </div>
                            <div>
                                <span>自我评价<label>:</label></span>
                                <label>{{ $user_info->self_evaluation }}</label>
                            </div>
                            <div>
                                <span>技能介绍<label>:</label></span>
                                <label>{{ $user_info->personal_main }}</label>
                            </div>
                        <a href="{{ url('/profile/edit') }}">编辑</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

@extends('layouts.base')
@section('content')
    <div class="container">
        <div class="list-page">

            <form class="col-md-12 list">
                <input type="text" class="text" name="name" placeholder="输入伙伴名称...">
                <input type="submit" class="submitbtn" value="搜索">
            </form>

            {{--<div class="clearfix"></div>--}}
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
            <div class="col-md-offset-12">
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
                </div>
            </div>

    </div>
    {{$partners->render()}}

@endsection
@section('scripts')
@endsection
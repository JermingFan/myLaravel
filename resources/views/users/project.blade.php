@extends('layouts.base')
@section('content')

    <div class="container">
        <div class="shared-hosting">
            <h3 class="header-c">{{ $user_info->name }}</h3>
            <figure class="float-right"><img src="/assets/images/b1.jpg" width="400px" alt="Placeholder"></figure>
            <div class="about_desc question-answers">
                <div id="qus-1" class="answers">
                    <h4>项目详情</h4>
                    <p>{{ $user_info->details }}</p>
                </div>
                <div id="qus-2" class="answers">
                    <h4>项目近况</h4>
                    <p><{{ $user_info->development }}/p>
                </div>
                <div id="qus-3" class="answers">
                    <h4>团队简介</h4>
                    <p>{{ $user_info->intro }}</p>
                </div>
                <div id="qus-4" class="answers">
                    <h4>团队需求</h4>
                    <p>{{ $user_info->require }}</p>
                </div>
                <a href="{{ url('/myProject/edit') }}">编辑</a>
            </div>
        </div>
    </div>

@endsection

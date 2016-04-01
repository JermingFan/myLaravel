<nav class="navbar-fixed-top">
    <div class="header">
        <div class="container">
            <span class="menu">Menu</span>
            <ul class="nav banner-nav">
                <li><a href="{{ url('/') }}">主页</a></li>
                <li><a href="{{ url('/project') }}">项目</a></li>
                <li><a href="{{ url('/partner') }}">识才</a></li>
                @if (Auth::guest())
                    <li class="navbar-right"><a href="{{ url('/login') }}" type="button" class="">登录</a></li>
                    <li class="navbar-right"><a class="register-link" href="{{ url('/register') }}" type="button" >注册</a></li>
                @else
                    <li class="dropdown1 navbar-right">
                        <a href="javascript:;" data-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown2" role="menu">
                            <li><a href="{{ url('/setting') }}">基本资料</a></li>
                            <li><a href="{{ url('/logout') }}">注销</a></li>
                        </ul>
                    </li>
                    <li class="dropdown1 navbar-right">
                        <a href="javascript:;" data-toggle="dropdown">
                            发布
                        </a>
                        <ul class="dropdown2" role="menu">
                            <li><a href="{{ url('/myProject') }}">项目</a></li>
                            <li><a href="{{ url('/profile') }}">简历</a></li>
                        </ul>
                    </li>
                    <li class="dropdown1 navbar-right">
                        <a href="javascript:;" data-toggle="dropdown">
                            关注
                        </a>
                        <ul class="dropdown2" role="menu">
                            <li><a href="{{ url('/projectFocus') }}">关注的项目</a></li>
                            <li><a href="{{ url('/partnerFocus') }}">关注的人才</a></li>
                        </ul>
                    </li>
                    <li class="navbar-right">
                        <a href="{{ url('/toNews') }}">消息<i id="news" style="color: rgb(70,160,230); font-size: 1px;"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@section('scripts')
@endsection
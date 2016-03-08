<nav class="navbar-fixed-top">
    <div class="header">
        <div class="container">
            <span class="menu">Menu</span>

            <div class="banner-top">
                <ul class="nav banner-nav">
                    <li><a class="" href="{{ URL('/') }}">主页</a></li>
                    <li><a href="{{ URL('/project') }}">xxx</a></li>
                    <li><a href="{{ URL('/talent') }}">xxx</a></li>
                    <li><a href="{{ URL('/partner') }}">xxx</a></li>

                    @if (Auth::guest())
                        <li class="navbar-right"><a href="{{ URL('/login') }}" type="button" class="dt-sc-button small">登录</a></li>
                        <li class="navbar-right"><a href="{{ URL('/register') }}" type="button" class="dt-sc-button small">注册</a></li>
                    @else
                        <li class="dropdown1 navbar-right">
                            <a href="#" class="" data-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown2" role="menu">
                                <li><a href="{{ url('/userinfo') }}">个人资料</a></li>
                                <li><a href="{{ url('/logout') }}">注销</a></li>
                            </ul>
                        </li>
                    @endif
                    <form>
                        <div class="nav search-bar">
                            <input type="text"  value="Search" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Search';}">
                            <input type="submit" value="" />
                        </div>
                    </form>
                </ul>

                <script>
                    $("span.menu").click(function(){
                        $(" ul.nav").slideToggle("slow" , function(){
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</nav>
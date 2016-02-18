<nav class="navbar-fixed-top">
    <div class="header">
        <div class="container">
            <span class="menu">Menu</span>

            <div class="banner-top">
                <ul class="nav banner-nav">
                    <li><a href="{{ URL('/') }}">主页</a></li>
                    <li><a href="{{ URL('/project') }}">xxx</a></li>
                    <li><a href="{{ URL('/partner') }}">xxx</a>
                    <li class="navbar-right"><a href="{{ URL('/register') }}" type="button" class="dt-sc-button small">注册</a>
                    <li class="navbar-right"><a href="{{ URL('/login') }}" type="button" class="dt-sc-button small">登录</a>
                    </li>
                    <form>
                        <div class="nav search-bar">
                            <label>
                                <input type="text" value="Search" onFocus="this.value = '';"
                                       onBlur="if (this.value == '') {this.value = 'Search';}">
                            </label>
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
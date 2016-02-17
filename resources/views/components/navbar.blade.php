<nav class="navbar-fixed-top">
    <div class="header">
        <div class="container">
            <span class="menu">Menu</span>

            <div class="banner-top">
                <ul class="nav banner-nav">
                    <li><a href="index.html">主页</a></li>
                    <li><a href="">项目</a></li>
                    <li><a href="domain.html">xxx</a>
                    <li class="navbar-right"><a href="domain.html" type="button" class="btn btn-success navbar-btn">注册</a>
                    <li class="navbar-right"><a href="domain.html" type="button" class="btn btn-success navbar-btn">登录</a>
                    </li>
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
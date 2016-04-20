<!DOCTYPE HTML>
<html>
<head>
    <title>shichai</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link href="{{asset('/assets/css/bootstrap.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Custom Theme files -->
    <link href="{{asset('/assets/css/style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/assets/css/nav.css')}}" rel="stylesheet" type="text/css" media="all"/>
    <script src="{{asset('/assets/js/jquery-2.2.0.min.js')}}"></script>

    @yield('styles')

</head>
<body>
@include('layouts.navbar')
@yield('content')
@include('layouts.footer')
<script src="{{asset('/assets/js/scrolltopcontrol.js')}}"></script>
<script>
    setInterval("myInterval()",3000000);//1000为1秒钟
    function myInterval()
    {
        $.ajax({
            type:"GET",
            url:"/getNews",
            dataType:"json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function(message)
            {
                if(message == '' || message == null)
                {
                    alert('busy!!!');
                }
                else
                {
                    if(message["state"] == 200)
                    {
                        $("#news").addClass("fa fa-commenting");
                    }
                    else
                    {
                       // alert(message.content);
                    }
                }
            },
            error:function()
            {
                alert("请求失败");
            }
        });
    }
</script>
<script>
    (function (window, undefined) {
        var Batmany_Easytip = window.Batmany_Easytip = function (text, delay, autoClose){
            return new Batmany_Easytip.fn.init(text, delay, autoClose);
        };
        Batmany_Easytip.fn = Batmany_Easytip.prototype = {
            init : function (text, delay, autoClose) {
                autoClose = autoClose || true;
                var timeId = this.getTimeId();
                this.create(text, delay, timeId, autoClose);
            },
            getTimeId : function () {
                return 'batmany_easy_tip_' + new Date().getSeconds() + new Date().getMilliseconds();
            },
            create : function (text, delay, timeId, autoClose) {
                document.getElementById('batmany_easytip').innerHTML = this.getTipHtml(text, timeId);
                this.show(delay, timeId, autoClose);
            },
            getTipHtml : function (text, timeId) {
                return '<div id="' + timeId + '" class="batmany-easy-tip">' + text + '</div>';
            },
            show : function (delay, timeId, autoClose) {
                var tip = document.getElementById(timeId),
                        that = this;
                setTimeout(function () {
                    tip.className += ' active';
                }, 30);

                delay = delay || 1000;
                if (autoClose) {
                    setTimeout(function () {
                        that.destroy(tip);
                    }, delay);
                }
                return this;
            },
            destroy : function (tip) {
                if (tip) {
                    tip.className = 'batmany-easy-tip';
                }
                return this;
            }
        };
        Batmany_Easytip.fn.init.prototype = Batmany_Easytip.prototype;
    })(window);
</script>
@yield('scripts')

</body>
</html>
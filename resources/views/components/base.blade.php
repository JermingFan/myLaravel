<!DOCTYPE HTML>
<html>
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="" />

    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel='stylesheet' type='text/css' />
    <!-- Custom Theme files -->
    <link href="{{asset('/assets/css/style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/assets/css/nav.css')}}" rel="stylesheet" type="text/css" media="all"/>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('/assets/js/jquery-2.2.0.min.js')}}"></script>
    <!-- dropdown -->
    <script src="{{asset('/assets/js/jquery.easydropdown.js')}}"></script>

    @yield('styles')

    <meta name="_token" content="{{ csrf_token() }}"/>
</head>
<body>

@include('components.navbar')

@yield('content')

@include('components.footer')

<!-- start-smoth-scrolling -->
<script type="text/javascript" src="{{asset('/assets/js/move-top.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/js/easing.js')}}"></script>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
        });
    });
</script>
<!-- end-smoth-scrolling -->
<!-- here stars scrolling icon -->
<script type="text/javascript">
    $(document).ready(function() {
        /*
         var defaults = {
         containerID: 'toTop', // fading element id
         containerHoverID: 'toTopHover', // fading element hover id
         scrollSpeed: 1200,
         easingType: 'linear'
         };
         */
        $().UItoTop({ easingType: 'easeOutQuart' });

    });
</script>
<!-- //here ends scrolling icon -->
<script>(function (window, undefined) {
        var Batmany_Easytip = window.Batmany_Easytip = function (text, delay, autoClose) {
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
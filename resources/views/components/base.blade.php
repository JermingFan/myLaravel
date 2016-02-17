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
    <!-- webfonts -->
    <link href='http://fonts.useso.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('/assets/js/jquery-2.2.0.min.js')}}"></script>
    <!-- dropdown -->
    <script src="{{asset('/assets/js/jquery.easydropdown.js')}}"></script>

</head>
<body>

<!-- Header Starts Here -->
@include('components.navbar')
<!-- Header Ends Here -->

@yield('content')

<!-- #Footer -->
@include('components.footer')
<!-- /#Footer -->

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

</body>
</html>
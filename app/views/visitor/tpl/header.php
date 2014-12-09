<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <title><?php echo $this->title ?></title>
    <meta name="description" content="<?php echo $this->description ?>">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="<?php echo URL ?>/public/visitor/css/style.css" type="text/css"  media="all">
    <link href="<?php echo URL ?>/public/visitor/http://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700|Roboto+Slab:300,400" rel="stylesheet" type="text/css">


    <!-- JS
    ================================================== -->
    <script type="text/javascript" src="<?php echo URL ?>/public/visitor/js/jquery.min.js" ></script>
    <!--[if lt IE 9]>
    <script src="<?php echo URL ?>/public/visitor/js/modernizr.custom.11889.js" type="text/javascript"></script>
    <![endif]-->
    <!-- HTML5 Shiv events (end)-->



    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="<?php echo URL ?>/public/visitor/images/favicon.ico">

    <script type="text/javascript">
        var URL = "<?php echo URL ?>" ;


        $.ajaxSetup({
            type: 'POST',
            timeout: 1000000,
            cache: false
        });

        function showOverlay() {
            var ov = $("#bodyOverlay");
            var pos = ov.offset();
            var doc = $(document);
            ov.css({
                left: pos.left + 'px',
                top: pos.top + 'px',
                width: 0,
                height: 0
            })
                .show()
                .animate({
                    left: 0,
                    top: 0,
                    width: '100%',
                    height: '100%'
                }, 10);

        }

        function Ajax_Error(jqXHR){
            if (jqXHR.status === 0) {
                alerts = 'Not connected Verify Network.' ;
            } else if (jqXHR.status == 404) {
                alerts = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                alerts = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                alerts = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                alerts = 'Time out error.';
            } else if (exception === 'abort') {
                alerts = 'Ajax request aborted';
            } else {
                alerts = 'Uncaught Error.\n' + jqXHR.responseText ;
            }
            return alerts ;
        }

        //Validate email address check
        function valid_email(email){
            var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
            return pattern.test(email);
        }


        //Validate interger value input
        function isInt(n){
            var reInt = new RegExp(/^-?\d+$/);
            if (!reInt.test(n)) {
                return false;
            }
        }

        /* Custom alert dialog */
        function alert(msg){
            showOverlay();
            $(".loading").hide();
            $(".alertDialog").show().find("span").html(msg) ;
        }


        $(function(){

            $.ajaxSetup({
                type: 'POST',
                timeout: 1000000,
                cache: false
            });


            /* Ajax loading effect */
            $(document).ajaxStart(function(){
                showOverlay();
                $(".loading").fadeIn("fast");
            }).ajaxStop(function() {
                $(".loading").hide();
                $("#bodyOverlay").hide();
            });

            $(".alertDialog a").click(function(e){
                e.preventDefault();
                $("#bodyOverlay").hide();
                $(".alertDialog").hide();
                $(".loading").hide();
            });

        });



    </script>

    <style>
        .bodyOverlay {
            background-color: rgba(0, 0, 0, 0.5);
            color: #333;
            position: fixed;
            width: 100%;
            z-index: 900;
            height: 100%;
            top: 0px;
            display:none;
        }

        .alertDialog{
            display: none;
            z-index: 1000;
            position: fixed;
            background-color: #ffffff;
            width:97%;
            margin: 15% auto;
            left: 0;
            right: 0;
            max-width: 400px;
        }

        .alertDialog span{
            padding:10px;
            font-size: 18px;
            line-height: 30px;
            font-family: 'PT Sans Narrow', Calibri, 'Myriad Pro', Tahoma, Arial;
            display: block;
            text-align: center;

        }

        .alertDialog a{
            display: block !important;
            text-align: center;
            border-radius: 0 0 0 0 !important;
        }

        .loading{
            display: none;
            position: fixed;
            width: 200px;
            text-align: center;
            margin: 15% auto;
            left: 0;
            right: 0;
            z-index: 1200;
        }

        .but_phone{
            background-color: #843534;
            padding:5px;
            color: #fff;
        }
    </style>

</head>
<body>

<div id="bodyOverlay" name="bodyOverlay" class="bodyOverlay">
</div>

<div class="loading">
    <img src="<?php echo URL ?>/public/visitor/images/loading.gif" alt="Loading" />
</div>

<div class="alertDialog">
<span>
    this is an alert dialog
</span>
    <a href="#" class="but_phone"><i class="fa fa-times fa-lg"></i> close</a>

</div>

<!-- Primary Page Layout
================================================== -->

<div id="wrap" class="colorskin-0">
    <div id="sticker">
        <header id="header">

            <div  class="container">
                <div class="four columns">
                    <div class="logo"><a href="<?php echo URL ?>"><img src="<?php echo URL ?>/public/visitor/images/logo.png" style="width: 100%; padding: 30px;" id="img-logo" alt="logo"></a></div>
                </div>

                <!-- Navigation starts
                  ================================================== -->
                <nav id="nav-wrap" class="nav-wrap1 twelve columns">
                    <div id="search-form">
                        <form action="#" method="get">
                            <input type="text" class="search-text-box" id="search-box">
                        </form>
                    </div>
                    <ul id="nav">
                        <li class="home"><a href="<?php echo URL ?>">Home</a></li>
                        <li class="about"><a  href="<?php echo URL ?>/about">About us</a>
                            <ul>
                                <li class="about"><a href="<?php echo URL ?>/about">About us</a></li>
                                <li ><a href="<?php echo URL ?>/ourteam">Our team</a></li>
                                <li class="about"><a href="<?php echo URL ?>/contact">Contact</a></li>
                            </ul>
                        </li>
                        <li class="faq"><a href="<?php echo URL ?>/faq">FAQ</a></li>
                        <li class="login"><a  href="<?php echo URL ?>/login">Login</a></li>
                        <li class="signup"><a  href="<?php echo URL ?>/signup">Sign up</a></li>


                    </ul>
                </nav>
                <!-- /nav-wrap -->

                <!-- Navigation ends
                  ================================================== -->
            </div>
            <div id="search-form2">
                <form action="#" method="get">
                    <input type="text" class="search-text-box2">
                </form>
            </div>
        </header>
    </div>

</div>
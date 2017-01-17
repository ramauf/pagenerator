<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{$meta['description']}}">
    <meta name="keywords" content="{{$meta['keywords']}}">
    <title>{!!$meta['title']!!}</title>
    <link href="/adm/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/adm/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="/adm/dist/css/timeline.css" rel="stylesheet">
    <link href="/adm/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="/adm/bower_components/morrisjs/morris.css" rel="stylesheet">
    <link href="/adm/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter40433085 = new Ya.Metrika({
                    id:40433085,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/40433085" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?php if (Session::has('users')){ echo Session::get('users')->lastName.' '.Session::get('users')->firstName;}else{ echo 'Здравствуйте гость';}?></a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <?php if (Session::has('users')) {?>
                    <li><a href="/account"><i class="fa fa-user fa-fw"></i> Профиль</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Выход</a>
                    </li>
                    <?php }else{?>
                    <li><a href="/registration"><i class="fa fa-user fa-fw"></i> Регистрация</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="/login"><i class="fa fa-sign-out fa-fw"></i> Вход</a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li><a href="/poputchik"><i class="fa fa-search"></i> Поиск попутчиков</a></li>
                    <li><a href="/cities"><i class="fa fa-map-marker"></i> По городам</a></li>
                    <li><a href="/contacts"><i class="fa fa-envelope"></i> Контакты</a></li>
                    <li><a href="/registration"><i class="fa fa-users"></i> Регистрация</a></li>
                    <?php if (!Session::has('users')){ ?>
                    <li><a href="/login"><i class="glyphicon glyphicon-log-in"></i> Авторизация</a></li>
                    <?php }else{ ?>
                    <li><a href="/logout"><i class="glyphicon glyphicon-log-in"></i> Выход</a></li>
                    <?php } ?>
                </ul>
                <br /><br />
                <!--LiveInternet counter--><script type="text/javascript"><!--
                    document.write("<a href='//www.liveinternet.ru/click' "+
                            "target=_blank><img src='//counter.yadro.ru/hit?t38.6;r"+
                            escape(document.referrer)+((typeof(screen)=="undefined")?"":
                            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                                    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                            ";"+Math.random()+
                            "' alt='' title='LiveInternet' "+
                            "border='0' width='31' height='31'><\/a>")
                    //-->
                </script><!--/LiveInternet-->
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{$menuName}}</h1>
            </div>
        </div>
        <div class="row">
            @include($subTemplate)
        </div>
        <br />
        <br />
    </div>
</div>
<script src="/adm/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/adm/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/adm/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<script src="/adm/dist/js/sb-admin-2.js"></script>
</body>
</html>

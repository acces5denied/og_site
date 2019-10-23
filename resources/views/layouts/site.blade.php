<!doctype html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        
		{!! SEO::generate() !!}

        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/png">
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>

        @include('frontend.menu')

        <main class="mob_menu">

            @yield('header')

            @yield('content')

            @yield('footer')

        </main>
        
         @include('frontend.popup')

        <script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU&amp;apikey=d43a9233-b84a-4146-b639-8318d2a6e5fc" type="text/javascript"></script>
        <script src="https://yandex.st/jquery/2.2.3/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/main.min.js') }}"></script>
        
        <!-- Yandex.Metrika counter --> 
        <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(55078375, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/55078375" style="position:absolute; left:-9999px;" alt="" /></div></noscript> 
        <!-- /Yandex.Metrika counter -->
        
         @yield('scripts') 

    </body>
</html>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

</head>
<body>
<style>
    @page { 
        margin: 0;

    }
    
    header { position: fixed; top: 0px; left: 0px; right: 0px; background-color: lightblue; height: 50px; }
    footer { position: fixed; bottom: 0px; left: 0px; right: 0px; background-color: lightblue; height: 50px; }
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .page-break {
        padding: 50px 0;
        page-break-after: always;
    }
</style>
<header>header on each page</header>
<footer>footer on each page</footer>

<section class="page-break">
    <div class="inner_wrapper">
        <div class="container">
            <ul>
                <li>Название: {{ $offer->name }}</li>
                <li>id: {{ $offer->id }}</li>
                <li>Тип недвижимости: {{ $offer->type_name }}</li>
                <li>Отделка: {{ $offer->finish_name }}</li>
                <li>Дата создания: {{ $offer->created_at }}</li>
                
            </ul>
       
        </div>
    </div>
</section>
<section class="page-break">
    <div class="inner_wrapper">
        <div class="container">
            <ul>
                <li>Название: {{ $offer->name }}</li>
                <li>id: {{ $offer->id }}</li>
                <li>Тип недвижимости: {{ $offer->type_name }}</li>
                <li>Отделка: {{ $offer->finish_name }}</li>
                <li>Дата создания: {{ $offer->created_at }}</li>
                
            </ul>
       
        </div>
    </div>
</section>

</body>
</html>
   


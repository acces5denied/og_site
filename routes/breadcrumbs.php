<?php

//  Home
Breadcrumbs::for('index', function ($breadcrumbs) {
     $breadcrumbs->push('Главная', route('frontend.index'));
});

//  Home > Offers
Breadcrumbs::for('offers', function ($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Жилая недвижимость', route('frontend.offers.index'));
});

//  Home > Offers > [Type]
Breadcrumbs::for('type', function ($breadcrumbs, $offer) {

    $breadcrumbs->parent('offers');
    $breadcrumbs->push($offer->type_name, route('frontend.offers.index') . '/' . $offer->type);

});

//  Home > Offers > [Type] > [Offer]
Breadcrumbs::for('offer', function ($breadcrumbs, $offer) {
    
    if (isset($offer->type)) {
        $breadcrumbs->parent('type', $offer);
    } else {
        $breadcrumbs->parent('offers');
    }

    $breadcrumbs->push($offer->name);
});


//  Home > Cats
Breadcrumbs::for('cats', function ($breadcrumbs) {
	$breadcrumbs->parent('index');
    $breadcrumbs->push('Жилищные комплексы', route('frontend.cats.index'));
});
//  Home > Cats > [Cat]
Breadcrumbs::for('cat', function ($breadcrumbs, $cat) {
    $breadcrumbs->parent('cats');
    $breadcrumbs->push($cat->name);
});

//  Home > News
Breadcrumbs::for('news', function ($breadcrumbs) {
	$breadcrumbs->parent('index');
    $breadcrumbs->push('Новости', route('frontend.news.index'));
});
//  Home > News > [News_open]
Breadcrumbs::for('news_open', function ($breadcrumbs, $news) {
    $breadcrumbs->parent('news');
    $breadcrumbs->push('Статья-' . $news->id);
});


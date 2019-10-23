<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc>{{ route('frontend.offers.index') }}</loc>
		<changefreq>daily</changefreq>
		<priority>1</priority>
	</url>
	<url>
		<loc>{{ route('frontend.cats.index') }}</loc>
		<changefreq>daily</changefreq>
		<priority>1</priority>
	</url>
	<url>
		<loc>{{ route('frontend.news.index') }}</loc>
		<changefreq>weekly</changefreq>
		<priority>0.7</priority>
	</url>
	
	 @foreach($offers->unique('type') as $k=>$offer)
       
        @foreach($offers->where('type', $offer->type)->unique('type') as $offer)
        <url>
        	<loc>{{ route('frontend.offers.index') . '/' . $offer->type }}</loc>
        	<changefreq>daily</changefreq>
        	<priority>1</priority>
        </url>
        @endforeach
        
        @foreach($offers->where('type', $offer->type)->unique('finish') as $offer)
        <url>
        	<loc>{{ route('frontend.offers.index') . '/' . $offer->type . '/' . $offer->finish}}</loc>
        	<changefreq>daily</changefreq>
        	<priority>1</priority>
        </url>
        @endforeach
       			
        @foreach($offers->sortBy('subway.city_subway')->where('type', $offer->type)->unique('subway_id') as $offer)
        <url>
        	<loc>{{ route('frontend.offers.index') . '/' . $offer->type . '/' . $offer->subway->slug_subway }}</loc>
        	<changefreq>daily</changefreq>
        	<priority>1</priority>
        </url>
        @endforeach 
        
		@foreach($offers->sortBy('subway.city_district')->where('type', $offer->type)->unique('subway.city_district') as $offer)
        <url>
            <loc>{{ route('frontend.offers.index') . '/' . $offer->type . '/' . $offer->subway->slug_district }}</loc>
            <changefreq>daily</changefreq>
        	<priority>1</priority>
        </url>
        @endforeach
        
        @foreach($offers->sortBy('subway.city_area')->where('type', $offer->type)->unique('subway.city_area') as $offer)
        <url>
            <loc>{{ route('frontend.offers.index') . '/' . $offer->type . '/' . $offer->subway->slug_area }}</loc>
            <changefreq>daily</changefreq>
        	<priority>1</priority>
        </url>
        @endforeach
	 @endforeach

</urlset>

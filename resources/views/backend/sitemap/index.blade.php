<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('sitemap/other') }}</loc>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap/offers') }}</loc>
        <lastmod>{{ $offers->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap/cats') }}</loc>
    </sitemap>
    @if($posts)
    <sitemap>
        <loc>{{ url('sitemap/news') }}</loc>
        <lastmod>{{ $posts->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    @endif
</sitemapindex>
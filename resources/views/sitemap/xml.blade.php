{!! $xml_header !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

@foreach ($entries as $entry)
    <url>
        <loc>{{ $entry['loc'] }}</loc>
        <lastmod>{{ $entry['lastmod'] }}</lastmod>
        @if (isset($entry['changefreq']))
            <changefreq>{{ $entry['changefreq'] }}</changefreq>
        @endif
        <priority>{{ $entry['priority'] }}</priority>

        @if (isset($entry['images']) && !empty($entry['images']))
            @foreach ($entry['images'] as $image)
                <image:image>
                    <image:loc>{{ $image['url'] }}</image:loc>
                    @if (isset($image['title']) && !empty($image['title']))
                        <image:title>{{ $image['title'] }}</image:title>
                    @endif
                    @if (isset($image['caption']) && !empty($image['caption']))
                        <image:caption>{{ $image['caption'] }}</image:caption>
                    @endif
                </image:image>
            @endforeach
        @endif
    </url>
@endforeach

</urlset>

<?php

namespace App\Http\Controllers;

use App\Actions\SitemapBuilder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class XmlSitemapController extends Controller
{
    public function index(SitemapBuilder $sitemapBuilder)
    {
        // Cache sitemap for 1 day (or adjust as needed)
        $content = Cache::remember(
            'sitemap.xml',
            app()->environment('production') ? now()->addHour() : 0,
            function () use ($sitemapBuilder) {
                $entries = $sitemapBuilder();

                return view('sitemap.xml', [
                    'entries' => $entries,
                    'xml_header' => '<?xml version="1.0" encoding="UTF-8"?>',
                ])->render();
            }
        );

        return (new Response($content, 200))
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=86400'); // 24 hours
    }
}

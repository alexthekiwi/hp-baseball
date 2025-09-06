<?php

namespace App\SearchFilters;

class PublishedFilter
{
    public function handle($item)
    {
        return $item->status() === 'published' && ! $item->seo_noindex;
    }
}

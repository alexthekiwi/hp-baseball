<?php

namespace App\Actions;

use Illuminate\Support\Collection;
use Statamic\Assets\Asset;
use Statamic\Assets\AssetCollection;
use Statamic\Entries\Entry;
use Statamic\Facades\Collection as CollectionFacade;
use Statamic\Facades\Site;

class SitemapBuilder
{
    protected $entries;

    protected $allowed_collections = [
        'pages',
        'news',
        'products',
    ];

    public function __construct()
    {
        $this->entries = collect();
    }

    public function __invoke()
    {
        return $this->buildEntries();
    }

    public function buildEntries(): Collection
    {
        $entries = collect();

        // Get all published entries
        $entries = $entries->merge($this->publishedEntries());

        // Filter by current site
        $entries = $entries->filter($this->siteFilter(Site::current()));

        // Transform entries into sitemap format with images
        $entries = $entries->map(function ($entry) {
            $augmented = $entry->newAugmentedInstance();
            $url = $augmented->get('permalink') ?? $augmented->get('absolute_url');
            $lastmod = $augmented->get('updated_at');

            $images = [];

            if ($entry->has('preview_thumbnail')) {
                if ($entry->image instanceof AssetCollection) {
                    $images = $this->getImagesFromAssetCollection($entry->preview_thumbnail, $entry);
                }
            }

            $priority = $augmented->get('sitemap_priority')?->value() ?? 0.5;
            $changeFrequency = $augmented->get('change_frequency')?->value() ?? 'weekly';

            return [
                'loc' => $url,
                'path' => parse_url($url)['path'] ?? '/',
                'lastmod' => $lastmod,
                'changefreq' => $changeFrequency,
                'priority' => $priority,
                'images' => $images,
            ];
        })
            ->filter(function ($entry) {
                // Filter out entries with no valid URL
                return ! empty($entry['loc']) && $this->isAbsoluteUrl($entry['loc']);
            })
            ->sortBy(function ($entry) {
                // Sort by path depth
                return substr_count(rtrim($entry['path'], '/'), '/');
            });

        return $entries;
    }

    protected function publishedEntries(): Collection
    {
        return CollectionFacade::all()
            ->filter(function ($collection) {
                return in_array($collection->handle(), $this->allowed_collections);
            })
            ->flatMap(function ($collection) {
                return $collection->queryEntries()->get();
            })
            ->filter(function ($entry) {
                // Filter out entries with no valid URL
                $absoluteUrl = $entry->absoluteUrl();
                if ($absoluteUrl === null || ! $this->isAbsoluteUrl($absoluteUrl)) {
                    return false;
                }

                // Check if entry is published
                if ($entry->status() !== 'published') {
                    return false;
                }

                // Respect seo_noindex if it exists
                if ($entry->has('seo_noindex')) {
                    $noIndex = $entry->get('seo_noindex');

                    // If it's a Value object, get the raw value
                    if ($noIndex instanceof \Statamic\Fields\Value) {
                        $noIndex = $noIndex->value();
                    }

                    // If noindex is true, exclude from sitemap
                    if ($noIndex === true || $noIndex === 'true' || $noIndex === 1 || $noIndex === '1') {
                        return false;
                    }
                }

                return true;
            });
    }

    protected function isAbsoluteUrl(string $url): bool
    {
        return preg_match('#^https?://#', $url);
    }

    protected function siteFilter(\Statamic\Sites\Site $currentSite): callable
    {
        return function ($entry) use ($currentSite) {
            return ! $entry->isRedirect() && $entry->locale() === $currentSite->handle();
        };
    }

    protected function getImagesFromAssetCollection($assetCollection, Entry $entry): array
    {
        $images = [];

        foreach ($assetCollection as $asset) {
            if ($asset instanceof Asset && in_array($asset->extension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                $imageUrl = $asset->absoluteUrl();
                $imageTitle = $entry->preview_title ?? $asset->get('alt') ?? $entry->get('title');
                $imageCaption = $entry->excerpt ?? $asset->get('caption') ?? '';

                if (! $imageUrl) {
                    continue;
                }

                $images[] = [
                    'url' => $imageUrl,
                    'title' => $imageTitle,
                    'caption' => $imageCaption,
                ];
            }
        }

        return $images;
    }
}

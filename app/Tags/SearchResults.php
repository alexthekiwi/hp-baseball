<?php

namespace App\Tags;

use Statamic\Facades\Entry;
use Statamic\Facades\Search;
use Statamic\Tags\Tags;

class SearchResults extends Tags
{
    /**
     * The {{ search_results }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        $index = $this->params->get('index', 'default');
        $limit = $this->params->get('limit', 10);

        $urlParams = $this->context->get('get');

        $keywords = $urlParams['keywords'] ?? '';
        $limit = $urlParams['limit'] ?? $limit;

        $tag = $urlParams['tag'] ?? '';

        $page = $urlParams['page'] ?? 1;
        $paginateResults = $limit > 0;

        // if no keywords or tags are provided, just return entries in order by date
        if (! $keywords && ! $tag) {
            $query = Entry::query()
                ->where('collection', $index)
                ->where('published', true)
                ->orderByDesc('date');

            // Conditionally paginate based on the limit param
            $results = $paginateResults
                ? $query->paginate(perPage: $limit, page: $page)
                : $query->get();

            if ($results->isEmpty()) {
                return $this->parseNoResults();
            }

            unset($urlParams['page']);
            $stringParams = http_build_query($urlParams);

            return [
                'items' => $results->collect(),
                'has_pages' => $results->total() > $limit,
                'pagination' => [
                    'current_page' => $results->currentPage(),
                    'last_page' => $results->lastPage(),
                    'per_page' => $results->perPage(),
                    'total' => $results->total(),
                    'next_page_url' => $results->nextPageUrl().
                        '&'.$stringParams,
                    'prev_page_url' => $results->previousPageUrl().
                        '&'.$stringParams,
                ],
            ];
        }

        $builder = Entry::query()
            ->where('collection', $index)
            ->where('published', true)
            ->when($tag, fn ($query) => $query->whereJsonContains('tags', $tag))
            ->orderByDesc('date');

        if ($keywords) {
            $indexResult = Search::index($index)
                ->ensureExists()
                ->search($keywords)
                ->get();

            // now filter $builder by these results
            $ids = $indexResult->map(function ($result) {
                $ref = $result->getReference();

                return explode('::', $ref)[1];
            })->all();

            $builder->whereIn('id', $ids);
        }

        // Run the query and conditionally paginate based on the limit param
        $results = $paginateResults
            ? $builder->paginate(perPage: $limit, page: $page)
            : $builder->get();

        if ($results->isEmpty()) {
            return $this->parseNoResults();
        }

        unset($urlParams['page']);
        $stringParams = http_build_query($urlParams);

        return [
            'items' => $results->collect(),
            'has_pages' => $results->total() > $limit,
            'pagination' => [
                'limit' => $limit,
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
                'total_pages' => ceil($results->total() / $limit),
                'next_page_url' => $results->nextPageUrl().
                    '&'.$stringParams,
                'prev_page_url' => $results->previousPageUrl().
                    '&'.$stringParams,
            ],
        ];
    }
}

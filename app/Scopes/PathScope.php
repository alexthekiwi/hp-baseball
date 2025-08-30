<?php

namespace App\Scopes;

use Statamic\Query\Scopes\Scope;

class PathScope extends Scope
{
    /**
     * Apply the scope.
     *
     * @param  \Statamic\Query\Builder  $query
     * @param  array  $values
     * @return void
     */
    public function apply($query, $values)
    {
        $path = $values['path'] ?? null;

        if (! $path) {
            return;
        }

        // TODO: Support regex syntax for our redirects

        $query
            ->where('title', $path)
            ->orWhere('title', $path.'/');
    }
}

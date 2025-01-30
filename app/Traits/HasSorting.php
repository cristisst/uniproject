<?php

namespace App\Traits;

use App\Core\Http\Routing\Request;

trait HasSorting
{
    /**
     * @param Request $request
     * @return string
     */
    public function sort($queryString): string
    {
        //Sort
        if (!empty($queryString) && isset($queryString['sort'])) {

            $sqlSort = match ($queryString['sort']) {
                'price-low-to-high' => ' ORDER BY price ASC',
                'price-high-to-low' => ' ORDER BY price DESC',
                'a-to-z' => ' ORDER BY name ASC',
                'z-to-a' => ' ORDER BY name DESC',
                'newest' => ' ORDER BY updated_at DESC',
                'oldest' => ' ORDER BY updated_at ASC',
                default => ' ORDER BY name ASC',
            };
        }
        return $sqlSort ?? '';
    }

}
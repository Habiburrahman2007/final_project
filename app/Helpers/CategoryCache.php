<?php

namespace App\Helpers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryCache
{
    const CACHE_KEY = 'categories_all';
    const CACHE_TTL = 3600; // 1 hour in seconds

    /**
     * Get all categories from cache or database
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function all()
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return Category::all();
        });
    }

    /**
     * Clear the category cache
     * Call this when categories are created, updated, or deleted
     * 
     * @return bool
     */
    public static function flush()
    {
        return Cache::forget(self::CACHE_KEY);
    }
}

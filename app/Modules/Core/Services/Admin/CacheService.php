<?php

namespace Modules\Core\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheService
{

    public function cacheOptions(Request $request)
    {
        $config_cache_groups = config('core.cache_group_key');
        $cache_options = [];
        foreach ($config_cache_groups as $key => $config_cache_group) {
            $cache_option = $config_cache_group['label'];
            array_push($cache_options, [$key => $cache_option]);
        }

        return $cache_options;
    }

    public function clearCacheByOption(Request $request)
    {
        $cache_option_groups = $request->input('cache_option');
        $path = storage_path() . "/framework/cache/repository-cache-keys.json";
        $cache_groups = json_decode(file_get_contents($path), true);
        $config_cache_groups = config('core.cache_group_key');
        foreach ($cache_option_groups as $cache_option) {
            $config = $config_cache_groups[$cache_option];
            $class = $config['class'];
            foreach($class as $clas){
                if (isset($cache_groups[$clas])) {
                    $caches_group = $cache_groups[$clas];
                    foreach ($caches_group as $cache_group) {
                        Cache::forget($cache_group);

                        unset($cache_groups[$clas]);

                    }
                }
            }

        }
        $cache_groups = json_encode($cache_groups);
        file_put_contents($path, $cache_groups);

        return true;
    }
}

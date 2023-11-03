<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Helpers\CacheKeys;

trait CoreHasCacheableTrait
{
    /**
     * Get Cache key for the method
     *
     * @param $method
     * @param $args
     *
     * @return string
     */
    public function getCacheKey($method, $args = null, $hasUser = false)
    {

        $request = app('Illuminate\Http\Request');
        $args = serialize($args);
        $key = sprintf('%s@%s-%s', get_called_class(), $method, md5($args . $request->fullUrl()));
        if (auth('sanctum')->check() && $hasUser) {
            $key .= auth('sanctum')->id();
        }
        CacheKeys::putKey(get_called_class(), $key);

        return $key;
    }

    public function getCacheTtl($type){
        $payload = DB::table('settings')->select('payload')->where(['group' => 'cache', 'name' => 'cache_setting'])->first();
        $cache_setting = json_decode($payload->payload);
        $ttl = 0;
        if($type == 'exam'){
            if($cache_setting->cache_exam_enable == true){
                $ttl = $cache_setting->cache_exam_time;
            }
        }elseif($type == 'banner'){
            if($cache_setting->cache_banner_enable == true){
                $ttl = $cache_setting->cache_banner_time;
            }
        }elseif($type == 'document'){
            if($cache_setting->cache_document_enable == true){
                $ttl = $cache_setting->cache_document_time;
            }
        }elseif($type == 'ebook'){
            if($cache_setting->cache_ebook_enable == true){
                $ttl = $cache_setting->cache_ebook_time;
            }
        }elseif($type == 'master_data'){
            if($cache_setting->cache_master_data_enable == true){
                $ttl = $cache_setting->cache_master_data_time;
            }
        }elseif($type == 'course_videos'){
            if($cache_setting->cache_master_data_enable == true){
                $ttl = $cache_setting->cache_master_data_time;
            }
        }

        return $ttl;

    }
}

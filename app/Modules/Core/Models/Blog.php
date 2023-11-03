<?php

namespace Modules\Core\Models;

use Modules\Core\Models\BlogTag;
use Modules\Core\Models\BlogCategory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasLogsActivity;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Blog.
 *
 * @package namespace Modules\Core\Models;
 */
class Blog extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, CoreHasUniqueCode;
    use CoreHasUserAudit, CoreHasTranslations, CoreHasLogsActivity;

    protected $table = "core_blogs";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'alias',
        'short_description',
        'description',
        'image_thumbnail',
        'image_cover',
        'type',
        'published_at',
        'finished_at',
        'status',
        'show_type',
        'action_click_type',
        'is_featured',
        'bizapp',
        'meta_title',
        'meta_description',
        'meta_url',
        'meta_keyword'
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_featured' => 'boolean',
    ];


    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = [
        'name',
        'short_description',
        'description'
    ];

    protected $hidden = ['pivot'];


    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'core_blog_category_map', 'blog_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'core_blog_tag_map', 'blog_id', 'tag_id');
    }
}

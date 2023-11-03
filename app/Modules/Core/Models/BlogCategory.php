<?php

namespace Modules\Core\Models;

use Modules\Core\Models\Blog;
use Modules\Core\Traits\CoreHasAlias;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasLogsActivity;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BlogCategory.
 *
 * @package namespace Modules\Core\Models;
 */
class BlogCategory extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, CoreHasUniqueCode;
    use CoreHasUserAudit, CoreHasTranslations, CoreHasAlias, CoreHasLogsActivity;

    protected $table = "core_blog_categories";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'alias',
        'description',
        'image',
        'is_active',
        'is_show_homepage'
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_show_homepage' => 'boolean',
    ];


    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = [
        'name',
        'description',
    ];

    protected $hidden = ['pivot'];


    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'core_blog_category_map', 'category_id', 'blog_id');
    }
}

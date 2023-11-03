<?php

namespace Modules\Core\Models;

use Modules\Core\Traits\CoreHasAlias;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Core\Traits\CoreHasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BlogTag.
 *
 * @package namespace Modules\Core\Models;
 */
class BlogTag extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;
    use CoreHasUserAudit, CoreHasAlias, CoreHasTranslations;

    protected $table = "core_blog_tags";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'is_active'
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = [
        'name',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];


    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    // public $translatable = [
    //     'name',
    // ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'core_blog_tag_map', 'tag_id', 'blog_id');
    }
}

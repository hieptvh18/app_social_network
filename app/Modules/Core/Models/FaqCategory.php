<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Core\Traits\CoreHasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FaqCategory.
 *
 * @package namespace Modules\Core\Models;
 */
class FaqCategory extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;
    use CoreHasUserAudit, CoreHasTranslations;

    protected $table = "core_faq_categories";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'icon',
        'is_active'
    ];

    public $translatable=['name'];

    protected $casts = ['is_active' => 'boolean'];

    public function faqs()
    {
        return $this->belongsTo(Faq::class, 'id', 'category_id');
    }
}

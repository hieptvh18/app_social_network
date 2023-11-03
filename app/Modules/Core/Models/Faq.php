<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Core\Traits\CoreHasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Faq.
 *
 * @package namespace Modules\Core\Models;
 */
class Faq extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;
    use CoreHasUserAudit, CoreHasTranslations;

    protected $table = "core_faqs";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'question',
        'answer',
        'is_active'
    ];

    public $translatable=['question','answer'];

    protected $casts = ['is_active' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class,'category_id','id');
    }
}

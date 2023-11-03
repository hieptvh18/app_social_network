<?php

namespace Modules\Core\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Services\PeriodService;
use Modules\Core\Traits\CoreHasAlias;
use Modules\Core\Traits\CoreHasLogsActivity;
use Modules\Core\Traits\CoreHasTranslations;
use Modules\Core\Traits\CoreHasUniqueCode;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class PlanFeature extends Model implements Sortable
{
    use HasFactory, CoreHasAlias, CoreHasUniqueCode, CoreHasLogsActivity, CoreHasTranslations, SoftDeletes, SortableTrait;

    const ALIAS_COLUMN = 'slug';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'plan_id',
        'slug',
        'name',
        'description',
        'value',
        'resettable_period',
        'resettable_interval',
        'sort_order',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'plan_id' => 'integer',
        'slug' => 'string',
        'value' => 'string',
        'resettable_period' => 'integer',
        'resettable_interval' => 'string',
        'sort_order' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
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

    /**
     * The sortable settings.
     *
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'sort_order',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('core.tables.plan_features'));
        // $this->mergeRules([
        //     'plan_id' => 'required|integer|exists:' . config('core.tables.plans') . ',id',
        //     'slug' => 'required|alpha_dash|max:150|unique:' . config('core.tables.plan_features') . ',slug',
        //     'name' => 'required|string|strip_tags|max:150',
        //     'description' => 'nullable|string|max:32768',
        //     'value' => 'required|string',
        //     'resettable_period' => 'sometimes|integer',
        //     'resettable_interval' => 'sometimes|in:hour,day,week,month',
        //     'sort_order' => 'nullable|integer|max:100000',
        // ]);

        parent::__construct($attributes);
    }

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($plan_feature) {
            $plan_feature->usage()->delete();
        });
    }

    /**
     * The plan feature may have many subscription usage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usage(): HasMany
    {
        return $this->hasMany(PlanSubscriptionUsage::class, 'feature_id', 'id');
    }

    /**
     * Get feature's reset date.
     *
     * @param string $dateFrom
     *
     * @return \Carbon\Carbon
     */
    public function getResetDate(Carbon $dateFrom): Carbon
    {
        $period = new PeriodService($this->resettable_interval, $this->resettable_period, $dateFrom ?? now());

        return $period->getEndDate();
    }
}

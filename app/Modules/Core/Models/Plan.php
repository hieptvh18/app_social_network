<?php

namespace Modules\Core\Models;

use Modules\Core\Traits\CoreHasAlias;
use Modules\Order\Traits\orderHelper;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUniqueCode;
use Spatie\EloquentSortable\SortableTrait;
use Modules\Core\Traits\CoreHasLogsActivity;
use Modules\Core\Traits\CoreHasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Models\OrderItem;

/**
 * Modules\Core\Models\Plan class
 */
class Plan extends Model implements Sortable
{
    use HasFactory, SoftDeletes, SortableTrait;

    use CoreHasAlias, CoreHasUniqueCode, CoreHasTranslations, CoreHasLogsActivity;

    const ALIAS_COLUMN = 'slug';

    protected $fillable = [
        'slug',
        'name',
        'code',
        'description',
        'is_active',
        'price',
        'signup_fee',
        'currency',
        'trial_period',
        'trial_interval',
        'invoice_period',
        'invoice_interval',
        'grace_period',
        'grace_interval',
        'prorate_day',
        'prorate_period',
        'prorate_extend_due',
        'active_subscribers_limit',
        'sort_order',
        'user_type',
        'bizapp'
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        // 'slug' => 'string',
        'is_active' => 'boolean',
        'price' => 'float',
        'signup_fee' => 'float',
        'currency' => 'string',
        'trial_period' => 'integer',
        'trial_interval' => 'string',
        'invoice_period' => 'integer',
        'invoice_interval' => 'string',
        'grace_period' => 'integer',
        'grace_interval' => 'string',
        'prorate_day' => 'integer',
        'prorate_period' => 'integer',
        'prorate_extend_due' => 'integer',
        'active_subscribers_limit' => 'integer',
        'sort_order' => 'integer',
        'deleted_at' => 'datetime',
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

    protected $with = ['features'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('core.tables.plans'));
        // $this->mergeRules([
        //     'slug' => 'required|alpha_dash|max:150|unique:' . config('core.tables.plans') . ',slug',
        //     'name' => 'required|string|strip_tags|max:150',
        //     'description' => 'nullable|string|max:32768',
        //     'is_active' => 'sometimes|boolean',
        //     'price' => 'required|numeric',
        //     'signup_fee' => 'required|numeric',
        //     'currency' => 'required|alpha|size:3',
        //     'trial_period' => 'sometimes|integer|max:100000',
        //     'trial_interval' => 'sometimes|in:hour,day,week,month',
        //     'invoice_period' => 'sometimes|integer|max:100000',
        //     'invoice_interval' => 'sometimes|in:hour,day,week,month',
        //     'grace_period' => 'sometimes|integer|max:100000',
        //     'grace_interval' => 'sometimes|in:hour,day,week,month',
        //     'sort_order' => 'nullable|integer|max:100000',
        //     'prorate_day' => 'nullable|integer|max:150',
        //     'prorate_period' => 'nullable|integer|max:150',
        //     'prorate_extend_due' => 'nullable|integer|max:150',
        //     'active_subscribers_limit' => 'nullable|integer|max:100000',
        // ]);

        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($plan) {
            $plan->features()->delete();
            $plan->planSubscriptions()->delete();
        });
    }

    public function items(){
        return $this->hasMany(OrderItem::class,'product_id','id');
    }

    /**
     * The plan may have many features.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features(): HasMany
    {
        return $this->hasMany(PlanFeature::class, 'plan_id', 'id');
    }

    /**
     * The plan may have many subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planSubscriptions(): HasMany
    {
        return $this->hasMany(PlanSubscription::class, 'plan_id', 'id');
    }

    /**
     * Check if plan is free.
     *
     * @return bool
     */
    public function isFree(): bool
    {
        return (float) $this->price <= 0.00;
    }

    /**
     * Check if plan has trial.
     *
     * @return bool
     */
    public function hasTrial(): bool
    {
        return $this->trial_period && $this->trial_interval;
    }

    /**
     * Check if plan has grace.
     *
     * @return bool
     */
    public function hasGrace(): bool
    {
        return $this->grace_period && $this->grace_interval;
    }

    /**
     * Get plan feature by the given slug.
     *
     * @param string $featureSlug
     *
     * @return \Rinvex\Subscriptions\Models\PlanFeature|null
     */
    public function getFeatureBySlug(string $featureSlug): ?PlanFeature
    {
        return $this->features()->where('slug', $featureSlug)->first();
    }

    /**
     * Activate the plan.
     *
     * @return $this
     */
    public function activate()
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate the plan.
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);

        return $this;
    }
}

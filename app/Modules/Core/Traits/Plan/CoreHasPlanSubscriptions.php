<?php

namespace Modules\Core\Traits\Plan;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Core\Models\Plan;
use Modules\Core\Models\PlanSubscription;
use Modules\Core\Services\PeriodService;

trait CoreHasPlanSubscriptions
{
    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param string $related
     * @param string $name
     * @param string $type
     * @param string $id
     * @param string $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

    /**
     * Boot the HasPlanSubscriptions trait for the model.
     *
     * @return void
     */
    protected static function bootHasSubscriptions()
    {
        static::deleted(function ($plan) {
            $plan->planSubscriptions()->delete();
        });
    }

    /**
     * The subscriber may have many plan subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function planSubscriptions(): MorphMany
    {
        return $this->morphMany(PlanSubscription::class, 'subscriber', 'subscriber_type', 'subscriber_id');
    }

    /**
     * A model may have many active plan subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function activePlanSubscriptions(): Collection
    {
        return $this->planSubscriptions->reject->inactive();
    }

    /**
     * Get a plan subscription by slug.
     *
     * @param string $subscriptionSlug
     *
     * @return \Rinvex\Subscriptions\Models\PlanSubscription|null
     */
    public function planSubscription(string $subscriptionSlug): ?PlanSubscription
    {
        return $this->planSubscriptions()->where('name', $subscriptionSlug)->findActive()->first();
    }

    /**
     * Get subscribed plans.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function subscribedPlans(): Collection
    {
        $planIds = $this->planSubscriptions->reject->inactive()->pluck('plan_id')->unique();

        return Plan::whereIn('id', $planIds)->get();
    }

    /**
     * Check if the subscriber subscribed to the given plan.
     *
     * @param int $planId
     *
     * @return bool
     */
    public function subscribedTo($planId): bool
    {
        $subscription = $this->planSubscriptions()->where('plan_id', $planId)->findActive()->first();

        return $subscription && $subscription->active();
    }

    /**
     * Subscribe subscriber to a new plan.
     *
     * @param string                            $subscription
     * @param \Rinvex\Subscriptions\Models\Plan $plan
     * @param \Carbon\Carbon|null               $startDate
     *
     * @return \Rinvex\Subscriptions\Models\PlanSubscription
     */
    public function newPlanSubscription($subscription, Plan $plan, Carbon $startDate = null): PlanSubscription
    {
        $trial = new PeriodService($plan->trial_interval, $plan->trial_period, $startDate ?? now());
        $period = new PeriodService($plan->invoice_interval, $plan->invoice_period, $trial->getEndDate());

        return $this->planSubscriptions()->create([
            'name' => $subscription,
            'plan_id' => $plan->getKey(),
            'trial_ends_at' => $trial->getEndDate(),
            'starts_at' => $period->getStartDate(),
            'ends_at' => $period->getEndDate(),
        ]);
    }

    public function activeOrderPlanSubscription($order, Plan $plan, Carbon $startDate = null)
    {
        $items = $order->items;
        $qty = $items->quantity;
        $plan_subscription = $this->newPlanSubscription('vip', $plan, $startDate);
        $plan_subscription->update([
            'ends_at' => $startDate->addMonths($qty)
        ]);
        $plan_features = $plan->features;
        foreach ($plan_features as $plan_feature) {
            $plan_feature->usage()->create([
                'subscription_id' => $plan_subscription->id,
                'feature_id' => $plan_feature->id,
                'used' => 0
            ]);
        }
        return $plan_subscription;
    }
}

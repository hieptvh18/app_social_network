<?php

namespace Modules\Core\Models;

use Codebyray\ReviewRateable\Models\Rating as ModelsRating;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;

class Rating extends ModelsRating
{
    use CoreHasUserAudit, SoftDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function reviewrateable()
    {
        return $this->morphTo(__FUNCTION__, 'reviewrateable_type', 'reviewrateable_id');
    }

    public function scopeRating($query){
        if (request()->has('rating')) {
            $rating = request()->query('rating');
            $query = $query->where('rating', $rating);
        }
        return $query;
    }

}

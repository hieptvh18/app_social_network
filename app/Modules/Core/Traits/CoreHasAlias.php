<?php

namespace Modules\Core\Traits;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

trait CoreHasAlias
{
    use HasSlug;
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        $aliasColumn = $this->getAliasColumn();
        return SlugOptions::create()
            ->doNotGenerateSlugsOnUpdate()
            ->generateSlugsFrom('name')
            ->saveSlugsTo($aliasColumn);
    }

    public function getAliasColumn()
    {
        return defined('static::ALIAS_COLUMN') ? static::ALIAS_COLUMN : 'alias';
    }
}

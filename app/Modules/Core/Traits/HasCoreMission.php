<?php

namespace Modules\Core\Traits;



trait HasCoreMission
{

    public function missions()
    {
        return defined('static::ALIAS_COLUMN') ? static::ALIAS_COLUMN : 'alias';
    }
}

<?php

namespace Modules\Core\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity as BaseLogsActivity;
use Illuminate\Support\Str;

trait CoreHasLogsActivity
{
    use BaseLogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()->useLogName($this->getLogName())
            ->dontLogIfAttributesChangedOnly($this->getIgnoreLogField());
        // ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");
        // Chain fluent methods for configuration options
    }

    public function getLogName()
    {
        return defined('static::LOG_NAME') ? static::LOG_NAME : Str::snake(class_basename($this));
    }

    public function getIgnoreLogField()
    {
        if (isset($this->ignore_log_field) && is_array($this->ignore_log_field)) {
            return $this->ignore_log_field;
        }
        return [];
    }
}

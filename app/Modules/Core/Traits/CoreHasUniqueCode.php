<?php

namespace Modules\Core\Traits;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;

trait CoreHasUniqueCode {

    // const CODE_LENGTH = 8;

    // const CODE_PREFIX = '';

    /**
     * Listen for events on model and capture the
     * appropriate activities.
     *
     * @return void
     */
    protected static function bootCoreHasUniqueCode()
    {
        // Register Models Event
        // Create appropriate activities
        static::creating(function($model) {
            if(!$model->code)
            {
                $model->code = $model->generateUniqueCode();
            }
        });
    }

    public function generateUniqueCode()
    {
        $prefix = $this->getCodePrefix();
        $length = strlen($prefix) + $this->getCodeLength();
        $table = $this->table;
        $field = $this->getCodeColumn();
        $code = IdGenerator::generate(['table' => $table,'field' => $field, 'length' => $length, 'prefix' =>$prefix]);
        return $code;
    }

    public function getCodeLength()
    {
        return defined('static::CODE_LENGTH') ? static::CODE_LENGTH : 6;
    }

    public function getCodePrefix()
    {
        $prefix = defined('static::CODE_PREFIX') ? static::CODE_PREFIX : Str::snake(class_basename($this));
        $char = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        shuffle($char);
        $prefix = $prefix.'_'.$char[0].$char[1].$char[2];

        return $prefix;
    }

    public function getCodeChar()
    {
        return defined('static::CODE_CHAR') ? static::CODE_CHAR : '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }

    public function getCodeColumn()
    {
        return defined('static::CODE_CHAR') ? static::CODE_COLUMN : 'code';
    }
}

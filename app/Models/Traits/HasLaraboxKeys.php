<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasLaraboxKeys
{
    protected static function generateId($prefix = '')
    {
        return str(Str::orderedUuid())->replace('-', '')->prepend($prefix);
    }

    protected static function bootHasLaraboxKeys()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = self::generateId($model::PREFIX);
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}

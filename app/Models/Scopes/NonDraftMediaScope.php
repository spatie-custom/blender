<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class NonDraftMediaScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (request()->isFront()) {
            $builder->where('custom_properties', 'not regexp', '[^"]*"draft"[^:]*:[^"]*true');
        }
    }
}

<?php

namespace Modules\Core\GlobalScopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveStatus implements Scope
{
//    public function apply(Builder $builder, Model $model)
//    {
//        $builder->where('is_trashed', 0);
//    }
    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
    }
}

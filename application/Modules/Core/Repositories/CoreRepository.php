<?php

namespace Modules\Core\Repositories;

use Illuminate\Database\Eloquent\Model;


abstract class CoreRepository
{
    protected ?Model $model = null;
}

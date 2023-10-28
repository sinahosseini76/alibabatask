<?php

namespace Modules\Core\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Core\GlobalScopes\ActiveStatus;
use Modules\Core\GlobalScopes\NotTrashedScope;

class CoreAuthenticatable extends Authenticatable
{
//    protected static function booted()
//    {
//        static::addGlobalScope(new ActiveStatus());
//    }
}

<?php

namespace Modules\Example\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\CoreModel;


class Example extends CoreModel
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = "examples";

}

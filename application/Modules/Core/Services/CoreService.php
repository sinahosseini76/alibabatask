<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\CoreRepository;
use Modules\Core\Traits\CoreApiResponser;

abstract class CoreService
{
    use CoreApiResponser;

    protected ?CoreRepository $repository = null;
}

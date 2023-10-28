<?php

namespace Modules\Example\Services;

use Modules\Core\Services\CoreService;
use Modules\Example\Repositories\PlanRepository;

class ExampleService extends CoreService
{
    public function __construct(PlanRepository $exampleRepository)
    {
        $this->repository = $exampleRepository;
    }
}

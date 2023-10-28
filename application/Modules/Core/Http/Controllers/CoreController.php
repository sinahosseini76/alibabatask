<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Core\Services\CoreService;
use Modules\Core\Traits\CoreApiResponser;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="ChainoBin Application API Documentation",
 *      description="Swagger",
 *      @OA\Contact(
 *          email="sina6g@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url="",
 *      description="Development Api Server"
 * )
 *
 * @QAS\SecurityScheme(
 *      securityScheme="bearer_token",
 *      type="http",
 *      scheme="bearer"
 * )
 *
 */
class CoreController extends Controller
{
    use CoreApiResponser;

    protected ?CoreService $service = null;
}

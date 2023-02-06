<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;
/**
 * @OA\OpenApi(
 *  @OA\Info(
 *      title="News ParserAPI",
 *      version="1.0.0",
 *      description="",
 *      @OA\Contact(
 *          email="example@example.ru"
 *      )
 *  ),
 *  @OA\Server(
 *      description="Laravel API",
 *      url="/api/"
 *  ),
 *  @OA\PathItem(
 *      path="/"
 *  )
 * )
 */
class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


}

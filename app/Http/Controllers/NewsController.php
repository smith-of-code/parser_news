<?php

namespace App\Http\Controllers;

use App\Jobs\ParserNewsRbcJob;
use App\Models\Image;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

class NewsController extends Controller
{
    /**
     * @OA\Post(
     *      path="/news",
     *      operationId="getNewsList",
     *      tags={"News"},
     *      summary="Get list of news",
     *      description="Returns list of news",
     *      @OA\Parameter( name="page", in="query", required=false, description="page number", @OA\Schema( type="string" ) ),
     *     @OA\RequestBody(
     *    request="Create Sample",
     *    description="Create Sample Fields",
     *        @OA\JsonContent(
     *        type="object",
     *        required={""},
     *      @OA\Property(property="fields", type="array", @OA\Items(type="string",example="id")),
     *      @OA\Property(property="sort_by", type="string",example="asc")
     *     )),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/NewsResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index(Request $request)
    {

        $news = new News();
        return News::select($request->fields??$news->getFillable())->orderBy('datetime_pub',$request->sort_by??'asc')->paginate();

    }

    /**
     * @OA\Get(
     *      path="/start-parsing",
     *      operationId="startParsing",
     *      tags={"News"},
     *      summary="",
     *      description="",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function startParsing(){
        ParserNewsRbcJob::dispatch('http://static.feed.rbc.ru/rbc/logical/footer/news.rss');
    }

}

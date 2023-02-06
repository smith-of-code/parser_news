<?php

namespace App\Virtual\Resources;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="NewsResource",
 *     description="News resource",
 *     @OA\Xml(
 *         name="NewsResource"
 *     )
 * )
 */
class NewsResource
{
    /**
     * @OA\Property()
     * @var integer
     */
    private $current_page;

    /**
     * @OA\Property()
     * @var \App\Virtual\Models\News[]
     */
    private $data;

    /**
     * @OA\Property()
     * @var string
     */
    private $first_page_url;

    /**
     * @OA\Property()
     * @var integer
     */
    private $from;

    /**
     * @OA\Property()
     * @var integer
     */
    private $to;

    /**
     * @OA\Property()
     * @var integer
     */
    private $last_page;

    /**
     * @OA\Property()
     * @var string
     */
    private $last_page_url;

    /**
     * @OA\Property(type="array",
     *                  @OA\Items(@OA\Property(property="url", type="string", example="http://localhost:40310/api/v1/news?page=1"),
     *                  @OA\Property(property="label", type="number", example="1"),
     *                  @OA\Property(property="active",type="boolean", example="true")
     *              )
     * )
     */
    private $links;

    /**
     * @OA\Property()
     * @var string
     */
    private $next_page_url;

    /**
     * @OA\Property()
     * @var string
     */
    private $path;

    /**
     * @OA\Property()
     * @var integer
     */
    private $per_page;

    /**
     * @OA\Property()
     * @var string
     */
    private $prev_page_url;

    /**
     * @OA\Property()
     * @var integer
     */
    private $total;

}

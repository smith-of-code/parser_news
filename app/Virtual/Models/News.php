<?php
namespace App\Virtual\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="News",
 *     description="News model",
 *     @OA\Xml(
 *         name="News"
 *     )
 * )
 */
class News
{

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the new User",
     *      example="A nice User"
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description news",
     *      example="la la fa fa end"
     * )
     *
     * @var string
     */
    private $description;

    /**
     * @OA\Property(
     *     title="datetime_pub",
     *     description="date and time published",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $datetime_pub;


    /**
     * @OA\Property(
     *      title="Author",
     *      description="Name of the Author",
     *      example="User Userovich"
     * )
     *
     * @var string
     */
    private $author;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;
}

<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:24:19
 */

/**
 * @OA\Schema(
 *     type="object",
 *     title="Refpostcomment",
 *     required={"id", "comment_id", "post_id"},
 *     description="belongsToMany",
 * )
 */
class Refpostcomment
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * @OA\Property(property="comment_id", default="NONE", description="belongsToMany")
     * @var comment
     */

    /**
     * @OA\Property(property="post_id", default="NONE", description="belongsToMany")
     * @var post
     */

    //{{SWAGGER_PROPERTY_NOT_DELETE_THIS_LINE}}

    /**
     * @OA\Property(property="created_at", type="TIMESTAMP", default="NULL", description="")
     */

    /**
     * @OA\Property(property="updated_at", type="TIMESTAMP", default="NULL", description="")
     */
}

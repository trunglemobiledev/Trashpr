<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:00:53
 */

/**
 * @OA\Get(
 *     path="/khos",
 *     tags={"kho"},
 *     summary="List kho",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(
 *          name="search",
 *          in="query",
 *          @OA\Schema (type="string")
 *     ),
 *     @OA\Parameter(
 *          name="limit",
 *          in="query",
 *          @OA\Schema (type="integer")
 *     ),
 *     @OA\Parameter(
 *          name="ascending",
 *          in="query",
 *          description="0: asc, 1: desc",
 *          @OA\Schema (type="integer", default=1)
 *     ),
 *     @OA\Parameter(
 *          name="page",
 *          in="query",
 *          @OA\Schema (type="integer", default=1)
 *     ),
 *     @OA\Parameter(
 *          name="orderBy",
 *          in="query",
 *          description="column order by",
 *          @OA\Schema (type="string", default="updated_at")
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Post(
 *     path="/khos",
 *     tags={"kho"},
 *     summary="Create kho",
 *     security={{"authApi":{}}},
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id"},
 *                  @OA\Property(property="ten_kho", type="VARCHAR", default="NULL", example="Elva Baumbach", description=""),
     *                  @OA\Property(property="dia_chi", type="VARCHAR", default="NULL", example="Devante Osinski", description=""),
     *                  @OA\Property(property="mo_ta", type="VARCHAR", default="NULL", example="Bridget Bosco", description=""),
     *                  @OA\Property(property="ma_kho", type="VARCHAR", default="NULL", example="Janice Paucek V", description=""),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 * @OA\Get(
 *     path="/khos/{id}",
 *     tags={"kho"},
 *     summary="Edit kho",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Put(
 *     path="/khos/{id}",
 *     tags={"kho"},
 *     summary="Update kho",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id"},
 *                  @OA\Property(property="ten_kho", type="VARCHAR", default="NULL", example="Elva Baumbach", description=""),
     *                  @OA\Property(property="dia_chi", type="VARCHAR", default="NULL", example="Devante Osinski", description=""),
     *                  @OA\Property(property="mo_ta", type="VARCHAR", default="NULL", example="Bridget Bosco", description=""),
     *                  @OA\Property(property="ma_kho", type="VARCHAR", default="NULL", example="Janice Paucek V", description=""),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Delete(
 *     path="/khos/{id}",
 *     tags={"kho"},
 *     summary="Delete kho",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 */

/**
 * @OA\Schema(
 *     type="object",
 *     title="kho",
 *     required={"id"},
 * )
 */
class kho
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * <###> @OA\Property(property="ten_kho", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="dia_chi", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="mo_ta", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="ma_kho", type="VARCHAR", default="NULL", description="")
     */

    //{{SWAGGER_PROPERTY_NOT_DELETE_THIS_LINE}}

    /**
     * @OA\Property(property="created_at", type="TIMESTAMP", default="NULL", description="")
     */

    /**
     * @OA\Property(property="updated_at", type="TIMESTAMP", default="NULL", description="")
     */

    
}

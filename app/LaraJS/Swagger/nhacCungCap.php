<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:47:52
 */

/**
 * @OA\Get(
 *     path="/nhac-cung-caps",
 *     tags={"nhacCungCap"},
 *     summary="List nhacCungCap",
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
 *     path="/nhac-cung-caps",
 *     tags={"nhacCungCap"},
 *     summary="Create nhacCungCap",
 *     security={{"authApi":{}}},
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id"},
 *                  @OA\Property(property="man_nha_cung_cap", type="VARCHAR", default="NULL", example="Pasquale Upton", description=""),
     *                  @OA\Property(property="ten_nhac_cung_cap", type="VARCHAR", default="NULL", example="Timmy Heaney", description=""),
     *                  @OA\Property(property="dia_chi", type="VARCHAR", default="NULL", example="Jasmin Ortiz", description=""),
     *                  @OA\Property(property="so_dien_thoai", type="VARCHAR", default="NULL", example="Esther Krajcik Sr.", description=""),
     *                  @OA\Property(property="tk_ngan_hang", type="VARCHAR", default="NULL", example="Pinkie Monahan II", description=""),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 * @OA\Get(
 *     path="/nhac-cung-caps/{id}",
 *     tags={"nhacCungCap"},
 *     summary="Edit nhacCungCap",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Put(
 *     path="/nhac-cung-caps/{id}",
 *     tags={"nhacCungCap"},
 *     summary="Update nhacCungCap",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id"},
 *                  @OA\Property(property="man_nha_cung_cap", type="VARCHAR", default="NULL", example="Pasquale Upton", description=""),
     *                  @OA\Property(property="ten_nhac_cung_cap", type="VARCHAR", default="NULL", example="Timmy Heaney", description=""),
     *                  @OA\Property(property="dia_chi", type="VARCHAR", default="NULL", example="Jasmin Ortiz", description=""),
     *                  @OA\Property(property="so_dien_thoai", type="VARCHAR", default="NULL", example="Esther Krajcik Sr.", description=""),
     *                  @OA\Property(property="tk_ngan_hang", type="VARCHAR", default="NULL", example="Pinkie Monahan II", description=""),
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
 *     path="/nhac-cung-caps/{id}",
 *     tags={"nhacCungCap"},
 *     summary="Delete nhacCungCap",
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
 *     title="nhacCungCap",
 *     required={"id"},
 * )
 */
class nhacCungCap
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * <###> @OA\Property(property="man_nha_cung_cap", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="ten_nhac_cung_cap", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="dia_chi", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="so_dien_thoai", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="tk_ngan_hang", type="VARCHAR", default="NULL", description="")
     */

    //{{SWAGGER_PROPERTY_NOT_DELETE_THIS_LINE}}

    /**
     * @OA\Property(property="created_at", type="TIMESTAMP", default="NULL", description="")
     */

    /**
     * @OA\Property(property="updated_at", type="TIMESTAMP", default="NULL", description="")
     */

    
}

<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:15:37
 */

/**
 * @OA\Get(
 *     path="/xuat-khos",
 *     tags={"xuatKho"},
 *     summary="List xuatKho",
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
 *     path="/xuat-khos",
 *     tags={"xuatKho"},
 *     summary="Create xuatKho",
 *     security={{"authApi":{}}},
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "kho_id"},
 *                  @OA\Property(property="ma_phieu_xuat", type="VARCHAR", default="NULL", example="Amir Jacobson II", description=""),
     *                  @OA\Property(property="ngay_xuat", type="DATETIME", default="NULL", example="2022-03-08 00:15:37", description=""),
     *                  @OA\Property(property="so_luong", type="VARCHAR", default="NULL", example="Prof. Roxane Durgan IV", description=""),
 *                  @OA\Property(property="kho_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 * @OA\Get(
 *     path="/xuat-khos/{id}",
 *     tags={"xuatKho"},
 *     summary="Edit xuatKho",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Put(
 *     path="/xuat-khos/{id}",
 *     tags={"xuatKho"},
 *     summary="Update xuatKho",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "kho_id"},
 *                  @OA\Property(property="ma_phieu_xuat", type="VARCHAR", default="NULL", example="Amir Jacobson II", description=""),
     *                  @OA\Property(property="ngay_xuat", type="DATETIME", default="NULL", example="2022-03-08 00:15:37", description=""),
     *                  @OA\Property(property="so_luong", type="VARCHAR", default="NULL", example="Prof. Roxane Durgan IV", description=""),
 *                  @OA\Property(property="kho_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
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
 *     path="/xuat-khos/{id}",
 *     tags={"xuatKho"},
 *     summary="Delete xuatKho",
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
 *     title="xuatKho",
 *     required={"id", "kho_id"},
 * )
 */
class xuatKho
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * <###> @OA\Property(property="ma_phieu_xuat", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="ngay_xuat", type="DATETIME", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="so_luong", type="VARCHAR", default="NULL", description="")
     */

    /**
     * @OA\Property(property="kho_id", default="NONE", description="hasMany")
     * @var kho
     */

    //{{SWAGGER_PROPERTY_NOT_DELETE_THIS_LINE}}

    /**
     * @OA\Property(property="created_at", type="TIMESTAMP", default="NULL", description="")
     */

    /**
     * @OA\Property(property="updated_at", type="TIMESTAMP", default="NULL", description="")
     */

    
}

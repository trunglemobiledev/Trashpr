<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:10:12
 */

/**
 * @OA\Get(
 *     path="/nhap-khos",
 *     tags={"nhapKho"},
 *     summary="List nhapKho",
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
 *     path="/nhap-khos",
 *     tags={"nhapKho"},
 *     summary="Create nhapKho",
 *     security={{"authApi":{}}},
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "kho_id"},
 *                  @OA\Property(property="ngay_nhap", type="DATETIME", default="NULL", example="2022-03-08 00:10:12", description=""),
     *                  @OA\Property(property="so_luong", type="INT", default="NULL", example="4352", description=""),
 *                  @OA\Property(property="ma_phieu_nhap", type="VARCHAR", default="NULL", example="Belle Torphy", description=""),
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
 *     path="/nhap-khos/{id}",
 *     tags={"nhapKho"},
 *     summary="Edit nhapKho",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Put(
 *     path="/nhap-khos/{id}",
 *     tags={"nhapKho"},
 *     summary="Update nhapKho",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "kho_id"},
 *                  @OA\Property(property="ngay_nhap", type="DATETIME", default="NULL", example="2022-03-08 00:10:12", description=""),
     *                  @OA\Property(property="so_luong", type="INT", default="NULL", example="4352", description=""),
 *                  @OA\Property(property="ma_phieu_nhap", type="VARCHAR", default="NULL", example="Belle Torphy", description=""),
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
 *     path="/nhap-khos/{id}",
 *     tags={"nhapKho"},
 *     summary="Delete nhapKho",
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
 *     title="nhapKho",
 *     required={"id", "kho_id"},
 * )
 */
class nhapKho
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * <###> @OA\Property(property="ngay_nhap", type="DATETIME", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="so_luong", type="INT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="ma_phieu_nhap", type="VARCHAR", default="NULL", description="")
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

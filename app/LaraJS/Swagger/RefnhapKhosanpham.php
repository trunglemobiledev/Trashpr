<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:08:26
 */

/**
 * @OA\Get(
 *     path="/refnhap-khosanphams",
 *     tags={"RefnhapKhosanpham"},
 *     summary="List RefnhapKhosanpham",
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
 *     path="/refnhap-khosanphams",
 *     tags={"RefnhapKhosanpham"},
 *     summary="Create RefnhapKhosanpham",
 *     security={{"authApi":{}}},
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id"},
 *                  @OA\Property(property="don_vi_tinh", type="VARCHAR", default="NULL", example="Josie Hintz", description=""),
     *                  @OA\Property(property="ghi_chu", type="VARCHAR", default="NULL", example="Eugenia O'Hara", description=""),
     *                  @OA\Property(property="so_luong", type="INT", default="NULL", example="2287", description=""),
     *                  @OA\Property(property="ngay_nhap", type="DATETIME", default="NULL", example="2022-03-10 00:08:26", description=""),
     *                  @OA\Property(property="qr_code_nhap", type="VARCHAR", default="NULL", example="Prof. Estelle O'Conner", description=""),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 * @OA\Get(
 *     path="/refnhap-khosanphams/{id}",
 *     tags={"RefnhapKhosanpham"},
 *     summary="Edit RefnhapKhosanpham",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Put(
 *     path="/refnhap-khosanphams/{id}",
 *     tags={"RefnhapKhosanpham"},
 *     summary="Update RefnhapKhosanpham",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id"},
 *                  @OA\Property(property="don_vi_tinh", type="VARCHAR", default="NULL", example="Josie Hintz", description=""),
     *                  @OA\Property(property="ghi_chu", type="VARCHAR", default="NULL", example="Eugenia O'Hara", description=""),
     *                  @OA\Property(property="so_luong", type="INT", default="NULL", example="2287", description=""),
     *                  @OA\Property(property="ngay_nhap", type="DATETIME", default="NULL", example="2022-03-10 00:08:26", description=""),
     *                  @OA\Property(property="qr_code_nhap", type="VARCHAR", default="NULL", example="Prof. Estelle O'Conner", description=""),
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
 *     path="/refnhap-khosanphams/{id}",
 *     tags={"RefnhapKhosanpham"},
 *     summary="Delete RefnhapKhosanpham",
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
 *     title="RefnhapKhosanpham",
 *     required={"id"},
 * )
 */
class RefnhapKhosanpham
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * <###> @OA\Property(property="don_vi_tinh", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="ghi_chu", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="so_luong", type="INT", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="ngay_nhap", type="DATETIME", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="qr_code_nhap", type="VARCHAR", default="NULL", description="")
     */

    //{{SWAGGER_PROPERTY_NOT_DELETE_THIS_LINE}}

    /**
     * @OA\Property(property="created_at", type="TIMESTAMP", default="NULL", description="")
     */

    /**
     * @OA\Property(property="updated_at", type="TIMESTAMP", default="NULL", description="")
     */

    
}

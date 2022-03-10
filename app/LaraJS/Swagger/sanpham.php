<?php
/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:32:32
 */

/**
 * @OA\Get(
 *     path="/sanphams",
 *     tags={"sanpham"},
 *     summary="List sanpham",
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
 *     path="/sanphams",
 *     tags={"sanpham"},
 *     summary="Create sanpham",
 *     security={{"authApi":{}}},
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "danh_muc_id", "thuong_hieu_id", "nhac_cung_cap_id"},
 *                  @OA\Property(property="ma_san_pham", type="VARCHAR", default="NULL", example="Dianna Mueller", description=""),
     *                  @OA\Property(property="ten_san_pham", type="VARCHAR", default="NULL", example="Prof. Nicklaus Kling I", description=""),
     *                  @OA\Property(property="gia_nhap", type="FLOAT", default="0", example="6975.45", description=""),
     *                  @OA\Property(property="gia_ban", type="FLOAT", default="0", example="1639.45", description=""),
     *                  @OA\Property(property="ten_khach_ban", type="VARCHAR", default="NULL", example="Shannon Blick", description=""),
     *                  @OA\Property(property="so_dien_thoai_khach_ban", type="VARCHAR", default="NULL", example="Johnathon Schoen MD", description=""),
 *                  @OA\Property(property="hinh_anh", type="VARCHAR", default="NULL", example="Seamus Cormier IV", description=""),
 *                  @OA\Property(property="so_may", type="VARCHAR", default="NULL", example="Mrs. Lyla Schuppe", description=""),
     *                  @OA\Property(property="don_vi_tinh", type="VARCHAR", default="NULL", example="Mr. Javier Ruecker I", description=""),
     *                  @OA\Property(property="tinh_trang_bao_hanh", type="VARCHAR", default="NULL", example="Zora Corkery", description=""),
     *                  @OA\Property(property="ho_so", type="VARCHAR", default="NULL", example="Emma Buckridge", description=""),
     *                  @OA\Property(property="ngay_mua", type="DATETIME", default="NULL", example="2022-03-07 23:55:29", description=""),
 *                  @OA\Property(property="mo_ta", type="LONGTEXT", default="NULL", example="Voluptatem rem alias nemo et beatae. Magni laudantium quo commodi optio est repellendus voluptate. Voluptates consequuntur et modi possimus in ut. Reprehenderit sed magnam iusto maxime.", description=""),
 *                  @OA\Property(property="danh_muc_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="thuong_hieu_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="nhac_cung_cap_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  x="{{SWAGGER_PROPERTY_JSON_CONTENT_NOT_DELETE_THIS_LINE}}"
 *              )
 *          )
 *     ),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 * @OA\Get(
 *     path="/sanphams/{id}",
 *     tags={"sanpham"},
 *     summary="Edit sanpham",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Response(response="200", ref="#/components/responses/OK"),
 *     @OA\Response(response="404", ref="#/components/responses/NotFound"),
 *     @OA\Response(response="500", ref="#/components/responses/Error"),
 * )
 *
 * @OA\Put(
 *     path="/sanphams/{id}",
 *     tags={"sanpham"},
 *     summary="Update sanpham",
 *     security={{"authApi":{}}},
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema (
 *                  required={"id", "danh_muc_id", "thuong_hieu_id", "nhac_cung_cap_id"},
 *                  @OA\Property(property="ma_san_pham", type="VARCHAR", default="NULL", example="Dianna Mueller", description=""),
     *                  @OA\Property(property="ten_san_pham", type="VARCHAR", default="NULL", example="Prof. Nicklaus Kling I", description=""),
     *                  @OA\Property(property="gia_nhap", type="FLOAT", default="0", example="6975.45", description=""),
     *                  @OA\Property(property="gia_ban", type="FLOAT", default="0", example="1639.45", description=""),
     *                  @OA\Property(property="ten_khach_ban", type="VARCHAR", default="NULL", example="Shannon Blick", description=""),
     *                  @OA\Property(property="so_dien_thoai_khach_ban", type="VARCHAR", default="NULL", example="Johnathon Schoen MD", description=""),
 *                  @OA\Property(property="hinh_anh", type="VARCHAR", default="NULL", example="Seamus Cormier IV", description=""),
 *                  @OA\Property(property="so_may", type="VARCHAR", default="NULL", example="Mrs. Lyla Schuppe", description=""),
     *                  @OA\Property(property="don_vi_tinh", type="VARCHAR", default="NULL", example="Mr. Javier Ruecker I", description=""),
     *                  @OA\Property(property="tinh_trang_bao_hanh", type="VARCHAR", default="NULL", example="Zora Corkery", description=""),
     *                  @OA\Property(property="ho_so", type="VARCHAR", default="NULL", example="Emma Buckridge", description=""),
     *                  @OA\Property(property="ngay_mua", type="DATETIME", default="NULL", example="2022-03-07 23:55:29", description=""),
 *                  @OA\Property(property="mo_ta", type="LONGTEXT", default="NULL", example="Voluptatem rem alias nemo et beatae. Magni laudantium quo commodi optio est repellendus voluptate. Voluptates consequuntur et modi possimus in ut. Reprehenderit sed magnam iusto maxime.", description=""),
 *                  @OA\Property(property="danh_muc_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="thuong_hieu_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
 *                  @OA\Property(property="nhac_cung_cap_id", type="BIGINT", default="NONE", example="1", description="hasMany"),
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
 *     path="/sanphams/{id}",
 *     tags={"sanpham"},
 *     summary="Delete sanpham",
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
 *     title="sanpham",
 *     required={"id", "danh_muc_id", "thuong_hieu_id", "nhac_cung_cap_id"},
 * )
 */
class sanpham
{
    /**
     * @OA\Property(property="id", type="BIGINT", description="AUTO_INCREMENT")
     */

    /**
     * <###> @OA\Property(property="ma_san_pham", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="ten_san_pham", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="gia_nhap", type="FLOAT", default="0", description="")
     */

    /**
     * <###> @OA\Property(property="gia_ban", type="FLOAT", default="0", description="")
     */

    /**
     * <###> @OA\Property(property="ten_khach_ban", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="so_dien_thoai_khach_ban", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="hinh_anh", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="so_may", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="don_vi_tinh", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="tinh_trang_bao_hanh", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="ho_so", type="VARCHAR", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="ngay_mua", type="DATETIME", default="NULL", description="")
     */

    /**
     * <###> @OA\Property(property="mo_ta", type="LONGTEXT", default="NULL", description="")
     */

    /**
     * @OA\Property(property="danh_muc_id", default="NONE", description="hasMany")
     * @var danhMuc
     */

    /**
     * @OA\Property(property="thuong_hieu_id", default="NONE", description="hasMany")
     * @var thuongHieu
     */

    /**
     * @OA\Property(property="nhac_cung_cap_id", default="NONE", description="hasMany")
     * @var nhacCungCap
     */

    //{{SWAGGER_PROPERTY_NOT_DELETE_THIS_LINE}}

    /**
     * @OA\Property(property="created_at", type="TIMESTAMP", default="NULL", description="")
     */

    /**
     * @OA\Property(property="updated_at", type="TIMESTAMP", default="NULL", description="")
     */

    
}

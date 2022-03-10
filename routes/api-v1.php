<?php
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => 'optimizeImages'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::get('/language/{language}', 'LaraJSController@setLanguage');
Route::post('/logging', 'LaraJSController@logging');
// Send reset password mail
Route::post('/forgot-password', 'AuthController@forgotPassword');
// Handle reset password form process
Route::post('/reset-password', 'AuthController@resetPassword');
// START - Auth
Route::post('/fe-login', 'AuthController@feLogin');
Route::post('/refresh-token', 'AuthController@refreshToken');
Route::post('/login', 'AuthController@login');
// END - Auth
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/fe-logout', 'AuthController@feLogout');
    Route::get('/user-info', 'UserController@userInfo');
    Route::get('/logout', 'AuthController@logout');
    Route::group(['middleware' => 'verify_request'], function () {});
    // permission manage permission
    Route::group(
        [
            'middleware' => 'permission:' . \ACL::PERMISSION_PERMISSION_MANAGE,
        ],
        function () {
            Route::apiResource('roles', 'RoleController');
            Route::apiResource('permissions', 'PermissionController');
        }
    );
    // role Admin (Super admin)
    Route::group(['middleware' => 'role:' . \ACL::ROLE_ADMIN], function () {
        Route::group(['prefix' => 'generators'], function () {
            Route::get('check-model', 'GeneratorController@checkModel');
            Route::get('check-column', 'GeneratorController@checkColumn');
            Route::get('get-models', 'GeneratorController@getModels');
            Route::get('get-all-models', 'GeneratorController@getAllModels');
            Route::get('get-columns', 'GeneratorController@getColumns');
            Route::post('relationship', 'GeneratorController@generateRelationship');
            Route::get('diagram', 'GeneratorController@generateDiagram');
        });
        Route::apiResource('generators', 'GeneratorController');
        Route::apiResource('users', 'UserController');
        //{{ROUTE_ADMIN_NOT_DELETE_THIS_LINE}}
    });

    /*<==> sanpham Route - 2022-03-07 23:32:32 <==>*/
    Route::get('/sanphams/get-sanphams', 'sanphamController@getsanpham');
            Route::apiResource('sanphams', 'sanphamController');
    /*<==> thuongHieu Route - 2022-03-07 23:38:19 <==>*/
    Route::get('/thuong-hieus/get-thuong-hieus', 'thuongHieuController@getthuongHieu');
            Route::apiResource('thuong-hieus', 'thuongHieuController');
    /*<==> danhMuc Route - 2022-03-07 23:41:40 <==>*/
    Route::get('/danh-mucs/get-danh-mucs', 'danhMucController@getdanhMuc');
            Route::apiResource('danh-mucs', 'danhMucController');
    /*<==> nhacCungCap Route - 2022-03-07 23:47:52 <==>*/
    Route::get('/nhac-cung-caps/get-nhac-cung-caps', 'nhacCungCapController@getnhacCungCap');
            Route::apiResource('nhac-cung-caps', 'nhacCungCapController');
    /*<==> kho Route - 2022-03-08 00:00:53 <==>*/
    Route::get('/khos/get-khos', 'khoController@getkho');
            Route::apiResource('khos', 'khoController');
    /*<==> nhapKho Route - 2022-03-08 00:10:12 <==>*/
    Route::get('/nhap-khos/get-nhap-khos', 'nhapKhoController@getnhapKho');
            Route::apiResource('nhap-khos', 'nhapKhoController');
    /*<==> xuatKho Route - 2022-03-08 00:15:37 <==>*/
    Route::get('/xuat-khos/get-xuat-khos', 'xuatKhoController@getxuatKho');
            Route::apiResource('xuat-khos', 'xuatKhoController');

    
    /*<==> post Route - 2022-03-10 00:21:11 <==>*/
    Route::get('/posts/get-posts', 'postController@getpost');
            Route::apiResource('posts', 'postController');
    /*<==> comment Route - 2022-03-10 00:23:36 <==>*/
    Route::get('/comments/get-comments', 'commentController@getcomment');
            Route::apiResource('comments', 'commentController');
    //{{ROUTE_USER_NOT_DELETE_THIS_LINE}}
});

Route::fallback(function () {
    return response()->json(
        [
            'message' => trans('error.404'),
        ],
        404
    );
});

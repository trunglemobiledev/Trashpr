<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:32:32
 * File: sanpham.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\sanpham;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoresanphamRequest;

class sanphamController extends Controller
{
    /**
     * sanpham constructor.
     * @author tanmnt
     */
    public function __construct()
    {
        $this->middleware('permission:' . \ACL::PERMISSION_VISIT, ['only' => ['index']]);
        $this->middleware('permission:' . \ACL::PERMISSION_CREATE, ['only' => ['store']]);
        $this->middleware('permission:' . \ACL::PERMISSION_EDIT, ['only' => ['show', 'update']]);
        $this->middleware('permission:' . \ACL::PERMISSION_DELETE, ['only' => ['destroy']]);
    }

	/**
	 * lists
	 * @param Request $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function index(Request $request): JsonResponse
	{
		try {
			$limit = $request->get('limit', 25);
			$ascending = $request->get('ascending', '');
			$orderBy = $request->get('orderBy', '');
			$search = $request->get('search', '');
			$betweenDate = $request->get('updated_at', []);

			$queryService = new QueryService(new sanpham);
            $queryService->select = [];
            $queryService->columnSearch = [];
            $queryService->withRelationship = ['danhMuc','thuongHieu','nhacCungCap','nhapKhos'];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $sanpham = $query->toArray();

			return $this->jsonTable($sanpham);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StoresanphamRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StoresanphamRequest $request): JsonResponse
	{
		try {
		    $sanpham = new sanpham();
		    $sanpham->fill($request->all());
            $sanpham->save();
			$nhapKhoId = $request->get('nhap_kho_id', []);
            $sanpham->nhapKhos()->attach($nhapKhoId);
            //{{CONTROLLER_RELATIONSHIP_MTM_CREATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($sanpham, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param sanpham $sanpham
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(sanpham $sanpham): JsonResponse
	{
		try {
		    $sanpham->nhap_kho_id = \Arr::pluck($sanpham->nhapKhos()->get(), 'pivot.nhap_kho_id');
            //{{CONTROLLER_RELATIONSHIP_MTM_SHOW_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($sanpham);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StoresanphamRequest $request
	 * @param sanpham $sanpham
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StoresanphamRequest $request, sanpham $sanpham): JsonResponse
	{
		try {
		    $sanpham->fill($request->all());
            $sanpham->save();
            $nhapKhoId = $request->get('nhap_kho_id', []);
            $sanpham->nhapKhos()->sync($nhapKhoId);
            //{{CONTROLLER_RELATIONSHIP_MTM_UPDATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($sanpham);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param sanpham $sanpham
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(sanpham $sanpham): JsonResponse
    {
	    try {
	        $sanpham->nhapKhos()->detach();
            //{{CONTROLLER_RELATIONSHIP_MTM_DELETE_NOT_DELETE_THIS_LINE}}
			$sanpham->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    /**
     * get all data from sanpham
     * @return JsonResponse
     */
    public function getsanpham(): JsonResponse
    {
        try {
            $sanphams = sanpham::all();

            return $this->jsonData($sanphams);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    //{{CONTROLLER_RELATIONSHIP_NOT_DELETE_THIS_LINE}}
}

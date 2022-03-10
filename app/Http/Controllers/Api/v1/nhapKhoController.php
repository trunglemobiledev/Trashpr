<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:10:12
 * File: nhapKho.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\nhapKho;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorenhapKhoRequest;

class nhapKhoController extends Controller
{
    /**
     * nhapKho constructor.
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

			$queryService = new QueryService(new nhapKho);
            $queryService->select = [];
            $queryService->columnSearch = [];
            $queryService->withRelationship = ['sanphams','kho'];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $nhapKho = $query->toArray();

			return $this->jsonTable($nhapKho);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StorenhapKhoRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StorenhapKhoRequest $request): JsonResponse
	{
		try {
		    $nhapKho = new nhapKho();
		    $nhapKho->fill($request->all());
            $nhapKho->save();
			$sanphamId = $request->get('sanpham_id', []);
            $nhapKho->sanphams()->attach($sanphamId);
            //{{CONTROLLER_RELATIONSHIP_MTM_CREATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($nhapKho, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param nhapKho $nhapKho
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(nhapKho $nhapKho): JsonResponse
	{
		try {
		    $nhapKho->sanpham_id = \Arr::pluck($nhapKho->sanphams()->get(), 'pivot.sanpham_id');
            //{{CONTROLLER_RELATIONSHIP_MTM_SHOW_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($nhapKho);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StorenhapKhoRequest $request
	 * @param nhapKho $nhapKho
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StorenhapKhoRequest $request, nhapKho $nhapKho): JsonResponse
	{
		try {
		    $nhapKho->fill($request->all());
            $nhapKho->save();
            $sanphamId = $request->get('sanpham_id', []);
            $nhapKho->sanphams()->sync($sanphamId);
            //{{CONTROLLER_RELATIONSHIP_MTM_UPDATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($nhapKho);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param nhapKho $nhapKho
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(nhapKho $nhapKho): JsonResponse
    {
	    try {
	        $nhapKho->sanphams()->detach();
            //{{CONTROLLER_RELATIONSHIP_MTM_DELETE_NOT_DELETE_THIS_LINE}}
			$nhapKho->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    /**
     * get all data from nhapKho
     * @return JsonResponse
     */
    public function getnhapKho(): JsonResponse
    {
        try {
            $nhapKhos = nhapKho::all();

            return $this->jsonData($nhapKhos);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    //{{CONTROLLER_RELATIONSHIP_NOT_DELETE_THIS_LINE}}
}

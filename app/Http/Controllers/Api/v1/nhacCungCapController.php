<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:47:52
 * File: nhacCungCap.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\nhacCungCap;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorenhacCungCapRequest;

class nhacCungCapController extends Controller
{
    /**
     * nhacCungCap constructor.
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

			$queryService = new QueryService(new nhacCungCap);
            $queryService->select = [];
            $queryService->columnSearch = [];
            $queryService->withRelationship = [];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $nhacCungCap = $query->toArray();

			return $this->jsonTable($nhacCungCap);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StorenhacCungCapRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StorenhacCungCapRequest $request): JsonResponse
	{
		try {
		    $nhacCungCap = new nhacCungCap();
		    $nhacCungCap->fill($request->all());
            $nhacCungCap->save();
			//{{CONTROLLER_RELATIONSHIP_MTM_CREATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($nhacCungCap, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param nhacCungCap $nhacCungCap
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(nhacCungCap $nhacCungCap): JsonResponse
	{
		try {
		    //{{CONTROLLER_RELATIONSHIP_MTM_SHOW_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($nhacCungCap);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StorenhacCungCapRequest $request
	 * @param nhacCungCap $nhacCungCap
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StorenhacCungCapRequest $request, nhacCungCap $nhacCungCap): JsonResponse
	{
		try {
		    $nhacCungCap->fill($request->all());
            $nhacCungCap->save();
            //{{CONTROLLER_RELATIONSHIP_MTM_UPDATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($nhacCungCap);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param nhacCungCap $nhacCungCap
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(nhacCungCap $nhacCungCap): JsonResponse
    {
	    try {
	        //{{CONTROLLER_RELATIONSHIP_MTM_DELETE_NOT_DELETE_THIS_LINE}}
			$nhacCungCap->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    /**
     * get all data from nhacCungCap
     * @return JsonResponse
     */
    public function getnhacCungCap(): JsonResponse
    {
        try {
            $nhacCungCaps = nhacCungCap::all();

            return $this->jsonData($nhacCungCaps);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    //{{CONTROLLER_RELATIONSHIP_NOT_DELETE_THIS_LINE}}
}

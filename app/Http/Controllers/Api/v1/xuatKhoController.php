<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:15:37
 * File: xuatKho.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\xuatKho;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorexuatKhoRequest;

class xuatKhoController extends Controller
{
    /**
     * xuatKho constructor.
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

			$queryService = new QueryService(new xuatKho);
            $queryService->select = [];
            $queryService->columnSearch = [];
            $queryService->withRelationship = ['kho'];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $xuatKho = $query->toArray();

			return $this->jsonTable($xuatKho);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StorexuatKhoRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StorexuatKhoRequest $request): JsonResponse
	{
		try {
		    $xuatKho = new xuatKho();
		    $xuatKho->fill($request->all());
            $xuatKho->save();
			//{{CONTROLLER_RELATIONSHIP_MTM_CREATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($xuatKho, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param xuatKho $xuatKho
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(xuatKho $xuatKho): JsonResponse
	{
		try {
		    //{{CONTROLLER_RELATIONSHIP_MTM_SHOW_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($xuatKho);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StorexuatKhoRequest $request
	 * @param xuatKho $xuatKho
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StorexuatKhoRequest $request, xuatKho $xuatKho): JsonResponse
	{
		try {
		    $xuatKho->fill($request->all());
            $xuatKho->save();
            //{{CONTROLLER_RELATIONSHIP_MTM_UPDATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($xuatKho);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param xuatKho $xuatKho
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(xuatKho $xuatKho): JsonResponse
    {
	    try {
	        //{{CONTROLLER_RELATIONSHIP_MTM_DELETE_NOT_DELETE_THIS_LINE}}
			$xuatKho->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    //{{CONTROLLER_RELATIONSHIP_NOT_DELETE_THIS_LINE}}
}

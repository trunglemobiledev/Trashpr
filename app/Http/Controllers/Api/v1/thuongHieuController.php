<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:38:19
 * File: thuongHieu.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\thuongHieu;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorethuongHieuRequest;

class thuongHieuController extends Controller
{
    /**
     * thuongHieu constructor.
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

			$queryService = new QueryService(new thuongHieu);
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
            $thuongHieu = $query->toArray();

			return $this->jsonTable($thuongHieu);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StorethuongHieuRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StorethuongHieuRequest $request): JsonResponse
	{
		try {
		    $thuongHieu = new thuongHieu();
		    $thuongHieu->fill($request->all());
            $thuongHieu->save();
			//{{CONTROLLER_RELATIONSHIP_MTM_CREATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($thuongHieu, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param thuongHieu $thuongHieu
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(thuongHieu $thuongHieu): JsonResponse
	{
		try {
		    //{{CONTROLLER_RELATIONSHIP_MTM_SHOW_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($thuongHieu);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StorethuongHieuRequest $request
	 * @param thuongHieu $thuongHieu
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StorethuongHieuRequest $request, thuongHieu $thuongHieu): JsonResponse
	{
		try {
		    $thuongHieu->fill($request->all());
            $thuongHieu->save();
            //{{CONTROLLER_RELATIONSHIP_MTM_UPDATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($thuongHieu);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param thuongHieu $thuongHieu
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(thuongHieu $thuongHieu): JsonResponse
    {
	    try {
	        //{{CONTROLLER_RELATIONSHIP_MTM_DELETE_NOT_DELETE_THIS_LINE}}
			$thuongHieu->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    /**
     * get all data from thuongHieu
     * @return JsonResponse
     */
    public function getthuongHieu(): JsonResponse
    {
        try {
            $thuongHieus = thuongHieu::all();

            return $this->jsonData($thuongHieus);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    //{{CONTROLLER_RELATIONSHIP_NOT_DELETE_THIS_LINE}}
}

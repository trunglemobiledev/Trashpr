<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:23:36
 * File: comment.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\comment;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorecommentRequest;

class commentController extends Controller
{
    /**
     * comment constructor.
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

			$queryService = new QueryService(new comment);
            $queryService->select = [];
            $queryService->columnSearch = ['post.id'];
            $queryService->withRelationship = ['posts'];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $comment = $query->toArray();

			return $this->jsonTable($comment);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StorecommentRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StorecommentRequest $request): JsonResponse
	{
		try {
		    $comment = new comment();
		    $comment->fill($request->all());
            $comment->save();
			$postId = $request->get('post_id', []);
            $comment->posts()->attach($postId);
            //{{CONTROLLER_RELATIONSHIP_MTM_CREATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($comment, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param comment $comment
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(comment $comment): JsonResponse
	{
		try {
		    $comment->post_id = \Arr::pluck($comment->posts()->get(), 'pivot.post_id');
            //{{CONTROLLER_RELATIONSHIP_MTM_SHOW_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($comment);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StorecommentRequest $request
	 * @param comment $comment
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StorecommentRequest $request, comment $comment): JsonResponse
	{
		try {
		    $comment->fill($request->all());
            $comment->save();
            $postId = $request->get('post_id', []);
            $comment->posts()->sync($postId);
            //{{CONTROLLER_RELATIONSHIP_MTM_UPDATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($comment);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param comment $comment
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(comment $comment): JsonResponse
    {
	    try {
	        $comment->posts()->detach();
            //{{CONTROLLER_RELATIONSHIP_MTM_DELETE_NOT_DELETE_THIS_LINE}}
			$comment->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    /**
     * get all data from comment
     * @return JsonResponse
     */
    public function getcomment(): JsonResponse
    {
        try {
            $comments = comment::all();

            return $this->jsonData($comments);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    //{{CONTROLLER_RELATIONSHIP_NOT_DELETE_THIS_LINE}}
}

<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:21:11
 * File: post.php
 */

namespace App\Http\Controllers\Api\v1;

use App\Models\post;
use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorepostRequest;

class postController extends Controller
{
    /**
     * post constructor.
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

			$queryService = new QueryService(new post);
            $queryService->select = [];
            $queryService->columnSearch = ['comment.id'];
            $queryService->withRelationship = ['comments'];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;

            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $post = $query->toArray();

			return $this->jsonTable($post);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * create
	 * @param StorepostRequest $request
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function store(StorepostRequest $request): JsonResponse
	{
		try {
		    $post = new post();
		    $post->fill($request->all());
            $post->save();
			$commentId = $request->get('comment_id', []);
            $post->comments()->attach($commentId);
            //{{CONTROLLER_RELATIONSHIP_MTM_CREATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($post, Response::HTTP_CREATED);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * get once by id
	 * @param post $post
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function show(post $post): JsonResponse
	{
		try {
		    $post->comment_id = \Arr::pluck($post->comments()->get(), 'pivot.comment_id');
            //{{CONTROLLER_RELATIONSHIP_MTM_SHOW_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($post);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * update once by id
	 * @param StorepostRequest $request
	 * @param post $post
	 * @return JsonResponse
	 * @author tanmnt
	 */
	public function update(StorepostRequest $request, post $post): JsonResponse
	{
		try {
		    $post->fill($request->all());
            $post->save();
            $commentId = $request->get('comment_id', []);
            $post->comments()->sync($commentId);
            //{{CONTROLLER_RELATIONSHIP_MTM_UPDATE_NOT_DELETE_THIS_LINE}}

			return $this->jsonData($post);
		} catch (\Exception $e) {
			return $this->jsonError($e);
		}
	}

	/**
	 * delete once by id
	 * @param post $post
	 * @return JsonResponse
	 * @author tanmnt
	 */
    public function destroy(post $post): JsonResponse
    {
	    try {
	        $post->comments()->detach();
            //{{CONTROLLER_RELATIONSHIP_MTM_DELETE_NOT_DELETE_THIS_LINE}}
			$post->delete();

		    return $this->jsonMessage(trans('messages.delete'));
	    } catch (\Exception $e) {
	    	return $this->jsonError($e);
	    }
    }

    /**
     * get all data from post
     * @return JsonResponse
     */
    public function getpost(): JsonResponse
    {
        try {
            $posts = post::all();

            return $this->jsonData($posts);
        } catch (\Exception $e) {
            return $this->jsonError($e);
        }
    }

    //{{CONTROLLER_RELATIONSHIP_NOT_DELETE_THIS_LINE}}
}

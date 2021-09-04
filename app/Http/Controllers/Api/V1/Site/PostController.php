<?php

namespace App\Http\Controllers\Api\V1\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected $postRepository;

    /**
     * Construct post
     * 
     * PostRepository $postRepository
     */
    function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    /**
     * Get list post
     * 
     * @param $request
     */
    public function index (Request $request) { 
        return $this->postRepository->getPost($request->all());
    }

    /**
     * Get right post
     * 
     * @param $request
     */
    public function postRight (Request $request) { 
        $data = [
            'posts' => $this->postRepository->getRight(),
            'tags' => $this->postRepository->getTags()
        ];
        return $this->sendSuccessResponse($data, $this->statusOk);
    }

    /**
     * show post
     * 
     * @param $post
     * 
     * @return mixed
     */
    public function show(Post $post) {
        return $this->sendSuccessResponse($post, $this->statusOk);
    }
}

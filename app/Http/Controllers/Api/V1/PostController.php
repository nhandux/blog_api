<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Http\Requests\Api\PostStoreRequest;
use App\Http\Requests\Api\PostUpdateRequest;
use Nhanduc\Core\Func\Upload\FuncLocal;

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
     * Save post
     * 
     * @param $request
     */
    public function store(PostStoreRequest $request) {
        $post = $this->postRepository->create(
            $request->only(
                'name',
                'slug',
                'category_id',
                'description',
                'content',
                'seo_title',
                'seo_description',
                'status',
                'tags'
            ) + ['author' => $request->user()->id]
        );

        if(!empty($post) && !empty($request->image)) {
            $fileS3 = new FuncLocal;
            $file = $request->image;
            $filePath = env('AWS_IMAGE_PATH') . 'posts/';
            $fileName = $fileS3->uploadFile($file, $filePath);
            $post->image = '/storage/' .$filePath . $fileName;
            $post->save();
        }

        return $this->sendSuccessResponse(['data'=> $post], $this->statusOk);
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
    
    /**
     * Update function post
     * 
     * @param $request
     * 
     * @return $post
     */
    public function update(PostUpdateRequest $request, $post_id) {
        $post = $this->postRepository->updateById(
            $post_id,
            $request->only(
                'name',
                'slug',
                'category_id',
                'description',
                'content',
                'seo_title',
                'seo_description',
                'status',
                'tags'
            )
        );

        if(!empty($post) && !empty($request->image)) {
            $fileS3 = new FuncLocal;
            $file = $request->image;
            $filePath = env('AWS_IMAGE_PATH') . 'posts/';
            $fileName = $fileS3->uploadFile($file, $filePath);
            $post->image = '/storage/' .$filePath . $fileName;
            $post->save();
        }

        return $this->sendSuccessResponse(['data'=> $post], $this->statusOk);
    } 

    /**
     * Delete post all
     * 
     * @param $request
     */
    function deleteItems (Request $request) {
        if(!empty($request->ids)){
            return $this->postRepository->deleteMultipleById($request->ids);
        } abort(404);
    }
}

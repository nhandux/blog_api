<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Http\Requests\Api\CategoryStoreRequest;
use App\Http\Requests\Api\CategoryUpdateRequest;
use Nhanduc\Core\Func\Upload\FuncLocal;

class CategorieController extends Controller
{
    protected $categoryRepository;

    /**
     * Construct category
     * 
     * CategoryRepository $categoryRepository
     */
    function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get list category
     * 
     * @param $request
     */
    public function index (Request $request) { 
        return $this->categoryRepository->getCategory($request->all());
    }

    /**
     * Save category
     * 
     * @param $request
     */
    public function store(CategoryStoreRequest $request) {
        $category = $this->categoryRepository->create(
            $request->only(
                'name',
                'slug',
                'parent_id',
                'description',
                'seo_title',
                'seo_description',
                'tags'
            )
        );

        if(!empty($category) && !empty($request->image)) {
            $fileS3 = new FuncLocal;
            $file = $request->image;
            $filePath = env('AWS_IMAGE_PATH') . 'categories/';
            $fileName = $fileS3->uploadFile($file, $filePath);
            $category->image = '/storage/' .$filePath . $fileName;
            $category->save();
        }

        return $this->sendSuccessResponse(['data'=> $category], $this->statusOk);
    }

    /**
     * show category
     * 
     * @param $category
     * 
     * @return mixed
     */
    public function show(Category $category) {
        return $this->sendSuccessResponse($category, $this->statusOk);
    }
    
    /**
     * Update function category
     * 
     * @param $request
     * 
     * @return $category
     */
    public function update(CategoryUpdateRequest $request, $category_id) {
        $category = $this->categoryRepository->updateById(
            $category_id,
            $request->only(
                'name',
                'slug',
                'parent_id',
                'description',
                'seo_title',
                'seo_description',
                'tags'
            )
        );

        if(!empty($category) && !empty($request->image)) {
            $fileS3 = new FuncLocal;
            $file = $request->image;
            $filePath = env('AWS_IMAGE_PATH') . 'categories/';
            $fileName = $fileS3->uploadFile($file, $filePath);
            $category->image = '/storage/' .$filePath . $fileName;
            $category->save();
        }

        return $this->sendSuccessResponse(['data'=> $category], $this->statusOk);
    } 

    /**
     * Delete categories all
     * 
     * @param $request
     */
    function deleteItems (Request $request) {
        if(!empty($request->ids)){
            return $this->categoryRepository->deleteMultipleById($request->ids);
        } abort(404);
    }
}

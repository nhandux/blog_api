<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use App\Http\Requests\Api\QuestionStoreRequest;
use App\Http\Requests\Api\QuestionUpdateRequest;
use Nhanduc\Core\Func\Upload\FuncLocal;

class QuestionController extends Controller
{
    protected $questionRepository;

    /**
     * Construct question
     * 
     * QuestionRepository $questionRepository
     */
    function __construct(QuestionRepository $questionRepository) {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Get list question
     * 
     * @param $request
     */
    public function index (Request $request) { 
        return $this->questionRepository->getQuestion($request->all());
    }

    /**
     * Save question
     * 
     * @param $request
     */
    public function store(QuestionStoreRequest $request) {
        $question = $this->questionRepository->create(
            $request->only(
                'title',
                'slug',
                'content',
                'status',
                'description',
                'seo_title',
                'seo_description',
                'tags'
            )
        );

        if(!empty($question) && !empty($request->image)) {
            $fileS3 = new FuncLocal;
            $file = $request->image;
            $filePath = env('AWS_IMAGE_PATH') . 'questions/';
            $fileName = $fileS3->uploadFile($file, $filePath);
            $question->image = '/storage/' .$filePath . $fileName;
            $question->save();
        }

        return $this->sendSuccessResponse(['data'=> $question], $this->statusOk);
    }

    /**
     * show question
     * 
     * @param $question
     * 
     * @return mixed
     */
    public function show(Question $question) {
        return $this->sendSuccessResponse($question, $this->statusOk);
    }
    
    /**
     * Update function question
     * 
     * @param $request
     * 
     * @return $question
     */
    public function update(QuestionUpdateRequest $request, $question_id) {
        $question = $this->questionRepository->updateById(
            $question_id,
            $request->only(
                'title',
                'slug',
                'content',
                'status',
                'description',
                'seo_title',
                'seo_description',
                'tags'
            )
        );

        if(!empty($question) && !empty($request->image)) {
            $fileS3 = new FuncLocal;
            $file = $request->image;
            $filePath = env('AWS_IMAGE_PATH') . 'questions/';
            $fileName = $fileS3->uploadFile($file, $filePath);
            $question->image = '/storage/' .$filePath . $fileName;
            $question->save();
        }

        return $this->sendSuccessResponse(['data'=> $question], $this->statusOk);
    } 

    /**
     * Delete question all
     * 
     * @param $request
     */
    function deleteItems (Request $request) {
        if(!empty($request->ids)){
            return $this->questionRepository->deleteMultipleById($request->ids);
        } abort(404);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\QuestionRepository;
use Nhanduc\Core\Func\Upload\FuncLocal;

class QuestionController extends Controller
{
    protected $questionRepository;

    /**
     * Construct post
     * 
     * QuestionRepository $questionRepository
     */
    function __construct(QuestionRepository $questionRepository) {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Get list post
     * 
     * @param $request
     */
    public function index (Request $request) { 
        $question = $this->questionRepository->getQuestion($request->all());

        return $this->sendSuccessResponse(['question' => $question], $this->statusOk);
    }
}

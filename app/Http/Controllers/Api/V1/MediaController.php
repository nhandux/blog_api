<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Repositories\MediaRepository;
use App\Http\Requests\Api\MediaStoreRequest;
use App\Http\Requests\Api\MediaUpdateRequest;
use Nhanduc\Core\Func\Upload\FuncLocal;

class MediaController extends Controller
{
    protected $mediaRepository;

    /**
     * Construct category
     * 
     * MediaRepository $mediaRepository
     */
    function __construct(MediaRepository $mediaRepository) {
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * Get list media
     * 
     * @param $request
     */
    public function index (Request $request) { 
        return $this->mediaRepository->getMedia($request->all());
    }

    /**
     * Save media
     * 
     * @param $request
     */
    public function store(MediaStoreRequest $request) {
        $media = $this->mediaRepository->create(
            $request->type == "video" ? $request->only(
                'type',
                'file'
            ) : $request->only(
                'type'
            )
        );

        if(!empty($media) && $request->type == "image") {
            $fileS3 = new FuncLocal;
            $file = $request->file;
            $filePath = env('AWS_IMAGE_PATH') . 'medias/';
            $fileName = $fileS3->uploadFile($file, $filePath);
            $media->file = '/storage/' .$filePath . $fileName;
            $media->save();
        }

        return $this->sendSuccessResponse(['data'=> $media], $this->statusOk);
    }

    /** 
     * Delete file
     * 
     * @param $id file
     * 
     * @return mixed
     */
    public function destroy($id) {
        return $this->mediaRepository->deleteById($id);
    }
}

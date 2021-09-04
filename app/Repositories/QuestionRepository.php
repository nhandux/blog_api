<?php

namespace App\Repositories;

use App\Models\Question;
use Nhanduc\Core\Func\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\GeneralException;
use DB;

/**
 * Class QuestionRepository.
 */
class QuestionRepository extends BaseRepository
{
    /**
     * QuestionRepository constructor.
     *
     * @param  Question  $model
     */
    public function __construct(Question $model)
    {
        $this->model = $model;
	}
	
    /**
     * @param array $data
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getQuestion($data = [], $paged = 10, $orderBy = 'created_at', $sort = 'desc')
    {
        $resuft = $this->model
                    ->select([
                        // DB::raw('ROW_NUMBER() OVER(ORDER BY created_at ASC) AS `no`'),
                        'id as no',
                        'id',
                        'title',
                        'slug',
                        'description',
                        'content',
                        'view',
                        'created_at'
                    ])
                    ->when(!empty($data['slug']), function ($query) use ($data) {
                        $query->where('slug', 'like', $data['slug']);
                    })
                    ->when(!empty($data['keywords']), function ($query) use ($data) {
                        $query->where('title', 'like', '%' . $data['keywords'] . '%');
                    })
                    ->orderBy('id', $sort);

                    return !empty($data['slug']) ? $resuft->first() : (!empty($data['page_size']) ? $resuft->paginate($data['page_size']) : $resuft->get());            
    }
}

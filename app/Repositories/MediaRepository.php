<?php

namespace App\Repositories;

use App\Models\Media;
use Nhanduc\Core\Func\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\GeneralException;
use DB;

/**
 * Class MediaRepository.
 */
class MediaRepository extends BaseRepository
{
    /**
     * MediaRepository constructor.
     *
     * @param  Media  $model
     */
    public function __construct(Media $model)
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
    public function getMedia($data = [], $paged = 10, $orderBy = 'created_at', $sort = 'desc')
    {
        return  $this->model
                    ->select([
                        DB::raw('ROW_NUMBER() OVER(ORDER BY created_at ASC) AS `no`'),
                        'id',
                        'name',
                        'slug',
                        'file',
                        'created_at'
                    ])
                    ->when(!empty($data['type']), function ($query) use ($data) {
                        $query->where('type', $data['type']);
                    })
                    ->when(!empty($data['keywords']), function ($query) use ($data) {
                        $query->where('name', 'like', '%' . $data['keywords'] . '%');
                    })
                    ->orderBy('no', $sort)
                    ->get();            
    }
}

<?php

namespace App\Repositories;

use App\Models\Category;
use Nhanduc\Core\Func\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\GeneralException;
use DB;

/**
 * Class CategoryRepository.
 */
class CategoryRepository extends BaseRepository
{
    /**
     * CategoryRepository constructor.
     *
     * @param  Category  $model
     */
    public function __construct(Category $model)
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
    public function getCategory($data = [], $paged = 10, $orderBy = 'created_at', $sort = 'asc')
    {
        $resuft = $this->model
                    ->with(['parents:id,name,parent_id'])
                    ->select([
                        // DB::raw('ROW_NUMBER() OVER(ORDER BY created_at DESC) AS `no`'),
                        'id as no',
                        'id',
                        'name',
                        'image',
                        'slug',
                        'tags',
                        'description',
                        'created_at'
                    ])
                    ->addSelect([
                        'post_count' => function ($query) {
                            $query->select([DB::raw('count(posts.id)')])
                                ->from('posts')
                                ->join('categories as C', 'posts.category_id', 'C.id')
                                ->whereColumn('C.parent_id', 'categories.id');
                        },
                        'comment_count' => function ($query) {
                            $query->select([DB::raw('count(comments.id)')])
                                ->from('posts')
                                ->join('categories as C', 'posts.category_id', 'C.id')
                                ->join('comments', 'comments.comment_id', 'posts.id')
                                ->whereColumn('C.parent_id', 'categories.id');
                        }
                    ])
                    ->when(isset($data['parent_id']), function ($query) use ($data) {
                        $query->where('parent_id', $data['parent_id']);
                    })
                    ->when(!empty($data['keywords']), function ($query) use ($data) {
                        $query->where('name', 'like', '%' . $data['keywords'] . '%');
                    })
                    ->orderBy('id', $sort);

        return !empty($data['page_size']) ? $resuft->paginate($data['page_size']) : $resuft->get();            
    }
}

<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Category;
use Nhanduc\Core\Func\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\GeneralException;
use DB;

/**
 * Class PostRepository.
 */
class PostRepository extends BaseRepository
{
    /**
     * PostRepository constructor.
     *
     * @param  Post  $model
     */
    public function __construct(Post $model)
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
    public function getPost($data = [], $paged = 10, $orderBy = 'created_at', $sort = 'desc')
    {
        $resuft = $this->model
                    ->with(['category', 'user:id,name'])
                    ->select([
                        // DB::raw('ROW_NUMBER() OVER(ORDER BY created_at ASC) AS `no`'),
                        'id as no',
                        'posts.*'
                    ])
                    ->when(!empty($data['keywords']), function ($query) use ($data) {
                        $query->where('name', 'like', '%' . $data['keywords'] . '%');
                    })
                    ->when(!empty($data['tag']), function ($query) use ($data) {
                        $query->whereRaw('FIND_IN_SET("' . $data['tag'] . '", tags)');
                    })
                    ->when(!empty($data['slug']), function ($query) use ($data) {
                        $query->where('slug', 'like', $data['slug']);
                    })
                    ->when(!empty($data['slug_category']), function ($query) use ($data) {
                        $category = Category::where('slug', $data['slug_category'])->first();
                        $category_id = $category->parent_id == 0 ? Category::where('parent_id', $category->id)->pluck('id') : array($category->id);
                        $query->whereIn('category_id', $category_id);
                    })
                    ->when(!empty($data['order_by']), function ($query) use ($data) {
                        $query->when($data['order_by'] == 'NEWEST', function ($query) use ($data) {
                            $query->orderBy('created_at', 'DESC');
                        })
                        ->when($data['order_by'] == 'OLDEST', function ($query) use ($data) {
                            $query->orderBy('created_at', 'ASC');
                        })
                        ->when($data['order_by'] == 'AtoZ', function ($query) use ($data) {
                            $query->orderBy('name', 'ASC');
                        })
                        ->when($data['order_by'] == 'ZtoA', function ($query) use ($data) {
                            $query->orderBy('name', 'DESC');
                        });
                    }, function ($query) use ($sort) {
                        $query->orderBy('id', $sort);
                    });

        $posts = !empty($data['slug']) ? $resuft->first() : (!empty($data['page_size']) ? $resuft->paginate($data['page_size']) : $resuft->get());            
        if(!empty($data['slug'])) {
            $posts->orthers = $this->model
                ->where('category_id', $posts->category_id)
                ->where('id', '!=', $posts->id)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();

            $posts->authors = $this->model
                ->where('author', $posts->author)
                ->where('id', '!=', $posts->id)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
        }

        return $posts;
    }

    /**
     * @return mixed
     */
    public function getRight()
    {
        return $this->model
                ->orderBy('view', 'desc')
                ->limit(4)
                ->get();
    }
    
    /**
     * @return mixed
     */
    public function getTags()
    {
        $hashtag = [];
        $tags = $this->model->pluck('tags');
        $tags->each(function ($item, $key) use (&$hashtag) {
            $tag_items = explode(',', $item);
            foreach($tag_items as $tag) {
                $tag = trim($tag);
                if (array_key_exists($tag, $hashtag)) {
                    $hashtag[$tag] = $hashtag[$tag] + 1;
                } else {
                    $hashtag[$tag] = 1;
                }
            }
        });
        arsort($hashtag);

        return $hashtag; 
    }
}

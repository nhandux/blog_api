<?php 
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

if (! function_exists('include_route_files')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
		try {
            $rdi = new RecursiveDirectoryIterator($folder);
            $it = new RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (! function_exists('transformApi')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function transformApi($pagination) {
        
        return  array_merge([
                    'data' => $pagination->items()], [
                    'pagination' => [
                        'count' => $pagination->perPage(),
                        'pages' => ceil($pagination->total() / $pagination->perPage()),
                        'page' => $pagination->currentPage(),
                        'limit' => $pagination->perPage()
                    ]
                ]);
        }
}


if (! function_exists('paginate')) {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $perPage = $perPage > 0 ? $perPage : 10;
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        $currentPageResults = $items->slice(($page - 1) * $perPage, $perPage)->values();
        return new LengthAwarePaginator($currentPageResults, $items->count(), $perPage, $page, $options);
    }
}

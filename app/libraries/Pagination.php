<?php

namespace Skeleton\Library;

use Phalcon\Di\Di;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorNativeArrayAdapter;

/**
 * Pagination library.
 */
class Pagination
{
    protected $config;

    /**
     * Construct
     */
    function __construct()
    {
        $this->config = Di::getDefault()->get('config');
    }

    /**
     * @param array $data
     * @param int $page
     * @return array
     */
    public function pager(array $data = [], int $page = 1)
    {
        $paginator = new PaginatorNativeArrayAdapter([
            'data'  => $data,
            'limit' => $this->config->pagination->perpage,
            'page'  => $page,
        ]);

        return [
            'items' => $paginator->paginate()->getItems(),
            'pager' => [
                'all_items_count' => $paginator->paginate()->getTotalItems(),
                'total_pages'     => \ceil($paginator->paginate()->getTotalItems() / $this->config->pagination->perpage),
                'total_items'     => $paginator->paginate()->getTotalItems(),
                'limit'           => $paginator->paginate()->getLimit(),
                'first'           => $paginator->paginate()->getFirst(),
                'previous'        => $paginator->paginate()->getPrevious(),
                'current'         => $paginator->paginate()->getCurrent(),
                'next'            => $paginator->paginate()->getNext(),
                'last'            => $paginator->paginate()->getLast()
            ]
        ];
    }
}
